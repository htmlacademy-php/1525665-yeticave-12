<?php

  function format_sum (int $sum){
  $ok_sum = ceil($sum);
    if ($ok_sum >= 1000){
      $ok_sum = number_format($ok_sum, 0, ' ', ' ');
    }
  $ok_sum = $ok_sum . " " . "₽";
  return $ok_sum;
}
?>
