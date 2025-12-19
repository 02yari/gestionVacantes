<?php
require_once __DIR__ . '/../../config/config.php';

class Factura {
    private $db;

    public function __construct() {
        $this->db = conexion();
    }

    // ================================
    // CREAR FACTURA
    // ================================
    public function crear($empresa_id, $concepto, $detalle, $total) {
        $sql = "
            INSERT INTO factura (empresa_id, concepto, detalle, total, estado, fecha)
            VALUES (:empresa_id, :concepto, :detalle, :total, 'pendiente', NOW())
        ";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':empresa_id' => $empresa_id,
            ':concepto'   => $concepto,
            ':detalle'    => $detalle,
            ':total'      => $total
        ]);
    }

    // ================================
    // LISTAR FACTURAS POR EMPRESA
    // ================================
    public function listarPorEmpresa($empresa_id) {
        $sql = "
            SELECT id, concepto, detalle, total, estado, fecha
            FROM factura
            WHERE empresa_id = :empresa_id
            ORDER BY fecha DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':empresa_id' => $empresa_id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ================================
    // VERIFICAR DEUDA
    // ================================
    public function tieneDeuda($empresa_id) {
        $sql = "
            SELECT COUNT(*) 
            FROM factura
            WHERE empresa_id = :empresa_id
            AND estado = 'pendiente'
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':empresa_id' => $empresa_id]);

        return $stmt->fetchColumn() > 0;
    }
}
