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
	IF NEW.dateOfBirth >= CURDATE() THEN
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Invalid Date! Enter Date From Past';
    END IF;
END$$
DELIMITER ;


DELIMITER $$
CREATE TRIGGER date_check_update
BEFORE UPDATE ON `User`
FOR EACH ROW 
BEGIN 
	IF NEW.dateOfBirth >= CURDATE() THEN
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





