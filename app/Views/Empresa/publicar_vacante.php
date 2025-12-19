<?php
require_once __DIR__ . '/../../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}

/* VALIDAR CAMPOS */
if (
    empty($_POST['titulo']) ||
    empty($_POST['descripcion']) ||
    empty($_POST['fecha_inicio']) ||
    empty($_POST['fecha_fin'])
) {
    $_SESSION['error'] = "Complete todos los campos obligatorios.";
    header("Location: crear_vacante.php");
    exit;
}

$usuario_id = $_SESSION['usuario']['id'];

/* CONEXIÓN */
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión");
}

/* OBTENER EMPRESA */
$stmt = $conn->prepare("SELECT id FROM empresa WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Empresa no encontrada.";
    header("Location: crear_vacante.php");
    exit;
}

$empresa_id = $result->fetch_assoc()['id'];

/* VERIFICAR FACTURAS PENDIENTES */
$stmt = $conn->prepare("
    SELECT COUNT(*) AS pendientes
    FROM factura
    WHERE empresa_id = ? AND estado = 'pendiente'
");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$pendientes = $stmt->get_result()->fetch_assoc()['pendientes'];

if ($pendientes > 0) {
    $_SESSION['error'] = "Tiene facturas pendientes. Debe pagar antes de publicar nuevas vacantes.";
    header("Location: crear_vacante.php");
    exit;
}

/* CONTAR VACANTES EXISTENTES */
$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM vacante WHERE empresa_id = ?");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$totalVacantes = $stmt->get_result()->fetch_assoc()['total'];

/* SI SUPERA LAS 3 GRATIS → CREAR FACTURA */
if ($totalVacantes >= 3) {

    $concepto = "Publicación de vacante";
    $detalle  = "Cargo por publicación adicional de vacante en la plataforma";
    $total    = 2.50;

    $stmt = $conn->prepare("
        INSERT INTO factura (empresa_id, concepto, total, fecha, detalle, estado)
        VALUES (?, ?, ?, NOW(), ?, 'pendiente')
    ");
    $stmt->bind_param("isds", $empresa_id, $concepto, $total, $detalle);
    $stmt->execute();
}

/* INSERTAR VACANTE */
$stmt = $conn->prepare("
    INSERT INTO vacante (empresa_id, titulo, descripcion, fecha_inicio, fecha_fin)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issss",
    $empresa_id,
    $_POST['titulo'],
    $_POST['descripcion'],
    $_POST['fecha_inicio'],
    $_POST['fecha_fin']
);

$stmt->execute();

$_SESSION['success'] = "Vacante publicada correctamente.";
header("Location: mis_vacantes.php");
exit;
