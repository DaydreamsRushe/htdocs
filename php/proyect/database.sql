-- Active: 1748019110775@@127.0.0.1@3306@serenalive
DROP DATABASE IF EXISTS serenalive;

CREATE DATABASE  serenalive DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE serenalive;

CREATE TABLE usuario (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    tipo_usuario TINYINT NOT NULL,
    foto VARCHAR(255),
    CONSTRAINT chk_tipo_usuario CHECK (tipo_usuario IN (1, 2))
)ENGINE=InnoDB;

CREATE TABLE enfermedad (
  nombre_enfermedad VARCHAR(50) PRIMARY KEY,
  nombre_farmaco VARCHAR(50)
)ENGINE=InnoDB;


CREATE TABLE diagnostico (
    id_diagnostico INT PRIMARY KEY AUTO_INCREMENT,
    nombre_dolencia VARCHAR(50) NOT NULL,
    farmaco VARCHAR(50),
    FOREIGN KEY (nombre_dolencia) REFERENCES enfermedad(nombre_enfermedad)
)ENGINE=InnoDB;

CREATE TABLE paciente (
    user_id INT PRIMARY KEY,
    nombre_paciente VARCHAR(50) NOT NULL,
    id_diagnostico INT,
    FOREIGN KEY (user_id) REFERENCES usuario(id),
    FOREIGN KEY (id_diagnostico) REFERENCES diagnostico(id_diagnostico)
)ENGINE=InnoDB;

CREATE TABLE profesional (
    user_id INT PRIMARY KEY,
    nombre_profesional VARCHAR(50) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES usuario(id)
)ENGINE=InnoDB;




CREATE TABLE especializa (
    id_profesional INT,
    especialidad VARCHAR(50),
    PRIMARY KEY (id_profesional, especialidad),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (especialidad) REFERENCES enfermedad(nombre_enfermedad)
)ENGINE=InnoDB;




/* Todo paciente tendra solo un profesional asociado, pero un profesional puede tener varios */
CREATE TABLE asignacion (
    id_paciente INT PRIMARY KEY,
    id_profesional INT,
    id_diagnostico INT,
    FOREIGN KEY (id_paciente) REFERENCES paciente(user_id),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (id_diagnostico) REFERENCES diagnostico(id_diagnostico)
)ENGINE=InnoDB;


CREATE TABLE visita (
    id_paciente INT,
    id_profesional INT,
    diagnostico INT,
    fecha DATE NOT NULL,
    PRIMARY KEY (id_profesional, id_paciente, fecha),
    FOREIGN KEY (id_profesional) REFERENCES profesional(user_id),
    FOREIGN KEY (id_paciente) REFERENCES paciente(user_id),
    FOREIGN KEY (diagnostico) REFERENCES diagnostico(id_diagnostico),
    CONSTRAINT professional_date UNIQUE (id_profesional, fecha)
)ENGINE=InnoDB;

/* La tabla enfermedad contendra todas las dolencias que se traten en la aplicacion */
INSERT INTO enfermedad (nombre_enfermedad, nombre_farmaco) VALUES ("Ansiedad", "Diazepam");
INSERT INTO enfermedad (nombre_enfermedad, nombre_farmaco) VALUES ("Depresion", "Sertralina");
INSERT INTO enfermedad (nombre_enfermedad, nombre_farmaco) VALUES ("Estres", NULL);
INSERT INTO enfermedad (nombre_enfermedad, nombre_farmaco) VALUES ("Insomnio", "Melatonina");
INSERT INTO enfermedad (nombre_enfermedad, nombre_farmaco) VALUES ("Adiccion", "Metadona");
INSERT INTO enfermedad (nombre_enfermedad, nombre_farmaco) VALUES ("Funcionamiento diario", "Modafinilo");

