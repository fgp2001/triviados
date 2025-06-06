
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-06-2025 a las 04:31:20
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12
CREATE DATABASE triviados;
USE triviados;
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
(1, 1, 'Roma', 1),
(2, 1, 'París', 0),
(3, 1, 'Madrid', 0),
(4, 1, 'Berlín', 0),
(5, 2, 'Amazonas', 1),
(6, 2, 'Nilo', 0),
(7, 2, 'Yangtsé', 0),
(8, 2, 'Mississippi', 0),
(9, 3, '1939', 1),
(10, 3, '1941', 0),
(11, 3, '1914', 0),
(12, 3, '1945', 0),
(13, 4, 'Mercurio', 1),
(14, 4, 'Venus', 0),
(15, 4, 'Tierra', 0),
(16, 4, 'Marte', 0),
(17, 5, 'Gabriel García Márquez', 1),
(18, 5, 'Mario Vargas Llosa', 0),
(19, 5, 'Isabel Allende', 0),
(20, 5, 'Jorge Luis Borges', 0),
(21, 6, 'Au', 1),
(22, 6, 'Ag', 0),
(23, 6, 'Fe', 0),
(24, 6, 'Hg', 0),
(25, 7, 'Leonardo da Vinci', 1),
(26, 7, 'Michelangelo', 0),
(27, 7, 'Picasso', 0),
(28, 7, 'Van Gogh', 0),
(29, 8, 'Chino mandarín', 1),
(30, 8, 'Inglés', 0),
(31, 8, 'Español', 0),
(32, 8, 'Árabe', 0),
(33, 9, '8', 1),
(34, 9, '9', 0),
(35, 9, '7', 0),
(36, 9, '10', 0),
(37, 10, 'Oxígeno', 1),
(38, 10, 'Hidrógeno', 0),
(39, 10, 'Nitrógeno', 0),
(40, 10, 'Dióxido de carbono', 0),
(41, 11, 'Barómetro', 1),
(42, 11, 'Termómetro', 0),
(43, 11, 'Higrómetro', 0),
(44, 11, 'Anemómetro', 0),
(45, 12, 'George Washington', 1),
(46, 12, 'Abraham Lincoln', 0),
(47, 12, 'Thomas Jefferson', 0),
(48, 12, 'John Adams', 0),
(49, 13, '63', 1),
(50, 13, '72', 0),
(51, 13, '54', 0),
(52, 13, '81', 0),
(53, 14, 'Francia', 1),
(54, 14, 'Italia', 0),
(55, 14, 'España', 0),
(56, 14, 'Alemania', 0),
(57, 15, 'África', 1),
(58, 15, 'Asia', 0),
(59, 15, 'Europa', 0),
(60, 15, 'América', 0),
(61, 16, 'León', 1),
(62, 16, 'Tigre', 0),
(63, 16, 'Elefante', 0),
(64, 16, 'Pantera', 0),
(65, 17, 'Canberra', 1),
(66, 17, 'Sidney', 0),
(67, 17, 'Melbourne', 0),
(68, 17, 'Perth', 0),
(69, 18, '5', 1),
(70, 18, '4', 0),
(71, 18, '6', 0),
(72, 18, '7', 0),
(73, 19, 'Microscopio', 1),
(74, 19, 'Telescopio', 0),
(75, 19, 'Lupa', 0),
(76, 19, 'Radar', 0),
(77, 20, 'Italia', 1),
(78, 20, 'Grecia', 0),
(79, 20, 'España', 0),
(80, 20, 'Portugal', 0),
(81, 21, 'Litio', 1),
(82, 21, 'Aluminio', 0),
(83, 21, 'Helio', 0),
(84, 21, 'Hierro', 0),
(85, 22, 'Arthur Conan Doyle', 1),
(86, 22, 'Agatha Christie', 0),
(87, 22, 'J.K. Rowling', 0),
(88, 22, 'Stephen King', 0),
(89, 23, 'China', 1),
(90, 23, 'India', 0),
(91, 23, 'Estados Unidos', 0),
(92, 23, 'Indonesia', 0),
(93, 24, 'La piel', 1),
(94, 24, 'El hígado', 0),
(95, 24, 'El corazón', 0),
(96, 24, 'Los pulmones', 0),
(97, 25, 'La noche estrellada', 1),
(98, 25, 'El grito', 0),
(99, 25, 'Guernica', 0),
(100, 25, 'Las meninas', 0),
(101, 26, 'Nitrógeno', 1),
(102, 26, 'Oxígeno', 0),
(103, 26, 'Dióxido de carbono', 0),
(104, 26, 'Hidrógeno', 0),
(105, 27, 'Japón', 1),
(106, 27, 'China', 0),
(107, 27, 'Corea del Sur', 0),
(108, 27, 'Vietnam', 0),
(109, 28, 'Organización de las Naciones Unidas', 1),
(110, 28, 'Organismo Nacional Unido', 0),
(111, 28, 'Oficina de Naciones Unidas', 0),
(112, 28, 'Organización No Unida', 0),
(113, 29, 'Miguel de Cervantes', 1),
(114, 29, 'Gabriel García Márquez', 0),
(115, 29, 'William Shakespeare', 0),
(116, 29, 'Federico García Lorca', 0),
(117, 30, 'Francia', 1),
(118, 30, 'Croacia', 0),
(119, 30, 'Alemania', 0),
(120, 30, 'Brasil', 0);

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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `id_incremental` int(11) NOT NULL,
  `pregunta` text NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `verificado` tinyint(1) DEFAULT 0,
  `id_usuario` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`id_incremental`, `pregunta`, `estado`, `verificado`, `id_usuario`, `id_categoria`) VALUES
