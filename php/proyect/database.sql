-- Active: 1747734032471@@127.0.0.1@3306@usuarisrole
DROP DATABASE IF EXISTS serenalive;

CREATE DATABASE  serenalive DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE serenalive;

CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo_usuario TINYINT NOT NULL,
    foto VARCHAR(255)
)ENGINE=InnoDB;

CREATE TABLE paciente (
    user_id INT PRIMARY KEY,
    nombre_paciente VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES usuario(id)
)ENGINE=InnoDB;

CREATE TABLE profesional (
    user_id INT PRIMARY KEY,
    nombre_profesional VARCHAR(50),
    FOREIGN KEY (user_id) REFERENCES usuario(id)
)ENGINE=InnoDB;

CREATE TABLE farmaco (
    nombre_farmaco VARCHAR(50) PRIMARY KEY, 
    proveedor VARCHAR(50) NOT NULL
)ENGINE=InnoDB;

CREATE TABLE dolencia (
    nombre_dolencia VARCHAR(50) PRIMARY KEY,
    farmaco VARCHAR(50),
    FOREIGN KEY (farmaco) REFERENCES farmaco(nombre_farmaco)
)ENGINE=InnoDB;

CREATE TABLE especializa (
    id_profesional INT,
    dolencia VARCHAR(50),
    PRIMARY KEY (id_profesional, dolencia),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (dolencia) REFERENCES dolencia(nombre_dolencia)
)ENGINE=InnoDB;

CREATE TABLE terapia (
    id_paciente INT,
    id_profesional INT,
    dolencia VARCHAR(50),
    fecha DATE NOT NULL,
    PRIMARY KEY (id_profesional, id_paciente, fecha),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (id_paciente) REFERENCES paciente(user_id),
    FOREIGN KEY (dolencia) REFERENCES dolencia(nombre_dolencia),
    CONSTRAINT professional_date UNIQUE (id_profesional, fecha)
)ENGINE=InnoDB;