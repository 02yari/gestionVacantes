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

/* ===============================
   OBTENER EMPRESA
================================ */
$empresaModel = new Empresa();
$empresa = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);

if (!$empresa) {
    die("Empresa no encontrada");
}

$conexion = conexion();

/* ===============================
   ELIMINAR VACANTE (CRUD - DELETE)
================================ */
if (isset($_GET['eliminar'])) {
    $sql = "DELETE FROM vacante 
            WHERE id = ? AND empresa_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$_GET['eliminar'], $empresa['id']]);
    header("Location: mis_vacantes.php");
    exit;
}

/* ===============================
   LISTAR VACANTES
================================ */
$sql = "SELECT * FROM vacante 
        WHERE empresa_id = ?
        ORDER BY fecha_creacion DESC";

$stmt = $conexion->prepare($sql);
$stmt->execute([$empresa['id']]);
$vacantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ===============================
   FECHA ACTUAL (DEL SISTEMA)
================================ */
$fechaActual = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Vacantes</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/mis_vacantes.css">
</head>
<body>

<h2>Mis Vacantes</h2>

<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

    <?php if (empty($vacantes)): ?>
        <tr>
            <td colspan="6">No hay vacantes registradas.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($vacantes as $v): ?>

            <?php
                // ESTADO AUTOMÁTICO SEGÚN FECHA DEL SISTEMA
                $estado = (
                    $fechaActual >= $v['fecha_inicio'] &&
                    $fechaActual <= $v['fecha_fin']
                ) ? '🟢 Activa' : '🔴 Inactiva';
            ?>

            <tr>
                <td><?= htmlspecialchars($v['titulo']) ?></td>
                <td><?= htmlspecialchars($v['descripcion']) ?></td>
                <td><?= $v['fecha_inicio'] ?></td>
                <td><?= $v['fecha_fin'] ?></td>
                <td><?= $estado ?></td>
                <td>
                    <!-- EDITAR = UPDATE -->
                    <a class="btn editar" href="editar_vacante.php?id=<?= $v['id'] ?>">
                        Editar
                    </a>

                    <!-- ELIMINAR = DELETE -->
                    <a class="btn eliminar"
                       href="?eliminar=<?= $v['id'] ?>"
                       onclick="return confirm('¿Seguro que desea eliminar esta vacante?')">
                        Eliminar
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>

    </tbody>
</table>

<br>

<a class="btn volver" href="index.php">⬅ Volver al panel</a>

</body>
</html>
