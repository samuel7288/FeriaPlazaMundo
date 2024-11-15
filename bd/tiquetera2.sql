-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 12-11-2024 a las 00:12:51
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS tiquetera2;
USE tiquetera2;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: tiquetera2
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla categorias
--

CREATE TABLE categorias (
  id_categoria int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  nombreCategoria varchar(150) DEFAULT NULL,
  fechaCaptura date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla categorias
--

INSERT INTO `categorias` (`id_categoria`, `nombreCategoria`, `fechaCaptura`) VALUES
(2, 'Juegos de Habilidad', '2024-11-09'),
(3, 'Juegos de Azar', '2024-11-09');


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla edad
--

CREATE TABLE edad (
  id_edad int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  nombre varchar(200) DEFAULT NULL,
  edadMin varchar(200) DEFAULT NULL,
  edadMax varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla edad
--

INSERT INTO edad (id_edad, id_usuario, nombre, edadMin, edadMax) VALUES
(1, 1, 'Adulto Mayor', '60', '95');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla imagenes
--

CREATE TABLE imagenes (
  id_imagen int(11) NOT NULL,
  id_categoria int(11) NOT NULL,
  nombre varchar(500) DEFAULT NULL,
  ruta varchar(500) DEFAULT NULL,
  fechaSubida date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla imagenes
--

INSERT INTO imagenes (id_imagen, id_categoria, nombre, ruta, fechaSubida) VALUES
(1, 1, 'png-transparent-mechanical-bull-bull-riding-bucking-bull-bull-animals-cowboy-cartoon-thumbnail.png', '../../archivos/png-transparent-mechanical-bull-bull-riding-bucking-bull-bull-animals-cowboy-cartoon-thumbnail.png', '2024-11-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla tickets
--

CREATE TABLE tickets (
  id_ticket int(11) NOT NULL,
  id_categoria int(11) NOT NULL,
  id_imagen int(11) NOT NULL,
  id_usuario int(11) NOT NULL,
  nombre varchar(50) DEFAULT NULL,
  descripcion varchar(500) DEFAULT NULL,
  cantidad int(11) DEFAULT NULL,
  precio float DEFAULT NULL,
  fechaCaptura date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla tickets
--

INSERT INTO tickets (id_ticket, id_categoria, id_imagen, id_usuario, nombre, descripcion, cantidad, precio, fechaCaptura) VALUES
(1, 1, 1, 1, 'Toro', 'Torito Mecanico', 100, 2, '2024-11-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla usuarios
--

CREATE TABLE usuarios (
  id_usuario int(11) NOT NULL,
  nombre varchar(50) DEFAULT NULL,
  apellido varchar(50) DEFAULT NULL,
  email varchar(50) DEFAULT NULL,
  password tinytext DEFAULT NULL,
  fechaCaptura date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla usuarios
--

INSERT INTO usuarios (id_usuario, nombre, apellido, email, password, fechaCaptura) VALUES
(1, 'Jose', 'Antonio', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2024-11-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla ventas
--

CREATE TABLE ventas (
  id_venta int(11) NOT NULL,
  id_edad int(11) DEFAULT NULL,
  id_ticket int(11) DEFAULT NULL,
  id_usuario int(11) DEFAULT NULL,
  precio float DEFAULT NULL,
  fechaCompra date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla ventas
--

INSERT INTO ventas (id_venta, id_edad, id_ticket, id_usuario, precio, fechaCompra) VALUES
(2, 1, 1, 1, 2, '2024-11-09'),
(3, 1, 1, 1, 2, '2024-11-09'),
(4, 1, 1, 1, 2, '2024-11-09'),
(4, 1, 1, 1, 2, '2024-11-09');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla categorias
--
ALTER TABLE categorias
  ADD PRIMARY KEY (id_categoria);

--
-- Indices de la tabla edad
--
ALTER TABLE edad
  ADD PRIMARY KEY (id_edad);

--
-- Indices de la tabla imagenes
--
ALTER TABLE imagenes
  ADD PRIMARY KEY (id_imagen);

--
-- Indices de la tabla tickets
--
ALTER TABLE tickets
  ADD PRIMARY KEY (id_ticket);

--
-- Indices de la tabla usuarios
--
ALTER TABLE usuarios
  ADD PRIMARY KEY (id_usuario);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla categorias
--
ALTER TABLE categorias
  MODIFY id_categoria int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla edad
--
ALTER TABLE edad
  MODIFY id_edad int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla imagenes
--
ALTER TABLE imagenes
  MODIFY id_imagen int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla tickets
--
ALTER TABLE tickets
  MODIFY id_ticket int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla usuarios
--
ALTER TABLE usuarios
  MODIFY id_usuario int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;