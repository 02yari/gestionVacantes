<?php
// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// (Opcional) Proteger acceso
if (!isset($_SESSION['usuario'])) {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empresas</title>

    <!-- CSS ABSOLUTO (si luego lo usas) -->
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/empresa.css">
</head>
<body>

<h1>Empresas</h1>

<?php if (!empty($data)) : ?>
    <ul>
        <?php foreach ($data as $empresa) : ?>
            <li><?= htmlspecialchars($empresa['nombre']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>No hay empresas registradas.</p>
<?php endif; ?>

<a href="/proyecto_vacantes/index.php">Volver al inicio</a>

</body>
</html>
