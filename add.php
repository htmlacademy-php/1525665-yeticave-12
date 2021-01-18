<?php
    require_once("function.php");
    require_once("init.php");
    require_once("helpers.php");
    $is_auth = rand(0, 1);
    $errors = [];
    $cats_ids = [];
    $cats_ids = array_column($categories, 'id');
    $lot = $_POST;
    $files = $_FILES;
    $rules = [
    'category_id' => function($value) use ($cats_ids) {
        return validateCategory($value, $cats_ids);
    },
    'title' => function() {
        if (!validateFilled('title')){
        return "Это поле должно быть заполнено";
      }
    },
    'first_price' => function() {
         if(!validatePrice($_POST['first_price'])){
           return "Это поле должно быть заполнено целым положительным числом";
      }
    },
    'description' => function() {
        if (!validateFilled('description')){
        return "Это поле должно быть заполнено";
      }
    },
    'bet_step' => function() {
        if(!validateBet($_POST['bet_step'])){
        return "Это поле должно быть заполнено целым положительным числом";
       }
    },
    'date_delection' => function() {
      $date = $_POST['date_delection'];
      if (!is_date_valid($date)){
          return "Введите дату завершения торгов в формате ГГГГ-ММ-ДД";
      }
      elseif(strtotime($date) < time()){
        return "Введите дату хотя бы следующего дня или позже";
      }
    },
    'lot-img' => function() {
        if(!validateImage()){
        return "Загрузите картинку в формате jpg, jpeg или png";
      }
    }
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($lot as $key => $value) {
       if (isset($rules[$key])) {
         $rule = $rules[$key];
           $result = $rule($value);
           if ($result !== null) {
             $errors[$key] = $result;
           }
       }
    }
    }
    foreach ($files as $key => $value) {
     if (isset($rules[$key])) {
         $rule = $rules[$key];
         $result = $rule($value);
         if($result !== null){
         $errors[$key] = $result;
       }
     }
    }

    if (empty($errors)){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $file_name = $_FILES['lot-img']['name'];
          $uniq_url = uniqid();
          $file_path = __DIR__ . '/uploads/' . $uniq_url . $file_name;
          $file_path_db = 'uploads/' . $uniq_url . $file_name;
          $file_upload_result = move_uploaded_file($_FILES['lot-img']['tmp_name'], $file_path);
          if ($file_upload_result === false){
             $lot['lot-img'] = "Ошибка загрузки фото!";
             die('Произошла ошибка!');
          }
             $new_lot = [$_POST['title'], $_POST['first_price'], $_POST['category_id'], $_POST['description'], $_POST['bet_step'], $_POST['date_delection'], $file_path_db];
            $lot['url'] = $file_path;
            $sql = 'INSERT INTO lots (name, first_price, category_id, description, bet_step, date_delection, date_creation, author, url) VALUES (?, ?, ?, ?, ?, ?, NOW(), 1, ?)';
            $stmt = db_get_prepare_stmt($connection, $sql, $new_lot);
            $res = mysqli_stmt_execute($stmt);

      if ($res) {
        $lot_id = mysqli_insert_id($connection);

        header("Location: lot.php?id=" . $lot_id);
      }
      else{
        print("Ошибка добавления лота!" . mysqli_error($connection));
        exit;
      }
    }
    }
    $errors = array_filter($errors);
    $content = include_template('add.php', ['categories' => $categories, 'connection' => $connection, 'rules' => $rules, 'errors' => $errors]);
    $layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Добавление лота', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => 'Илья', 'rules' => $rules]);
    print($layout_content);
?>
