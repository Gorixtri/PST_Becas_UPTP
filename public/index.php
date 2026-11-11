<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/Usuario.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $authController = new AuthController();
            $authController->login($email, $password);
        } else {
            $error = $_SESSION['error'] ?? null;
            unset($_SESSION['error']);
            require_once __DIR__ . '/../app/Views/login.php';
        }
        break;

    case 'dashboard':
        // 🛡️ 1. Verificar que el usuario esté logueado
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?route=login");
            exit();
        }

        // 🛡️ 2. Anti-Secuestro de Sesión (IP y Navegador)
        if ($_SESSION['ip_usuario'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['navegador'] !== $_SERVER['HTTP_USER_AGENT']) {
            session_destroy();
            header("Location: index.php?route=login&error=sesion_invalida");
            exit();
        }

        // 🛡️ 3. Timeout de Inactividad (15 minutos = 900 segundos)
        if (isset($_SESSION['ultima_actividad']) && (time() - $_SESSION['ultima_actividad'] > 900)) {
            session_destroy();
            header("Location: index.php?route=login&error=sesion_expirada");
            exit();
        }
        $_SESSION['ultima_actividad'] = time(); // Actualizar actividad

        // Mostrar Dashboard
        echo "<div style='font-family: sans-serif; padding: 2rem;'>";
        echo "<h1>Bienvenido al Dashboard</h1>";
        echo "<p><strong>Email:</strong> " . htmlspecialchars($_SESSION['email']) . "</p>";
        echo "<p><strong>Rol:</strong> " . htmlspecialchars($_SESSION['rol']) . "</p>";
        echo "<a href='index.php?route=logout'>Cerrar Sesión</a>";
        echo "</div>";
        break;

    case 'logout':
        $authController = new AuthController();
        $authController->logout();
        break;

    default:
        http_response_code(404);
        echo "404 - Ruta no encontrada";
        break;
}
?>