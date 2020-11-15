<?php
  session_start();
  define('CACHE_DIR', basename(__DIR__ . DIRECTORY_SEPARATOR . 'cache'));
  define('UPLOAD_PATH', basename(__DIR__ . DIRECTORY_SEPARATOR . 'uploads'));
  $connection = mysqli_connect("localhost", "root", "", "yeticave");
  if ($connection === false) {
    exit;
  }
  mysqli_set_charset($connection, "utf8");
  $sql_categories = "SELECT name, id, img FROM categories;";
  $result_categories = mysqli_query($connection, $sql_categories);
  if (!$result_categories) {
    exit;
  }
  $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);
?>
