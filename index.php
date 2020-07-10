<?php
      require_once("function.php");
      require_once("helpers.php");
      $categories = [
        "Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"
      ];
$is_auth = rand(0, 1);

$user_name = 'Илья';

$products = [
  [
    'title' => '2014 Rossignol District Snowboard',
    'category' => 'Доски и лыжи',
    'cost' => 10999,
    'image' => 'img/lot-1.jpg',
    'date' => '2020-07-07',
  ],

  [
    'title' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => 'Доски и лыжи',
    'cost' => 159999,
    'image' => 'img/lot-2.jpg',
    'date' => '2020-07-14',
  ],

  [
    'title' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => 'Крепления',
    'cost' => 8000,
    'image' => 'img/lot-3.jpg',
    'date' => '2020-07-14',
  ],

  [
    'title' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => 'Ботинки',
    'cost' => 10999,
    'image' => 'img/lot-4.jpg',
    'date' => '2020-07-14',
  ],
  [
    'title' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => 'Одежда',
    'cost' => 7500,
    'image' => 'img/lot-5.jpg',
    'date' => '2020-07-17',
  ],

  [
    'title' => 'Маска Oakley Canopy',
    'category' => 'Разное',
    'cost' => 5400,
    'image' => 'img/lot-6.jpg',
    'date' => '2020-07-19',
  ]

];
$content = include_template('main.php', ['categories' => $categories, 'products' => $products]);

$layout_content = include_template('layout.php', ['content' => $content, 'title' => 'Главная', 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => 'Илья']);

print($layout_content);
?>
