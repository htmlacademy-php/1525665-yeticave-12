<?php
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
  $link = mysqli_connect("localhost", "root", "", "yeticave");
  if ($link === false) {
    exit;
  }
?>
