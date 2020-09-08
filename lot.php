<?php
    $id = $_GET['id'] ?? NULL;
    if ($id === NULL) {
      header("Location: pages/404.html");
      exit;
    }
    require_once("./function.php");
    require_once("init.php");
    require_once("helpers.php");
    $sql_lot = "SELECT categories.name AS category_name, lots.name, lots.id AS id, description, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = $id;";
    $result_lot = mysqli_query($con, $sql_lot);
    if (!$result_lot) {
      exit;
    }
    $lot_info = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
    $lot = $lot_info[0];

    $is_auth = rand(0, 1);
    if ($id != $lot['id']) {
      header("Location: pages/404.html");
      exit;
    }
      $result_time = deletion_of_lot($lot['date_delection']);
      // Получаю максимальную ставку для того, чтобы сложить ее с первоначальной ценой и получить текущую цену
      $sql_current = "SELECT MAX(cost) AS cost, lot_id FROM bets JOIN lots ON lots.id = bets.lot_id WHERE lots.id = $id;";
      $result_current = mysqli_query($con, $sql_current);
      if (!$result_current) {
       exit;
      }
      $lot_max_bet = mysqli_fetch_assoc($result_current);
      $lmb = $lot_max_bet['cost'];
      if(!$lmb){
        $lmb = $lot['bet_step'];
      }
      $content = include_template('lot.php', ['lot' => $lot, 'categories' => $categories, 'result_time' => $result_time, 'lmb' => $lmb]);
      $layout_content = include_template('layout.php', ['content' => $content, 'title' => $lot['name'], 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => 'Илья']);
      print($layout_content);
?>
