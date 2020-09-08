<?php
  $con = mysqli_connect("localhost", "root", "", "yeticave");
  if ($con == false) {
    exit;
  }
  mysqli_set_charset($con, "utf8");
  $sql_cat = "SELECT name, id, img FROM categories;";
  $result_cat = mysqli_query($con, $sql_cat);
  if (!$result_cat) {
    exit;
  }
  $categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);
?>
