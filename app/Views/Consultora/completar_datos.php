<?php
session_start();
require_once __DIR__ . '/../../../config/config.php';

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'consultora') {
    header("Location: /proyecto_vacantes/app/controllers/AuthController.php?action=login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Completar datos de la Consultora</title>

    <!-- CSS específico -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/completar_datos.css">
</head>
<body>

<div class="contrato-container">

    <h2>Datos de la Empresa Consultora</h2>

    <p>
        Para habilitar el acceso al panel de consultoría, complete la información
        requerida de la empresa responsable del análisis y auditoría del sistema.
    </p>

    <form method="POST" action="<?= BASE_URL ?>/app/controllers/ConsultoraController.php?action=guardarDatos">

        <label>Nombre de la empresa consultora</label>
        <input type="text" name="nombre_empresa" required>

        <label>RUC</label>
        <input type="text" name="ruc" required>

        <label>Nombre de contacto</label>
        <input type="text" name="nombre" required>

        <label>Persona encargada</label>
        <input type="text" name="encargado" required>

        <label>Cédula del encargado</label>
        <input type="text" name="cedula_encargado" required>

        <label>Teléfono</label>
        <input type="text" name="telefono" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>
            <input type="checkbox" name="acepta_contrato" value="1" required>
            Acepto los términos del contrato
        </label>

        <button type="submit">Aceptar y continuar</button>
    </form>


</div>

</body>
</html>
