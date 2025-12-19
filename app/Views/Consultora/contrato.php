<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contrato Consultora</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/empresa.css">
</head>
<body>

<h2>Contrato de Acceso – Empresa Consultora</h2>

<p>
La empresa consultora acepta el acceso a información estadística, empresarial
y de facturación del sistema, exclusivamente para fines de análisis y auditoría.
</p>

<p>
El acceso tiene un costo mensual según el esquema de facturación establecido.
El uso indebido de la información queda bajo responsabilidad de la empresa consultora.
</p>

<form method="POST" action="<?= BASE_URL ?>/app/controllers/ConsultoraController.php?action=activar">

    <label>Nombre de la empresa</label>
    <input type="text" name="nombre_empresa" required>

    <label>RUC</label>
    <input type="text" name="ruc" required>

    <label>Persona encargada</label>
    <input type="text" name="encargado" required>

    <label>Cédula del encargado</label>
    <input type="text" name="cedula_encargado" required>

    <label>
        <input type="checkbox" required>
        Acepto los términos del contrato
    </label>

    <br><br>
    <button type="submit">Aceptar y Activar Acceso</button>
</form>

</body>
</html>
