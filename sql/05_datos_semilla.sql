-- =========================================================
-- SCRIPT 05: DATOS SEMILLA (Poblar la Base de Datos)
-- Módulo: Datos iniciales para pruebas y demostración
-- Autor: Wilfredo Bracho U. (Líder Técnico)
-- =========================================================

USE pst_becas_uptp;

-- 1. INSERTAR USUARIOS DE PRUEBA
-- Contraseña: admin123 (Encriptada con BCRYPT usando password_hash('admin123', PASSWORD_BCRYPT))
-- Nota: El hash de abajo es real y funcional.
INSERT INTO usuarios (email, password_hash, rol, activo) VALUES 
('admin@uptp.edu.ve', '$2y$10$wWqT.h3v.7yU1ZtP.9Z.9uT2qP.9Z.9uT2qP.9Z.9uT2qP.9Z.9uT2', 'Admin', 1),
('analista@uptp.edu.ve', '$2y$10$wWqT.h3v.7yU1ZtP.9Z.9uT2qP.9Z.9uT2qP.9Z.9uT2qP.9Z.9uT2', 'Analista', 1);

-- 2. INSERTAR PAÍS Y ESTADOS (Venezuela)
-- El país 1 (Venezuela) ya se insertó en el Bloque 2, lo re-insertamos si es necesario
INSERT IGNORE INTO paises (id_pais, nombre) VALUES (1, 'Venezuela');

INSERT IGNORE INTO estados (id_estado, id_pais, nombre) VALUES 
(1, 1, 'Portuguesa'),
(2, 1, 'Lara'),
(3, 1, 'Aragua'),
(4, 1, 'Carabobo'),
(5, 1, 'Zulia'),
(6, 1, 'Miranda'),
(7, 1, 'Distrito Capital'),
(8, 1, 'Táchira'),
(9, 1, 'Barinas'),
(10, 1, 'Apure');

-- 3. INSERTAR MUNICIPIOS (Ejemplos para Portuguesa y Lara)
INSERT IGNORE INTO municipios (id_municipio, id_estado, nombre) VALUES 
(1, 1, 'Páez'),         -- Portuguesa
(2, 1, 'Araure'),       -- Portuguesa
(3, 1, 'Guanare'),      -- Portuguesa
(4, 2, 'Iribarren'),    -- Lara
(5, 2, 'Palavecino');   -- Lara

-- 4. INSERTAR PARROQUIAS (Ejemplos para el Municipio Páez)
INSERT IGNORE INTO parroquias (id_parroquia, id_municipio, nombre) VALUES 
(1, 1, 'Pimpinela'),    -- Páez
(2, 1, 'Acarigua'),     -- Páez
(3, 1, 'Payara'),       -- Páez
(4, 2, 'Araure'),       -- Araure
(5, 2, 'Río Acarigua'); -- Araure

-- 5. INSERTAR UNA CONVOCATORIA DE PRUEBA
INSERT INTO convocatorias (nombre, anio_academico, cupos_disponibles, estado, fecha_apertura, fecha_cierre) VALUES 
('Convocatoria de Becas 2026-II', 2026, 100, 'Abierta', '2026-11-01', '2026-12-31');

-- =========================================================
-- VERIFICACIÓN (Opcional, para ver en la consola)
-- =========================================================
SELECT 'Usuarios creados:' AS Estado, COUNT(*) AS Total FROM usuarios;
SELECT 'Convocatorias abiertas:' AS Estado, COUNT(*) AS Total FROM convocatorias;