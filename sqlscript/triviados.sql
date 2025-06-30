-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-06-2025 a las 16:08:01
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
-- Base de datos: `triviados`
--
CREATE DATABASE triviados;
USE triviados;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `color` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`, `color`) VALUES
(1, 'Geografía', 'azul'),
(2, 'Historia', 'amarillo'),
(3, 'Ciencia', 'verde'),
(4, 'Deportes', 'naranja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opciones`
--

CREATE TABLE `opciones` (
  `id_incremental` int(11) NOT NULL,
  `pregunta_id` int(11) NOT NULL,
  `opcion` varchar(255) NOT NULL,
  `es_correcta` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `opciones`
--

INSERT INTO `opciones` (`id_incremental`, `pregunta_id`, `opcion`, `es_correcta`) VALUES
(1, 1, 'Madrid', 0),
(2, 1, 'Berlín', 0),
(3, 1, 'Roma', 1),
(4, 1, 'París', 0),
(5, 2, 'Yangtsé', 0),
(6, 2, 'Mississippi', 0),
(7, 2, 'Amazonas', 1),
(8, 2, 'Nilo', 0),
(9, 3, '1945', 0),
(10, 3, '1939', 1),
(11, 3, '1941', 0),
(12, 3, '1914', 0),
(13, 4, 'Marte', 0),
(14, 4, 'Mercurio', 1),
(15, 4, 'Tierra', 0),
(16, 4, 'Venus', 0),
(17, 5, 'Mario Vargas Llosa', 0),
(18, 5, 'Gabriel García Márquez', 1),
(19, 5, 'Jorge Luis Borges', 0),
(20, 5, 'Isabel Allende', 0),
(21, 6, 'Hg', 0),
(22, 6, 'Fe', 0),
(23, 6, 'Au', 1),
(24, 6, 'Ag', 0),
(25, 7, 'Picasso', 0),
(26, 7, 'Van Gogh', 0),
(27, 7, 'Michelangelo', 0),
(28, 7, 'Leonardo da Vinci', 1),
(29, 8, 'Español', 0),
(30, 8, 'Árabe', 0),
(31, 8, 'Inglés', 0),
(32, 8, 'Chino mandarín', 1),
(33, 9, '10', 0),
(34, 9, '8', 1),
(35, 9, '7', 0),
(36, 9, '9', 0),
(37, 10, 'Dióxido de carbono', 0),
(38, 10, 'Nitrógeno', 0),
(39, 10, 'Hidrógeno', 0),
(40, 10, 'Oxígeno', 1),
(41, 11, 'Termómetro', 0),
(42, 11, 'Anemómetro', 0),
(43, 11, 'Higrómetro', 0),
(44, 11, 'Barómetro', 1),
(45, 12, 'George Washington', 1),
(46, 12, 'John Adams', 0),
(47, 12, 'Thomas Jefferson', 0),
(48, 12, 'Abraham Lincoln', 0),
(49, 13, '72', 0),
(50, 13, '63', 1),
(51, 13, '81', 0),
(52, 13, '54', 0),
(53, 14, 'Alemania', 0),
(54, 14, 'España', 0),
(55, 14, 'Francia', 1),
(56, 14, 'Italia', 0),
(57, 15, 'Asia', 0),
(58, 15, 'Europa', 0),
(59, 15, 'África', 1),
(60, 15, 'América', 0),
(61, 16, 'Pantera', 0),
(62, 16, 'Elefante', 0),
(63, 16, 'León', 1),
(64, 16, 'Tigre', 0),
(65, 17, 'Sidney', 0),
(66, 17, 'Perth', 0),
(67, 17, 'Canberra', 1),
(68, 17, 'Melbourne', 0),
(69, 18, '6', 0),
(70, 18, '7', 0),
(71, 18, '4', 0),
(72, 18, '5', 1),
(73, 19, 'Radar', 0),
(74, 19, 'Microscopio', 1),
(75, 19, 'Lupa', 0),
(76, 19, 'Telescopio', 0),
(77, 20, 'España', 0),
(78, 20, 'Grecia', 0),
(79, 20, 'Italia', 1),
(80, 20, 'Portugal', 0),
(81, 21, 'Hierro', 0),
(82, 21, 'Litio', 1),
(83, 21, 'Helio', 0),
(84, 21, 'Aluminio', 0),
(85, 22, 'Agatha Christie', 0),
(86, 22, 'Arthur Conan Doyle', 1),
(87, 22, 'Stephen King', 0),
(88, 22, 'J.K. Rowling', 0),
(89, 23, 'India', 0),
(90, 23, 'China', 1),
(91, 23, 'Indonesia', 0),
(92, 23, 'Estados Unidos', 0),
(93, 24, 'La piel', 1),
(94, 24, 'El corazón', 0),
(95, 24, 'Los pulmones', 0),
(96, 24, 'El hígado', 0),
(97, 25, 'Guernica', 0),
(98, 25, 'Las meninas', 0),
(99, 25, 'El grito', 0),
(100, 25, 'La noche estrellada', 1),
(101, 26, 'Dióxido de carbono', 0),
(102, 26, 'Oxígeno', 0),
(103, 26, 'Hidrógeno', 0),
(104, 26, 'Nitrógeno', 1),
(105, 27, 'Japón', 1),
(106, 27, 'Vietnam', 0),
(107, 27, 'Corea del Sur', 0),
(108, 27, 'China', 0),
(109, 28, 'Organización de las Naciones Unidas', 1),
(110, 28, 'Oficina de Naciones Unidas', 0),
(111, 28, 'Organismo Nacional Unido', 0),
(112, 28, 'Organización No Unida', 0),
(113, 29, 'William Shakespeare', 0),
(114, 29, 'Gabriel García Márquez', 0),
(115, 29, 'Miguel de Cervantes', 1),
(116, 29, 'Federico García Lorca', 0),
(117, 30, 'Brasil', 0),
(118, 30, 'Francia', 1),
(119, 30, 'Alemania', 0),
(120, 30, 'Croacia', 0),
(121, 31, '1778', 1),
(122, 31, '1850', 0),
(123, 31, '1735', 0),
(124, 31, '1802', 0),
(125, 32, '1778', 1),
(126, 32, '1850', 0),
(127, 32, '1735', 0),
(128, 32, '1802', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partida`
--

CREATE TABLE `partida` (
  `id_incremental` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_inicio` datetime NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `puntaje_obtenido` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `partida`
--

INSERT INTO `partida` (`id_incremental`, `id_usuario`, `fecha_inicio`, `estado`, `puntaje_obtenido`) VALUES
(1, 3, '2025-06-26 15:22:08', 0, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_incremental` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `reportado` tinyint(1) DEFAULT 0,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `veces_entregada` int(11) DEFAULT 0,
  `veces_correcta` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_incremental`, `pregunta`, `estado`, `reportado`, `id_usuario`, `id_categoria`, `veces_entregada`, `veces_correcta`) VALUES
(1, '¿Cuál es la capital de Italia?', 1, 0, 3, 1, 0, 0),
(2, '¿Cuál es el río más largo del mundo?', 1, 0, 3, 2, 1, 0),
(3, '¿En qué año comenzó la Segunda Guerra Mundial?', 1, 0, 3, 2, 0, 0),
(4, '¿Qué planeta es el más cercano al sol?', 1, 0, 3, 3, 0, 0),
(5, '¿Quién escribió \'Cien años de soledad\'?', 1, 0, 3, 4, 0, 0),
(6, '¿Cuál es el símbolo químico del oro?', 1, 0, 3, 3, 0, 0),
(7, '¿Quién pintó la Mona Lisa?', 1, 0, 3, 4, 0, 0),
(8, '¿Cuál es el idioma más hablado del mundo?', 1, 0, 3, 1, 0, 0),
(9, '¿Cuántos planetas hay en el sistema solar?', 1, 0, 3, 3, 0, 0),
(10, '¿Qué gas es necesario para que ocurra la combustión?', 1, 0, 3, 3, 0, 0),
(11, '¿Qué instrumento mide la presión atmosférica?', 1, 0, 3, 3, 0, 0),
(12, '¿Quién fue el primer presidente de los Estados Unidos?', 1, 0, 3, 2, 0, 0),
(13, '¿Cuál es el resultado de 9 x 7?', 1, 0, 3, 2, 0, 0),
(14, '¿En qué país se encuentra la Torre Eiffel?', 1, 0, 3, 1, 0, 0),
(15, '¿Qué continente tiene más países?', 1, 0, 3, 1, 0, 0),
(16, '¿Qué animal es conocido como el \"rey de la selva\"?', 1, 0, 3, 4, 0, 0),
(17, '¿Cuál es la capital de Australia?', 1, 0, 3, 1, 0, 0),
(18, '¿Cuántos océanos hay en la Tierra?', 1, 0, 3, 2, 0, 0),
(19, '¿Qué instrumento se usa para ver objetos muy pequeños?', 1, 0, 3, 3, 0, 0),
(20, '¿Qué país tiene forma de bota?', 1, 0, 3, 1, 0, 0),
(21, '¿Cuál es el metal más ligero?', 1, 0, 3, 3, 0, 0),
(22, '¿Qué escritor creó a Sherlock Holmes?', 1, 0, 3, 2, 0, 0),
(23, '¿Cuál es el país con más habitantes?', 1, 0, 3, 1, 0, 0),
(24, '¿Cuál es el órgano más grande del cuerpo humano?', 1, 0, 3, 3, 1, 1),
(25, '¿Qué pintura famosa hizo Vincent Van Gogh?', 1, 0, 3, 4, 0, 0),
(26, '¿Cuál es el elemento más abundante en el aire?', 1, 0, 3, 3, 0, 0),
(27, '¿Qué país inventó el sushi?', 1, 0, 3, 1, 0, 0),
(28, '¿Qué significa la sigla \"ONU\"?', 1, 0, 3, 1, 0, 0),
(29, '¿Qué autor escribió \"El Quijote\"?', 1, 0, 3, 2, 0, 0),
(30, '¿Qué país ganó el Mundial de Fútbol en 2018?', 1, 0, 3, 4, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas_partida`
--

CREATE TABLE `respuestas_partida` (
  `id_incremental` int(11) NOT NULL,
  `id_partida` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `id_opcion_seleccionada` int(11) NOT NULL,
  `es_correcta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_incremental` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_completo` varchar(255) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` enum('masculino','femenino','otro') DEFAULT 'otro',
  `pais` varchar(100) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `foto_perfil` varchar(255) DEFAULT NULL,
  `validado` tinyint(1) DEFAULT 0,
  `token_validacion` varchar(64) DEFAULT NULL,
  `tipo_Usuario` varchar(64) DEFAULT 'Jugador',
  `preguntas_respondidas` int(11) DEFAULT 0,
  `puntaje` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_incremental`, `email`, `password`, `nombre_completo`, `fecha_nacimiento`, `sexo`, `pais`, `ciudad`, `nombre_usuario`, `foto_perfil`, `validado`, `token_validacion`, `tipo_Usuario`, `preguntas_respondidas`, `puntaje`) VALUES
(1, 'admin@admin.com', 'admin123', 'Admin Principal', '1990-01-01', 'otro', 'Argentina', 'Buenos Aires', 'admin', 'admin.jpg', 1, NULL, 'admin', 0, 0),
(2, 'editor@editor.com', 'editor123', 'Editor Principal', '1990-01-01', 'otro', 'Argentina', 'Buenos Aires', 'editor', 'editor.jpg', 1, NULL, 'editor', 0, 0),
(3, 'fgp_2001@hotmail.com', 'facu123', 'Facundo Pereira', '2001-01-15', 'masculino', 'Argentina', 'El Palomar', 'Facupe', 'img/Facupe.png', 1, '113ecf408e93b5124ba9e8ddffb921d3', 'Jugador', 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_pregunta`
--

CREATE TABLE `usuario_pregunta` (
  `id_incremental` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario_pregunta`
--

INSERT INTO `usuario_pregunta` (`id_incremental`, `id_usuario`, `id_pregunta`) VALUES
(0, 3, 24),
(0, 3, 2);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_incremental`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_incremental`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_incremental`);

--
-- Indices de la tabla `respuestas_partida`
--
ALTER TABLE `respuestas_partida`
  ADD PRIMARY KEY (`id_incremental`),
  ADD KEY `id_partida` (`id_partida`),
  ADD KEY `id_pregunta` (`id_pregunta`),
  ADD KEY `id_opcion_seleccionada` (`id_opcion_seleccionada`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_incremental`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `respuestas_partida`
--
ALTER TABLE `respuestas_partida`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `respuestas_partida`
--
ALTER TABLE `respuestas_partida`
  ADD CONSTRAINT `respuestas_partida_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partida` (`id_incremental`),
  ADD CONSTRAINT `respuestas_partida_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_incremental`),
  ADD CONSTRAINT `respuestas_partida_ibfk_3` FOREIGN KEY (`id_opcion_seleccionada`) REFERENCES `opciones` (`id_incremental`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
