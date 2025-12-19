<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pagar Factura</title>
</head>
<body>

<h2>Pagar Factura</h2>

<p><strong>Concepto:</strong> <?= htmlspecialchars($factura['concepto']) ?></p>
<p><strong>Total:</strong> $<?= number_format($factura['total'], 2) ?></p>

<form method="POST" action="<?= BASE_URL ?>/app/controllers/FacturaController.php?action=confirmarPago">
    <input type="hidden" name="factura_id" value="<?= $factura['id'] ?>">
    <button type="submit">Confirmar Pago</button>
    <a href="<?= BASE_URL ?>/app/controllers/FacturaController.php">Cancelar</a>
</form>

</body>
</html>
