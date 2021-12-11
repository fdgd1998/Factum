-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-12-2021 a las 02:07:35
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `factum`
--
CREATE DATABASE IF NOT EXISTS `factum` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `factum`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `nif` varchar(9) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  `cp` int(5) DEFAULT NULL,
  `localidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `controlfactura`
--

CREATE TABLE `controlfactura` (
  `nombreserie` varchar(20) NOT NULL,
  `anoultimafactura` int(2) DEFAULT NULL,
  `numeroultimafactura` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `controlfactura`
--

INSERT INTO `controlfactura` (`nombreserie`, `anoultimafactura`, `numeroultimafactura`) VALUES
('FIVA', 21, 0),
('PR', 21, 0),
('RFIVA', 21, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `numero` varchar(15) NOT NULL,
  `nif` varchar(9) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `formapago` varchar(20) DEFAULT NULL,
  `conceptos` longtext DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `total` float NOT NULL,
  `imponible` float NOT NULL,
  `iva` float NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `cp` int(5) NOT NULL,
  `localidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturasrec`
--

CREATE TABLE `facturasrec` (
  `numero` varchar(15) NOT NULL,
  `facturaref` varchar(15) NOT NULL,
  `nif` varchar(9) NOT NULL,
  `fecha` date NOT NULL,
  `formapago` varchar(20) NOT NULL,
  `conceptos` longtext NOT NULL,
  `observaciones` text NOT NULL,
  `total` float NOT NULL,
  `iva` float NOT NULL,
  `imponible` float NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `cp` int(5) NOT NULL,
  `localidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `presupuestos`
--

CREATE TABLE `presupuestos` (
  `numero` varchar(15) NOT NULL,
  `nif` varchar(9) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `conceptos` longtext DEFAULT NULL,
  `observaciones` text DEFAULT NULL,
  `formapago` varchar(20) NOT NULL,
  `tieneiva` varchar(2) DEFAULT NULL,
  `total` float NOT NULL,
  `imponible` float NOT NULL,
  `iva` float NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `cp` int(5) NOT NULL,
  `localidad` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`nif`);

--
-- Indices de la tabla `controlfactura`
--
ALTER TABLE `controlfactura`
  ADD PRIMARY KEY (`nombreserie`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `facturas_ibfk_1` (`nif`);

--
-- Indices de la tabla `facturasrec`
--
ALTER TABLE `facturasrec`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `facturaref` (`facturaref`),
  ADD KEY `nif` (`nif`);

--
-- Indices de la tabla `presupuestos`
--
ALTER TABLE `presupuestos`
  ADD PRIMARY KEY (`numero`),
  ADD KEY `presupuestos_ibfk_1` (`nif`);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `facturasrec`
--
ALTER TABLE `facturasrec`
  ADD CONSTRAINT `facturasrec_ibfk_1` FOREIGN KEY (`facturaref`) REFERENCES `facturas` (`numero`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
