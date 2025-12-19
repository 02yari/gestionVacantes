<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Solo usuarios con rol 'empresa'
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'empresa') {
    header("Location: ../../app/controllers/AuthController.php?action=login");
    exit;
}

$nombre = $_SESSION['usuario']['nombre'] ?? 'Empresa';
$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida a la Plataforma</title>
    <link rel="stylesheet" href="/proyecto_vacantes/public/css/form_empresa.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="welcome-container">
    <header>
        <h1>¡Bienvenido, <?= htmlspecialchars($nombre) ?>!</h1>
        <p>Antes de poder publicar vacantes, completa los datos de tu empresa y acepta nuestro contrato digital.</p>
    </header>

    <?php if ($error): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="form-contract-container">
        <form class="empresa-form" method="POST" action="/proyecto_vacantes/app/controllers/EmpresaController.php?action=store">
            <h2>Datos de la Empresa</h2>
            <label>Nombre de la Empresa</label>
            <input type="text" name="nombre_empresa" required>

            <label>Tipo de Empresa</label>
            <select name="tipo_empresa" required>
                <option value="">Seleccione tipo</option>
                <option value="publica">Pública</option>
                <option value="privada">Privada</option>
            </select>

            <label>Dirección</label>
            <input type="text" name="direccion" required>

            <label>Teléfono</label>
            <input type="text" name="telefono" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>RUC / NIT</label>
            <input type="text" name="ruc" required>

            <div class="contract-box">
                <h3>Contrato Digital</h3>
                <p>
                    Al publicar vacantes en nuestra plataforma, se aplican las siguientes tarifas por interacción con los postulantes:
                </p>
                <ul>
                    <li>Por cada 10 postulantes registrados: <strong>$5</strong></li>
                    <li>Por cada 50 postulantes registrados: <strong>$20</strong></li>
                    <li>Por cada 100 postulantes registrados: <strong>$35</strong></li>
                </ul>
                <p>
                    Una vez que acepte este contrato, cada vacante publicada estará sujeta a estas tarifas según la cantidad de postulantes o interacciones que reciba.
                </p>
                <label class="accept-contract">
                    <input type="checkbox" name="acepto_contrato" required>
                    Acepto los términos del contrato
                </label>
            </div>

            <button type="submit" class="btn-submit">Completar Registro y Acceder</button>
        </form>
    </div>
</div>

</body>
</html>
