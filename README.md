# 🏛️ SIGEBE: Sistema de Gestión de Becas (UPTP JJ Montilla)

[![Versión](https://img.shields.io/badge/Versión-0.1.0-blue.svg)](https://github.com/Gorixtri/PST_Becas_UPTP)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4.svg?logo=php&logoColor=white)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1.svg?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![Licencia](https://img.shields.io/badge/Licencia-Software%20Libre-green.svg)]()

## 📖 Descripción General
SIGEBE es una aplicación web de arquitectura **MVC** diseñada para automatizar el proceso de control y asignación de becas estudiantiles en el Departamento de Bienestar Estudiantil de la UPTP "Juan de Jesús Montilla".

## 🎯 Objetivos del Sistema
1. Reducir el tiempo de procesamiento de solicitudes de >30 días a <5 días hábiles.
2. Validar la integridad académica (cruce de notas declaradas vs. oficiales).
3. Implementar un algoritmo de priorización multicriterio (Scoring).
4. Generar reportes interoperables con el Sistema Patria.

## 🛠️ Stack Tecnológico
* **Backend:** PHP 8.x (POO, PDO, Strict Types).
* **Base de Datos:** MySQL 8.x (InnoDB, 3FN, Átomo).
* **Frontend:** HTML5, CSS3, JS (Bootstrap 5, Chart.js).
* **Control de Versiones:** Git & GitHub (Conventional Commits).

## 📂 Arquitectura del Repositorio
```text
PST_Becas_UPTP/
├── app/               # Lógica de negocio (Controllers, Models, Views)
├── config/            # Configuración del sistema (database.php)
├── public/            # Punto de entrada (index.php, assets css/js)
├── sql/               # Scripts DDL y DML para la base de datos
├── docs/              # Documentación técnica y de usuario
│   ├── 01_Tutoriales/
│   ├── 02_Guia_HowTo/
│   ├── 03_Referencia_Tecnica/
│   └── 04_Explicacion_Conceptos/
├── project_management/# Gestión del proyecto (Ishikawa, Entrevistas)
└── README.md