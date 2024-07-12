-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2024 at 06:24 PM
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
(9, 'I-Pad 9', 'Mac', 'tablet', 1300000, 28, 'ImagenesDeProductos/2024/tablet-I-Pad 9.jpeg'),
(10, 'Tab A 9', 'Samsung', 'tablet', 300000, 30, 'ImagenesDeProductos/2024/tablet-Tab A 9.jpeg'),
(11, 'A50', 'Samsung', 'smartphone', 800000, 30, 'ImagenesDeProductos/2024/smartphone-A50.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `mail` varchar(50) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(250) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `foto` varchar(250) NOT NULL,
  `fecha_de_alta` date NOT NULL,
  `fecha_de_baja` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `mail`, `usuario`, `contrasena`, `perfil`, `foto`, `fecha_de_alta`, `fecha_de_baja`) VALUES
(1, 'candela@mail.com', 'candela', '$2y$10$2rdSxMHpVzcF9gLT8.WEsOlAQYWWaf41SqDxbZTrxMWoYxOuuJAKC', 'admin', 'ImagenesDeUsuarios/2024candela-admin-2024-07-06.jpeg', '2024-07-06', '0000-00-00'),
(2, 'agustin@mail.com', 'agustin', '$2y$10$PHn0kkrhOdfcULmm7CXl3.lXyAmaGKzGlocmU5MBLGPO2atJxYpYa', 'empleado', 'ImagenesDeUsuarios/2024/agustin-empleado-2024-07-06.jpeg', '2024-07-06', '0000-00-00'),
(3, 'alejandro@mail.com', 'alejandro', '$2y$10$NTS2VSSngdFO542HS4Q4Yev3fCkHKN6KKcLOyc3HyTlgc6fIzGfAy', 'admin', 'ImagenesDeUsuarios/2024/alejandro-admin-2024-07-06.jpeg', '2024-07-06', '0000-00-00');

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
(5, '2024-07-05', 'Leonardo@mail.com', 'Leonardo', 4, 1, 800000, 'Error al cargar la foto'),
(6, '2024-07-06', 'agustin@mail.com', 'Agustin', 9, 1, 1300000, 'ImagenesDeVenta/2024/tablet-Mac-I-Pad 9-agustin.jpeg'),
(7, '2024-07-06', 'agustin@mail.com', 'Agustin', 9, 1, 1300000, 'ImagenesDeVenta/2024/tablet-Mac-I-Pad 9-agustin.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tienda`
--
ALTER TABLE `tienda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
