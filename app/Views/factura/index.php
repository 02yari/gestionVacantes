<?php
// Incluir configuración para obtener BASE_URL
require_once __DIR__ . '/../../config/config.php';

// Incluir cualquier lógica necesaria del controlador si aplica
require_once __DIR__ . '/../../controllers/FacturaController.php';

// Si necesitas la vista de login para algo, se puede incluir
// require_once __DIR__ . '/../Auth/login.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Vista Factura / Consultora</title>
    <!-- CSS con ruta absoluta -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/factura.css">
</head>
<body>

<h2>Vista Factura / Consultora</h2>
<p>Acceder a facturación y estadísticas de interacciones.</p>
<a href="<?= BASE_URL ?>/index.php">Volver al Inicio</a>

</body>
</html>
