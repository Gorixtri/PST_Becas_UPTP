<?php
declare(strict_types=1);

class Usuario {
    private PDO $db;

    public function __construct(PDO $conexion) {
        $this->db = $conexion;
    }

    public function buscarPorEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email AND activo = 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado : null;
    }

    public function verificarPassword(string $password, string $hash): bool {
        return password_verify($password, $hash);
    }
}
?>