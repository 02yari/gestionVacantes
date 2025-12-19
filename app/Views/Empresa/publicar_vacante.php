<?php
require_once __DIR__ . '/../../../config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}

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

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión");
}

/* ================================
   OBTENER EMPRESA
================================ */
$stmt = $conn->prepare("SELECT id FROM empresa WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

$empresa_id = $result->fetch_assoc()['id'];

/* ================================
   VERIFICAR FACTURAS PENDIENTES
================================ */
$stmt = $conn->prepare("
    SELECT COUNT(*) AS pendientes
    FROM factura
    WHERE empresa_id = ? AND estado = 'pendiente'
");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$pendientes = $stmt->get_result()->fetch_assoc()['pendientes'];

if ($pendientes > 0) {
    $_SESSION['error'] = "Tiene facturas pendientes. Debe pagar antes de publicar más vacantes.";
    header("Location: crear_vacante.php");
    exit;
}

/* ================================
   CONTAR VACANTES DE LA EMPRESA
================================ */
$stmt = $conn->prepare("
    SELECT COUNT(*) AS total 
    FROM vacante 
    WHERE empresa_id = ?
");
$stmt->bind_param("i", $empresa_id);
$stmt->execute();
$totalVacantes = $stmt->get_result()->fetch_assoc()['total'];

$MAX_GRATIS = 2;

/* ================================
   SI YA PASÓ EL LÍMITE GRATIS
================================ */
if ($totalVacantes >= $MAX_GRATIS) {

    // Verificar si ya tiene una factura pendiente
    if ($pendientes > 0) {
        $_SESSION['error'] = "Tiene facturas pendientes. Debe pagar antes de publicar más vacantes.";
        header("Location: crear_vacante.php");
        exit;
    }

    // Crear nueva factura
    $concepto = "Publicación de vacante adicional";
    $total    = 2.50;
    $detalle  = "Cargo por publicación adicional de vacante";
    $fecha    = date('Y-m-d');
    $estado   = "pendiente";

    $stmt = $conn->prepare("
        INSERT INTO factura (empresa_id, concepto, total, fecha, detalle, estado)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isdsss",
        $empresa_id,
        $concepto,
        $total,
        $fecha,
        $detalle,
        $estado
    );

    $stmt->execute();
}


/* ================================
   INSERTAR VACANTE
================================ */
$stmt = $conn->prepare("
    INSERT INTO vacante 
    (empresa_id, titulo, descripcion, fecha_inicio, fecha_fin, fecha_creacion)
    VALUES (?, ?, ?, ?, ?, NOW())
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
