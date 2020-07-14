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
    $today = date("Y-m-d");
    $today = date_create($today);
    $diff = date_diff($today, $date);
    $hours_count = date_interval_format($diff, '%H');
    $minutes_count = date_interval_format($diff, '%i');
    $rest_time = [$hours_count, $minutes_count];
    $final = implode(":", $rest_time);
    if($hours_count < 1 and $minutes_count < 60){
    $add_class = 1;
    }
    return $final;
    return $add_class;
  }
?>
