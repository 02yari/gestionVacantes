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
    empty($_POST['descripcion'])
) {
    $_SESSION['error'] = "Complete los campos obligatorios.";
    header("Location: crear_vacante.php");
    exit;
}

$usuario_id = $_SESSION['usuario']['id'];

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Error de conexión");
}

/* OBTENER EMPRESA DEL USUARIO */
$stmt = $conn->prepare("SELECT id FROM empresa WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Empresa no encontrada.";
    header("Location: crear_vacante.php");
    exit;
}

$empresa = $result->fetch_assoc();
$empresa_id = $empresa['id'];

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
