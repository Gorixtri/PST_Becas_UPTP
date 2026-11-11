-- =========================================================
-- SCRIPT 03: TABLAS DE USUARIOS, ESTUDIANTES Y SAIME
-- Módulo: Identidad y Datos Personales
-- Regla SAIME: V, E, P (Validación con TRIGGER)
-- =========================================================

USE pst_becas_uptp;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('Admin', 'Coordinador', 'Analista', 'Estudiante') NOT NULL DEFAULT 'Estudiante',
    activo BOOLEAN DEFAULT TRUE,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE estudiantes (
    id_estudiante INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT UNIQUE NOT NULL,
    nacionalidad ENUM('V', 'E', 'P') NOT NULL DEFAULT 'V',
    documento VARCHAR(20) UNIQUE NOT NULL, 
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    genero ENUM('Femenino', 'Masculino') NOT NULL,
    fecha_nacimiento DATE NOT NULL, -- La edad se calcula en PHP, no se guarda
    discapacidad BOOLEAN DEFAULT FALSE,
    tipo_discapacidad VARCHAR(100) NULL,
    estado_civil VARCHAR(20),
    telefono_movil VARCHAR(20),
    telefono_trabajo VARCHAR(20),
    telefono_fijo VARCHAR(20),
    etnia VARCHAR(50),
    direccion TEXT,
    foto_url VARCHAR(255), -- Ruta de la foto subida por el estudiante
    
    -- Datos Académicos
    fecha_ingreso DATE,
    condicion_residencia VARCHAR(50),
    becado_actualmente BOOLEAN DEFAULT FALSE,
    privado_libertad BOOLEAN DEFAULT FALSE,
    anio_egreso_bachiller INT,
    dependencia_instituto VARCHAR(50),
    sistema_estudio VARCHAR(50),
    rama_estudio VARCHAR(50),
    
    -- Ubicaciones
    id_parroquia_nacimiento INT,
    id_parroquia_residencia INT,
    
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE,
    FOREIGN KEY (id_parroquia_nacimiento) REFERENCES parroquias(id_parroquia) ON DELETE SET NULL,
    FOREIGN KEY (id_parroquia_residencia) REFERENCES parroquias(id_parroquia) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================================================
-- REGLA DE NEGOCIO: VALIDACIÓN SAIME CON TRIGGER
-- =========================================================
DELIMITER //
CREATE TRIGGER validar_documento_saime
BEFORE INSERT ON estudiantes
FOR EACH ROW
BEGIN
    IF NEW.nacionalidad IN ('V', 'E') AND NEW.documento REGEXP '[^0-9]' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Cédula V o E debe ser solo números.';
    END IF;
    IF NEW.nacionalidad = 'P' AND NEW.documento REGEXP '^[0-9]+$' THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Pasaporte debe contener letras y números.';
    END IF;
END;
//
DELIMITER ;