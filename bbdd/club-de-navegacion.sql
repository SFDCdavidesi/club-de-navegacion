-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 06-05-2024 a las 20:14:36
-- Versión del servidor: 10.11.2-MariaDB-log
-- Versión de PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `club-de-navegacion`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calendario`
--

CREATE TABLE `calendario` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `plazas_disponibles` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `precio` double NOT NULL,
  `id_instructor` int(11) DEFAULT NULL,
  `nivel_requerido` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `createdby` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `calendario`
--

INSERT INTO `calendario` (`id`, `curso_id`, `plazas_disponibles`, `activo`, `precio`, `id_instructor`, `nivel_requerido`, `fecha`, `createdby`) VALUES
(1, 9, 9, 1, 600, NULL, 5, '2024-04-20 00:00:00', 3),
(3, 9, 9, 1, 600, NULL, 5, '2024-04-20 00:00:00', 3),
(5, 9, 9, 1, 600, NULL, 5, '2024-04-20 00:00:00', 3),
(7, 9, 9, 1, 600, NULL, 5, '2024-04-20 00:00:00', 3),
(9, 9, 9, 1, 600, NULL, 5, '2024-04-20 00:00:00', 3),
(11, 9, 9, 1, 333, NULL, 7, '2024-04-20 00:00:00', 3),
(13, 9, 9, 1, 333, NULL, 7, '2024-04-20 00:00:00', 3),
(15, 9, 9, 1, 333, NULL, 7, '2024-04-20 00:00:00', 3),
(17, 9, 9, 1, 333, NULL, 7, '2024-04-20 00:00:00', 3),
(19, 7, 9, 1, 400, NULL, 5, '2024-04-21 00:00:00', 3),
(21, 11, 9, 1, 150, NULL, 9, '2024-04-27 00:00:00', 3),
(23, 9, 9, 1, 500, NULL, 5, '2024-05-24 00:00:00', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id_calificacion` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_habilidad` int(11) DEFAULT NULL,
  `nivel_obtenido` int(11) NOT NULL,
  `comentarios` text DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_revision` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `id_curso` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL,
  `comentarios` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(128) NOT NULL,
  `descripcion` text NOT NULL,
  `entradilla` text NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `lugar_id` int(11) DEFAULT NULL,
  `duracion` int(11) DEFAULT NULL,
  `medida_tiempo` int(11) DEFAULT NULL,
  `numero_plazas` int(11) DEFAULT 9,
  `precio` double DEFAULT NULL,
  `nivel_requerido` int(11) DEFAULT NULL,
  `createdBy` int(11) NOT NULL COMMENT 'FK usuarios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `titulo`, `descripcion`, `entradilla`, `activo`, `fecha_creacion`, `lugar_id`, `duracion`, `medida_tiempo`, `numero_plazas`, `precio`, `nivel_requerido`, `createdBy`) VALUES
(7, 'Curso de navegación nocturna en el mediterraneo', 'El curso de navegación nocturna en el Mediterráneo está diseñado para brindarte las habilidades esenciales y la confianza necesaria para explorar las aguas en la oscuridad de manera segura y emocionante. Durante el curso, te sumergirás en una combinación única de teoría y práctica, guiado por instructores expertos con amplia experiencia en navegación nocturna.\r\n\r\nComenzaremos explorando los fundamentos teóricos de la navegación nocturna, incluyendo la interpretación de cartas náuticas, el uso de instrumentos de navegación como el compás y el GPS, y la comprensión de las luces de navegación y señales. Aprenderás a planificar rutas seguras y eficientes, teniendo en cuenta factores como las corrientes, los vientos y los peligros potenciales en la oscuridad.\r\n\r\nUna vez establecidas las bases teóricas, nos adentraremos en la práctica a bordo de embarcaciones especialmente equipadas para la navegación nocturna. Aprenderás técnicas de manejo de la embarcación en la oscuridad, incluyendo la utilización de luces adecuadas, la observación de referencias naturales y la comunicación efectiva entre la tripulación. También exploraremos estrategias de seguridad y procedimientos de emergencia diseñados específicamente para la navegación nocturna.\r\n\r\nAdemás de adquirir habilidades prácticas, este curso te brindará la oportunidad de experimentar la belleza y la serenidad del Mediterráneo bajo un nuevo y fascinante punto de vista. La navegación nocturna te permitirá disfrutar de espectaculares vistas estrelladas, así como de la tranquilidad que solo la noche en alta mar puede ofrecer.\r\n\r\nYa sea que seas un navegante experimentado en busca de desafíos nuevos o un principiante que desea expandir sus habilidades, nuestro curso de navegación nocturna en el Mediterráneo te proporcionará una experiencia inolvidable y un conjunto de habilidades valiosas para toda la vida. ¡Embárcate con nosotros y descubre el lado nocturno del mar Mediterráneo!', 'Descubre los secretos ocultos del Mediterráneo bajo el manto estrellado en nuestro apasionante curso de navegación nocturna. Aprende las técnicas y habilidades necesarias para surcar las aguas en la oscuridad, mientras te sumerges en la magia y la tranquilidad de la noche en alta mar. ¡Embárcate en esta aventura única y despierta tus sentidos a nuevas experiencias marítimas!', 1, '2024-04-04 19:44:51', 9, 3, 3, 9, NULL, 1, 3),
(9, 'Navegación astronómica', '¿Quieres navegar como lo hacían en el siglo XIX? El GPS no siempre estuvo allí, y puede que no siempre esté.\r\nEn cambio las estrellas siempre estarán ahí arriba (a noser que esté nublado).\r\n\r\nVen a unas prácticas de navegación donde tomarás rectas de altura y te posicionarás haciendo uso del sextante', 'Navegación guiándose por las estrellas haciendo uso de sextante', 1, '2024-04-14 13:07:12', 9, 5, 3, 9, NULL, 1, 3),
(11, 'Curso de remo en el retiro', 'Sumérgete en una experiencia única de navegación a remo en el emblemático Parque del Retiro de Madrid. Este curso está diseñado para todos los entusiastas del remo, desde principiantes hasta aquellos con experiencia previa que deseen perfeccionar sus habilidades en un entorno natural y relajante.\r\n\r\nDurante el curso, aprenderás las técnicas fundamentales de remo, desde el manejo correcto del remo hasta la navegación segura en aguas tranquilas. Nuestros instructores altamente capacitados te guiarán a través de cada paso, brindándote las herramientas y los conocimientos necesarios para disfrutar plenamente de esta actividad acuática.\r\n\r\nEl Parque del Retiro, con su estanque central rodeado de exuberante vegetación y monumentos históricos, ofrece el escenario perfecto para practicar remo mientras te sumerges en un oasis de tranquilidad en medio de la bulliciosa ciudad de Madrid.', 'Adéntrate en el mundo de la navegación desde el retiro', 1, '2024-04-24 20:46:02', 1, 3, 1, 9, NULL, 1, 3);

