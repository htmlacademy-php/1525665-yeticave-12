<?php

  function format_sum (int $sum){
  $ok_sum = ceil($sum);
    if ($ok_sum >= 1000){
      $ok_sum = number_format($ok_sum, 0, ' ', ' ');
    }
  $ok_sum = $ok_sum . ' ₽';
  return $ok_sum;
}

  function timer_2($date){
    $date = date_create($date);
    $today = date_create(date("Y-m-d"));
    $diff = date_diff($today, $date);
    $hours_count = date_interval_format($diff, '%H');
    $minutes_count = date_interval_format($diff, '%i');
    $rest_time = [$hours_count, $minutes_count];
    $rest_time = implode(":", $rest_time);
    return $rest_time;
  }
?>
