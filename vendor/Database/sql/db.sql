DROP DATABASE IF EXISTS Order_form;
CREATE DATABASE Order_form DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
USE Order_form;


-- Table structure for table Coupon_code
DROP TABLE IF EXISTS Coupon_code;
CREATE TABLE Coupon_code (
    `id` INT(3) NOT NULL AUTO_INCREMENT,
    `active` tinyint(1) NOT NULL,
    `code` VARCHAR(255) COLLATE utf8_polish_ci NOT NULL,
    `percent` FLOAT(11) NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

LOCK TABLES Coupon_code WRITE;
INSERT INTO Coupon_code VALUES
    (1, 1, '5PLFAST', 0.5),
    (2, 0, 'Q95FAST', 0.25);

UNLOCK TABLES;


-- Table structure for table User
DROP TABLE IF EXISTS User;
CREATE TABLE User (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `login` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `pass` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `name` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `surname` varchar(255) COLLATE utf8_polish_ci NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

LOCK TABLES User WRITE;
INSERT INTO User VALUES
    (1, 'developer', '$2y$10$xbYWmiExwvDuiLcST3hbIe2JiFwmhS4f9htqCJYjjKf38EhrUGzv6', 'Kamil', 'Nowak');

UNLOCK TABLES;


-- Table structure for table Address
DROP TABLE IF EXISTS Address;
CREATE TABLE Address (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL REFERENCES User (`id`),
    `Country` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `address` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `postcode` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `town` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `phone` varchar(255) COLLATE utf8_polish_ci NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

LOCK TABLES Address WRITE;
INSERT INTO Address VALUES
    (1, 1, 'Polska', 'Opole', '45-003', 'Opole', '512 123 938');

UNLOCK TABLES;


-- Table structure for table Order_info
DROP TABLE IF EXISTS Order_info;
CREATE TABLE Order_info (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL REFERENCES User (`id`),
    `order_number` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `price` FLOAT(11) NOT NULL,
    `delivery_method` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `payment_method` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `comment` varchar(255) COLLATE utf8_polish_ci NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

LOCK TABLES Order_info WRITE;
INSERT INTO Order_info VALUES
    (1, 1, 'asd7a8s7d9byp2ebbaps9dypq', 115.00, 'inpost', 'Bank transfer', '');

UNLOCK TABLES;


-- Table structure for table Delivery_method
DROP TABLE IF EXISTS Delivery_method;
CREATE TABLE Delivery_method (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `description` varchar(255) COLLATE utf8_polish_ci NOT NULL,
    `price` FLOAT(11) NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

LOCK TABLES Delivery_method WRITE;
INSERT INTO Delivery_method VALUES
    (1, 'Paczkomaty 24/7', 10.99),
    (2, 'Kurier DPD', 18.00),
    (3, 'Kurier DPD pobranie', 22.00);

UNLOCK TABLES;


-- Table structure for table Country
DROP TABLE IF EXISTS Country;
CREATE TABLE Country (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `country` varchar(255) COLLATE utf8_polish_ci NOT NULL,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

LOCK TABLES Country WRITE;
INSERT INTO Country (`country`) VALUES
    ('Albania'),
    ('Andora'),
    ('Austria'),
    ('Belgia'),
    ('Białoruś'),
    ('Bośnia i Hercegowina'),
    ('Bułgaria'),
    ('Chorwacja'),
    ('Cypr'),
    ('Czarnogóra'),
    ('Czechy'),
    ('Dania'),
    ('Estonia'),
    ('Finlandia'),
    ('Francja'),
    ('Grecja'),
    ('Hiszpania'),
    ('Holandia'),
    ('Irlandia'),
    ('Islandia'),
    ('Kosowo'),
    ('Liechtenstein'),
    ('Litwa'),
    ('Luksemburg'),
    ('Łotwa'),
    ('Macedonia'),
    ('Malta'),
    ('Mołdawia'),
    ('Monako'),
    ('Niemcy'),
    ('Norwegia'),
    ('Polska'),
    ('Portugalia'),
    ('Rosja'),
    ('Rumunia'),
    ('San Marino'),
    ('Serbia'),
    ('Słowacja'),
    ('Słowenia'),
    ('Szwajcaria'),
    ('Szwecja'),
    ('Turcja'),
    ('Ukraina'),
    ('Watykan'),
    ('Węgry'),
    ('Wielka Brytania'),
    ('Włochy');

UNLOCK TABLES;


-- Check tables
system echo 'Table: Coupon_code';
SELECT * FROM Coupon_code;

system echo 'Table: User';
SELECT * FROM User;

system echo 'Table: Address';
SELECT * FROM Address;

system echo 'Table: Order_info';
SELECT * FROM Order_info;

system echo 'Table: Delivery_method';
SELECT * FROM Delivery_method;

system echo 'Table: Country';
SELECT * FROM Country;
