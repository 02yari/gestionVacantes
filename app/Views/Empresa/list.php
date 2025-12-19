<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empresas</title>
</head>
<body>
    <h1>Empresas</h1>
    <?php if (!empty($data)) : ?>
        <ul>
            <?php foreach($data as $empresa) : ?>
                <li><?php echo $empresa['nombre']; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No hay empresas registradas.</p>
    <?php endif; ?>
</body>
</html>
