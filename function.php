<?php
  function format_sum (int $sum){
    $ok_sum = ceil($sum);
    if ($ok_sum >= 1000){
      $ok_sum = number_format($ok_sum, 0, ' ', ' ');
    }
    $ok_sum = $ok_sum . ' ₽';
    return $ok_sum;
  }

  function deletion_of_lot(string $date){
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
      $minutes_count = "0" . $minutes_count;
    }
    $rest_time = [$hours_count, $minutes_count];
    return $rest_time;
  }

  function deletion_of_lot_with_seconds(string $date){
      $date = date_create($date);
      $today = date_create(date("Y-m-d H:i"));
      $diff = date_diff($today, $date);
      $days_count = date_interval_format($diff, '%d');
      $hours_count = date_interval_format($diff, '%h');
      if($days_count > 0){
          $hours_count = $hours_count + (24 * $days_count);
      }
      $minutes_count = date_interval_format($diff, '%i');
      $seconds_count = date_interval_format($diff, '%s');
      if($minutes_count < 10){
          $minutes_count = "0" . $minutes_count;
      }
      if($seconds_count < 10){
          $seconds_count = "0" . $seconds_count;
      }
      $rest_time = [$hours_count, $minutes_count, $seconds_count];
      return $rest_time;
  }

  function is_lot_expire_soon($date){
      $date = date_create($date);
      $today = date_create(date("Y-m-d H:i:s"));
      $diff = date_diff($today, $date);
      $days_count = date_interval_format($diff, '%d');
      $hours_count = date_interval_format($diff, '%h');
      if($hours_count < 24 && $days_count > 0){
         return false;
      }
      return true;
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

  function validateCategory(int $id, array $allowed_list) {
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
        if (ctype_digit($bet) === false or intval($bet) <= 0){
            return false;
        }
        else{
            return true;
        }
    }

  function validateAddBet(string $bet, string $step){
      if (empty($bet)){
          return false;
      }
      if (ctype_digit($bet) === false or intval($bet) <= 0 or intval($bet) < intval($step)){
        return false;
      }
      else{
        return true;
      }
    }

    function remaining_minutes(string $timestamp){
        $date = date_create($timestamp);
        $today = date_create(date("Y-m-d H:i"));
        $diff = date_diff($today, $date);
        $days_count = date_interval_format($diff, '%d');
        if ($days_count < 1) {
            $hours_count = date_interval_format($diff, '%h');
            if ($hours_count < 1) {
                $minutes_count = date_interval_format($diff, '%i');
                $rest = get_noun_plural_form(
                    intval($minutes_count),
                  'минута',
                  'минуты',
                  'минут'
                );
                return $minutes_count . ' ' . $rest . ' назад';
            }
            $rest = get_noun_plural_form(
                intval($hours_count),
                'час',
                'часа',
                'часов'
            );
            return $hours_count . ' ' . $rest . ' назад';
        }
        $timestamp = strtotime($timestamp);
        $date = date("Y-m-d", $timestamp);
        $time = date("h:m", $timestamp);
        return $date . ' в ' . $time;
    }

    function return_validated_errors(array $rules, array $errors)
    {
        foreach ($_POST as $key => $value) {
            if (isset($rules[$key])) {
                $rule = $rules[$key];
                $result = $rule($value);
                if ($result !== null) {
                    $errors[$key] = $result;
                }
            }
        }
        return $errors;
    }
?>
