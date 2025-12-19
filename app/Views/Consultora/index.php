<?php
session_start();
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../models/Consultora.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}

$usuarioId = $_SESSION['usuario']['id'];

$consultoraModel = new Consultora();
$consultora = $consultoraModel->obtenerPorUsuario($usuarioId);

//  SI NO EXISTE REGISTRO DE CONSULTORA, CREARLO
if (!$consultora) {
    header("Location: completar_datos.php");
    exit;
}

// SI NO ACEPTÓ CONTRATO
if ($consultora['contrato_aceptado'] == 0) {
    require_once 'contrato.php';
    exit;
}

//  SI YA ACEPTÓ CONTRATO
require_once 'dashboard.php';
exit;
