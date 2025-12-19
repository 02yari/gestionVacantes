<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../Models/Empresa.php';
require_once __DIR__ . '/../../Models/Vacante.php';
require_once __DIR__ . '/../../Models/Factura.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}

$nombre = $_SESSION['usuario']['nombre'] ?? 'Empresa';

$empresaModel = new Empresa();
$vacanteModel = new Vacante();

$empresa = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);
$vacantesActivas = $vacanteModel->obtenerActivas($empresa['id']);
$facturaModel = new Factura();
$facturasPendientes = $facturaModel->tieneDeuda($empresa['id']) ? 1 : 0;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Empresa</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/empresa.css">
</head>
<body>

<header class="header">
    <h1>Bienvenido, <?= htmlspecialchars($nombre) ?></h1>
    <nav>
        <a href="<?= BASE_URL ?>/app/views/empresa/crear_vacante.php">Publicar Vacante</a>
        <a href="<?= BASE_URL ?>/app/views/empresa/mis_vacantes.php">Mis Vacantes</a>
        <a href="<?= BASE_URL ?>/app/controllers/FacturaController.php">Ver Facturas</a>
        <a href="/proyecto_vacantes/app/controllers/AuthController.php?action=logout">Cerrar sesión</a>
    </nav>
</header>

<main>
    <section class="dashboard-cards">

        <div class="card">
            <h2>Vacantes Activas</h2>

            <?php if (empty($vacantesActivas)): ?>
                <p>No tienes vacantes activas</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($vacantesActivas as $v): ?>
                        <li>
                            <strong><?= htmlspecialchars($v['titulo']) ?></strong><br>
                            <?= htmlspecialchars($v['descripcion']) ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="card">
            <h2>Solicitudes Recibidas</h2>
            <p>Revisa los candidatos que aplicaron a tus vacantes.</p>
        </div>

        <div class="card">
            <h2>Facturación</h2>

            <?php if ($facturasPendientes > 0): ?>
                <p style="color:red;font-weight:bold;">
                    Tienes <?= $facturasPendientes ?> factura(s) pendiente(s)
                </p>
            <?php else: ?>
                <p>No tienes facturas pendientes</p>
            <?php endif; ?>

            <a href="<?= BASE_URL ?>/app/controllers/FacturaController.php">
                Ver facturas
            </a>
        </div>


    </section>
</main>

</body>
</html>
