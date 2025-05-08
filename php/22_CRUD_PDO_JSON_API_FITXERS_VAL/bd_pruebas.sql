-- Active: 1741626660969@@127.0.0.1@3306@usuarisrold
DROP DATABASE IF EXISTS usuarisrolD;
CREATE DATABASE  usuarisrolD DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE usuarisrolD;

DROP TABLE IF EXISTS datos_usuarios;
CREATE TABLE datos_usuarios (
      id INT PRIMARY KEY AUTO_INCREMENT,
      nombre_apellidos VARCHAR(50),
      usuario VARCHAR(50),
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      tipo_usuario TINYINT NOT NULL CHECK (tipo_usuario IN (1, 2, 3)),
      foto VARCHAR(255),
      CONSTRAINT chk_tipo_usuario CHECK (tipo_usuario IN (1, 2, 3))
      );
INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
VALUES ('Oscar', 'Eroles', 'oscar@ejemplo.com', '$2y$14$y8C1SGalwVADZyBLGgaSAuic7RRzb4J6EDLrwBd6OykjxALzH7hZC', 1, "default-user.svg");
INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
VALUES ('Santiago', 'Perolillos', 'santiago@ejemplo.com', '$2y$14$T8abg7yuw4iMXyvmr9oQneX5aoxz0Oy29StkxakzH9h6.jjQXGXMS', 2, "default-user.svg");

INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
VALUES ('Admin', 'Hernandez', 'admin@ejemplo.com', '$2y$10$iVDiBcvRwXTcgUot/QAQ1e3KDdOQl8UUkuMkot.JSFrBtRQR4y9wm', 3, "default-user.svg");
/* Admin! */
