<?php
// ================================
// CONFIGURACIÓN BASE DE DATOS
// ================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'proyecto_vacantes'); // <-- aquí
define('DB_USER', 'root');
define('DB_PASS', '');

define('BASE_URL', 'http://localhost:8080/proyecto_vacantes');

// ================================
// FUNCIÓN DE CONEXIÓN GLOBAL
// ================================
function conexion() {
    try {
        $conexion = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
            DB_USER,
            DB_PASS
        );
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conexion;
    } catch (PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}
