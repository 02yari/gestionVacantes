<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/login.css">
</head>
<body>

<div class="login-container">

    <h2>Bienvenido</h2>
    <p>Accede a tu cuenta</p>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message">
            <?= $_SESSION['error'] ?>
        </div>
    <?php unset($_SESSION['error']); endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-message">
            <?= $_SESSION['success'] ?>
        </div>
    <?php unset($_SESSION['success']); endif; ?>

    <form method="POST"
          action="/proyecto_vacantes/app/controllers/AuthController.php?action=auth">

        <div class="form-group">
            <label>Correo</label>
            <input type="email" name="correo" required>
        </div>

        <div class="form-group">
            <label>Contraseña</label>
            <input type="password" name="password" required>
        </div>

        <button class="btn-login">Iniciar sesión</button>
    </form>

    <div class="login-links">
        <a href="/proyecto_vacantes/app/controllers/AuthController.php?action=register">
            Crear cuenta
        </a>

        <a href="/proyecto_vacantes/index.php">
            Volver al inicio
        </a>
    </div>

</div>

</body>
</html>
