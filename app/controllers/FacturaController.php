<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Factura.php';
require_once __DIR__ . '/../models/Empresa.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Solo empresas
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: " . BASE_URL . "/app/controllers/AuthController.php?action=login");
    exit;
}

$facturaModel = new Factura();
$empresaModel = new Empresa();

// Obtener empresa del usuario
$empresa = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);

if (!$empresa) {
    $_SESSION['error'] = "Debe registrar una empresa primero.";
    header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=create");
    exit;
}

// Listar facturas
$facturas = $facturaModel->listarPorEmpresa($empresa['id']);

// Cargar vista
require_once __DIR__ . '/../views/Factura/facturas.php';
