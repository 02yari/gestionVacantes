<?php
session_start();

// Protege la ruta: solo usuarios con rol 'consultora'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
    header("Location: ../../app/controllers/AuthController.php?action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Consultora</title>
    <link rel="stylesheet" href="../../public/css/consultora.css">
</head>
<body>
    <h2>Bienvenido, <?= $_SESSION['usuario']['nombre'] ?></h2>
    <p>Panel de consultora</p>
    <a href="../../app/controllers/AuthController.php?action=logout">Cerrar sesión</a>
</body>
</html>
