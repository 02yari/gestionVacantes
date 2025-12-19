<?php
require_once __DIR__ . '/../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vacantes Disponibles</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/listar_vacantes.css">
</head>
<body>

<header class="header">
    <h1>Vacantes Disponibles</h1>
    <a href="<?= BASE_URL ?>" class="btn-volver">Volver al inicio</a>
</header>

<main class="contenedor">

<?php if (empty($vacantes)): ?>
    <p class="mensaje">No hay vacantes activas en este momento.</p>
<?php else: ?>
    <?php foreach ($vacantes as $v): ?>
        <div class="vacante-card">
            <h2><?= htmlspecialchars($v['titulo']) ?></h2>
            <p><?= nl2br(htmlspecialchars($v['descripcion'])) ?></p>
            <span class="fecha">
                Vigente: <?= $v['fecha_inicio'] ?> al <?= $v['fecha_fin'] ?>
            </span>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

</main>

</body>
</html>
