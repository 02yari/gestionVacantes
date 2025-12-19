<?php require_once __DIR__ . '/../../../config/config.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Facturas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/empresa.css">
</head>
<body>

<header class="header">
    <h1>Mis Facturas</h1>
    <nav>
        <a href="<?= BASE_URL ?>/app/controllers/EmpresaController.php?action=dashboard">Panel</a>
        <a href="<?= BASE_URL ?>/app/controllers/VacanteController.php?action=misVacantes">Mis Vacantes</a>
        <a href="<?= BASE_URL ?>/app/controllers/AuthController.php?action=logout">Cerrar sesión</a>
    </nav>
</header>

<main>

<?php if (empty($facturas)): ?>
    <p>No hay facturas registradas.</p>
<?php else: ?>

<table border="1" width="100%" cellpadding="10" cellspacing="0">
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
                <td>
                    <?= $f['estado'] === 'pagada'
                        ? '🟢 Pagada'
                        : '🔴 Pendiente' ?>
                </td>
                <td><?= $f['fecha'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

</main>

</body>
</html>
