<!-- Функция форматирования суммы -->
<?php function format_sum ($sum){

  $ok_sum = ceil($sum);
  if ($ok_sum < 1000){
  }
    elseif ($ok_sum >= 1000){
      $ok_sum = number_format($ok_sum, 0, ' ', ' ');
    }
  return $ok_sum;
}
?>
