<?php
    require_once("init.php");
    require_once("function.php");
    require_once("helpers.php");
    $lots = [];
    mysqli_query($connection, 'CREATE FULLTEXT INDEX lots_search ON lots(name, description)');
	$search = $_GET['search'] ?? '';
	if ($search) {
		$sql = "SELECT users.name, lots.name, lots.id AS id, first_price, url, date_delection, bet_step FROM lots JOIN users ON users.id = lots.author "
		  . "WHERE MATCH(lots.name, description) AGAINST(?)";

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
