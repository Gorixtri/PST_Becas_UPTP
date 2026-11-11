-- =========================================================
-- SCRIPT 02: TABLAS GEOGRÁFICAS (Selectores en Cascada)
-- Módulo: Ubicación Geográfica (3FN)
-- =========================================================

USE pst_becas_uptp;

CREATE TABLE paises (
    id_pais INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE estados (
    id_estado INT AUTO_INCREMENT PRIMARY KEY,
    id_pais INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_pais) REFERENCES paises(id_pais) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE municipios (
    id_municipio INT AUTO_INCREMENT PRIMARY KEY,
    id_estado INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_estado) REFERENCES estados(id_estado) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE parroquias (
    id_parroquia INT AUTO_INCREMENT PRIMARY KEY,
    id_municipio INT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    FOREIGN KEY (id_municipio) REFERENCES municipios(id_municipio) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Datos semilla mínimos para probar (Venezuela, Portuguesa, Páez, Pimpinela)
INSERT INTO paises (nombre) VALUES ('Venezuela');
INSERT INTO estados (id_pais, nombre) VALUES (1, 'Portuguesa');
INSERT INTO municipios (id_estado, nombre) VALUES (1, 'Páez');
INSERT INTO parroquias (id_municipio, nombre) VALUES (1, 'Pimpinela');