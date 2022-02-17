CREATE DATABASE IF NOT EXISTS shopDatabase;
USE shopDatabase;


DROP TABLE IF EXISTS `User`;
CREATE TABLE `User` (
	`id` INT PRIMARY KEY AUTO_INCREMENT,
    `email` varchar(128) NOT NULL,
    `password` VARCHAR(256) NOT NULL,
    `fname` varchar(128) NOT NULL,
    `lname` varchar(128) NOT NULL,
    `phone` varchar(12) NOT NULL,
    `gender` INT NOT NULL,
    `date_of_birth` DATE NOT NULL,
    `profile_image_url` VARCHAR(128) NOT NULL,
    UNIQUE INDEX(`email`) USING BTREE
);


DELIMITER $$
CREATE TRIGGER date_check
BEFORE INSERT ON `User`
FOR EACH ROW 
BEGIN 
	IF NEW.date_of_birth >= CURDATE() THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid Date! Enter Date From Past';
    END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER date_check_update
BEFORE UPDATE ON `User`
FOR EACH ROW 
BEGIN 
	IF NEW.date_of_birth >= CURDATE() THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid Date! Enter Date From Past';
    END IF;
END$$
DELIMITER ;



DROP TABLE IF EXISTS `ForgetPassword`;
CREATE TABLE `ForgetPassword`(
    `token` varchar(256) PRIMARY KEY,
    `user_id` INT,
    CONSTRAINT fgp_fk_user_id FOREIGN KEY (`user_id`) REFERENCES `User`(`id`)

);


DROP TABLE IF EXISTS `ProductCategories`;
CREATE TABLE `ProductCategories`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(128) NOT NULL
);


DROP TABLE IF EXISTS `Product`;
CREATE TABLE `Product`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `name` varchar(128) NOT NULL,
    `price` INT NOT NULL,
    `category_id` INT NOT NULL,
    `image_url` VARCHAR(128) NOT NULL,
    `quantity` INT NOT NULL,
    CONSTRAINT fk_product_category FOREIGN KEY (`category_id`) REFERENCES `ProductCategories`(`id`)
);


DROP TABLE IF EXISTS `Cart`;
CREATE TABLE `Cart`(
    `id` INT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `product_id` INT NOT NULL,
    `quantity` INT NOT NULL DEFAULT 1,
    `description` VARCHAR(256) DEFAULT "Product Description not found",
    CONSTRAINT fk_cart_user FOREIGN KEY (`user_id`) REFERENCES `User`(`id`),
    CONSTRAINT fk_cart_product FOREIGN KEY (`product_id`) REFERENCES `Product`(`id`)
);


-- insert dummy data to ProductCategories table
INSERT INTO `ProductCategories` (`name`) VALUES ('Men'), ('Women'), ('Female');


-- insert dummy data to Product 
INSERT INTO `Product` (`name`, `price`, `category_id`, `image_url`, `quantity`) VALUES
    ('Classic Spin', 200, 1, 'images/mensImage1.jpg', 10),
    ('Air Force 1 X', 202, 1, 'images/mensImage2.jpg', 10),
    ('Love Nana 20', 200, 1, 'images/mensImage3.jpg', 10),
    
    ('New Green Jacket', 200, 2, 'images/womensImage1.jpg', 10),
    ('Classic Dress', 202, 2, 'images/womensImage2.jpg', 10),
    ('Spring Collection', 2000, 2, 'images/womensImage3.jpg', 10),
    
    ('School Collection', 200, 3, 'images/kidsImages1.jpg', 10),
    ('Summer Camp', 202, 3, 'images/kidsImages2.jpg', 10),
    ('Love Nana 20', 200, 3, 'images/kidsImages3.jpg', 10);
    
    
    

