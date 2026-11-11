<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - SIGEBE | UPTP JJ Montilla</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; min-height: 100vh; display: flex; flex-direction: column; align-items: center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; }
        .header-institucional { width: 100%; background-color: white; border-bottom: 4px solid #b91c1c; padding: 15px 0; text-align: center; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .logos-container { display: flex; justify-content: center; align-items: center; gap: 40px; margin-bottom: 10px; }
        .logos-container img { max-height: 70px; width: auto; }
        .datos-institucionales { font-size: 0.75rem; color: #475569; line-height: 1.3; }
        .datos-institucionales strong { color: #1e293b; }
        .login-container { flex: 1; display: flex; align-items: center; justify-content: center; width: 100%; padding: 2rem; }
        .login-card { width: 100%; max-width: 420px; padding: 2rem; border-radius: 8px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); background: white; text-align: center; }
        .titulo-sistema { color: #b91c1c; font-weight: 800; letter-spacing: 1px; margin-bottom: 5px; }
        .btn-institucional { background-color: #2563eb; border: none; font-weight: 600; }
        .btn-institucional:hover { background-color: #1d4ed8; }
        .footer-institucional { width: 100%; background-color: #1e293b; color: white; text-align: center; padding: 10px; font-size: 0.75rem; }
    </style>
</head>
<body>

    <!-- 1. CABECERA SUPERIOR CON LOGOS Y DATOS -->
    <header class="header-institucional">
        <div class="logos-container">
            <img src="img/logo_uptp.jpg" alt="Logo UPTP">
            <img src="img/logo_ministerio.jpg" alt="Logo Ministerio">
        </div>
        <div class="datos-institucionales">
            <strong>Universidad Politécnica Territorial del Estado Portuguesa "Juan de Jesús Montilla"</strong><br>
            Creada según Decreto Presidencial N° 8.803 (Gaceta Oficial N° 39.902 del 13/04/2012) | Fundación IUTEP: 19/09/1978<br>
            RIF: G-20010200-4 | Av. Circunvalación Sur, sector Bellas Artes, Acarigua, Edo. Portuguesa
        </div>
    </header>

    <!-- 2. FORMULARIO DE LOGIN -->
    <main class="login-container">
        <div class="login-card">
            <h2 class="titulo-sistema">SIGEBE</h2>
            <p class="text-muted mb-4" style="font-size: 0.9rem;">Sistema de Gestión de Becas</p>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger text-center py-2" role="alert" style="font-size: 0.9rem;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error']) && $_GET['error'] === 'sesion_expirada'): ?>
                <div class="alert alert-warning text-center py-2" style="font-size: 0.9rem;">
                    Tu sesión ha expirado por inactividad. Por favor, ingresa nuevamente.
                </div>
            <?php endif; ?>

            <form action="index.php?route=login" method="POST" class="text-start" autocomplete="off">
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold" style="font-size: 0.9rem;">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required placeholder="admin@uptp.edu.ve">
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label fw-bold" style="font-size: 0.9rem;">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="********">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" style="border: 1px solid #ced4da;">👁️</button>
                    </div>
                    
                    <!-- 🛡️ VALIDADOR VISUAL EN TIEMPO REAL -->
                    <div class="mt-2" style="font-size: 0.75rem;">
                        <div id="rule-length" class="text-muted">❌ Mínimo 8 caracteres</div>
                        <div id="rule-upper" class="text-muted">❌ Al menos una mayúscula</div>
                        <div id="rule-lower" class="text-muted">❌ Al menos una minúscula</div>
                        <div id="rule-number" class="text-muted">❌ Al menos un número</div>
                        <div id="rule-special" class="text-muted">❌ Al menos un carácter especial (@, #, $, etc.)</div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary btn-institucional w-100 py-2 mt-2">Ingresar al Sistema</button>
            </form>
        </div>
    </main>

    <!-- 3. PIE DE PÁGINA -->
    <footer class="footer-institucional">
        Proyecto Socio Tecnológico II - Sección 436 | PNF en Informática © 2026
    </footer>

    <!-- SCRIPTS: OJITO Y VALIDADOR -->
    <script>
        // 1. Lógica del Ojito
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁️' : '🙈';
        });

        // 2. Lógica del Validador en Tiempo Real
        const passwordInput = document.getElementById('password');
        const rules = {
            length: { el: document.getElementById('rule-length'), regex: /.{8,}/, text: "Mínimo 8 caracteres" },
            upper: { el: document.getElementById('rule-upper'), regex: /[A-Z]/, text: "Al menos una mayúscula" },
            lower: { el: document.getElementById('rule-lower'), regex: /[a-z]/, text: "Al menos una minúscula" },
            number: { el: document.getElementById('rule-number'), regex: /[0-9]/, text: "Al menos un número" },
            special: { el: document.getElementById('rule-special'), regex: /[\W_]/, text: "Al menos un carácter especial (@, #, $, etc.)" }
        };

        passwordInput.addEventListener('input', function() {
            const val = this.value;
            for (const key in rules) {
                if (rules[key].regex.test(val)) {
                    rules[key].el.innerHTML = "✅ " + rules[key].text;
                    rules[key].el.className = "text-success fw-bold";
                } else {
                    rules[key].el.innerHTML = "❌ " + rules[key].text;
                    rules[key].el.className = "text-muted";
                }
            }
        });
    </script>
</body>
</html>