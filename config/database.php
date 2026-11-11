<?php
// config/database.php - Versión 0.2.1 (Seguridad Mejorada)
declare(strict_types=1);

// Ocultar errores en producción (Poka-Yoke)
ini_set('display_errors', '0');
error_reporting(E_ALL);

class Database {
    private string $host = 'localhost';
    private string $db   = 'pst_becas_uptp';
    private string $user = 'root'; 
    private string $pass = '';     

    public function getConnection(): PDO {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
            $pdo = new PDO($dsn, $this->user, $this->pass);
            // Configuración de seguridad PDO
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Previene Inyección SQL
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            // En producción no mostramos el error real
            die("Error crítico de conexión. Contacte al administrador.");
        }
    }
}
?>