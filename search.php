<?php
    require_once("init.php");
    require_once("function.php");
    require_once("helpers.php");
    $lots = [];
	$search = $_GET['search'] ?? '';
	if ($search) {
		$sql = "SELECT  categories.name AS category_name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN categories ON categories.id = lots.category_id WHERE date_delection > NOW() ORDER BY date_delection DESC "
		  . "WHERE MATCH(lots.name, description) AGAINST(?);";

		$stmt = db_get_prepare_stmt($connection, $sql, [$search]);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		if(!$result){
            $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
	}
    $content = include_template('search.php', ['categories' => $categories, 'connection' => $connection, 'lots' => $lots]);
    $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Результаты поиска', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username, 'search' => $search]);
    print($layout_content);
?>
