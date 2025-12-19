<?php
require_once __DIR__ . '/../../config/config.php';

class Usuario {

    private $db;

    public function __construct() {
        $this->db = conexion();
    }

    // Crear usuario
    public function crear($nombre, $correo, $password, $rol) {
        try {
            $sql = "INSERT INTO usuario (nombre, email, password, rol, tipo)
                    VALUES (:nombre, :correo, :password, :rol, :tipo)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                ':nombre' => $nombre,
                ':correo' => $correo,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':rol' => $rol,
                ':tipo' => 'normal'
            ]);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                return "duplicate";
            }
            return false;
        }
    }

    // Login de usuario
    public function login($correo, $password) {
        $sql = "SELECT * FROM usuario WHERE email = :correo AND estado = 1 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':correo' => $correo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
