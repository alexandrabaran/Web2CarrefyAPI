<?php

require_once './app/config.php';

class APIModel {

        protected $db;

        function __construct() {
            $this->createDatabaseIfNotExists();
            $this->db = new PDO('mysql:host='. MYSQL_HOST .';dbname='. MYSQL_DB .';charset=utf8', MYSQL_USER, MYSQL_PASS);
            $this->deploy();
        }

        private function createDatabaseIfNotExists(){
            $pdo = new PDO('mysql:host=' . MYSQL_HOST, MYSQL_USER, MYSQL_PASS);
            $query = 'CREATE DATABASE IF NOT EXISTS ' . MYSQL_DB;
            $pdo->exec($query);
        }

        function deploy() {
            $query = $this->db->query('SHOW TABLES');
            $tables = $query->fetchAll();
            if(count($tables)==0) {
                $sql =<<<END

                SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
                START TRANSACTION;
                SET time_zone = "+00:00";

                -- Database: `carrefy`

                CREATE TABLE `admins` (
                `admin_id` int(11) NOT NULL,
                `admin_user` varchar(45) NOT NULL,
                `admin_pass` varchar(45) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


                INSERT INTO `admins` (`admin_id`, `admin_user`, `admin_pass`) VALUES
                (1, 'webadmin', 'admin');

                CREATE TABLE `categories` (
                `category_id` int(11) NOT NULL,
                `category_name` varchar(45) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `categories` (`category_id`, `category_name`) VALUES
                (1, 'Lacteos'),
                (2, 'Panificados'),
                (3, 'Granja'),
                (4, 'Verduleria'),
                (5, 'Almacen'),
                (6, 'Limpieza');

                CREATE TABLE `products` (
                `product_id` int(11) NOT NULL,
                `product_name` varchar(45) NOT NULL,
                `product_price` float NOT NULL,
                `product_stock` int(11) NOT NULL,
                `category_id` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

                INSERT INTO `products` (`product_id`, `product_name`, `product_price`, `product_stock`, `category_id`) VALUES
                (1, 'Aceite girasol', 2024.6, 0, 5),
                (2, 'Tomate', 3500, 20, 4),
                (3, 'Pollo', 8800, 14, 3),
                (4, 'Huevos', 3090, 12, 3),
                (5, 'Arroz', 3700, 22, 5),
                (6, 'Aceite', 2050, 40, 5),
                (7, 'Tallarines', 1050, 33, 5),
                (8, 'Papel Higienico', 4650, 24, 6),
                (9, 'Detergente', 1790, 8, 6),
                (10, 'Pan integral', 2890, 16, 2),
                (11, 'Lechuga', 3590, 11, 4),
                (12, 'Zanahoria', 1490, 14, 4),
                (13, 'Queso untable', 2457.5, 22, 1),
                (14, 'Tostadas', 1390, 15, 2),
                (15, 'Leche', 1750, 0, 1);

                ALTER TABLE `admins`
                ADD PRIMARY KEY (`admin_id`);

                ALTER TABLE `categories`
                ADD PRIMARY KEY (`category_id`);

                ALTER TABLE `products`
                ADD PRIMARY KEY (`product_id`),
                ADD KEY `category_id` (`category_id`);

                ALTER TABLE `admins`
                MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

                ALTER TABLE `categories`
                MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

                ALTER TABLE `products`
                MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

                ALTER TABLE `products`
                ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
                COMMIT;

                END;
                $this->db->query($sql);
            }
            
        }
    }