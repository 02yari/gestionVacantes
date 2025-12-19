<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../Models/Empresa.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: mis_vacantes.php");
    exit;
}

$empresaModel = new Empresa();
$empresa = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);
$conexion = conexion();

/* ===============================
   OBTENER VACANTE
================================ */
$sql = "SELECT * FROM vacante WHERE id = ? AND empresa_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$_GET['id'], $empresa['id']]);
$vacante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$vacante) {
    die("Vacante no encontrada");
}

/* ===============================
   ACTUALIZAR VACANTE
================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE vacante 
            SET titulo = ?, descripcion = ?, fecha_inicio = ?, fecha_fin = ?
            WHERE id = ? AND empresa_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        $_POST['titulo'],
        $_POST['descripcion'],
        $_POST['fecha_inicio'],
        $_POST['fecha_fin'],
        $vacante['id'],
        $empresa['id']
    ]);

    header("Location: mis_vacantes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Vacante</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/editar_vacante.css">
</head>
<body>

<h2>Editar Vacante</h2>

<form method="POST">
    <label>Título</label>
    <input type="text" name="titulo" value="<?= htmlspecialchars($vacante['titulo']) ?>" required>

    <label>Descripción</label>
    <textarea name="descripcion" required><?= htmlspecialchars($vacante['descripcion']) ?></textarea>

    <label>Fecha Inicio</label>
    <input type="date" name="fecha_inicio" value="<?= $vacante['fecha_inicio'] ?>" required>

    <label>Fecha Fin</label>
    <input type="date" name="fecha_fin" value="<?= $vacante['fecha_fin'] ?>" required>

    <button type="submit" class="btn editar">Actualizar</button>
    <a href="mis_vacantes.php" class="btn volver">Cancelar</a>
</form>

</body>
</html>
