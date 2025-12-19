<?php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Empresa.php';

session_start();

// Asegurarse de que el usuario esté logueado
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: " . BASE_URL . "/app/controllers/AuthController.php?action=login");
    exit;
}

$action = $_GET['action'] ?? 'dashboard';
$empresaModel = new Empresa();

switch ($action) {

    case 'create':
        // Verificar si el usuario ya tiene empresa registrada
        $empresaExistente = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);
        if ($empresaExistente) {
            $_SESSION['error'] = "Ya existe una empresa registrada con este usuario.";
            header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=dashboard");
            exit;
        }

        // Mostrar formulario para nueva empresa
        require_once __DIR__ . '/../views/Empresa/create.php';
        break;

    case 'store':
        // Guardar los datos del formulario en la BD
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario_id = $_SESSION['usuario']['id'];

            // Verificar si ya existe empresa antes de insertar
            $empresaExistente = $empresaModel->obtenerPorUsuario($usuario_id);
            if ($empresaExistente) {
                $_SESSION['error'] = "Ya existe una empresa registrada con este usuario.";
                header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=dashboard");
                exit;
            }

            // Obtener datos del formulario
            $nombre_empresa = trim($_POST['nombre_empresa'] ?? '');
            $tipo_empresa = trim($_POST['tipo_empresa'] ?? '');
            $direccion = trim($_POST['direccion'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $ruc = trim($_POST['ruc'] ?? '');
            $acepto_contrato = $_POST['acepto_contrato'] ?? '';

            // Validar campos
            if (!$nombre_empresa || !$tipo_empresa || !$direccion || !$telefono || !$email || !$ruc || !$acepto_contrato) {
                $_SESSION['error'] = "Por favor complete todos los campos y acepte el contrato.";
                header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=create");
                exit;
            }

            // Crear empresa
            $resultado = $empresaModel->crear(
                $usuario_id,
                $nombre_empresa,
                $tipo_empresa,
                $direccion,
                $telefono,
                $email,
                $ruc
            );

            if ($resultado) {
                $_SESSION['success'] = "Empresa registrada correctamente.";
                header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Error al registrar la empresa.";
                header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=create");
                exit;
            }
        }
        break;

    case 'dashboard':
    default:
        // Verificar que el usuario tiene empresa creada
        $empresa = $empresaModel->obtenerPorUsuario($_SESSION['usuario']['id']);

        if (!$empresa) {
            // Si no hay empresa registrada, enviamos a create
            header("Location: " . BASE_URL . "/app/controllers/EmpresaController.php?action=create");
            exit;
        }

        // Mostrar dashboard
        require_once __DIR__ . '/../views/Empresa/index.php';
        break;
}
