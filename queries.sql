USE yeticave;
INSERT INTO categories (name, img)
  VALUES
  ('Доски и лыжи', 'boards'),
  ('Крепления', 'attachment'),
  ('Ботинки', 'boots'),
  ('Одежда', 'clothing'),
  ('Инструменты', 'tools'),
  ('Разное', 'other');

INSERT INTO users (register_date, name, email, contacts, password)
  VALUES
  ('2020-01-12', 'Ilya', 'ilya12@ilya.ru', 'skype: ilya', 'password'),
  ('2020-02-13', 'Sensey', 'sensey12@gmail.com', 'phone: +0987654321', 'secret'),
  ('1987-09-12', 'Lev_Landau', 'landau12@lev.com', 'whatsapp: +79809089890', 'ilovephysics');

INSERT INTO lots (date_creation, name, description, url, first_price, date_delection, bet_step, author, winner, category_id) VALUES
(
'2021-12-27',
 '2014 Rossignol District Snowboard',
 'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.',
 'img/lot-1.jpg',
 10999,
 '2022-11-11',
 500,
 2,
 NULL,
 1
),
(
  '2021-12-25',
  'DC Ply Mens 2016/2017 Snowboard',
  'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.',
  'img/lot-2.jpg',
  159999,
  '2022-07-25',
  600,
  2,
  NULL,
  1
),
(
  '2021-12-24',
  'Крепления Union Contact Pro 2015 года размер L/XL',
  'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.',
  'img/lot-3.jpg',
  8000,
  '2022-07-24',
  700,
  2,
  NULL,
  2
),
('2021-12-21',
 'Ботинки для сноуборда DC Mutiny Charocal',
 'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.',
 'img/lot-4.jpg',
 10999,
 '2022-09-21',
 1000000,
 2,
 NULL,
 3
),
('2021-12-29',
 'Куртка для сноуборда DC Mutiny Charocal',
 'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.',
 'img/lot-5.jpg',
 7500,
 '2022-07-29',
 100,
 3,
 NULL,
 4
),
('2020-07-30',
  'Маска Oakley Canopy',
  'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.',
  'img/lot-6.jpg',
  5400,
  '2022-07-30',
  200,
  2,
  NULL,
  6
);
   INSERT INTO bets(time_bet, cost, lot_id, user_id)
     VALUES
       ('2019-01-17', 10000, 2, 1),
       ('2019-01-17', 20000, 3, 2),
       ('2019-01-17', 25000, 2, 3);

SELECT name FROM categories; -- Получил все категории
SELECT categories.name, lots.name, first_price, url, bet_step FROM lots JOIN categories ON categories.id = lots.category_id;
SELECT lots.name, first_price, url, bet_step, categories.name FROM lots JOIN categories ON categories.id = lots.category_id WHERE lots.id = 5;
UPDATE lots SET name = '2014 Rossignol District Snowboard' WHERE  id = 1;
SELECT cost FROM bets ORDER BY time_bet DESC;
