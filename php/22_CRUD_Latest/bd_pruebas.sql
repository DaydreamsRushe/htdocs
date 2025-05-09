-- Active: 1744121672729@@127.0.0.1@3306@bienesraices_crud
DROP DATABASE IF EXISTS usuarisrole;
CREATE DATABASE  usuarisrole DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE usuarisrole;
CREATE TABLE datos_usuarios (
      id INT PRIMARY KEY AUTO_INCREMENT,
      nombre_apellidos VARCHAR(50),
      usuario VARCHAR(50),
      email VARCHAR(100) NOT NULL UNIQUE,
      password VARCHAR(255) NOT NULL,
      tipo_usuario TINYINT NOT NULL,
      foto VARCHAR(255),
      CONSTRAINT chk_tipo_usuario CHECK (tipo_usuario IN (1, 2, 3))
      );
INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
VALUES ('Oscar', 'Eroles', 'oscar@ejemplo.com', '$2y$14$qzc9yTGssy7Wgeut3ILOf.h4w/n2KXPk1STqeVajsL.DdOqSMdIjm', 1, "default-user.svg");
INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
VALUES ('Santiago', 'Perolillos', 'santiago@ejemplo.com', '$2y$14$T8abg7yuw4iMXyvmr9oQneX5aoxz0Oy29StkxakzH9h6.jjQXGXMS', 2, "default-user.svg");

INSERT INTO datos_usuarios (nombre_apellidos, usuario, email, password, tipo_usuario, foto) 
VALUES ('Administrador', 'admin', 'admin@admin.com', '$2y$14$XUrGWGIAzpPgbUy3jEuO4eUB5kjjyEqQZGICCGZlSm7umVSMQsIPu', 3, "default-user.svg");

