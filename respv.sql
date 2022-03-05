-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 05, 2022 at 02:18 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `respv`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `name_product` varchar(40) NOT NULL,
  `description_product` varchar(50) NOT NULL,
  `mark_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int(11) NOT NULL,
  `cost_product` int(11) NOT NULL,
  `code_product` int(11) NOT NULL,
  `productExistance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id_product`, `name_product`, `description_product`, `mark_product`, `unitaryPrice_product`, `cost_product`, `code_product`, `productExistance`) VALUES
(2, 'Zopes', 'Orden de 5 zopes de diferentes guizos', 'Casa', 90, 50, 2, 0),
(4, 'Chilaquiles rojos', 'Chilaquiles rojos con queso y frijoles', 'Casa', 75, 30, 2, 1),
(5, 'Orden tacos', 'Orden 4 tacos', 'Casa', 100, 30, 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int(11) NOT NULL,
  `date_purchase` date NOT NULL,
  `totalQuantity_purchase` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail`
--

CREATE TABLE `purchasedetail` (
  `id_purchaseDetail` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `name_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int(11) NOT NULL,
  `cuantity_sellDetail` int(11) NOT NULL,
  `id_purchasell` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `id_sell` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `name_product` varchar(30) NOT NULL,
  `unitaryPrice_product` int(11) NOT NULL,
  `quantity_sell` int(11) NOT NULL,
  `timestamp_sell` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`id_sell`, `id_product`, `name_product`, `unitaryPrice_product`, `quantity_sell`, `timestamp_sell`) VALUES
(1, 2, 'Zopes', 90, 1, '2022-03-04 19:07:05');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `name_user` varchar(30) DEFAULT NULL,
  `lname_user` varchar(30) DEFAULT NULL,
  `phone_user` varchar(10) DEFAULT NULL,
  `email_user` varchar(40) DEFAULT NULL,
  `pass_user` varchar(20) DEFAULT NULL,
  `userType` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name_user`, `lname_user`, `phone_user`, `email_user`, `pass_user`, `userType`) VALUES
(1, 'Adrian', 'Cavazos', '8115681580', 'cavazos_adrian@hotmail.com', 'adrian01', 1),
(5, 'Julio Adrian', 'Cavazos', '8116882007', 'adrian@outlook.com', 'adrian123', 3),
(6, 'Juan', 'Perez', '12345678', 'juan@mesero.com', 'juan', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id_purchase`);

--
-- Indexes for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD PRIMARY KEY (`id_purchaseDetail`),
  ADD KEY `cuantity_sellDetail` (`cuantity_sellDetail`);

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id_sell`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id_purchase` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  MODIFY `id_purchaseDetail` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `id_sell` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchasedetail`
--
ALTER TABLE `purchasedetail`
  ADD CONSTRAINT `purchasedetail_ibfk_1` FOREIGN KEY (`cuantity_sellDetail`) REFERENCES `purchase` (`id_purchase`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
