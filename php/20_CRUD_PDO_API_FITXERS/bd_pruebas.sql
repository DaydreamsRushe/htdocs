-- Active: 1741626660969@@127.0.0.1@3306
DROP DATABASE IF EXISTS usuarisrolc;
CREATE DATABASE usuarisrolc DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE usuarisrolc;
CREATE TABLE datos_usuarios (
      id INT PRIMARY KEY AUTO_INCREMENT,
      nombre_apellidos VARCHAR(50),
      usuario VARCHAR(50),
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      tipo_usuario TINYINT NOT NULL CHECK (tipo_usuario IN(1,2)),
      foto VARCHAR(255),
      CONSTRAINT chk_tipo_usuario CHECK (tipo_usuario IN (1,2))
      );
INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) VALUES ('Oscar','Eroles','soscar@ejemplo.com','$2y$10$an9LzI8mv5WOudkHMwv4e.vUnRH4EZkGXNEV73WNKuf8GN1x8xU3q',1, 'default-user.svg');
INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) VALUES ('Santiago','Farolillos','santifar@ejemplo.com','$2y$10$Xxv2fFazpIbLUkgpvXvS4uwnd3/qtvmlgI4XZkE5JNXW.bPygIY.m',2, 'default-user.svg');
