<?php require_once __DIR__ . '/../../../config/config.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Facturas</title>

    <!-- Layout general -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/empresa.css">
    <!-- Estilos específicos de facturación -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/factura.css">
</head>
<body>

<header class="header">
    <h1>Mis Facturas</h1>
    <nav>
        <a href="<?= BASE_URL ?>/app/controllers/EmpresaController.php?action=dashboard">Panel</a>
        <a href="<?= BASE_URL ?>/app/views/Empresa/mis_vacantes.php">Mis Vacantes</a>
        <a href="<?= BASE_URL ?>/app/controllers/AuthController.php?action=logout">Cerrar sesión</a>
    </nav>
</header>

<main>

<?php
$facturaPendiente = null;

if (!empty($facturas)) {
    foreach ($facturas as $f) {
        if ($f['estado'] === 'pendiente') {
            $facturaPendiente = $f;
            break; // solo la primera pendiente
        }
    }
}
?>

<?php if (empty($facturas)): ?>
    <p>No hay facturas registradas.</p>
<?php else: ?>

    <table class="tabla-facturas" width="100%" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Concepto</th>
                <th>Detalle</th>
                <th>Total ($)</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($facturas as $f): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['concepto']) ?></td>
                    <td><?= htmlspecialchars($f['detalle']) ?></td>
                    <td><?= number_format($f['total'], 2) ?></td>
                    <td class="<?= $f['estado'] === 'pagada' ? 'estado-pagada' : 'estado-pendiente' ?>">
                        <?= $f['estado'] === 'pagada' ? '🟢 Pagada' : '🔴 Pendiente' ?>
                    </td>
                    <td><?= $f['fecha'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>

<?php if ($facturaPendiente): ?>
    <!-- ALERTA DE PAGO (FUERA DE LA TABLA) -->
    <div class="factura-alerta">
        <span>
            ⚠️ Tienes una factura pendiente por
            <strong>$<?= number_format($facturaPendiente['total'], 2) ?></strong>
        </span>

        <a
            href="<?= BASE_URL ?>/app/controllers/FacturaController.php?action=pagar&id=<?= $facturaPendiente['id'] ?>"
        >
            Pagar ahora
        </a>
    </div>
<?php endif; ?>

</main>

</body>
</html>
