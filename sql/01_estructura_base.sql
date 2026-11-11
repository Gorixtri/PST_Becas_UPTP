-- =========================================================
-- SCRIPT 01: CREACIÓN DE LA BASE DE DATOS SIGEBE
-- Módulo: Base e Inicialización
-- Autor: Wilfredo Bracho U. 
-- =========================================================

DROP DATABASE IF EXISTS pst_becas_uptp;
CREATE DATABASE pst_becas_uptp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pst_becas_uptp;

SELECT 'Base de datos pst_becas_uptp creada exitosamente' AS Mensaje;