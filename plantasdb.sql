-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-10-2021 a las 13:29:36
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `plantasdb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

CREATE TABLE `cities` (
  `cityID` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `city_state` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `collaborators`
--

CREATE TABLE `collaborators` (
  `collaboratorID` int(11) NOT NULL,
  `col_customerID` int(11) NOT NULL,
  `col_join_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `courses`
--

CREATE TABLE `courses` (
  `courseID` int(11) NOT NULL,
  `course_productID` int(11) NOT NULL,
  `course_name` varchar(100) NOT NULL,
  `course_teacher` varchar(200) NOT NULL,
  `course_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `cus_name` varchar(100) NOT NULL,
  `cus_lastname` varchar(100) NOT NULL,
  `cus_age` smallint(6) NOT NULL,
  `cus_cityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_assistants`
--

CREATE TABLE `event_assistants` (
  `assistantID` int(11) NOT NULL,
  `assis_name` varchar(100) NOT NULL,
  `assis_lastname` varchar(100) NOT NULL,
  `assis_age` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_attendance`
--

CREATE TABLE `event_attendance` (
  `EA_assitantID` int(11) NOT NULL,
  `EA_eventID` int(11) NOT NULL,
  `EA_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_record`
--

CREATE TABLE `event_record` (
  `eventID` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `event_date` date DEFAULT NULL,
  `event_typeID` int(11) NOT NULL,
  `event_attendace` int(11) NOT NULL,
  `event_cityID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `event_type`
--

CREATE TABLE `event_type` (
  `eventTypeID` int(11) NOT NULL,
  `event_type_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `greenhouses`
--

CREATE TABLE `greenhouses` (
  `greenhousesID` int(11) NOT NULL,
  `gh_cityID` int(11) NOT NULL,
  `gh_realease_date` date DEFAULT NULL,
  `gh_capacity` int(11) NOT NULL,
  `gh_is_own` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lotes`
--

CREATE TABLE `lotes` (
  `loteID` int(11) NOT NULL,
  `lote_realease_date` date DEFAULT NULL,
  `lote_capacity` int(11) NOT NULL,
  `lote_greenhouseID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_customerID` int(11) NOT NULL,
  `order_productID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `plants_inv`
--

CREATE TABLE `plants_inv` (
  `plantID` int(11) NOT NULL,
  `plant_productID` int(11) NOT NULL,
  `plant_weight` int(11) NOT NULL,
  `plant_specie` varchar(100) NOT NULL,
  `plant_loteID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `prod_name` varchar(100) NOT NULL,
  `prod_typeID` int(11) NOT NULL,
  `prod_raelease_date` date DEFAULT NULL,
  `prod_is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_type`
--

CREATE TABLE `product_type` (
  `product_typeID` int(11) NOT NULL,
  `prod_type_name` varchar(100) NOT NULL,
  `prod_type_release_name` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `todos_juntos`
--

CREATE TABLE `todos_juntos` (
  `todos_juntos_recordID` int(11) NOT NULL,
  `td_collaboratorID` int(11) NOT NULL,
  `td_loteID` int(11) NOT NULL,
  `td_delivery_date` date DEFAULT NULL,
  `td_recovery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `Id` int(11) NOT NULL,
  `Tipo` int(11) DEFAULT NULL,
  `Nombre` varchar(30) DEFAULT NULL,
  `ApellidoP` varchar(30) DEFAULT NULL,
  `ApellidoM` varchar(30) DEFAULT NULL,
  `Contrasena` text DEFAULT NULL,
  `Salt` text DEFAULT NULL,
  `Estatus` int(11) DEFAULT NULL,
  `Usuario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`Id`, `Tipo`, `Nombre`, `ApellidoP`, `ApellidoM`, `Contrasena`, `Salt`, `Estatus`, `Usuario`) VALUES
(1, 1, 'Salma Odalys', 'Solana', 'Velasco', '2304c586fedcb6622cbcf39e3fc72847260263bcacc561cbc7b9ea5a699c3b47', 'fc76e52c2c591e4256caeac416044d6b2ea1e39b04eda435a8a0163d473a87e5', 1, 'salma.admin@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`cityID`);

--
-- Indices de la tabla `collaborators`
--
ALTER TABLE `collaborators`
  ADD PRIMARY KEY (`collaboratorID`),
  ADD KEY `FK_CUSTOMER_TO_COLLABORATOR` (`col_customerID`);

--
-- Indices de la tabla `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`courseID`),
  ADD KEY `FK_PRODUCT_ID_COURSES` (`course_productID`);

--
-- Indices de la tabla `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`),
  ADD KEY `FK_CUSTOMER_CITY` (`cus_cityID`);

--
-- Indices de la tabla `event_assistants`
--
ALTER TABLE `event_assistants`
  ADD PRIMARY KEY (`assistantID`);

--
-- Indices de la tabla `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD KEY `FK_EVENT_ASSISTANCE` (`EA_assitantID`),
  ADD KEY `FK_EVENT_ID` (`EA_eventID`);

--
-- Indices de la tabla `event_record`
--
ALTER TABLE `event_record`
  ADD PRIMARY KEY (`eventID`),
  ADD KEY `FK_EVENT_TYPE` (`event_typeID`);

--
-- Indices de la tabla `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`eventTypeID`);

--
-- Indices de la tabla `greenhouses`
--
ALTER TABLE `greenhouses`
  ADD PRIMARY KEY (`greenhousesID`),
  ADD KEY `FK_GREENHOUSE_CITY` (`gh_cityID`);

--
-- Indices de la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD PRIMARY KEY (`loteID`),
  ADD KEY `FK_LOTE_GREENHOUSE` (`lote_greenhouseID`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `FK_CUSTOMER_ORDERS` (`order_customerID`),
  ADD KEY `FK_PRODUCT_ORDERS` (`order_productID`);

--
-- Indices de la tabla `plants_inv`
--
ALTER TABLE `plants_inv`
  ADD PRIMARY KEY (`plantID`),
  ADD KEY `FK_PRODUCT_ID_PLANTS` (`plant_productID`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `FK_PRODUCT_TYPE` (`prod_typeID`);

--
-- Indices de la tabla `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`product_typeID`);

--
-- Indices de la tabla `todos_juntos`
--
ALTER TABLE `todos_juntos`
  ADD PRIMARY KEY (`todos_juntos_recordID`),
  ADD KEY `FK_COLLABORATOR_PROGRAM` (`td_collaboratorID`),
  ADD KEY `FK_LOTE_PROGRAM` (`td_loteID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `usuario` (`Usuario`) USING HASH,
  ADD UNIQUE KEY `Usuario_2` (`Usuario`) USING HASH,
  ADD UNIQUE KEY `Usuario_3` (`Usuario`) USING HASH;

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `collaborators`
--
ALTER TABLE `collaborators`
  ADD CONSTRAINT `FK_CUSTOMER_TO_COLLABORATOR` FOREIGN KEY (`col_customerID`) REFERENCES `customers` (`customerID`);

--
-- Filtros para la tabla `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_PRODUCT_ID_COURSES` FOREIGN KEY (`course_productID`) REFERENCES `products` (`productID`);

--
-- Filtros para la tabla `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `FK_CUSTOMER_CITY` FOREIGN KEY (`cus_cityID`) REFERENCES `cities` (`cityID`);

--
-- Filtros para la tabla `event_attendance`
--
ALTER TABLE `event_attendance`
  ADD CONSTRAINT `FK_EVENT_ASSISTANCE` FOREIGN KEY (`EA_assitantID`) REFERENCES `event_assistants` (`assistantID`),
  ADD CONSTRAINT `FK_EVENT_ID` FOREIGN KEY (`EA_eventID`) REFERENCES `event_record` (`eventID`);

--
-- Filtros para la tabla `event_record`
--
ALTER TABLE `event_record`
  ADD CONSTRAINT `FK_EVENT_TYPE` FOREIGN KEY (`event_typeID`) REFERENCES `event_type` (`eventTypeID`);

--
-- Filtros para la tabla `greenhouses`
--
ALTER TABLE `greenhouses`
  ADD CONSTRAINT `FK_GREENHOUSE_CITY` FOREIGN KEY (`gh_cityID`) REFERENCES `cities` (`cityID`);

--
-- Filtros para la tabla `lotes`
--
ALTER TABLE `lotes`
  ADD CONSTRAINT `FK_LOTE_GREENHOUSE` FOREIGN KEY (`lote_greenhouseID`) REFERENCES `greenhouses` (`greenhousesID`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK_CUSTOMER_ORDERS` FOREIGN KEY (`order_customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `FK_PRODUCT_ORDERS` FOREIGN KEY (`order_productID`) REFERENCES `products` (`productID`);

--
-- Filtros para la tabla `plants_inv`
--
ALTER TABLE `plants_inv`
  ADD CONSTRAINT `FK_PRODUCT_ID_PLANTS` FOREIGN KEY (`plant_productID`) REFERENCES `products` (`productID`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_PRODUCT_TYPE` FOREIGN KEY (`prod_typeID`) REFERENCES `product_type` (`product_typeID`);

--
-- Filtros para la tabla `todos_juntos`
--
ALTER TABLE `todos_juntos`
  ADD CONSTRAINT `FK_COLLABORATOR_PROGRAM` FOREIGN KEY (`td_collaboratorID`) REFERENCES `collaborators` (`collaboratorID`),
  ADD CONSTRAINT `FK_LOTE_PROGRAM` FOREIGN KEY (`td_loteID`) REFERENCES `lotes` (`loteID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
