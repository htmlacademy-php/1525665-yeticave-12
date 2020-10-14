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
$cats_ids = array_column($categories, 'id');
   $lot = $_POST;
  $rules = [
    'category_id' => function() use ($cats_ids) {
        return validateCategory('category_id', $cats_ids);
    },
    'title' => function() {
        return validateFilled('title');
    },
    'first_price' => function() {
        return validatePrice('first_price');
    },
    'description' => function() {
        return validateFilled('description');
    },
    'bet_step' => function() {
        return validateBet('bet_step'); //
    },
    'date_delection' => function() {
      $date = $_POST['date_delection'];
      if (!is_date_valid($date)){
          return "Неправильный формат даты";
      }
      else{
        return null;
      }
    },
    'lot-img' => function() {
        $lotimg = $_FILES['lot-img']['name'];
        return validateImage($lotimg);// функция наличия файла('lot-img');
    }
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  foreach ($lot as $key => $value) {
       if (isset($rules[$key])) {
           $rule = $rules[$key];
           $errors[$key] = $rule($value);
       }
   }
}

if (empty($errors)){
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $lot = $_POST;
      $filename = uniqid() . $file_name;
      $lot['path'] = $filename;
      if (isset($_FILES['lot-img'])){
        move_uploaded_file($_FILES['lot-img']['tmp_name'], 'uploads/' . $filename);
      }
      $sql = 'INSERT INTO lots (date_creation, title, first_price, category_id, description, bet_step, date_delection, path) VALUES (NOW(), ?, 1, ?, ?, ?, ?, ?)';

      $stmt = db_get_prepare_stmt($link, $sql, $lot);
      $res = mysqli_stmt_execute($stmt);

      if ($res) {
        $lot_id = mysqli_insert_id($link);

        header("Location: lot.php?id=" . $lot_id);
      }
    }
  }
$errors = array_filter($errors);
$content = include_template('add.php', ['categories' => $categories, 'connection' => $connection, 'rules' => $rules, 'errors' => $errors]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Добавление лота', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => 'Илья', 'rules' => $rules]);
print($layout_content);
?>
