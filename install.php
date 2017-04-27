<?php
$mysqli = mysqli_connect('localhost', 'root', 'rg5kf', 'ft_minishop', 3306);
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}

$query = "CREATE TABLE categories (
category_id int(11) NOT NULL,
  name varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;";

$query .= "INSERT INTO categories (category_id, name) VALUES
(4, 'Art & collectible'),
(8, 'Disco'),
(1, 'Fashion'),
(3, 'Home & Garden'),
(2, 'Motor'),
(6, 'Music'),
(5, 'Sport goods');";

$query .= "CREATE TABLE commands (
command_id int(11) NOT NULL,
  user_id int(11) NOT NULL,
  total_price decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;";

$query .= "CREATE TABLE commands_products (
id int(11) NOT NULL,
  command_id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  qte int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$query .= "CREATE TABLE products (
product_id int(11) NOT NULL,
  ref varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  name varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  price decimal(10,2) NOT NULL,
  stock int(11) NOT NULL,
  active tinyint(1) NOT NULL DEFAULT '1',
  promo_rate int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;";

$query .= "INSERT INTO products (product_id, ref, name, price, stock, active, promo_rate) VALUES
(1, 'gengar-hat-001', 'Casquette Jenjar', '20.00', 9999, 1, 5),
(2, 'tondeuse-001', 'Tondeuse a gazon de ouf', '3499.99', 1, 1, 0),
(3, 'poster-latios-001', 'Drop the dracos', '30.00', 20, 1, 0),
(4, 'oras-ost-001', 'ORAS Original Soundtrack', '59.99', 18, 1, 0),
(5, 'mm-ost-001', 'Majora\'s Mask Original Soundtrack', '29.99', 50, 1, 0);";


$query .= "CREATE TABLE product_category (
id int(11) NOT NULL,
  product_id int(11) NOT NULL,
  category_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

$query .= "INSERT INTO product_category (id, product_id, category_id) VALUES
(1, 1, 1),
(2, 1, 4),
(3, 2, 2),
(4, 2, 3),
(5, 3, 4),
(6, 4, 4),
(7, 4, 6),
(8, 5, 4),
(9, 5, 6);";

$query .= "CREATE TABLE users (
user_id int(11) NOT NULL,
  login varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  passwd varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  admin tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;";

$query .= "INSERT INTO users (user_id, login, passwd, admin) VALUES
(18, 'root', '06948d93cd1e0855ea37e75ad516a250d2d0772890b073808d831c438509190162c0d890b17001361820cffc30d50f010c387e9df943065aa8f4e92e63ff060c', 1),
(19, 'willy', 'b913d5bbb8e461c2c5961cbe0edcdadfd29f068225ceb37da6defcf89849368f8c6c2eb6a4c4ac75775d032a0ecfdfe8550573062b653fe92fc7b8fb3b7be8d6', 0);";

$query .= "ALTER TABLE categories
  ADD PRIMARY KEY (category_id),
  ADD UNIQUE KEY name (name);";

$query .= "ALTER TABLE commands
  ADD PRIMARY KEY (command_id),
  ADD KEY user (user_id);";

$query .= "ALTER TABLE commands_products
  ADD PRIMARY KEY (id),
  ADD KEY command_id (command_id),
  ADD KEY product_id (product_id),
  ADD KEY product_id_2 (product_id);";

$query .= "ALTER TABLE products
  ADD PRIMARY KEY (product_id),
  ADD UNIQUE KEY ref (ref);";

$query .= "ALTER TABLE product_category
  ADD PRIMARY KEY (id),
  ADD KEY product_id (product_id),
  ADD KEY category_id (category_id);";

$query .= "ALTER TABLE users
  ADD PRIMARY KEY (user_id),
  ADD UNIQUE KEY login (login);";

$query .= "ALTER TABLE categories
  MODIFY category_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;";

$query .= "ALTER TABLE commands
  MODIFY command_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;";

$query .= "ALTER TABLE commands_products
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;";

$query .= "ALTER TABLE products
  MODIFY product_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;";

$query .= "ALTER TABLE product_category
  MODIFY id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;";

$query .= "ALTER TABLE users
  MODIFY user_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;";

$query .= "ALTER TABLE commands
  ADD CONSTRAINT user_command FOREIGN KEY (user_id) REFERENCES users (user_id);";

$query .= "ALTER TABLE commands_products
  ADD CONSTRAINT command_table FOREIGN KEY (command_id) REFERENCES commands (command_id),
  ADD CONSTRAINT product_table FOREIGN KEY (product_id) REFERENCES products (product_id);";

$query .= "ALTER TABLE product_category
  ADD CONSTRAINT category FOREIGN KEY (category_id) REFERENCES categories (category_id),
  ADD CONSTRAINT product FOREIGN KEY (product_id) REFERENCES products (product_id);";

mysqli_multi_query($mysqli, $query);
