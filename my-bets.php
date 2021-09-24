<?php
    require_once("function.php");
    require_once("init.php");
    require_once("helpers.php");
    if(!isset($_SESSION['user_id'])){
        header('Location: login.php');
        exit;
    }
    $id = $_SESSION['user_id'];

    $sql_bets = "SELECT bets.cost as cost, bets.time_bet as time, lots.author as id, categories.name as category, lots.name as lot_name, lots.id AS id, url as lot_image, date_delection FROM lots JOIN categories ON categories.id = lots.category_id JOIN bets ON bets.lot_id = lots.id WHERE date_delection > NOW() AND bets.user_id = $id ORDER BY bets.time_bet DESC;";
    $result_bets = mysqli_query($connection, $sql_bets);
    if (!$result_bets) {
        exit;
    }
    $bets = mysqli_fetch_all($result_bets, MYSQLI_ASSOC);
    $content = include_template('my-bets.php', ['categories' => $categories, 'connection' => $connection, 'bets' => $bets]);
    $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Мои ставки', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username]);
    print($layout_content);
?>
