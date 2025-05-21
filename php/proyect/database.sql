-- Active: 1741626660969@@127.0.0.1@3306@ejercicioprofe
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
    nombre_paciente VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuario(id)
)ENGINE=InnoDB;

CREATE TABLE profesional (
    user_id INT PRIMARY KEY,
    nombre_profesional VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuario(id)
)ENGINE=InnoDB;

CREATE TABLE diagnostico (
    id_diagnostico INT PRIMARY KEY AUTO_INCREMENT,
    nombre_dolencia VARCHAR(50) NOT NULL,
    farmaco VARCHAR(50),
    FOREIGN KEY (nombre_dolencia) REFERENCES enfermedad(nombre_enfermedad)
)ENGINE=InnoDB;

CREATE TABLE especializa (
    id_profesional INT,
    especialidad VARCHAR(50),
    PRIMARY KEY (id_profesional, dolencia),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (especialidad) REFERENCES enfermedad(nombre_enfermedad)
)ENGINE=InnoDB;

CREATE TABLE enfermedad (
  nombre_enfermedad VARCHAR(50) PRIMARY KEY,
  nombre_farmaco VARCHAR(50)
)ENGINE=InnoDB;

/* Todo paciente tendra solo un profesional asociado, pero un profesional puede tener varios */
CREATE TABLE visita (
    id_paciente INT,
    id_profesional INT,
    diagnostico INT,
    fecha DATE NOT NULL,
    PRIMARY KEY (id_profesional, id_paciente, fecha),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (id_paciente) REFERENCES paciente(user_id),
    FOREIGN KEY (diagnostico) REFERENCES diagnostico(id_diagnostico),
    CONSTRAINT professional_date UNIQUE (id_profesional, fecha),
)ENGINE=InnoDB;