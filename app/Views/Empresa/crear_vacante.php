<?php
require_once __DIR__ . '/../../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Vacante</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/crear_vacante.css">
</head>
<body>

<h2>Publicar Vacante</h2>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<form method="POST" action="publicar_vacante.php">

    <label>Título</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Descripción</label><br>
    <textarea name="descripcion" required></textarea><br><br>

    <label>Fecha Inicio</label><br>
    <input type="date" name="fecha_inicio"><br><br>

    <label>Fecha Fin</label><br>
    <input type="date" name="fecha_fin"><br><br>

    <button type="submit">Publicar Vacante</button>
</form>

<br>
<a href="index.php">Volver al panel</a>

</body>
</html>
