<?php
require_once __DIR__ . '/../../config/config.php';

class Consultora {
    private $db;

    public function __construct() {
        $this->db = conexion();
    }

    public function obtenerPorUsuario($usuario_id) {
        $sql = "SELECT * FROM consultora WHERE usuario_id = :usuario_id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':usuario_id' => $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function activar($data) {
        $sql = "
            UPDATE consultora SET
                nombre_empresa = :nombre_empresa,
                ruc = :ruc,
                encargado = :encargado,
                cedula_encargado = :cedula,
                acepta_contrato = 1,
                fecha_aceptacion = NOW(),
                estado = 'activa'
            WHERE usuario_id = :usuario_id
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }
    public function aceptarContrato($usuarioId) {
    $sql = "UPDATE consultora 
            SET contrato_aceptado = 1, fecha_contrato = NOW()
            WHERE usuario_id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$usuarioId]);
}
public function crear($data) {

    $sql = "
        INSERT INTO consultora (
            usuario_id,
            nombre_empresa,
            ruc,
            nombre,
            telefono,
            email,
            encargado,
            cedula_encargado,
            acepta_contrato,
            contrato_aceptado,
            fecha_aceptacion,
            fecha_contrato,
            estado,
            fecha_creacion
        ) VALUES (
            :usuario_id,
            :nombre_empresa,
            :ruc,
            :nombre,
            :telefono,
            :email,
            :encargado,
            :cedula_encargado,
            1,
            1,
            NOW(),
            NOW(),
            'activo',
            NOW()
        )
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
        ':usuario_id'        => $data['usuario_id'],
        ':nombre_empresa'    => $data['nombre_empresa'],
        ':ruc'               => $data['ruc'],
        ':nombre'            => $data['nombre'],
        ':telefono'          => $data['telefono'],
        ':email'             => $data['email'],
        ':encargado'         => $data['encargado'],
        ':cedula_encargado'  => $data['cedula_encargado']
    ]);
}



}

