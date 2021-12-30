<?php
    require_once("init.php");
    require_once("function.php");
    require_once("helpers.php");

    $result = mysqli_query($connection, "SELECT COUNT(*) as cnt, id, date_delection FROM lots WHERE lots.date_delection > NOW() group by lots.id;");
    $lots_count = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $items_count = count($lots_count);
    if (isset($_GET['page'])){
         if (is_numeric($_GET['page']) === false){
             header("Location: pages/404.html");
         }
        $current_page = intval($_GET['page']);
        }
    else {
        $current_page = 1;
    }
    $page_items = 9;
    $pages_count = ceil($items_count / $page_items);
    $offset = ($current_page - 1) * $page_items;
    $pages = range(1, $pages_count);
    if (($current_page > $pages_count + 1) or $current_page <= 0) {
        header("Location: pages/404.html");
    }

    $sql_lots = 'SELECT categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() ORDER BY date_delection
     DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
    $result_lots = mysqli_query($connection, $sql_lots);
    if (!$result_lots) {
        exit;
    }
    $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

    $category_id = $_GET['category'] ?? null;
    if ($category_id !== null) {
        $category_id = intval($_GET['category']);

        $result = mysqli_query($connection, "SELECT COUNT(*) as cnt, date_delection FROM lots WHERE lots.date_delection > NOW() AND lots.category_id =' . $category_id ' group by lots.date_delection;");
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $items_count = count($lots);
        $pages_count = ceil($items_count / $page_items);
        $offset = ($current_page - 1) * $page_items;
        $pages = range(1, $pages_count);
        if ($current_page > $pages_count + 1 or ctype_digit($current_page)) {
            header("Location: pages/404.html");
        }
        // запрос на показ девяти лотов
        $sql = 'SELECT categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() AND lots.category_id ='
            . $category_id
            . ' ORDER BY date_delection DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
        $lots = mysqli_query($connection, $sql);
        if ($lots) {
            $tpl_data = [
                'categories' => $categories,
                'products' => $lots,
                'pages' => $pages,
                'pages_count' => $pages_count,
                'current_page' => $current_page
            ];
        }
    } else {
        $tpl_data = [
            'pages' => $pages,
            'pages_count' => $pages_count,
            'current_page' => $current_page,
            'categories' => $categories,
            'products' => $lots
        ];
    }
    $content = include_template('main.php', $tpl_data);

    $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Главная', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username]);

    print($layout_content);
    require_once("getwinner.php");
?>
