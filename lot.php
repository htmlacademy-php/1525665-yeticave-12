<?php
    require_once("init.php");
    $id = $_GET['id'] ?? NULL;
    if ($id === NULL or ctype_digit($_GET['id']) === false) {
      header("Location: pages/404.html");
      exit;
    }
    $id = intval($_GET['id']);
    require_once("function.php");
    require_once("helpers.php");
    $sql_lot = "SELECT categories.name AS category_name, lots.name, lots.id AS id, description, first_price AS price, url, author, winner, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = $id;";
    $result_lot = mysqli_query($connection, $sql_lot);
    if (!$result_lot) {
      exit;
    }
    $lot = mysqli_fetch_assoc($result_lot);
    if ($id !== intval($lot['id'])) {
      header("Location: pages/404.html");
      exit;
    }
    $result_time = deletion_of_lot_with_seconds($lot['date_delection']);
    // Получаю максимальную ставку для того, чтобы сложить ее с первоначальной ценой и получить текущую цену
    $sql_current = "SELECT MAX(cost) AS cost, lot_id FROM bets JOIN lots ON lots.id = bets.lot_id WHERE lots.id = $id;";
    $result_current = mysqli_query($connection, $sql_current);
    $lot_max_bet = mysqli_fetch_assoc($result_current);
    $max_bet = $lot_max_bet['cost'] ?? NULL;
    if ($lot_max_bet['cost'] === NULL)
    {
        $max_bet = $lot['price'];
    }
    $current_cost = $max_bet;
    $minimal_bet = $max_bet + $lot['bet_step'];
    //Сценарий запроса истории ставок
    $sql_bets = "SELECT bets.cost as cost, lot_id, user_id as author, bets.time_bet as time, users.name FROM bets JOIN lots ON lots.id = bets.lot_id JOIN users ON user_id = users.id WHERE lots.id = $id ORDER BY bets.time_bet DESC;";
    $result_bets = mysqli_query($connection, $sql_bets);
    $bets_history = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);

    if (!empty($bets_history)) {
        $last_bet = reset($bets_history);
        $last_bet['author'] = intval($last_bet['author']);
    }
    else {
        $last_bet['author'] = 0;
    }

    if (!(isset($_SESSION['user_id'])) or $lot['author'] === $user_id or $last_bet['author'] === intval($_SESSION['user_id']) or $lot['winner'] !== NULL or strtotime($lot['date_delection']) < time()) {
        $hide = 1;
    }
    else {
        $hide = 0;
    }

    //Сценарий добавления ставки
    $errors = [];
    $bet = $_POST;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $res = validateAddBet($_POST['cost'], $minimal_bet);
        if ($res !== true)
        {
            $errors['cost'] = $res;
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
    $errors = array_filter($errors);
    $content = include_template('lot.php', ['lot' => $lot, 'categories' => $categories, 'result_time' => $result_time, 'is_auth' => $is_auth, 'minimal_bet' => $minimal_bet, 'current_cost' => $current_cost, 'errors' => $errors, 'hide' => $hide, 'bets_history' => $bets_history]);
    $layout_content = include_template('layout.php', ['content' => $content, 'title' => $lot['name'], 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username]);
    print($layout_content);
?>
