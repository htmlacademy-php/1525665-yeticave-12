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

  function getPostVal($name) {
    return $_POST[$name] ?? "";
}
function validateFilled($name) {
 if (empty($_POST[$name])) {
     return "Это поле должно быть заполнено";
 }
}

function validateCategory($id, $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }

    return null;
}
 function validateImage($file){
 if (!empty($_FILES['lot-img']['name'])) {
     $tmp_name = $_FILES['lot-img']['tmp_name'];
       $_FILES['tmp_name'] = $file_name;
       $path = $_FILES['lot-img']['name'];
       $filename = uniqid() . $tmp_name;
             if($file_name !== "image/jpeg" && $file_name !== "image/jpg" && $file_name !== "image/png"){
                  $errors['lot-img'] = "Загрузите картинку в формате jpg, jpeg или png";
                  return $errors['lot-img'];
                }
            }

        elseif (empty($_FILES['lot-img']['name'])) {
          return "Загрузите фото";
        }
        else{
          return null;
        }
      }

function validatePrice($price){
  if (empty($_POST['first_price'])) {
      return "Это поле должно быть заполнено";
  }
  elseif (!is_numeric($price)) {
    return "Это поле должно быть заполнено числом";
  }
  else{
    if($price > 0){
      return null;
    }
    else{
      return "Начальная цена должна быть положительной";
    }
  }
}

function validateBet($bet){
  if (empty($_POST['bet_step'])) {
      return "Это поле должно быть заполнено";
  }
  elseif (!is_numeric($bet)) {
    return "Это поле должно быть заполнено числом";
  }
  else{
    if($bet > 0 && is_int($bet)){
      return null;
    }
    else{
      return "Ставка для лота должна быть целым положительным числом";
    }
  }
}

?>