(1, '¿Cuál es la capital de Italia?', 1, 1, 3, 1),
(2, '¿Cuál es el río más largo del mundo?', 1, 1, 3, 2),
(3, '¿En qué año comenzó la Segunda Guerra Mundial?', 1, 1, 3, 2),
(4, '¿Qué planeta es el más cercano al sol?', 1, 1, 3, 3),
(5, '¿Quién escribió \'Cien años de soledad\'?', 1, 1, 3, 4),
(6, '¿Cuál es el símbolo químico del oro?', 1, 1, 3, 3),
(7, '¿Quién pintó la Mona Lisa?', 1, 1, 3, 4),
(8, '¿Cuál es el idioma más hablado del mundo?', 1, 1, 3, 1),
(9, '¿Cuántos planetas hay en el sistema solar?', 1, 1, 3, 3),
(10, '¿Qué gas es necesario para que ocurra la combustión?', 1, 1, 3, 3),
(11, '¿Qué instrumento mide la presión atmosférica?', 1, 1, 3, 3),
(12, '¿Quién fue el primer presidente de los Estados Unidos?', 1, 1, 3, 2),
(13, '¿Cuál es el resultado de 9 x 7?', 1, 1, 3, 2),
(14, '¿En qué país se encuentra la Torre Eiffel?', 1, 1, 3, 1),
(15, '¿Qué continente tiene más países?', 1, 1, 3, 1),
(16, '¿Qué animal es conocido como el \"rey de la selva\"?', 1, 1, 3, 4),
(17, '¿Cuál es la capital de Australia?', 1, 1, 3, 1),
(18, '¿Cuántos océanos hay en la Tierra?', 1, 1, 3, 2),
(19, '¿Qué instrumento se usa para ver objetos muy pequeños?', 1, 1, 3, 3),
(20, '¿Qué país tiene forma de bota?', 1, 1, 3, 1),
(21, '¿Cuál es el metal más ligero?', 1, 1, 3, 3),
(22, '¿Qué escritor creó a Sherlock Holmes?', 1, 1, 3, 2),
(23, '¿Cuál es el país con más habitantes?', 1, 1, 3, 1),
(24, '¿Cuál es el órgano más grande del cuerpo humano?', 1, 1, 3, 3),
(25, '¿Qué pintura famosa hizo Vincent Van Gogh?', 1, 1, 3, 4),
(26, '¿Cuál es el elemento más abundante en el aire?', 1, 1, 3, 3),
(27, '¿Qué país inventó el sushi?', 1, 1, 3, 1),
(28, '¿Qué significa la sigla \"ONU\"?', 1, 1, 3, 1),
(29, '¿Qué autor escribió \"El Quijote\"?', 1, 1, 3, 2),
(30, '¿Qué país ganó el Mundial de Fútbol en 2018?', 1, 1, 3, 4);

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
  `elo` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_incremental`, `email`, `password`, `nombre_completo`, `fecha_nacimiento`, `sexo`, `pais`, `ciudad`, `nombre_usuario`, `foto_perfil`, `validado`, `token_validacion`, `tipo_Usuario`, `elo`) VALUES
(1, 'admin@admin.com', 'admin123', 'Admin Principal', '1990-01-01', 'otro', 'Argentina', 'Buenos Aires', 'admin', 'admin.jpg', 1, NULL, 'admin', 0),
(2, 'editor@editor.com', 'editor123', 'Editor Principal', '1990-01-01', 'otro', 'Argentina', 'Buenos Aires', 'editor', 'editor.jpg', 1, NULL, 'editor', 0),
(3, 'fgp_2001@hotmail.com', 'facu123', 'Facundo Pereira', '2001-01-15', 'masculino', 'Argentina', 'El Palomar', 'Facupe', 'img/Facupe.png', 1, '113ecf408e93b5124ba9e8ddffb921d3', 'Jugador', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario_pregunta`
--

CREATE TABLE `usuario_pregunta` (
  `id_incremental` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pregunta` int(11) NOT NULL,
  `entregado` int(11) DEFAULT 0,
  `respondido_correcto` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD PRIMARY KEY (`id_incremental`),
  ADD KEY `pregunta_id` (`pregunta_id`);

--
-- Indices de la tabla `partida`
--
ALTER TABLE `partida`
  ADD PRIMARY KEY (`id_incremental`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`id_incremental`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_incremental`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- Indices de la tabla `usuario_pregunta`
--
ALTER TABLE `usuario_pregunta`
  ADD PRIMARY KEY (`id_incremental`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_pregunta` (`id_pregunta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `opciones`
--
ALTER TABLE `opciones`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT de la tabla `partida`
--
ALTER TABLE `partida`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario_pregunta`
--
ALTER TABLE `usuario_pregunta`
  MODIFY `id_incremental` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `opciones`
--
ALTER TABLE `opciones`
  ADD CONSTRAINT `opciones_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `preguntas` (`id_incremental`) ON DELETE CASCADE;

--
-- Filtros para la tabla `partida`
--
ALTER TABLE `partida`
  ADD CONSTRAINT `partida_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_incremental`) ON DELETE CASCADE;

--
-- Filtros para la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD CONSTRAINT `preguntas_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_incremental`) ON DELETE CASCADE,
  ADD CONSTRAINT `preguntas_ibfk_2` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `usuario_pregunta`
--
ALTER TABLE `usuario_pregunta`
  ADD CONSTRAINT `usuario_pregunta_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_incremental`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_pregunta_ibfk_2` FOREIGN KEY (`id_pregunta`) REFERENCES `preguntas` (`id_incremental`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
