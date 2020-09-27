<?php
      require_once("function.php");
      require_once("init.php");
      require_once("helpers.php");
  //
  $is_auth = rand(0, 1);
  $errors = [];
  //if (!$link) {
    //$error = mysqli_connect_error();
  //  show_error($content, $error);
//}
  $rules = [
    'title' => function() {
        return validateFilled('title');
    },
    'first_price' => function() {
        return validateFilled('first_price');
    },
    'description' => function() {
        return validateFilled('description');
    },
    'bet_step' => function() {
        return validateFilled('bet_step');
    },
    'date_delection' => function() {
        return is_date_valid('date_delection');
    }
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST;

        $filename = uniqid() . 'jpg';
        $lot['lot-img'] = $filename;
        move_uploaded_file($_FILES['lot-img']['title'], 'uploads/' . $filename);

        $sql = 'INSERT INTO lots (date_creation, name, category_id, description, foto, date_delection) VALUES (NOW(), ?, ?, ?, ?, ?)';

        $stmt = db_get_prepare_stmt($link, $sql, $lot);
        $res = mysqli_stmt_execute($stmt);
        // if ($res) {
        //    $lot_id = mysqli_insert_id($link);

      //      header("Location: lot.php?id=" . $lot_id );
      //  }
}

$errors = array_filter($errors);
$content = include_template('add.php', ['categories' => $categories, 'connection' => $connection, 'rules' => $rules, 'errors' => $errors]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Добавление лота', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => 'Илья']);
print($layout_content);
?>
