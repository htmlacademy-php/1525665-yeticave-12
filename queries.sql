USE YetiCave
INSERT INTO categories (name) VALUES ('Доски и лыжи' 'Крепления' 'Ботинки' 'Одежда' 'Инструменты' 'Разное');
INSERT INTO users (register_date, name, email, contacts, password) VALUES ('12.01.2020', 'Ilya', 'ilya@ilya.ru', 'skype: ilya', 'password');
INSERT INTO lots (date_creation, name, description, url, first_price, date_delection, bet_step, author, winner, category_id) VALUES (
   '2020-07-27' '2020-07-25' '2020-07-24' '2020-07-21' '2020-07-29' '2020-07-30',
   '2014 Rossignol District Snowboard' 'DC Ply Mens 2016/2017 Snowboard' 'Крепления Union Contact Pro 2015 года размер L/XL' 'Ботинки для сноуборда DC Mutiny Charocal' 'Куртка для сноуборда DC Mutiny Charocal' 'Маска Oakley Canopy',
   'Красочное и запоминающееся описание, побуждающее вас к покупке данного товара.' ,
   'img/lot-1.jpg' 'img/lot-2.jpg' 'img/lot-3.jpg' 'img/lot-4.jpg'  'img/lot-5.jpg' 'img/lot-6.jpg' ,
   '10999' '159999' '8000' '10999' '7500' '5400',
   '2020-11-11' '2020-07-25' '2020-07-24' '2020-07-21' '2020-07-29' '2020-07-30',
   '500' '600' '700' '1000000' '1' '222',
   '2' '2' '2' '2' '2' '2',
   '1' '1' '1' '1' '1' '1',
   '1' '1' '2' '3' '4' '6'
   );
INSERT INTO bets (time_bet, cost, user_id, lot_id) VALUES(
  '2020-10-12' '2020-08-08',
  '11000' '12000',
  '1' '2',
  '1' '2',
);

SELECT name FROM categories; -- Получил все категории
SELECT name, first_price, url, first_price + bet_step FROM lots JOIN categories; --
SELECT lot_id, name FROM lots JOIN categories;
UPDATE lots SET name = '2014 Rossignol District Snowboard'  id = '1';--
SELECT cost FROM bets ORDER BY time_bet DESC;
