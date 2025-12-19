-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 19-12-2025 a las 14:31:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_vacantes`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultora`
--

CREATE TABLE `consultora` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `tipo` enum('publica','privada') NOT NULL,
  `direccion` varchar(200) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `nombre`, `tipo`, `direccion`, `telefono`, `email`, `usuario_id`, `fecha_creacion`) VALUES
(1, 'YarielsyConsultaria', 'privada', 'Chiriqui-David', '6644-4444', 'Yarigonza0294@gmail.com', 1, '2025-12-19 04:00:19'),
(2, 'ProgramacionYari', 'publica', 'Chiriqui-David', '6644-4444', 'Yarigonza0294@gmail.com', 1, '2025-12-19 04:04:13'),
(3, 'Consultoria', 'privada', 'Panama Oeste', '00067257896', 'yari33@gmail.com', 5, '2025-12-19 04:08:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE `factura` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `concepto` varchar(150) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `detalle` text DEFAULT NULL,
  `estado` enum('pendiente','pagada') NOT NULL DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `interaccion`
--

CREATE TABLE `interaccion` (
  `id` int(11) NOT NULL,
  `vacante_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('empresa','consultora','postulante') NOT NULL,
  `tipo` enum('empresa','consultora') NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `ultimo_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `nombre`, `email`, `password`, `rol`, `tipo`, `estado`, `fecha_creacion`, `ultimo_login`) VALUES
(1, 'Yarielsy Joan González', 'yarigonza0294@gmail.com', '$2y$10$f081st1e9QszvlP9ve2rxedOGM7ezTUc0oYObhQey4eZfRuyy2L2y', 'empresa', '', 1, '2025-12-19 02:35:51', NULL),
(3, 'Yarielsy', 'joan@gmail.com', '$2y$10$Yu0M6Z4QfahFtVTGCc0EpetVN3vh1oqDnl5RW1fbSk4Y4FRsUIWnm', 'consultora', '', 1, '2025-12-19 02:36:44', NULL),
(5, 'Yari', 'yarigonza@gmail.com', '$2y$10$mP.6srDOCNj9BJmR9Ig09O4Fi7nd5xF3jipIu0o13lRQILp5JQUe.', 'empresa', '', 1, '2025-12-19 04:06:53', NULL),
(7, 'Capuchino', 'capu@gmail.com', '$2y$10$DW.02x0rWZZzTapHRyJPsOViBlv3KT36TzZUQOVjtd.Ppy0DTi6Mi', 'empresa', '', 1, '2025-12-19 09:53:51', NULL),
(8, 'Eldaa', 'eldaa@gmail.com', '$2y$10$ChBv72UsY19xb.W7D87A2.4e0gsbioJ5zMNlus7ET5vAairXLR/Oq', 'empresa', '', 1, '2025-12-19 12:09:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vacante`
--

CREATE TABLE `vacante` (
  `id` int(11) NOT NULL,
  `empresa_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` enum('activa','inactiva') NOT NULL DEFAULT 'activa',
  `eliminado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `vacante`
--

INSERT INTO `vacante` (`id`, `empresa_id`, `titulo`, `descripcion`, `fecha_inicio`, `fecha_fin`, `fecha_creacion`, `estado`, `eliminado`) VALUES
(1, 1, 'Ama de casa', 'Limpiar la casa a diario', '2025-12-18', '2025-12-20', '2025-12-19 10:15:20', 'activa', 0),
(2, 1, 'Niñera', 'Cuidar niño de 1 año las 24/7', '2025-12-19', '2025-12-27', '2025-12-19 13:13:07', 'activa', 0),
(3, 1, 'Salonero', 'salonero', '2025-12-19', '2025-12-27', '2025-12-19 13:30:50', 'activa', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `consultora`
--
ALTER TABLE `consultora`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- Indices de la tabla `interaccion`
--
ALTER TABLE `interaccion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vacante_id` (`vacante_id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`);

--
-- Indices de la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `empresa_id` (`empresa_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `consultora`
--
ALTER TABLE `consultora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `interaccion`
--
ALTER TABLE `interaccion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `vacante`
--
ALTER TABLE `vacante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `consultora`
--
ALTER TABLE `consultora`
  ADD CONSTRAINT `consultora_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD CONSTRAINT `empresa_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `interaccion`
--
ALTER TABLE `interaccion`
  ADD CONSTRAINT `interaccion_ibfk_1` FOREIGN KEY (`vacante_id`) REFERENCES `vacante` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `interaccion_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `vacante`
--
ALTER TABLE `vacante`
  ADD CONSTRAINT `vacante_ibfk_1` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
