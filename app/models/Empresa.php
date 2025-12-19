<?php
require_once __DIR__ . '/../../config/config.php';


class Empresa {
    private $db;

    public function __construct() {
        $this->db = conexion();
    }

    // Obtener empresa por ID de usuario
    public function obtenerPorUsuario($usuario_id) {
        $sql = "SELECT * FROM empresa WHERE usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear nueva empresa
    public function crear($usuario_id, $nombre_empresa, $tipo_empresa, $direccion, $telefono, $email) {
        $sql = "INSERT INTO empresa (usuario_id, nombre, tipo, direccion, telefono, email, fecha_creacion)
                VALUES (:usuario_id, :nombre, :tipo, :direccion, :telefono, :email, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':nombre' => $nombre_empresa,
            ':tipo' => $tipo_empresa,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':email' => $email
        ]);
    }
}
