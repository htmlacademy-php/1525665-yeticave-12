<?php
require_once("init.php");
require_once("function.php");
require_once("helpers.php");
if (isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit();
}
$errors = [];
$user = $_POST;
$rules = [
    'email' => function () {
        if (!validateEmail('email')) {
            return "Введите корректный email";
        }
    },
    'password' => function () {
        if (!validateFilled('password')) {
            return "Заполните это поле";
        }
    }
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = return_validated_errors($rules, $errors, $_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    $safe_email = mysqli_real_escape_string($connection, $_POST['email']);
    $sql_info = "SELECT id, name, password FROM users WHERE email = '$safe_email'";
    $res = mysqli_query($connection, $sql_info);
    if (!$res) {
        die("Произошла ошибка!");
    }
    $user_info = mysqli_fetch_all($res, MYSQLI_ASSOC);
    if (!empty($user_info)) {
        $user_password = $user_info[0];
    }

    if (mysqli_num_rows($res) === 0) {
        $errors['email'] = 'Пользователь с таким email не зарегистрирован';
    } else {
        if (password_verify($_POST['password'], $user_password['password'])) {
            $_SESSION['user_id'] = $user_password['id'];
            $_SESSION['user_name'] = $user_password['name'];
            header("Location: index.php");
        } else {
            $errors['password'] = "Неверный пароль";
        }
    }
}
$errors = array_filter($errors);
$content = include_template('login.php', ['categories' => $categories, 'connection' => $connection, 'rules' => $rules, 'errors' => $errors]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Регистрация', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => $username, 'rules' => $rules]);
print($layout_content);
?>
