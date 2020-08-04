CREATE DATABASE YetiCave
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;
USE YetiCave;
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  register_date DATETIME not null;
  name CHAR(64) not null,
  email VARCHAR not null UNIQUE,
  contacts TEXT not null,
  password CHAR(64) not null
);

CREATE UNIQUE INDEX user_email on users(email);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_creation DATETIME not null,
  name CHAR(64) not null,
  description TEXT not null,
  image URL CHAR(100),
  first_price INT not null,
  date_delection DATETIME not null,
  bet_step INT not null,
  author not null,
  winner null,
  category_id INT not null
);

ALTER TABLE users ADD
FOREIGN KEY (id)
REFERENCES lots
(author);

ALTER TABLE users ADD
FOREIGN KEY (id)
REFERENCES lots
(winner);

CREATE FULLTEXT INDEX lot_text on lots(description);
CREATE INDEX lots_name on lots(name);
CREATE INDEX lots_desc on lots(description);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(50) not null,
	img CHAR(30)
);

CREATE UNIQUE INDEX category_id on categories(id);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  time_bet DATETIME not null,
  cost INT not null,
  user_id INT,
  lot_id INT
);
CREATE UNIQUE INDEX bets_id on bets(id);
