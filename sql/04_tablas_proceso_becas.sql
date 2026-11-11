-- =========================================================
-- SCRIPT 04: TABLAS DEL PROCESO DE BECAS Y DOCUMENTOS
-- Módulo: Postulaciones y Validación Legal
-- =========================================================

USE pst_becas_uptp;

CREATE TABLE convocatorias (
    id_convocatoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    anio_academico YEAR NOT NULL,
    cupos_disponibles INT NOT NULL,
    estado ENUM('Abierta', 'Cerrada') DEFAULT 'Abierta',
    fecha_apertura DATE,
    fecha_cierre DATE
) ENGINE=InnoDB;

CREATE TABLE postulaciones (
    id_postulacion INT AUTO_INCREMENT PRIMARY KEY,
    id_estudiante INT NOT NULL,
    id_convocatoria INT NOT NULL,
    num_seguimiento VARCHAR(20) UNIQUE NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('Guardado', 'En Revisión', 'Verificado', 'Aprobado', 'Rechazado', 'Lista de Espera') DEFAULT 'Guardado',
    score DECIMAL(5,2) DEFAULT 0.00,
    FOREIGN KEY (id_estudiante) REFERENCES estudiantes(id_estudiante) ON DELETE CASCADE,
    FOREIGN KEY (id_convocatoria) REFERENCES convocatorias(id_convocatoria) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE documentos_consignados (
    id_documento INT AUTO_INCREMENT PRIMARY KEY,
    id_postulacion INT NOT NULL,
    copia_cedula BOOLEAN DEFAULT FALSE,
    copia_partida_nacimiento BOOLEAN DEFAULT FALSE,
    copia_titulo_bachiller BOOLEAN DEFAULT FALSE,
    
    -- Validación de Notas Certificadas (Legal)
    notas_certificadas_url VARCHAR(255),
    notas_verificadas BOOLEAN DEFAULT FALSE,
    id_analista_verificador INT NULL,
    fecha_verificacion TIMESTAMP NULL,
    
    FOREIGN KEY (id_postulacion) REFERENCES postulaciones(id_postulacion) ON DELETE CASCADE,
    FOREIGN KEY (id_analista_verificador) REFERENCES usuarios(id_usuario) ON DELETE SET NULL
) ENGINE=InnoDB;