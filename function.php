<?php

  function format_sum (int $sum){
    $ok_sum = ceil($sum);
    if ($ok_sum >= 1000){
      $ok_sum = number_format($ok_sum, 0, ' ', ' ');
    }
    $ok_sum = $ok_sum . ' ₽';
    return $ok_sum;
  }

  function deletion_of_lot($date){
    $date = date_create($date);
    $today = date_create(date("Y-m-d H:i"));
    $diff = date_diff($today, $date);
    $days_count = date_interval_format($diff, '%d');
    $hours_count = date_interval_format($diff, '%h');
    if($days_count > 0){
      $hours_count = $hours_count + (24 * $days_count);
    }
    $minutes_count = date_interval_format($diff, '%i');
    if($minutes_count < 10){
      $minutes_count = 0 . $minutes_count;
    }
    $rest_time = [$hours_count, $minutes_count];
    return $rest_time;
  }

  function getPostVal(string $name) {
    return $_POST[$name] ?? "";
  }

  function getFilesVal(string $name) {
    return $_FILES[$name] ?? "";
  }

  function validateEmail(string $name) {
    if (!filter_input(INPUT_POST, $name, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    else{
      return true;
    }
  }

  function validateFilled(string $name) {
    if (empty($_POST[$name])) {
        return false;
     }
     else{
        return true;
     }
  }

  function validateCategory(integer $id, array $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
  }

 function validateImage(){
   if (!empty($_FILES['lot-img']['name'])) {
       $finfo = finfo_open(FILEINFO_MIME_TYPE);
       $tmp_name = $_FILES['lot-img']['tmp_name'];
       $file_type = finfo_file($finfo, $tmp_name);
               if($file_type !== "image/jpeg" && $file_type !== "image/png" && $file_type !== "image/jpg"){
                    return  false;
                  }
              }
              if(empty($_FILES['lot-img']['name'])){
                  return false;
              }
         else{
            return true;
        }
      }

  function validatePrice(string $price){
      if (empty($price)){
          return false;
      }
      if (ctype_digit($price) === false && $price !== '0') {
          return false;
      }
      else{
        return true;
      }
    }

  function validateBet(string $bet){
      if (empty($bet)){
          return false;
      }
      if (ctype_digit($bet) === false && $bet !== '0'){
        return false;
      }
      else{
        return true;
      }
    }

?>
