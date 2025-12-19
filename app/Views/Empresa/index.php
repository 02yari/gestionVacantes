<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/config.php';

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Solo usuarios con rol 'empresa'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}

$nombre = $_SESSION['usuario']['nombre'] ?? 'Empresa';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Empresa</title>

    <!-- CSS ABSOLUTO ✔ -->
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/empresa.css">
    
</head>
<body>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<header class="header">
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?></h1>
    <nav>
        <a href="#">Publicar Vacante</a>
        <a href="#">Mis Vacantes</a>
        <a href="#">Ver Facturas</a>
        <a href="/proyecto_vacantes/app/controllers/AuthController.php?action=logout">
            Cerrar sesión
        </a>
    </nav>
</header>

<main>
    <section class="dashboard-cards">
        <div class="card">
            <h2>Vacantes Publicadas</h2>
            <p>Visualiza todas tus vacantes activas.</p>
        </div>
        <div class="card">
            <h2>Solicitudes Recibidas</h2>
            <p>Revisa los candidatos que aplicaron a tus vacantes.</p>
        </div>
        <div class="card">
            <h2>Facturación</h2>
            <p>Gestiona tus facturas y pagos.</p>
        </div>
    </section>
</main>

</body>
</html>
