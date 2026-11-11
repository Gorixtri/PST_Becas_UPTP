<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - SIGEBE | UPTP JJ Montilla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f8f9fa; 
            min-height: 100vh; 
            display: flex; 
            flex-direction: column;
            align-items: center; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* CABECERA INSTITUCIONAL */
        .header-institucional {
            width: 100%;
            background-color: white;
            border-bottom: 4px solid #b91c1c; /* Línea Roja Institucional */
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .logos-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-bottom: 10px;
        }
        .logos-container img {
            max-height: 70px;
            width: auto;
        }
        .datos-institucionales {
            font-size: 0.75rem;
            color: #475569;
            line-height: 1.3;
        }
        .datos-institucionales strong { color: #1e293b; }

        /* CONTENEDOR DEL LOGIN */
        .login-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 2rem;
        }
        .login-card { 
            width: 100%; 
            max-width: 400px; 
            padding: 2rem; 
            border-radius: 8px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
            background: white; 
            text-align: center; 
        }
        .titulo-sistema { color: #b91c1c; font-weight: 800; letter-spacing: 1px; margin-bottom: 5px; }
        .btn-institucional { background-color: #2563eb; border: none; font-weight: 600; }
        .btn-institucional:hover { background-color: #1d4ed8; }

        /* PIE DE PÁGINA */
        .footer-institucional {
            width: 100%;
            background-color: #1e293b;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>

    <!-- 1. CABECERA SUPERIOR CON LOGOS Y DATOS -->
    <header class="header-institucional">
        <div class="logos-container">
            <!-- OJO: Asegúrate de que las extensiones coincidan con tus archivos (.jpg o .png) -->
            <img src="img/logo_uptp.jpg" alt="Logo UPTP">
            <img src="img/logo_ministerio.jpg" alt="Logo Ministerio">
        </div>
        <div class="datos-institucionales">
            <strong>Universidad Politécnica Territorial del Estado Portuguesa "Juan de Jesús Montilla"</strong><br>
            Creada según Decreto Presidencial N° 8.803 (Gaceta Oficial N° 39.902 del 13/04/2012) | Fundación IUTEP: 19/09/1978<br>
            RIF: G-20010200-4 | Av. Circunvalación Sur, sector Bellas Artes, Acarigua, Edo. Portuguesa
        </div>
    </header>

    <!-- 2. FORMULARIO DE LOGIN (CENTRAL) -->
    <main class="login-container">
        <div class="login-card">
            <h2 class="titulo-sistema">SIGEBE</h2>
            <p class="text-muted mb-4" style="font-size: 0.9rem;">Sistema de Gestión de Becas</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center py-2" role="alert" style="font-size: 0.9rem;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form action="index.php?route=login" method="POST" class="text-start">
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold" style="font-size: 0.9rem;">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="admin@uptp.edu.ve">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold" style="font-size: 0.9rem;">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required placeholder="********">
                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">
                        Debe tener: Mínimo 8 caracteres, una Mayúscula, una minúscula, un número y un carácter especial.
                    </small>
                </div>
                <button type="submit" class="btn btn-primary btn-institucional w-100 py-2 mt-2">Ingresar al Sistema</button>
            </form>
        </div>
    </main>

    <!-- 3. PIE DE PÁGINA -->
    <footer class="footer-institucional">
        Proyecto Socio Tecnológico II - Sección 436 | PNF en Informática © 2026
    </footer>

</body>
</html>