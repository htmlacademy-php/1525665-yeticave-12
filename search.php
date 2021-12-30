<?php
require_once("init.php");
require_once("function.php");
require_once("helpers.php");
$lots = [];
$search = $_GET['search'] ?? '';
if ($search === '') {
    header("Location: pages/404.html");
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (iconv_strlen($search) < 4) {
        $errors['search'] = 'Введите более 3-х символов для поиска лота';
    }
}
if ($search && empty($errors)) {
    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;
    $sql = 'SELECT COUNT(*) as cnt, date_delection FROM lots WHERE lots.date_delection > NOW() AND MATCH(lots.name, description) AGAINST(?) group by lots.id;';
    $stmt = db_get_prepare_stmt($connection, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        die(mysqli_error($result));
    }
    $count_lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $items_count = count($count_lots);

    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

    $pages = range(1, $pages_count);
    if ($cur_page > $pages_count + 1 or ctype_digit($cur_page)) {
        header("Location: pages/404.html");
    }

    $sql = 'SELECT categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() AND MATCH(lots.name, description) AGAINST(?) ORDER BY date_delection DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;
    $stmt = db_get_prepare_stmt($connection, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if ($lots) {
        $tpl_data = [
            'categories' => $categories,
            'search' => $search,
            'lots' => $lots,
            'pages' => $pages,
            'pages_count' => $pages_count,
            'current_page' => $cur_page,
            'items_count' => $items_count
        ];
    } else {
        $tpl_data = [
            'pages_count' => 0,
            'items_count' => 0,
            'categories' => $categories
        ];
    }
} else {
    $tpl_data = [
        'pages_count' => 0,
        'items_count' => 0,
        'errors' => $errors,
        'search' => $search,
        'categories' => $categories
    ];
}

$content = include_template('search.php', $tpl_data);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Результаты поиска', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username, 'search' => $search]);
print($layout_content);
?>
