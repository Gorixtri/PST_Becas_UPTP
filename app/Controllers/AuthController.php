<?php
declare(strict_types=1);

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/../../config/database.php';

class AuthController {
    private Usuario $usuarioModel;

    public function __construct() {
        $database = new Database();
        $conexion = $database->getConnection();
        $this->usuarioModel = new Usuario($conexion);
    }

    public function login(string $email, string $password): void {
        // 1. Candado de intentos (Límite 3)
        if (!isset($_SESSION['intentos_fallidos'])) {
            $_SESSION['intentos_fallidos'] = 0;
        }

        if ($_SESSION['intentos_fallidos'] >= 3) {
            $_SESSION['error'] = "Has alcanzado el número máximo de 3 intentos fallidos. Por tu seguridad, la cuenta ha sido bloqueada. Intenta de nuevo en 5 minutos.";
            header("Location: index.php?route=login");
            exit();
        }

        // 2. Validación de Email
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "El formato del correo no es válido.";
            header("Location: index.php?route=login");
            exit();
        }

        // 3. Validación de Contraseña Fuerte (Reglas del Prof. Olmo)
        $erroresPassword = [];
        if (strlen($password) < 8) $erroresPassword[] = "mínimo 8 caracteres";
        if (!preg_match('/[A-Z]/', $password)) $erroresPassword[] = "una mayúscula";
        if (!preg_match('/[a-z]/', $password)) $erroresPassword[] = "una minúscula";
        if (!preg_match('/[0-9]/', $password)) $erroresPassword[] = "un número";
        if (!preg_match('/[\W_]/', $password)) $erroresPassword[] = "un carácter especial";

        if (!empty($erroresPassword)) {
            $_SESSION['error'] = "Contraseña insegura. Falta: " . implode(", ", $erroresPassword) . ".";
            header("Location: index.php?route=login");
            exit();
        }

        // 4. Consultar Base de Datos
        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if ($usuario && $this->usuarioModel->verificarPassword($password, $usuario['password_hash'])) {
            // Login Exitoso
            $_SESSION['intentos_fallidos'] = 0;
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['rol'] = $usuario['rol'];
            
            // 🛡️ MEDIDA DE SEGURIDAD: Huella de Sesión (Anti-Hijacking)
            $_SESSION['ip_usuario'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['navegador'] = $_SERVER['HTTP_USER_AGENT'];
            $_SESSION['ultima_actividad'] = time();
            
            header("Location: index.php?route=dashboard");
            exit();
        } else {
            // Login Fallido
            $_SESSION['intentos_fallidos']++;
            $restantes = 3 - $_SESSION['intentos_fallidos'];
            
            if ($restantes > 0) {
                $_SESSION['error'] = "Credenciales incorrectas. Te quedan {$restantes} intentos.";
            } else {
                $_SESSION['error'] = "Has alcanzado el número máximo de 3 intentos fallidos. Por tu seguridad, la cuenta ha sido bloqueada.";
            }
            header("Location: index.php?route=login");
            exit();
        }
    }

    public function logout(): void {
        session_destroy();
        header("Location: index.php?route=login");
        exit();
    }
}
?>