/* Creare 10 usuarios profesionales para hacer pruevas */
INSERT INTO usuario (usuario, email, password, tipo_usuario, foto) VALUES ("Oscar Eroles","oscar@eroles.com","$2y$14$NNhc1x1rrlxy3MK8m8T1luH9R.ScukwY7urRVBYFYlH/GXNFw8QV6",2,"pictures/user_3.jpg");
INSERT INTO usuario (usuario, email, password, tipo_usuario, foto) VALUES ("Santiago Perolillos","santiago@perolillos.com","$2y$14$qFMdfX6A6dyWSlMLVMExge8y4bCzcQZrZAhuKHlRw8dRtJb4vDIj.",2,"pictures/user_4.jpg");
INSERT INTO usuario (usuario, email, password, tipo_usuario, foto) VALUES ("Marta Sanchez","marta@sanchez.com","$2y$14$Xcc2dD161csRnPhYJHiH0eXJFEXQscppuct1SF7OLALS8qbbjINta",2,"pictures/user_2.jpg");
INSERT INTO usuario (usuario, email, password, tipo_usuario, foto) VALUES ("Mila Torres","mila@torres.com","$2y$14$jkUjPO9O/0BXBmhBj7tpF.fVe9I37CVs9JND09DNnDYhfrwh3rHxe",2,"pictures/user_5.jpg");
INSERT INTO usuario (usuario, email, password, tipo_usuario, foto) VALUES ("Juanma Sortos","juanma@sortos.com","$2y$14$jN1jcRe3uZlsghD9OUawU.5NpnwY12TxDrfMh95gaY5Kjh8fDo0UG",2,"pictures/user_8.jpg");
INSERT INTO usuario (usuario, email, password, tipo_usuario, foto) VALUES ("Manuel Garrido","manuel@garrido.com","$2y$14$ANg/F58fwICIFnYg9iaN1u.zE7.UhRjyr0lWIeK29g0TEslXu4BLi",2,"pictures/user_10.jpg");
INSERT INTO usuario (usuario, email, password, tipo_usuario) VALUES ("Jose Ortega","jose@ortega.com","$2y$14$vSECGMnkXL5za5C8HtwuJ.3mp4jluIUrO5oD6KZOtSPJhVqcGyNBu",2);
INSERT INTO usuario (usuario, email, password, tipo_usuario) VALUES ("Marta Suarez","marta@suarez.com","$2y$14$8BVaNexBXhWpkBd4gfSBMeq.HF4vIbDmZ6noQWXsK3Myvv9BzANDi",2);
INSERT INTO usuario (usuario, email, password, tipo_usuario) VALUES ("Sancho Panza","sancho@panza.com","$2y$14$2rsfo2FNNiPQudnrZxDrb.xAkb/dqvocWqT1LwCUp7/KAoY/1MDPe",2);
INSERT INTO usuario (usuario, email, password, tipo_usuario) VALUES ("Ariana Pequeña","ariana@pequeña.com","$2y$14$2Y4NYocr2K7FNIWZVZfyeuF4iZKkL1VzqFMEzLsOQRq5dlIHf77UC",2);



/* Esos mismos profesionales deben estar en la tabla de profesionales */
INSERT INTO profesional (user_id, nombre_profesional) VALUES (1,"Oscar Eroles");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (2,"Santiago Perolillos");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (3,"Marta Sanchez");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (4,"Mila Torres");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (5,"Juanma Sortos");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (6,"Manuel Garrido");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (7,"Jose Ortega");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (8,"Marta Suarez");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (9,"Sancho Panza");
INSERT INTO profesional (user_id, nombre_profesional) VALUES (10,"Ariana Pequeña");

/* Metemos unos cuantos pacientes */
INSERT INTO usuario (usuario, email, password, tipo_usuario) VALUES ("Joan Corto","joan@corto.com","$2y$14$VohThqmJbQq9rw3Tk4NeL.E0zuN0t7QM0xJEV6E6RLvKuBI5Fh1W6",1);

INSERT INTO diagnostico (id_diagnostico, nombre_dolencia, farmaco) VALUES (1, "Ansiedad", "Calmantes");

INSERT INTO paciente (user_id, nombre_paciente, id_diagnostico) VALUES (11,"Joan Corto",1);

INSERT INTO asignacion (id_paciente, id_profesional) VALUES (11, 7);

/* Darles algunas especialidades */
INSERT INTO especializa (id_profesional, especialidad) VALUES (1,"Ansiedad");
INSERT INTO especializa (id_profesional, especialidad) VALUES (1,"Depresion");
INSERT INTO especializa (id_profesional, especialidad) VALUES (2,"Depresion");
INSERT INTO especializa (id_profesional, especialidad) VALUES (2,"Estres");
INSERT INTO especializa (id_profesional, especialidad) VALUES (3,"Ansiedad");
INSERT INTO especializa (id_profesional, especialidad) VALUES (4,"Depresion");
INSERT INTO especializa (id_profesional, especialidad) VALUES (4,"Insomnio");
INSERT INTO especializa (id_profesional, especialidad) VALUES (4,"Adiccion");
INSERT INTO especializa (id_profesional, especialidad) VALUES (5,"Ansiedad");
INSERT INTO especializa (id_profesional, especialidad) VALUES (6,"Estres");
INSERT INTO especializa (id_profesional, especialidad) VALUES (7,"Funcionamiento diario");
INSERT INTO especializa (id_profesional, especialidad) VALUES (8,"Ansiedad");
INSERT INTO especializa (id_profesional, especialidad) VALUES (9,"Ansiedad");
INSERT INTO especializa (id_profesional, especialidad) VALUES (9,"Insomnio");
INSERT INTO especializa (id_profesional, especialidad) VALUES (10,"Depresion");