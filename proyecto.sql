-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-01-2024 a las 12:32:09
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `ID` int(11) NOT NULL,
  `ISBN` varchar(255) DEFAULT NULL,
  `Titulo` varchar(255) DEFAULT NULL,
  `Autor` varchar(255) DEFAULT NULL,
  `Editorial` varchar(255) DEFAULT NULL,
  `URL` varchar(255) DEFAULT NULL,
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`ID`, `ISBN`, `Titulo`, `Autor`, `Editorial`, `URL`, `Activo`) VALUES
(1, '9780451524935', '1984', 'George Orwell', 'Secker and Warburg', '1984.jpg', 1),
(2, '9780140328696', 'To Kill a Mockingbird', 'Harper Lee', 'J. B. Lippincott & Co.', 'To_Kill_a_Mockingbird.jpg', 1),
(3, '9780679410327', 'One Hundred Years of Solitude', 'Gabriel Garcia Marquez', 'Harper & Row', 'One_Hundred_Years_of_Solitude.jpg', 1),
(4, '9780521866032', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Cambridge University Press', 'The_Great_Gatsby.jpg', 1),
(5, '9780061120084', 'Brave New World', 'Aldous Huxley', 'Harper & Brothers', 'Brave_New_World.jpg', 1),
(6, '9780062315007', 'The Catcher in the Rye', 'J.D. Salinger', 'Little, Brown and Company', 'The_Catcher_in_the_Rye.jpg', 1),
(7, '9780141983769', 'Pride and Prejudice', 'Jane Austen', 'Penguin Books', 'pride-and-prejudice.jpg', 1),
(8, '9780553212587', 'Moby-Dick', 'Herman Melville', 'Bantam Books', 'moby-dick.jpg', 1),
(9, '9781400033423', 'The Brothers Karamazov', 'Fyodor Dostoevsky', 'Vintage Classics', 'The_Brothers_Karamazov.jpg', 1),
(10, '9780743273565', 'War and Peace', 'Leo Tolstoy', 'Scribner', 'War_And_Peace.jpg', 1),
(11, '9780140449334', 'Frankenstein', 'Mary Shelley', 'Penguin Classics', 'Frankestein.jpg', 1),
(12, '9780553213690', 'Anna Karenina', 'Leo Tolstoy', 'Bantam Classics', 'Anna_Karenina.jpg', 1),
(13, '9780199535569', 'Crime and Punishment', 'Fyodor Dostoevsky', 'Oxford University Press', 'crime-and-punishment.jpg', 1),
(14, '9780199539277', 'Wuthering Heights', 'Emily Bronte', 'Oxford University Press', 'Wuthering_Heights.jpg', 1),
(15, '9780486280615', 'The Picture of Dorian Gray', 'Oscar Wilde', 'Dover Publications', 'The_Picture.jpg', 1),
(16, '9780393967941', 'The Odyssey', 'Homer', 'W. W. Norton & Company', 'the-odyssey.jpg', 1),
(17, '9780451527745', 'Lord of the Flies', 'William Golding', 'Penguin Books', 'Lord_Of_The_Files.jpg', 1),
(18, '9780141439769', 'Dracula', 'Bram Stoker', 'Penguin Classics', 'Dracula.jpg', 1),
(19, '9780061124952', 'Heart of Darkness', 'Joseph Conrad', 'Harper Perennial', 'Hearth_of_Darkness.jpg', 1),
(20, '9780060935467', 'The Grapes of Wrath', 'John Steinbeck', 'Harper Perennial', 'The_Grapes_of_Wrath.jpg', 1),
(21, '9780099518471', 'The Trial', 'Franz Kafka', 'Vintage Classics', 'The_Trial.jpg', 1),
(48, '9780743273210', 'La Odisea', 'Homero', 'Anaya', '1984.jpg', 1),
(49, '9780234567890', 'EjemploLibro', 'Admin Admin', 'Anaya', 'portadaGenerica.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamo`
--

CREATE TABLE `prestamo` (
  `ID` int(11) NOT NULL,
  `ID_Usuario` int(11) DEFAULT NULL,
  `ID_Libro` int(11) DEFAULT NULL,
  `Inicio_Prestamo` datetime DEFAULT NULL,
  `Fin_Prestamo` datetime DEFAULT NULL,
  `ReservaActiva` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamo`
--

INSERT INTO `prestamo` (`ID`, `ID_Usuario`, `ID_Libro`, `Inicio_Prestamo`, `Fin_Prestamo`, `ReservaActiva`) VALUES
(17, 18, 1, '2023-11-13 10:10:34', '2023-11-20 17:50:00', 0),
(18, 18, 16, '2023-11-13 10:10:43', '2023-11-20 17:50:02', 0),
(19, 24, 2, '2023-11-14 13:16:43', '2023-11-20 08:50:27', 0),
(20, 18, 1, '2023-11-20 17:50:07', '2023-12-20 17:50:07', 1),
(21, 18, 2, '2023-11-20 17:50:18', '2023-12-20 17:50:18', 1),
(22, 25, 20, '2023-11-20 18:01:34', '2023-11-20 18:02:10', 0),
(23, 25, 3, '2023-11-20 18:01:36', '2023-11-20 18:02:10', 0),
(24, 25, 6, '2023-11-20 18:01:38', '2023-11-20 18:02:10', 0),
(25, 25, 5, '2023-11-20 18:01:40', '2023-11-20 18:02:10', 0),
(26, 25, 19, '2023-11-20 18:01:42', '2023-11-20 18:02:10', 0),
(27, 25, 7, '2023-11-20 18:01:45', '2023-11-20 18:02:10', 0),
(28, 26, 3, '2023-11-24 14:27:17', '2023-12-24 14:27:17', 1),
(29, 28, 18, '2023-12-09 17:33:24', '2024-01-08 17:33:24', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Apellido` varchar(255) DEFAULT NULL,
  `Apellido2` varchar(255) DEFAULT NULL,
  `Nombre_Usuario` varchar(255) DEFAULT NULL,
  `Contrasenia` varchar(255) DEFAULT NULL,
  `Correo_Electronico` varchar(255) DEFAULT NULL,
  `Rol` enum('ADMIN','LECTOR') DEFAULT 'LECTOR',
  `Activo` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Nombre`, `Apellido`, `Apellido2`, `Nombre_Usuario`, `Contrasenia`, `Correo_Electronico`, `Rol`, `Activo`) VALUES
(18, 'Gonzalo', 'Amo', 'Cano', 'Gonzalo', '$2y$10$wHmjv0G.iqmSLyzGGG/6tOvre4sN05Z6lVxLUrbQiDrgyf68l8La.', 'gonzalo@gmail.com', 'LECTOR', 1),
(21, 'Admin', NULL, NULL, 'Admin', '$2y$10$miAFPiYwYhlY5aIRUOApMuGHEwgY87wMdQTxCYuXVwE29/bD6cj.2', NULL, 'ADMIN', 1),
(24, 'Usuario', 'Usuario', 'Usuario', 'Usuario', '$2y$10$QlxB6OHGWpzrjlZ4JAPr1ep14GlYPIQK5.l6ZV43TEBPMAENE6UXG', 'usuario@gmail.com', 'LECTOR', 0),
(25, 'Irene', 'Cano', 'Gonzalez', 'Irene', '$2y$10$WVXbNUCJSQ.PQ./yXTBSFOa.LRVrwUmnXE/U1vXQy72UCE5qYGFPq', 'irene@gmail.com', 'LECTOR', 0),
(26, 'Pruebas', 'Pruebas Apellido', 'Pruebas SegundoApellido', 'Pruebas1', '$2y$10$UFu6QHbbMA5mOkVKptVYtupKRLxYLRWZUR5VzYyXHMkwWaHvBZRxG', 'pruebas@gmail.com', 'LECTOR', 1),
(27, 'Adriana', 'Rojas', 'Cano', 'Adriana', '$2y$10$voZjPjVVVspeP0Y457bwe.OSolEAUNtAF7FG.OjXOiw/xLY0B1Qni', 'adriana@gmail.com', 'LECTOR', 0),
(28, 'Adriana', 'Rojas', 'Cano', 'Adri', '$2y$10$SCOqJGao2WHpx6ta2QF.qeAu0zqy7YTOXoa3eAoXjkdv8BtahQwfm', 'adri@gmail.com', 'LECTOR', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `ISBN` (`ISBN`);

--
-- Indices de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Usuario` (`ID_Usuario`),
  ADD KEY `ID_Libro` (`ID_Libro`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Nombre_Usuario` (`Nombre_Usuario`),
  ADD UNIQUE KEY `Correo_Electronico` (`Correo_Electronico`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT de la tabla `prestamo`
--
ALTER TABLE `prestamo`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `prestamo`
--
ALTER TABLE `prestamo`
  ADD CONSTRAINT `Prestamo_ibfk_1` FOREIGN KEY (`ID_Usuario`) REFERENCES `usuarios` (`ID`),
  ADD CONSTRAINT `Prestamo_ibfk_2` FOREIGN KEY (`ID_Libro`) REFERENCES `libros` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
