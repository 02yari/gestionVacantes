<?php
session_start();

// Protege la ruta: solo usuarios con rol 'consultora'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Consultora</title>

    <!-- CSS ABSOLUTO -->
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/consultora.css">
</head>
<body>
    <h2>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h2>
    <p>Panel de consultora</p>

    <!-- LINK ABSOLUTO -->
    <a href="/proyecto_vacantes/app/controllers/AuthController.php?action=logout">
        Cerrar sesión
    </a>
</body>
</html>
