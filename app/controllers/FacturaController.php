<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Factura.php';
require_once __DIR__ . '/../models/Empresa.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: " . BASE_URL . "/app/controllers/AuthController.php?action=login");
    exit;
}

$facturaModel = new Factura();
$empresaModel = new Empresa();

$empresa = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);

$action = $_GET['action'] ?? 'index';

switch ($action) {

    case 'pagar':
        $factura_id = $_GET['id'] ?? null;

        if (!$factura_id) {
            header("Location: FacturaController.php");
            exit;
        }

        $factura = $facturaModel->obtenerPorId($factura_id, $empresa['id']);

        if (!$factura || $factura['estado'] === 'pagada') {
            $_SESSION['error'] = "Factura inválida o ya pagada.";
            header("Location: FacturaController.php");
            exit;
        }

        require __DIR__ . '/../views/Factura/pagar.php';
        break;

    case 'confirmarPago':
        $factura_id = $_POST['factura_id'];

        $facturaModel->pagar($factura_id);

        $_SESSION['success'] = "Factura pagada correctamente.";
        header("Location: FacturaController.php");
        exit;

    default:
        // listado de facturas (el que ya tienes)
        $facturas = $facturaModel->listarPorEmpresa($empresa['id']);
        require __DIR__ . '/../views/Factura/facturas.php';
}
