-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-06-2025 a las 23:35:17
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `registros_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contenidos`
--

CREATE TABLE `contenidos` (
  `idContenido` int(11) NOT NULL,
  `accion` text DEFAULT NULL,
  `idDescripcion` int(11) DEFAULT NULL,
  `fecha_seleccion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contenidos`
--

INSERT INTO `contenidos` (`idContenido`, `accion`, `idDescripcion`, `fecha_seleccion`) VALUES
(1, 'SOLUCION PARA EL INGRESO DEL SISTEMA DE TEAMS', 1, '2025-07-01 00:31:59'),
(2, 'SOLUCION PARA EL INGRESO DEL SISTEMA DE PRACTICAS', 2, '2025-07-01 00:26:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `descripcion`
--

CREATE TABLE `descripcion` (
  `idDescripcion` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `descripcion`
--

INSERT INTO `descripcion` (`idDescripcion`, `descripcion`) VALUES
(1, '1.-Ingresa tu correo institucional en la página de inicio de sesión de Microsoft y haz clic en \"Siguiente\".\r\n\r\n2.-Escribe tu contraseña y presiona \"Iniciar sesión\".\r\n\r\n3.-Selecciona tu cuenta si ya está guardada.\r\n\r\n4.-Si aparece verificación por mensaje, haz clic en \"Cancelar\".\r\n\r\n5.-Cuando pida asegurar tu cuenta, haz clic en \"Usar otra cuenta\" y luego en \"Siguiente\".\r\n\r\n6.-Vuelve a seleccionar tu cuenta para completar el ingreso.'),
(2, 'Tutorial para el tema modular de practicas\r\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `multimedia`
--

CREATE TABLE `multimedia` (
  `idMultimedia` int(11) NOT NULL,
  `idTipo` int(11) DEFAULT NULL,
  `idContenido` int(11) DEFAULT NULL,
  `idRuta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `multimedia`
--

INSERT INTO `multimedia` (`idMultimedia`, `idTipo`, `idContenido`, `idRuta`) VALUES
(1, 1, 1, 1),
(2, 1, 1, 2),
(3, 1, 1, 3),
(4, 1, 1, 4),
(5, 1, 1, 5),
(6, 1, 1, 6),
(7, 2, 2, 7);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `idOpcion` int(11) NOT NULL,
  `idContenido` int(11) DEFAULT NULL,
  `fecha_seleccion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `idRuta` int(11) NOT NULL,
  `ruta` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`idRuta`, `ruta`) VALUES
(1, '../Multimedia/Imagenes/Captura de pantalla 2025-06-30 115848.png'),
(2, '../Multimedia/Imagenes/T2.png'),
(3, '../Multimedia/Imagenes/T6.png'),
(4, '../Multimedia/Imagenes/T5.png'),
(5, '../Multimedia/Imagenes/T4.png'),
(6, '../Multimedia/Imagenes/T3.png'),
(7, '../Multimedia/Videos/viedo 1.mp4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `idTipo` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`idTipo`, `nombre`) VALUES
(1, 'Imagen'),
(2, 'Video'),
(3, 'Documento');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD PRIMARY KEY (`idContenido`),
  ADD KEY `idDescripcion` (`idDescripcion`);

--
-- Indices de la tabla `descripcion`
--
ALTER TABLE `descripcion`
  ADD PRIMARY KEY (`idDescripcion`);

--
-- Indices de la tabla `multimedia`
--
ALTER TABLE `multimedia`
  ADD PRIMARY KEY (`idMultimedia`),
  ADD KEY `idTipo` (`idTipo`),
  ADD KEY `idContenido` (`idContenido`),
  ADD KEY `idRuta` (`idRuta`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`idOpcion`),
  ADD KEY `idContenido` (`idContenido`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`idRuta`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`idTipo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contenidos`
--
ALTER TABLE `contenidos`
  MODIFY `idContenido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `descripcion`
--
ALTER TABLE `descripcion`
  MODIFY `idDescripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `multimedia`
--
ALTER TABLE `multimedia`
  MODIFY `idMultimedia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `idOpcion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `idRuta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `idTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `contenidos`
--
ALTER TABLE `contenidos`
  ADD CONSTRAINT `contenidos_ibfk_1` FOREIGN KEY (`idDescripcion`) REFERENCES `descripcion` (`idDescripcion`);

--
-- Filtros para la tabla `multimedia`
--
ALTER TABLE `multimedia`
  ADD CONSTRAINT `multimedia_ibfk_1` FOREIGN KEY (`idTipo`) REFERENCES `tipo` (`idTipo`),
  ADD CONSTRAINT `multimedia_ibfk_2` FOREIGN KEY (`idContenido`) REFERENCES `contenidos` (`idContenido`),
  ADD CONSTRAINT `multimedia_ibfk_3` FOREIGN KEY (`idRuta`) REFERENCES `rutas` (`idRuta`);

--
-- Filtros para la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_ibfk_1` FOREIGN KEY (`idContenido`) REFERENCES `contenidos` (`idContenido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
