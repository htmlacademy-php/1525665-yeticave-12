<?php
    require_once("./function.php");
    require_once("db.php");
    require_once("helpers.php");
    $is_auth = rand(0, 1);
    $id = $_GET['id'] ?? null;
    if (!$id) {
      header("Location: /pages/404.html");
    }
    $sql_cat = "SELECT name, id, img FROM categories;";
    $result_cat = mysqli_query($con, $sql_cat);
    if (!$result_cat) {
      exit;
    }
    $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
      // Получаю всю информацию о лоте
      $sql_lot = "SELECT categories.name AS category_name, lots.name, lots.id, description, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = $id;";
      $result_lot = mysqli_query($con, $sql_lot);
      if (!$result_lot) {
        header("Location: /pages/404.html");
      }
      $lot_info = mysqli_fetch_all($result_lot, MYSQLI_ASSOC);
      $lot = $lot_info[0];

      // Получаю максимальную ставку для того, чтобы сложить ее с первоначальной ценой
      // Получаю все ставки
      $sql_bets = "SELECT bets.id FROM bets JOIN lots ON lots.id = bets.lot_id WHERE lots.id = $id;";
      $result_bet = mysqli_query($con, $sql_bets);
      if (!$result_bet) {
        exit;
      }
       //Считаю кол-во ставок
       $content = include_template('templates/lot.php', ['lot' => $lot, 'categories' => $categories]);
       $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Главная', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => 'Илья']);
       print($layout_content);
      //Функция подсчета времени до закрытия лота
      $result_time = deletion_of_lot($lot['date_delection']);
      //Имя автора ставки для лота и размер ставки
?>