--
-- Disparadores `cursos`
--
DELIMITER $$
CREATE TRIGGER `eliminar_fotos_despues_borrar_curso` BEFORE DELETE ON `cursos` FOR EACH ROW BEGIN
    DELETE FROM fotosCursos WHERE id_curso = OLD.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotosCursos`
--

CREATE TABLE `fotosCursos` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `fotosCursos`
--

INSERT INTO `fotosCursos` (`id`, `id_curso`, `foto`) VALUES
(25, 7, '../View/img/fotosCursos/Velero 10.jpg'),
(27, 7, '../View/img/fotosCursos/Velero 12.jpeg'),
(29, 7, '../View/img/fotosCursos/Velero 2.webp'),
(33, 9, '../View/img/fotosCursos/Velero 10.jpg'),
(35, 9, '../View/img/fotosCursos/Velero 2.webp'),
(37, 11, '../View/img/fotosCursos/veleros 11.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `habilidades`
--

CREATE TABLE `habilidades` (
  `id_habilidad` int(11) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instructores`
--

CREATE TABLE `instructores` (
  `id_instructor` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `apellidos` varchar(128) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `fecha_creacion` datetime NOT NULL,
  `fecha_ultimo_curso` datetime DEFAULT NULL,
  `email` varchar(128) NOT NULL,
  `telefono` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugares`
--

CREATE TABLE `lugares` (
  `id` int(11) NOT NULL,
  `nombre` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `lugares`
--

INSERT INTO `lugares` (`id`, `nombre`) VALUES
(1, 'Pantano de San Juan'),
(3, 'Grao de Castellón'),
(5, 'Bahía de Cádiz'),
(7, 'Embalse de La Jarosa'),
(9, 'Puerto de Valencia'),
(11, 'Puerto Deportivo de Gijón'),
(13, 'Puerto Deportivo Marina Rubicón'),
(15, 'Marina del Sur'),
(17, 'Puerto Deportivo de Águilas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medida_tiempo`
--

CREATE TABLE `medida_tiempo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `medida_tiempo`
--

INSERT INTO `medida_tiempo` (`id`, `nombre`) VALUES
(1, 'horas'),
(3, 'dias'),
(5, 'semanas'),
(7, 'meses');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id`, `nombre`) VALUES
(5, 'Avanzado'),
(1, 'Básico'),
(7, 'Experto'),
(3, 'Intermedio'),
(9, 'Maestro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'admin'),
(2, 'usuario'),
(5, 'sólo lectura');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(64) DEFAULT NULL,
  `password` varchar(128) NOT NULL,
  `nombre` varchar(64) NOT NULL,
  `apellidos` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `rol_id` int(11) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_ultimo_ingreso` datetime DEFAULT NULL,
  `token_contraseña` varchar(64) DEFAULT NULL,
  `instructor` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `password`, `nombre`, `apellidos`, `email`, `telefono`, `rol_id`, `fecha_creacion`, `fecha_ultimo_ingreso`, `token_contraseña`, `instructor`) VALUES
(3, 'usuario', '$2y$10$AbaZozWL10/OfKS.vWp04usmskg/fZw2hxsSTrneAojJjs.esAVLO', 'David', 'Herrero Estévez', 'david@herrero.us', '650310344', 1, '2024-04-01 22:48:44', '2024-05-06 18:40:36', NULL, 0),
(5, 'pepito', '$2y$10$Q7wNcMzQevBpL/4sBji4P.LLPtti.WEkx8iBLnDrAELiG1HLHnN4a', 'Pepito', 'Grillo Grillez', 'davidesi@gmail.com', NULL, 2, '2024-04-24 21:21:00', NULL, NULL, 0),
(7, 'pepitogrillo', '$2y$10$meZSI9D2kcl61.EUhAZDa.MffjwkSpgDryIL.3XE4W1JYcep7vVyS', 'Pepito', 'Grillox Grillossa', 'davidesi@hotmail.com', 'aa', 2, '2024-04-24 21:25:45', NULL, NULL, 0),
(9, 'grumete', '$2y$10$6UiEUWkcLiXGF3Ntbe4mZuqVt8d0S.vZsHqiHbww3m9asRhzuNUKO', 'David', 'Herrero Estévez', 'david@herrero.us', '650310344', 2, '2024-05-05 22:37:06', '2024-05-05 22:37:26', NULL, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_cursos`
--

CREATE TABLE `usuarios_cursos` (
  `id_usuario_curso` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_calendario` int(11) DEFAULT NULL,
  `confirmado` tinyint(1) NOT NULL DEFAULT 0,
  `pagado` tinyint(1) NOT NULL DEFAULT 0,
  `precio` double NOT NULL DEFAULT 0,
  `descuento` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Volcado de datos para la tabla `usuarios_cursos`
--

INSERT INTO `usuarios_cursos` (`id_usuario_curso`, `id_usuario`, `id_calendario`, `confirmado`, `pagado`, `precio`, `descuento`) VALUES
(1, 3, 19, 0, 0, 0, 0),
(3, 3, 19, 1, 1, 0, 0),
(5, 3, 5, 0, 0, 0, 0),
(7, 3, 3, 0, 0, 0, 0),
(9, 3, 17, 0, 1, 0, 0),
(11, 3, 21, 1, 0, 0, 0),
(13, 3, 23, 0, 0, 0, 0),
(15, 9, 23, 1, 1, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curso` (`curso_id`),
  ADD KEY `id_instructor` (`id_instructor`),
  ADD KEY `fk_createdby` (`createdby`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id_calificacion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_habilidad` (`id_habilidad`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ubicacion` (`lugar_id`),
  ADD KEY `tiempo` (`medida_tiempo`);

--
-- Indices de la tabla `fotosCursos`
--
ALTER TABLE `fotosCursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curso` (`id_curso`);

--
-- Indices de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`id_habilidad`);

--
-- Indices de la tabla `instructores`
--
ALTER TABLE `instructores`
  ADD PRIMARY KEY (`id_instructor`);

--
-- Indices de la tabla `lugares`
--
ALTER TABLE `lugares`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `medida_tiempo`
--
ALTER TABLE `medida_tiempo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nivel` (`nombre`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `rol` (`rol_id`);

--
-- Indices de la tabla `usuarios_cursos`
--
ALTER TABLE `usuarios_cursos`
  ADD PRIMARY KEY (`id_usuario_curso`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_calendario` (`id_calendario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `calendario`
--
ALTER TABLE `calendario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id_calificacion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `fotosCursos`
--
ALTER TABLE `fotosCursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `id_habilidad` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `instructores`
--
ALTER TABLE `instructores`
  MODIFY `id_instructor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `lugares`
--
ALTER TABLE `lugares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `medida_tiempo`
--
ALTER TABLE `medida_tiempo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios_cursos`
--
ALTER TABLE `usuarios_cursos`
  MODIFY `id_usuario_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `calendario`
--
ALTER TABLE `calendario`
  ADD CONSTRAINT `calendario_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `calendario_ibfk_3` FOREIGN KEY (`id_instructor`) REFERENCES `instructores` (`id_instructor`),
  ADD CONSTRAINT `fk_createdby` FOREIGN KEY (`createdby`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `calificaciones_ibfk_2` FOREIGN KEY (`id_habilidad`) REFERENCES `habilidades` (`id_habilidad`);

--
-- Filtros para la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `comentarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`lugar_id`) REFERENCES `lugares` (`id`),
  ADD CONSTRAINT `cursos_ibfk_2` FOREIGN KEY (`medida_tiempo`) REFERENCES `medida_tiempo` (`id`);

--
-- Filtros para la tabla `fotosCursos`
--
ALTER TABLE `fotosCursos`
  ADD CONSTRAINT `fotosCursos_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`rol_id`) REFERENCES `roles` (`id`);

--
-- Filtros para la tabla `usuarios_cursos`
--
ALTER TABLE `usuarios_cursos`
  ADD CONSTRAINT `usuarios_cursos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `usuarios_cursos_ibfk_3` FOREIGN KEY (`id_calendario`) REFERENCES `calendario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
