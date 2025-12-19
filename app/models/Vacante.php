<?php
require_once __DIR__ . '/../../config/config.php';

class Vacante {
    private $db;

    public function __construct() {
        $this->db = conexion();
    }

    // ================================
    // CREAR VACANTE
    // ================================
    public function crear($empresa_id, $titulo, $descripcion, $fecha_inicio, $fecha_fin) {
        $sql = "INSERT INTO vacante 
                (empresa_id, titulo, descripcion, fecha_inicio, fecha_fin, fecha_creacion)
                VALUES 
                (:empresa_id, :titulo, :descripcion, :fecha_inicio, :fecha_fin, NOW())";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':empresa_id'   => $empresa_id,
            ':titulo'       => $titulo,
            ':descripcion'  => $descripcion,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin'    => $fecha_fin
        ]);
    }

    // ================================
    // LISTAR TODAS LAS VACANTES
    // (EMPRESA) + ESTADO POR FECHA
    // ================================
    public function listarPorEmpresa($empresa_id) {
        $sql = "
            SELECT *,
            CASE
                WHEN CURDATE() BETWEEN fecha_inicio AND fecha_fin
                THEN 'Activa'
                ELSE 'Inactiva'
            END AS estado
            FROM vacante
            WHERE empresa_id = :empresa_id
            ORDER BY fecha_inicio DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':empresa_id' => $empresa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // VACANTES ACTIVAS
    // (PANEL PRINCIPAL EMPRESA)
    // ================================
    public function obtenerActivas($empresa_id) {
        $sql = "
            SELECT titulo, descripcion
            FROM vacante
            WHERE empresa_id = :empresa_id
            AND CURDATE() BETWEEN fecha_inicio AND fecha_fin
            ORDER BY fecha_inicio DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':empresa_id' => $empresa_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // OBTENER UNA VACANTE POR ID
    // (PARA EDITAR)
    // ================================
    public function obtenerPorId($id, $empresa_id) {
        $sql = "SELECT * FROM vacante WHERE id = :id AND empresa_id = :empresa_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':empresa_id' => $empresa_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ================================
    // ACTUALIZAR VACANTE (EDITAR)
    // ================================
    public function actualizar($id, $empresa_id, $titulo, $descripcion, $fecha_inicio, $fecha_fin) {
        $sql = "
            UPDATE vacante SET
                titulo = :titulo,
                descripcion = :descripcion,
                fecha_inicio = :fecha_inicio,
                fecha_fin = :fecha_fin
            WHERE id = :id AND empresa_id = :empresa_id
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':titulo'       => $titulo,
            ':descripcion'  => $descripcion,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin'    => $fecha_fin,
            ':id'           => $id,
            ':empresa_id'   => $empresa_id
        ]);
    }

    // ================================
    // ELIMINAR VACANTE
    // ================================
    public function eliminar($id, $empresa_id) {
        $sql = "DELETE FROM vacante WHERE id = :id AND empresa_id = :empresa_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':empresa_id' => $empresa_id
        ]);
    }


     // VACANTES ACTIVAS (PÚBLICAS)
    public function obtenerVacantesActivas() {
        $sql = "SELECT titulo, descripcion, fecha_inicio, fecha_fin
                FROM vacante
                WHERE CURDATE() BETWEEN fecha_inicio AND fecha_fin
                ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
