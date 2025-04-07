-- Active: 1741626660969@@127.0.0.1@3306@pruebas
DROP DATABASE IF EXISTS pruebas;
CREATE DATABASE  pruebas DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pruebas;
CREATE TABLE datos_usuarios (
      id INT PRIMARY KEY AUTO_INCREMENT,
      Nombres VARCHAR(50),
      Apellidos VARCHAR(50)
      );
INSERT INTO datos_usuarios (Nombres,Apellidos) VALUES ('Oscar','Eroles'), ('Santiago','Perolillos');
