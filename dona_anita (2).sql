-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 04-03-2022 a las 05:24:01
-- Versión del servidor: 8.0.27
-- Versión de PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dona_anita`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `id_product` int NOT NULL,
  `name_product` varchar(40) NOT NULL,
  `description_product` varchar(50) NOT NULL,
  `mark_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int NOT NULL,
  `cost_product` int NOT NULL,
  `code_product` int NOT NULL,
  `productExistance` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id_product`, `name_product`, `description_product`, `mark_product`, `unitaryPrice_product`, `cost_product`, `code_product`, `productExistance`) VALUES
(2, 'Zopes', 'Orden de 5 zopes de diferentes guizos', 'Casa', 90, 50, 2, 0),
(4, 'Chilaquiles rojos', 'Chilaquiles rojos con queso y frijoles', 'Casa', 75, 30, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int NOT NULL,
  `date_purchase` date NOT NULL,
  `totalQuantity_purchase` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchasedetail`
--

CREATE TABLE `purchasedetail` (
  `id_purchaseDetail` int NOT NULL,
  `id_product` int NOT NULL,
  `name_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int NOT NULL,
  `cuantity_sellDetail` int NOT NULL,
  `id_purchasell` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sell`
--

CREATE TABLE `sell` (
  `id_sell` int NOT NULL,
  `date_sell` date NOT NULL,
  `totalQuantity_sell` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `selldetail`
--

CREATE TABLE `selldetail` (
  `id_sellDetail` int NOT NULL,
  `id_product` int NOT NULL,
  `name_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int NOT NULL,
  `cuantity_sellDetail` int NOT NULL,
  `id_sell` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `name_user` varchar(30) DEFAULT NULL,
  `lname_user` varchar(30) DEFAULT NULL,
  `phone_user` varchar(10) DEFAULT NULL,
  `email_user` varchar(40) DEFAULT NULL,
  `pass_user` varchar(20) DEFAULT NULL,
  `userType` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `lname_user`, `phone_user`, `email_user`, `pass_user`, `userType`) VALUES
(1, 'Adrian', 'Cavazos', '8115681580', 'cavazos_adrian@hotmail.com', 'adrian01', 1),
(5, 'Julio Adrian', 'Cavazos', '8116882007', 'adrian@outlook.com', 'adrian123', 3);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indices de la tabla `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id_purchase`);

--
-- Indices de la tabla `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD PRIMARY KEY (`id_purchaseDetail`),
  ADD KEY `cuantity_sellDetail` (`cuantity_sellDetail`);

--
-- Indices de la tabla `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id_sell`);

--
-- Indices de la tabla `selldetail`
--
ALTER TABLE `selldetail`
  ADD PRIMARY KEY (`id_sellDetail`),
  ADD KEY `cuantity_sellDetail` (`cuantity_sellDetail`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id_purchase` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `purchasedetail`
--
ALTER TABLE `purchasedetail`
  MODIFY `id_purchaseDetail` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `sell`
--
ALTER TABLE `sell`
  MODIFY `id_sell` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `selldetail`
--
ALTER TABLE `selldetail`
  MODIFY `id_sellDetail` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD CONSTRAINT `purchasedetail_ibfk_1` FOREIGN KEY (`cuantity_sellDetail`) REFERENCES `purchase` (`id_purchase`);

--
-- Filtros para la tabla `sell`
--
ALTER TABLE `sell`
  ADD CONSTRAINT `sell_ibfk_1` FOREIGN KEY (`id_sell`) REFERENCES `selldetail` (`cuantity_sellDetail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
