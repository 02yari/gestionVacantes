<?php
require_once __DIR__ . '/../../../config/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vacantes Disponibles</title>

    <!-- CSS PROPIO DE ESTA VISTA -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/listar_vacantes.css">
</head>
<body>

<header class="vacantes-header">
    <h1>Vacantes Disponibles</h1>
    <p>Explora oportunidades laborales activas</p>
</header>

<main class="vacantes-container">

    <?php if (empty($vacantes)): ?>
        <div class="empty-state">
            <p>No hay vacantes activas en este momento.</p>
        </div>
    <?php else: ?>
        <div class="vacantes-grid">
            <?php foreach ($vacantes as $vacante): ?>
                <article class="vacante-card">
                    <h2><?= htmlspecialchars($vacante['titulo']) ?></h2>

                    <p class="descripcion">
                        <?= nl2br(htmlspecialchars($vacante['descripcion'])) ?>
                    </p>

                    <div class="fechas">
                        <span>
                            <strong>Inicio:</strong>
                            <?= date('d/m/Y', strtotime($vacante['fecha_inicio'])) ?>
                        </span>
                        <span>
                            <strong>Fin:</strong>
                            <?= date('d/m/Y', strtotime($vacante['fecha_fin'])) ?>
                        </span>
                    </div>

                    <div class="estado activa">
                        Vacante Activa
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</main>

<footer class="vacantes-footer">
    <a href="<?= BASE_URL ?>" class="btn-volver">Volver al inicio</a>
</footer>

</body>
</html>
