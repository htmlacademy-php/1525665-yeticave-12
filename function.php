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
    $rest_time = [$hours_count, $minutes_count];
    return $rest_time;
  }
?>
