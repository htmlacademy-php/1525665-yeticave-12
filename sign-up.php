<?php
require_once("init.php");
require_once("function.php");
require_once("helpers.php");
if (isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
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
    },
    'name' => function () {
        if (!validateFilled('name')) {
            return "Заполните это поле";
        }
    },
    'message' => function () {
        if (!validateFilled('message')) {
            return "Заполните это поле";
        }
    }
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = return_validated_errors($rules, $errors, $_POST);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errors)) {
    $safe_email = mysqli_real_escape_string($connection, $user['email']);
    $sql = "SELECT id FROM users WHERE email = '$safe_email'";
    $res = mysqli_query($connection, $sql);
    if (mysqli_num_rows($res) > 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегистрирован';
    } else {
        $safe_name = mysqli_real_escape_string($connection, $_POST['name']);
        $safe_message = mysqli_real_escape_string($connection, $_POST['message']);
        $passwordHash = password_hash($user['password'], PASSWORD_DEFAULT);
        $new_user = [$safe_name, $safe_email, $safe_message, $passwordHash];
        $sql = 'INSERT INTO users (register_date, name, email, contacts, password) VALUES (NOW(), ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($connection, $sql, $new_user);
        $res = mysqli_stmt_execute($stmt);

        $sql_categories = "SELECT name, id, img FROM categories;";
        $result_categories = mysqli_query($connection, $sql_categories);
        if (!$result_categories) {
            exit;
        }
        $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

        if ($res && empty($errors)) {
            header("Location: login.php");
            exit;
        }
    }
}
$errors = array_filter($errors);
$content = include_template('sign-up.php', ['categories' => $categories, 'connection' => $connection, 'rules' => $rules, 'errors' => $errors]);
$layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Регистрация', 'categories' => $categories, 'is_auth' => $is_auth, 'username' => $username, 'rules' => $rules]);
print($layout_content);
?>
