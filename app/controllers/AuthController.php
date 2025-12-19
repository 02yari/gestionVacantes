<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../views/Auth/login.php';
require_once __DIR__ . '/../views/Auth/register.php';

$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'login':
        require_once __DIR__ . '/../views/Auth/login.php';
        break;

    case 'register':
        require_once __DIR__ . '/../views/Auth/register.php';
        break;

    case 'store':
        procesarRegistro();
        break;

    case 'auth':
        procesarLogin();
        break;

    case 'logout':
        session_destroy();
        header("Location: AuthController.php?action=login");
        exit;
}
function procesarRegistro() {
      if (empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['password']) || empty($_POST['rol'])) {
        $_SESSION['error'] = "Por favor llene todos los campos.";
        header("Location: AuthController.php?action=register");
        exit;
    }
    $usuario = new Usuario();

    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    $resultado = $usuario->crear($nombre, $correo, $password, $rol);

    if ($resultado === true) {
        $_SESSION['success'] = "Cuenta creada satisfactoriamente. Inicie sesión.";
        header("Location: AuthController.php?action=login");
    } elseif ($resultado === "duplicate") {
        $_SESSION['error'] = "Correo electrónico duplicado. Intente con otro.";
        header("Location: AuthController.php?action=register");
    } else {
        $_SESSION['error'] = "Error al crear la cuenta.";
        header("Location: AuthController.php?action=register");
    }
    exit;
}

function procesarLogin() {
    $usuarioModel = new Usuario();

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $usuario = $usuarioModel->login($correo, $password);

     if ($usuario) {
        session_start();
        $_SESSION['usuario'] = $usuario;

        if ($usuario['rol'] === 'empresa') {
            // Verificar si la empresa ya registró sus datos
            require_once __DIR__ . '/../models/Empresa.php';
            $empresaModel = new Empresa();
            $empresa = $empresaModel->obtenerPorUsuario($usuario['id']); 

            if ($empresa) {
                // Ya existe empresa → panel principal
                header("Location: ../views/Empresa/index.php");
            } else {
                // No existe empresa → bienvenida + formulario
                header("Location: ../views/Empresa/create.php");
            }
            exit;
        } else if ($usuario['rol'] === 'consultora') {
            header("Location: ../views/Consultora/index.php");
            exit;
        }
    }

    $_SESSION['error'] = "Correo o contraseña incorrectos.";
    header("Location: ../views/Auth/login.php");
    exit;
}

