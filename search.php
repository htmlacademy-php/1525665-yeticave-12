<?php
    require_once("init.php");
    require_once("function.php");
    require_once("helpers.php");
    $lots = [];
	$search = $_GET['search'] ?? '';
	$search = mysqli_real_escape_string($connection, $search);
	if ($search) {
        $cur_page = $_GET['page'] ?? 1;
        $page_items = 9;
        $result = mysqli_query($connection, "SELECT COUNT(*) as cnt, date_delection FROM lots WHERE lots.date_delection > NOW() AND MATCH(lots.name, description) AGAINST(" . $search . ") group by lots.date_delection;");
        $count = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $items_count = count($count);

        $pages_count = ceil($items_count / $page_items);
        $offset = ($cur_page - 1) * $page_items;

        $pages = range(1, $pages_count);
        if ($cur_page > $pages_count + 1 or ctype_digit($cur_page)) {
            header("Location: pages/404.html");
        }
        // запрос на показ девяти лотов
        $sql = 'SELECT categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() AND MATCH(lots.name, description) AGAINST(' . $search . ') ORDER BY date_delection DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
        if ($lots = mysqli_query($connection, $sql)) {
            $tpl_data = [
                'categories' => $categories,
                'search' => $search,
                'lots' => $lots,
                'pages' => $pages,
                'pages_count' => $pages_count,
                'cur_page' => $cur_page,
                'items_count' => $items_count
            ];
        } else {
            $tpl_data = [
                'pages_count' => 0,
                'categories' => $categories,
                'products' => $products
            ];
        }
    }

    $content = include_template('search.php', $tpl_data);
    $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Результаты поиска', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username, 'search' => $search]);
    print($layout_content);
?>
