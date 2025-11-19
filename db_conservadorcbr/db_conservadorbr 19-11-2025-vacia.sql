-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-11-2025 a las 05:26:32
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
-- Base de datos: `db_conservadorbr`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `apendices`
--

CREATE TABLE `apendices` (
  `id` int(11) NOT NULL,
  `tipo_registro` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL,
  `fecha_carga` datetime NOT NULL DEFAULT current_timestamp(),
  `ruta_imagen` varchar(255) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `certificados`
--

CREATE TABLE `certificados` (
  `id_certificado` int(11) NOT NULL,
  `tipo_registro` varchar(255) DEFAULT NULL,
  `tipo_documento` varchar(255) DEFAULT NULL,
  `foja_inicial` decimal(5,1) DEFAULT NULL,
  `foja_final` decimal(5,1) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `personas` text DEFAULT NULL,
  `fecha_emision` date DEFAULT NULL,
  `solicitud` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `copiasregistros`
--

CREATE TABLE `copiasregistros` (
  `id_copia` int(11) NOT NULL,
  `id_certificado` int(11) DEFAULT NULL,
  `tipo_registro` varchar(255) DEFAULT NULL,
  `tipo_documento` varchar(255) DEFAULT NULL,
  `foja_inicial` decimal(5,1) DEFAULT NULL,
  `numero` varchar(50) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `personas` text DEFAULT NULL,
  `ruta_copia` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fojas`
--

CREATE TABLE `fojas` (
  `id` int(11) NOT NULL,
  `tipo_registro` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL,
  `foja` decimal(5,1) NOT NULL,
  `subfoja` varchar(50) NOT NULL,
  `fecha_carga` datetime NOT NULL DEFAULT current_timestamp(),
  `ruta_imagen` varchar(255) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `indices`
--

CREATE TABLE `indices` (
  `id` int(11) NOT NULL,
  `comprador` varchar(255) NOT NULL,
  `vendedor` varchar(255) NOT NULL,
  `materia` varchar(255) NOT NULL,
  `foja` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `anio` int(11) NOT NULL,
  `libro` varchar(30) NOT NULL,
  `comuna` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `folio` varchar(50) DEFAULT NULL,
  `vigencia` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `personas`
--

CREATE TABLE `personas` (
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `rut` varchar(15) NOT NULL,
  `telefono` varchar(13) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nombre_boleta` varchar(50) DEFAULT NULL,
  `rut_boleta` varchar(50) DEFAULT NULL,
  `ciudad_boleta` varchar(50) DEFAULT NULL,
  `direccion_boleta` varchar(50) DEFAULT NULL,
  `tipo_envio` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_detalles`
--

CREATE TABLE `solicitudes_detalles` (
  `id` int(11) NOT NULL,
  `libro` varchar(50) DEFAULT NULL,
  `tomo` varchar(50) DEFAULT NULL,
  `bimestre` varchar(50) DEFAULT NULL,
  `foja` varchar(50) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `anio` int(11) DEFAULT NULL,
  `certificado` varchar(100) DEFAULT NULL,
  `observacion` varchar(50) DEFAULT NULL,
  `solicitud` int(11) NOT NULL,
  `valor` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_11_25`
--

CREATE TABLE `solicitud_11_25` (
  `id` int(11) NOT NULL,
  `id_certificado` int(11) NOT NULL,
  `data` longblob DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `estado` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valores_cert`
--

CREATE TABLE `valores_cert` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `valor` int(11) NOT NULL,
  `descripcion` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apendices`
--
ALTER TABLE `apendices`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `certificados`
--
ALTER TABLE `certificados`
  ADD PRIMARY KEY (`id_certificado`);

--
-- Indices de la tabla `copiasregistros`
--
ALTER TABLE `copiasregistros`
  ADD PRIMARY KEY (`id_copia`);

--
-- Indices de la tabla `fojas`
--
ALTER TABLE `fojas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `indices`
--
ALTER TABLE `indices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_libro_comprador` (`libro`,`comprador`(100)),
  ADD KEY `idx_libro_vendedor` (`libro`,`vendedor`(100)),
  ADD KEY `idx_inscripcion` (`libro`,`foja`,`numero`,`anio`),
  ADD KEY `idx_anio_numero` (`anio`,`numero`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes_detalles`
--
ALTER TABLE `solicitudes_detalles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitud` (`solicitud`);

--
-- Indices de la tabla `solicitud_11_25`
--
ALTER TABLE `solicitud_11_25`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_certificado` (`id_certificado`),
  ADD KEY `id_certificado_2` (`id_certificado`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `valores_cert`
--
ALTER TABLE `valores_cert`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apendices`
--
ALTER TABLE `apendices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `certificados`
--
ALTER TABLE `certificados`
  MODIFY `id_certificado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `copiasregistros`
--
ALTER TABLE `copiasregistros`
  MODIFY `id_copia` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `fojas`
--
ALTER TABLE `fojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `indices`
--
ALTER TABLE `indices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitudes_detalles`
--
ALTER TABLE `solicitudes_detalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `solicitud_11_25`
--
ALTER TABLE `solicitud_11_25`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `valores_cert`
--
ALTER TABLE `valores_cert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitudes_detalles`
--
ALTER TABLE `solicitudes_detalles`
  ADD CONSTRAINT `FK_solicitudes_detalles_solicitudes` FOREIGN KEY (`solicitud`) REFERENCES `solicitudes` (`id`);

--
-- Filtros para la tabla `solicitud_11_25`
--
ALTER TABLE `solicitud_11_25`
  ADD CONSTRAINT `FK_solicitud_11_25_solicitudes` FOREIGN KEY (`id_certificado`) REFERENCES `solicitudes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
