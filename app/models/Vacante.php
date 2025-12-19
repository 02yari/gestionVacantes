<?php
require_once __DIR__ . '/../../config/config.php';
class Factura {
    private $db;

    public function __construct() {
        $this->db = conexion();
    }

    // Métodos para manejar facturas pueden ser añadidos aquí
}