<?php
session_start();

require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Consultora.php';

$action = $_GET['action'] ?? '';

/* =====================================
   ACEPTAR CONTRATO
===================================== */
if ($action === 'aceptarContrato') {

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
        header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
        exit;
    }

    $usuarioId = $_SESSION['usuario']['id'];

    $consultoraModel = new Consultora();
    $consultoraModel->aceptarContrato($usuarioId);

    header("Location: /proyecto_vacantes/app/Views/Consultora/dashboard.php");
    exit;
}

/* =====================================
   GUARDAR DATOS CONSULTORA
===================================== */
if ($action === 'guardarDatos') {

    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
        header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
        exit;
    }

    $consultora = new Consultora();

    $data = [
        'usuario_id'       => $_SESSION['usuario']['id'],
        'nombre_empresa'   => $_POST['nombre_empresa'],
        'ruc'              => $_POST['ruc'],
        'nombre'           => $_POST['nombre'],
        'telefono'         => $_POST['telefono'],
        'email'            => $_POST['email'],
        'encargado'        => $_POST['encargado'],
        'cedula_encargado' => $_POST['cedula_encargado']
    ];

    $consultora->crear($data);

    header("Location: /proyecto_vacantes/app/Views/Consultora/dashboard.php");
    exit;
}

/* =====================================
   ACCIÓN NO VÁLIDA
===================================== */
header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
exit;
