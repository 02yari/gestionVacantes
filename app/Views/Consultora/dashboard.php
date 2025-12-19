<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../../config/config.php';

// Seguridad: solo consultoras
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
    header("Location: " . BASE_URL . "/app/controllers/AuthController.php?action=login");
    exit;
}

$nombreUsuario = $_SESSION['usuario']['nombre'] ?? 'Consultora';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Consultora</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/empresa.css">
</head>
<body>

<header class="header">
    <h1>Panel de Empresa Consultora</h1>

    <nav>
        <a href="<?= BASE_URL ?>/app/Views/Consultora/dashboard.php">Dashboard</a>
        <a href="<?= BASE_URL ?>/app/controllers/AuthController.php?action=logout">Cerrar sesión</a>
    </nav>
</header>

<main>
    <section class="dashboard-cards">

        <div class="card">
            <h2>📊 Estadísticas</h2>
            <p>Acceso a estadísticas generales del sistema.</p>
        </div>

        <div class="card">
            <h2>🏢 Empresas</h2>
            <p>Visualización de empresas registradas.</p>
        </div>

        <div class="card">
            <h2>📄 Facturación</h2>
            <p>Acceso de solo lectura a facturación.</p>
        </div>

    </section>
</main>

</body>
</html>
