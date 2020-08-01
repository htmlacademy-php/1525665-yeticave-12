CREATE DATABASE yeticave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE YetiCave;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  register_date DATETIME not null;
  name CHAR(64),
  email VARCHAR(128),
  contacts CHAR(64),
  password CHAR(64)
);

CREATE UNIQUE INDEX user_id on users(id);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_creation DATETIME not null,
  name CHAR(64) not null,
  description TEXT(128) not null,
  image FILE,
  first_price INT not null,
  date_delection DATETIME not null,
  bet_step INT not null,
  author CHAR(64) not null,
  winner CHAR(64) not null,
  category_id CHAR(64)
);

CREATE INDEX lots_name on lots(name);
CREATE INDEX lots_desc on lots(description);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cat_name CHAR(50) not null,
	cat_img CHAR(30)
);

CREATE UNIQUE INDEX category_id on categories(id);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  time_bet DATETIME not null,
  cost_bet INT not null,
);
CREATE UNIQUE INDEX bets_id on bets(id);
