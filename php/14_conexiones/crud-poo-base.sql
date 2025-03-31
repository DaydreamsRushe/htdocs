CREATE DATABASE crudpoo CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
USE crudpoo;

CREATE TABLE registros (
  id int() PRIMARY KEY AUTO_INCREMENT,
  nombre varchar(255) NOT NULL,
  email text NOT NULL,
  password text NOT NULL,
  fecha timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB;

