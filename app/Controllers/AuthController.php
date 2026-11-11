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
        // 🛡️ 1. Limpieza de datos (Elimina espacios en blanco)
        $email = trim($email);
        $password = trim($password);

        // 🛡️ 2. Inicializar el contador de intentos
        if (!isset($_SESSION['intentos_fallidos'])) {
            $_SESSION['intentos_fallidos'] = 0;
        }

        // 🛡️ 3. Candado de seguridad (Límite de 3 intentos)
        if ($_SESSION['intentos_fallidos'] >= 3) {
            $_SESSION['error'] = "Has alcanzado el número máximo de 3 intentos fallidos. Cuenta bloqueada por seguridad.";
            header("Location: index.php?route=login");
            exit();
        }

                // 🛡️ 4. VALIDACIÓN PROFESIONAL DE EMAIL (Formato + DNS)
        
        if (empty($email)) {
            $_SESSION['error'] = "El correo electrónico no puede estar vacío.";
            header("Location: index.php?route=login");
            exit();
        }

        // Capa 1: Validación de formato estándar (Acepta .com, .ve, .edu, .mil, .gob, etc.)
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "El formato del correo no es válido. Verifique que tenga @ y un dominio.";
            header("Location: index.php?route=login");
            exit();
        }

        // Capa 2: Validación de DNS (Verifica que el dominio realmente exista en Internet)
        $dominio = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($dominio, "MX") && !checkdnsrr($dominio, "A")) {
            $_SESSION['error'] = "El dominio del correo no existe o no puede recibir mensajes. Verifique su correo.";
            header("Location: index.php?route=login");
            exit();
        }

        // 🛡️ 5. Validación de Contraseña Fuerte (Reglas del Prof. Olmo)
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

        // 🛡️ 6. Consultar Base de Datos
        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if (is_array($usuario) && isset($usuario['password_hash']) && $this->usuarioModel->verificarPassword($password, $usuario['password_hash'])) {
            // ✅ Login Exitoso
            $_SESSION['intentos_fallidos'] = 0;
            $_SESSION['usuario_id'] = $usuario['id_usuario'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['rol'] = $usuario['rol'];
            
            // Seguridad de sesión
            $_SESSION['ip_usuario'] = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
            $_SESSION['navegador'] = $_SERVER['HTTP_USER_AGENT'] ?? 'Desconocido';
            $_SESSION['ultima_actividad'] = time();
            
            header("Location: index.php?route=dashboard");
            exit();
        } else {
            // ❌ Login Fallido
            $_SESSION['intentos_fallidos']++;
            $restantes = 3 - $_SESSION['intentos_fallidos'];
            
            if ($restantes > 0) {
                $_SESSION['error'] = "Credenciales incorrectas. Te quedan {$restantes} intentos.";
            } else {
                $_SESSION['error'] = "Has alcanzado el número máximo de 3 intentos fallidos. Cuenta bloqueada.";
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