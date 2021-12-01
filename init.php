<?php
  require_once("config.php");

  session_start();
  if(isset($_SESSION['user_id']) && $_SESSION['user_name']){
      $user_id = $_SESSION['user_id'];
      $is_auth = 1;
      $username = $_SESSION['user_name'];
  }
  else{
      $is_auth = 0;
      $username = null;
  }
  $connection = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], "yeticave");
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
