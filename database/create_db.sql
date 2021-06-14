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