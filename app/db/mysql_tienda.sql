-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2024 at 08:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysql_tienda`
--

-- --------------------------------------------------------

--
-- Table structure for table `tienda`
--

CREATE TABLE `tienda` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `tipo` varchar(50) NOT NULL,
  `precio` float UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL,
  `imagen` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tienda`
--

INSERT INTO `tienda` (`id`, `nombre`, `marca`, `tipo`, `precio`, `stock`, `imagen`) VALUES
(1, 'S22', 'Samsung', 'smartphone', 850000, 20, 'ImagenesDeProductos/2024/S22'),
(2, 'S23', 'Samsung', 'smartphone', 1000000, 20, 'ImagenesDeProductos/2024/smartphone-S23.jpeg'),
(3, 'S24', 'Samsung', 'smartphone', 1500000, 18, 'ImagenesDeProductos/2024/smartphone-S24.jpeg'),
(4, 'MotoX', 'Motorola', 'smartphone', 800000, 18, 'ImagenesDeProductos/2024/smartphone-MotoX.jpeg'),
(5, 'Redmi Note 15', 'Xiaomi', 'smartphone', 800000, 5, 'ImagenesDeProductos/2024/smartphone-Redmi Note 15.jpeg'),
(6, 'Redmi Tab', 'Xiaomi', 'tablet', 500000, 30, 'ImagenesDeProductos/2024/tablet-Redmi Tab.jpeg'),
(7, 'Yoga N12', 'Lenovo', 'tablet', 800000, 29, 'ImagenesDeProductos/2024/tablet-Yoga N12.jpeg'),
(8, 'Iphone 10', 'Mac', 'smartphone', 1800000, 30, 'ImagenesDeProductos/2024/smartphone-Iphone 10.jpeg'),
(9, 'I-Pad 9', 'Mac', 'tablet', 1300000, 30, 'ImagenesDeProductos/2024/tablet-I-Pad 9.jpeg'),
(10, 'Tab A 9', 'Samsung', 'tablet', 300000, 30, 'ImagenesDeProductos/2024/tablet-Tab A 9.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE `ventas` (
  `id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `email` varchar(100) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `producto` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL,
  `precio` float UNSIGNED NOT NULL,
  `imagen` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `email`, `nombre_usuario`, `producto`, `cantidad`, `precio`, `imagen`) VALUES
(1, '2024-07-04', 'Leonardo@mail.com', 'Leonardo', 4, 1, 800000, 'ImagenesDeVenta/2024/smartphone-Samsung - S24.candela - jpeg'),
(2, '2024-07-05', 'candela@mail.com', 'Candela', 3, 1, 1500000, 'ImagenesDeVenta/2024/smartphone-Samsung - S24 - candela.jpeg'),
(3, '2024-07-05', 'belen@mail.com', 'Belen', 7, 1, 800000, 'ImagenesDeVenta/2024/tablet-Lenovo-Yoga N12-belen.jpeg'),
(4, '2024-07-05', 'micaela@mail.com', 'Micaela', 5, 1, 800000, 'Error al cargar la foto'),
(5, '2024-07-05', 'Leonardo@mail.com', 'Leonardo', 4, 1, 800000, 'Error al cargar la foto');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tienda`
--
ALTER TABLE `tienda`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
