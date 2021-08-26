<?php
    require_once("init.php");
    $id = intval($_GET['id']) ?? NULL;
    if ($id === NULL) {
      header("Location: pages/404.html");
      exit;
    }
    require_once("function.php");
    require_once("helpers.php");
    $sql_lot = "SELECT categories.name AS category_name, lots.name, lots.id AS id, description, first_price AS price, url, date_delection, bet_step AS min_bet FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = $id;";
    $result_lot = mysqli_query($connection, $sql_lot);
    if (!$result_lot) {
      exit;
    }
    $lot = mysqli_fetch_assoc($result_lot);
    if ($id !== intval($lot['id'])) {
      header("Location: pages/404.html");
      exit;
    }
    // Сценарий для получения текущей цены
    $result_time = deletion_of_lot($lot['date_delection']);
    // Получаю максимальную ставку для того, чтобы сложить ее с первоначальной ценой и получить текущую цену
    $sql_current = "SELECT MAX(cost) AS cost, lot_id FROM bets JOIN lots ON lots.id = bets.lot_id WHERE lots.id = $id;";
    $result_current = mysqli_query($connection, $sql_current);
    $lot_max_bet = mysqli_fetch_assoc($result_current);
    $max_bet = $lot_max_bet['cost'] ?? NULL;
    if ($lot_max_bet['cost'] === NULL)
    {
        $max_bet = 0;
    }
    $current_cost = $max_bet + $lot['price'];
    //Сценарий запроса истории ставок
    $sql_bets = "SELECT bets.cost as cost, lot_id, user_id as author, users.name, time_bet as timestamp FROM bets JOIN lots ON lots.id = bets.lot_id JOIN users ON user_id = users.id WHERE lots.id = $id;";
    $result_bets = mysqli_query($connection, $sql_bets);
    $bets_history = mysqli_fetch_assoc($result_bets);
    //Сценарий добавления ставки
    $errors = [];
    $bet = $_POST;
    $min_bet = $lot['min_bet'];
    $rules = [
        'cost' => function() {
            global $min_bet;
            if (!validateBet($_POST['cost'], $min_bet)){
                return "Это поле должно быть заполнено";
            }
        }
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        foreach ($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $result = $rule($value);
                if ($result !== null) {
                    $errors[$key] = $result;
                }
            }
        }
    }
    if (empty($errors)){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_lot = [$_POST['cost'], $_SESSION['user_id'], $id];
            $sql = 'INSERT INTO `bets`(`time_bet`, `cost`, `user_id`, `lot_id`) VALUES (NOW(), ?, ?, ?)';
            $stmt = db_get_prepare_stmt($connection, $sql, $new_lot);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                $lot_id = mysqli_insert_id($connection);
                $page = "lot.php?id=" . $id;
                header("Refresh: 0; url=$page");
            }
            else{
                print("Ошибка добавления ставки!" . mysqli_error($connection));
                exit;
            }
        }
    }
    $content = include_template('lot.php', ['lot' => $lot, 'categories' => $categories, 'result_time' => $result_time, 'is_auth' => $is_auth, 'current_cost' => $current_cost, 'errors' => $errors, 'bets_history' => $bets_history]);
    $layout_content = include_template('layout.php', ['content' => $content, 'title' => $lot['name'], 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username]);
    print($layout_content);
?>
