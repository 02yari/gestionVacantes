<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$rol_predefinido = $_GET['tipo'] ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/register.css">
</head>
<body>

<div class="login-container">

    <h2>Crear cuenta</h2>
    <p>Registra tu acceso a la plataforma</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?= $_SESSION['error'] ?>
        </div>
    <?php unset($_SESSION['error']); endif; ?>

    <form method="POST"
          action="/proyecto_vacantes/app/controllers/AuthController.php?action=store">

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" required>
        </div>

        <div class="form-group">
            <label>Correo</label>
            <input type="email" name="correo" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>Tipo de cuenta</label>
            <?php if ($rol_predefinido === 'postulante'): ?>
                <input type="hidden" name="rol" value="postulante">
                <p>Postulante</p>
            <?php else: ?>
                <select name="rol" required>
                    <option value="">Seleccione una opción</option>
                    <option value="empresa">Empresa</option>
                    <option value="consultora">Consultora</option>
                </select>
            <?php endif; ?>
        </div>

        <button class="btn-login">Crear cuenta</button>
    </form>

    <div class="login-links">
        <a href="/proyecto_vacantes/app/controllers/AuthController.php?action=login">
            Volver al inicio de sesión
        </a>
    </div>

</div>

</body>
</html>
