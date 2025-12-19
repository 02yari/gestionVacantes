<?php
// test_connection.php
require_once 'config/config.php';  // Incluye la configuración

// Crear conexión PDO
try {
    $conexion = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8",
        DB_USER,
        DB_PASS
    );
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos.";
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
