<?php
require_once __DIR__ . '/../models/Vacante.php';

$vacanteModel = new Vacante();

// Obtener vacantes activas (públicas)
$vacantes = $vacanteModel->obtenerVacantesActivas();

// Cargar vista
require_once __DIR__ . '/../views/Vacantes/listar.php';
