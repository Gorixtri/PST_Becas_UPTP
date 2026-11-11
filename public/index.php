<?php
declare(strict_types=1);
session_start();

// Cargamos las dependencias
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/Models/Usuario.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';

$route = $_GET['route'] ?? 'login';

switch ($route) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Procesar formulario
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $authController = new AuthController();
            $authController->login($email, $password);
        } else {
            // Mostrar formulario
            $error = $_SESSION['error'] ?? null;
            unset($_SESSION['error']);
            require_once __DIR__ . '/../app/Views/login.php';
        }
        break;

    case 'dashboard':
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?route=login");
            exit();
        }
        echo "<h1>Bienvenido al Dashboard</h1>";
        echo "<p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>";
        echo "<p>Rol: " . htmlspecialchars($_SESSION['rol']) . "</p>";
        echo "<a href='index.php?route=logout'>Cerrar Sesión</a>";
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