CREATE DATABASE triviados;
USE triviados;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `usuarios` (
  `id_incremental` int(11) PRIMARY KEY AUTO_INCREMENT,
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
  `token_validacion` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `usuarios` (`email`, `password`, `nombre_completo`, `fecha_nacimiento`, `sexo`, `pais`, `ciudad`, `nombre_usuario`, `foto_perfil`, `validado`, `token_validacion`) VALUES
('admin@admin.com', 'admin123', 'Admin Principal', '1990-01-01', 'otro', 'Argentina', 'Buenos Aires', 'admin', 'admin.jpg', 1, NULL);
