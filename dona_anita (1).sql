-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 02-03-2022 a las 05:54:50
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
  `weight_product` varchar(30) NOT NULL,
  `mark_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int NOT NULL,
  `cost_product` int NOT NULL,
  `code_product` int NOT NULL,
  `id_productExistance` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`id_product`, `name_product`, `description_product`, `weight_product`, `mark_product`, `unitaryPrice_product`, `cost_product`, `code_product`, `id_productExistance`) VALUES
(1, 'Enchiladas', 'Enchiladas rojas con cebolla y papas doradas', 'Doscientos gramos', 'Casa', 35, 80, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productexistance`
--

CREATE TABLE `productexistance` (
  `id_productExistance` int NOT NULL,
  `name_productExistance` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productexistance`
--

INSERT INTO `productexistance` (`id_productExistance`, `name_productExistance`) VALUES
(1, 'En existencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int NOT NULL,
  `date_purchase` date NOT NULL,
  `totalQuantity_purchase` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sell`
--

CREATE TABLE `sell` (
  `id_sell` int NOT NULL,
  `date_sell` date NOT NULL,
  `totalQuantity_sell` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `id_userType` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `lname_user`, `phone_user`, `email_user`, `pass_user`, `id_userType`) VALUES
(1, 'Adrian', 'Cavazos', '8115681580', 'cavazos_adrian@hotmail.com', 'adrian01', 5),
(2, NULL, NULL, NULL, 'cesar_abc@outlook.com', 'Cesar01', 5),
(3, NULL, NULL, NULL, 'pablo@outlook.com', 'pablo01', 6),
(4, NULL, NULL, NULL, 'ricardo@outlook.com', 'ricardo01', 7),
(5, 'Julio Adrian', 'Cavazos', '8116882007', 'adrian@outlook.com', 'adrian123', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usertype`
--

CREATE TABLE `usertype` (
  `id_userType` int NOT NULL,
  `name_userType` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usertype`
--

INSERT INTO `usertype` (`id_userType`, `name_userType`) VALUES
(5, 'Administrador'),
(6, 'Mesero'),
(7, 'Contador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `id_productExistance` (`id_productExistance`);

--
-- Indices de la tabla `productexistance`
--
ALTER TABLE `productexistance`
  ADD PRIMARY KEY (`id_productExistance`);

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
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_userType` (`id_userType`);

--
-- Indices de la tabla `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`id_userType`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productexistance`
--
ALTER TABLE `productexistance`
  MODIFY `id_productExistance` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT de la tabla `usertype`
--
ALTER TABLE `usertype`
  MODIFY `id_userType` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `productexistance`
--
ALTER TABLE `productexistance`
  ADD CONSTRAINT `productexistance_ibfk_1` FOREIGN KEY (`id_productExistance`) REFERENCES `product` (`id_productExistance`);

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

--
-- Filtros para la tabla `usertype`
--
ALTER TABLE `usertype`
  ADD CONSTRAINT `usertype_ibfk_1` FOREIGN KEY (`id_userType`) REFERENCES `user` (`id_userType`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
