-- Active: 1741626660969@@127.0.0.1@3306@pruebas
DROP DATABASE IF EXISTS usuarisrol;
CREATE DATABASE usuarisrol DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE usuarisrol;
CREATE TABLE datos_usuarios (
      id INT PRIMARY KEY AUTO_INCREMENT,
      nombre VARCHAR(50),
      apellido VARCHAR(50),
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      tipo_usuario TINYINT NOT NULL CHECK (tipo_usuario IN(1,2)),
      CONSTRAINT chk_tipo_usuario CHECK (tipo_usuario IN (1,2))
      );
INSERT INTO datos_usuarios (nombre, apellido, email, password, tipo_usuario) VALUES ('Oscar','Eroles','soscar@ejemplo.com','$2y$10$an9LzI8mv5WOudkHMwv4e.vUnRH4EZkGXNEV73WNKuf8GN1x8xU3q',1);
INSERT INTO datos_usuarios (nombre, apellido, email, password, tipo_usuario) VALUES ('Santiago','Farolillos','santifar@ejemplo.com','$2y$10$Xxv2fFazpIbLUkgpvXvS4uwnd3/qtvmlgI4XZkE5JNXW.bPygIY.m',2);
