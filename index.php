<?php
    require_once("init.php");
    $sql_lots = "SELECT categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() ORDER BY date_delection DESC;";
    $result_lots = mysqli_query($connection, $sql_lots);
    if (!$result_lots) {
      exit;
    }
    $products = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);

    require_once("function.php");
    require_once("helpers.php");

    $cur_page = $_GET['page'] ?? 1;
    $category_id = $_GET['category'] ?? null;
    if ($category_id !== null) {
        $category_id = intval($_GET['category']);
        $page_items = 9;

        $result = mysqli_query($connection, "SELECT COUNT(*) as cnt, date_delection FROM lots WHERE lots.date_delection > NOW() AND lots.category_id =' . $category_id 'group by lots.date_delection;");
        $count = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $items_count = count($count);

        $pages_count = ceil($items_count / $page_items);
        $offset = ($cur_page - 1) * $page_items;

        $pages = range(1, $pages_count);
        if ($cur_page > $pages_count + 1 or ctype_digit($cur_page)) {
            header("Location: pages/404.html");
        }
        // запрос на показ девяти лотов
        $sql = 'SELECT categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() AND lots.category_id ='
            . $category_id
            . ' ORDER BY date_delection DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
        if ($lots = mysqli_query($connection, $sql)) {
            $tpl_data = [
                'categories' => $categories,
                'products' => $lots,
                'pages' => $pages,
                'pages_count' => $pages_count,
                'cur_page' => $cur_page
            ];
        }
    } else {
        $tpl_data = [
            'pages_count' => 0,
            'categories' => $categories,
            'products' => $products
        ];
    }
    require_once("getwinner.php");
    $content = include_template('main.php', $tpl_data);

    $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Главная', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username]);

    print($layout_content);
?>
