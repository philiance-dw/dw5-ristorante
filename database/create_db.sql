-- suppression si la base existe
DROP DATABASE IF EXISTS `ristorante`;

-- création de la base
CREATE DATABASE `ristorante`;

-- séléction de la base
USE `ristorante`;

CREATE TABLE
/* IF NOT EXISTS */
`users` (
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`first_name` VARCHAR(60) NOT NULL,
	`last_name` VARCHAR(100) NOT NULL,
	`phone` VARCHAR(10) NOT NULL,
	`address` VARCHAR(255) NOT NULL,
	`city` VARCHAR(100) NOT NULL,
	`country` VARCHAR(70) NOT NULL,
	`postal_code` VARCHAR(5) NOT NULL,
	`email` VARCHAR(255) UNIQUE NOT NULL,
	`password` VARCHAR(255) NOT NULL,
	`is_admin` BOOLEAN DEFAULT false,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `payments` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`amount` FLOAT(5, 2) NOT NULL,
	`user_id` INTEGER REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `dishes` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(255) UNIQUE NOT NULL,
	`size` ENUM("junior", "medium", "senior") NOT NULL,
	`description` TEXT NOT NULL,
	`price` FLOAT(5, 2) NOT NULL,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `cart` (
	`user_id` INTEGER REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`dish_id` INTEGER REFERENCES `dishes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME,
	PRIMARY KEY(`user_id`, `dish_id`)
);

CREATE TABLE `reviews` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`content` TEXT NOT NULL,
	`note` ENUM("1", "2", "3", "4", "5"),
	`user_id` INTEGER REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`dish_id` INTEGER REFERENCES `dishes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `orders` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`status` VARCHAR(50) NOT NULL,
	`method` VARCHAR(25) NOT NULL,
	`user_id` INTEGER REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `order_details` (
	`dish_id` INTEGER REFERENCES `dishes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`order_id` INTEGER REFERENCES `orders`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME,
	PRIMARY KEY(`dish_id`, `order_id`)
);

CREATE TABLE `categories` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) NOT NULL,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `products` (
	`id` INTEGER AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(150) UNIQUE NOT NULL,
	`quantity` INTEGER NOT NULL,
	`price` FLOAT(5, 2) NOT NULL,
	`category_id` INTEGER REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME
);

CREATE TABLE `ingredients` (
	`product_id` INTEGER REFERENCES `products`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`dish_id` INTEGER REFERENCES `dishes`(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	`created_at` DATETIME DEFAULT NOW(),
	`updated_at` DATETIME,
	PRIMARY KEY (`product_id`, `dish_id`)
);

INSERT INTO `users` (
		`first_name`,
		`last_name`,
		`phone`,
		`address`,
		`city`,
		`country`,
		`postal_code`,
		`email`,
		`password`,
		`is_admin`
	)
VALUES (
		'John',
		'Doe',
		'0123456789',
		'4 rue du test',
		'testville',
		'testpays',
		'75001',
		'test@test.com',
		'$2y$14$MvQ8WCwDVeJbr36FUzP32.dn6hWOVVVR6rbe8mNX9NiFsr9WDFAeW',
		-- Test_123+
		TRUE
	);