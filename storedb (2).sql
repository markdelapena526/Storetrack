-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2024 at 12:34 AM
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
-- Database: `storedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE `counter` (
  `counter_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `date_expired`
--

CREATE TABLE `date_expired` (
  `expired_id` int(11) NOT NULL,
  `expiry` date NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `date_expired`
--

INSERT INTO `date_expired` (`expired_id`, `expiry`, `product_id`) VALUES
(23, '2025-01-15', 31),
(24, '2025-03-03', 32),
(25, '2024-12-15', 33),
(26, '2024-12-11', 34),
(27, '2025-01-22', 35),
(28, '2024-12-31', 36),
(29, '2025-01-15', 37),
(30, '2025-01-29', 38),
(31, '2025-02-09', 39),
(32, '2025-01-16', 40),
(33, '2025-01-29', 41),
(34, '2024-12-30', 42),
(35, '2024-12-26', 43);

-- --------------------------------------------------------

--
-- Table structure for table `image_product`
--

CREATE TABLE `image_product` (
  `image_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image_product`
--

INSERT INTO `image_product` (`image_id`, `image_path`, `product_id`) VALUES
(24, 'kohaku.png', 31),
(25, 'mega.png', 32),
(26, 'Onion.png', 33),
(27, 'Bawang.png', 34),
(28, 'quickchow.png', 35),
(29, 'Atsal.png', 36),
(30, 'beer.png', 37),
(31, 'egg.png', 38),
(32, 'Suka.png', 39),
(33, 'Tuyo.png', 40),
(34, 'cocacola.png', 41),
(35, 'magic_sarap.png', 42),
(36, 'p55gvrdt.png', 43);

-- --------------------------------------------------------

--
-- Table structure for table `product_name`
--

CREATE TABLE `product_name` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `cost_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_name`
--

INSERT INTO `product_name` (`product_id`, `product_name`, `cost_price`) VALUES
(31, 'Kohako', 50),
(32, 'Mega Sardines', 20),
(33, 'Onion', 180),
(34, 'garlic', 150),
(35, 'quickchow', 12),
(36, 'Atsal', 200),
(37, 'Beer', 160),
(38, 'Egg', 12),
(39, 'Suka', 100),
(40, 'Tuyo', 12),
(41, 'Cocacola', 40),
(42, 'Magic Sarap', 4),
(43, 'Cocacola', 40);

-- --------------------------------------------------------

--
-- Table structure for table `product_sold`
--

CREATE TABLE `product_sold` (
  `sold_id` int(11) NOT NULL,
  `sold_quantity` int(11) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `time` varchar(255) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_sold`
--

INSERT INTO `product_sold` (`sold_id`, `sold_quantity`, `weight`, `date`, `time`, `total_price`, `product_id`) VALUES
(49, 1, '50', '2024-12-14', '11:04:09', 60.00, 31),
(50, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(51, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(52, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(53, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(54, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(55, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(56, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(57, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(58, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(59, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(60, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(61, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(62, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(63, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(64, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(65, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(66, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(67, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(68, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(69, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(70, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(71, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(72, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(73, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(74, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(75, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(76, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(77, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(78, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(79, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(80, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(81, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(82, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(83, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(84, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(85, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(86, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(87, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(88, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(89, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(90, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(91, 1, '50', '2024-12-14', '11:05:32', 60.00, 31),
(113, 1, '2', '2024-12-14', '11:09:10', 15.00, 38);

-- --------------------------------------------------------

--
-- Table structure for table `quantity_cost`
--

CREATE TABLE `quantity_cost` (
  `quantity_cost_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quantity_cost`
--

INSERT INTO `quantity_cost` (`quantity_cost_id`, `quantity`, `product_id`) VALUES
(15, '50', 31),
(16, '200', 32),
(17, '1', 33),
(18, '1', 34),
(19, '56', 35),
(20, '1', 36),
(21, '50', 37),
(22, '500', 38),
(23, '100', 39),
(24, '200', 40),
(25, '50', 41),
(26, '2050', 42),
(27, '500', 43);

-- --------------------------------------------------------

--
-- Table structure for table `quantity_tbl`
--

CREATE TABLE `quantity_tbl` (
  `quantity_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quantity_tbl`
--

INSERT INTO `quantity_tbl` (`quantity_id`, `quantity`, `product_id`) VALUES
(31, 45, 31),
(32, 200, 32),
(33, 1, 33),
(34, 1, 34),
(35, 56, 35),
(36, 1, 36),
(37, 49, 37),
(38, 499, 38),
(39, 99, 39),
(40, 200, 40),
(41, 50, 41),
(42, 2050, 42),
(43, 500, 43);

-- --------------------------------------------------------

--
-- Table structure for table `selling_price`
--

CREATE TABLE `selling_price` (
  `selling_price_id` int(11) NOT NULL,
  `selling_price` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `selling_price`
--

INSERT INTO `selling_price` (`selling_price_id`, `selling_price`, `product_id`) VALUES
(31, 60, 31),
(32, 30, 32),
(33, 200, 33),
(34, 170, 34),
(35, 18, 35),
(36, 250, 36),
(37, 200, 37),
(38, 15, 38),
(39, 160, 39),
(40, 14, 40),
(41, 50, 41),
(42, 5, 42),
(43, 50, 43);

-- --------------------------------------------------------

--
-- Table structure for table `size_tbl`
--

CREATE TABLE `size_tbl` (
  `size_id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size_tbl`
--

INSERT INTO `size_tbl` (`size_id`, `size`, `product_id`) VALUES
(13, 'small', 32),
(14, 'small', 35),
(15, 'small', 37),
(16, 'small', 38),
(17, 'Big', 39),
(18, 'small', 40),
(19, '1litre', 41),
(20, 'small', 42),
(21, 'Big', 43);

-- --------------------------------------------------------

--
-- Table structure for table `weight_cost`
--

CREATE TABLE `weight_cost` (
  `weight_cost_id` int(11) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `total_weight` decimal(10,2) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weight_cost`
--

INSERT INTO `weight_cost` (`weight_cost_id`, `weight`, `total_weight`, `product_id`) VALUES
(12, '50', 2500.00, 31),
(13, '10', 10.00, 33),
(14, '15', 15.00, 34),
(15, '20', 20.00, 36);

-- --------------------------------------------------------

--
-- Table structure for table `weight_tbl`
--

CREATE TABLE `weight_tbl` (
  `weight_id` int(11) NOT NULL,
  `weight` varchar(255) NOT NULL,
  `total_weight` decimal(10,2) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weight_tbl`
--

INSERT INTO `weight_tbl` (`weight_id`, `weight`, `total_weight`, `product_id`) VALUES
(23, '50', 2347.00, 31),
(24, '10', 10.00, 33),
(25, '15', 15.00, 34),
(26, '20', 20.00, 36);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counter`
--
ALTER TABLE `counter`
  ADD PRIMARY KEY (`counter_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `date_expired`
--
ALTER TABLE `date_expired`
  ADD PRIMARY KEY (`expired_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `image_product`
--
ALTER TABLE `image_product`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_name`
--
ALTER TABLE `product_name`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `product_sold`
--
ALTER TABLE `product_sold`
  ADD PRIMARY KEY (`sold_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `quantity_cost`
--
ALTER TABLE `quantity_cost`
  ADD PRIMARY KEY (`quantity_cost_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `quantity_tbl`
--
ALTER TABLE `quantity_tbl`
  ADD PRIMARY KEY (`quantity_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `selling_price`
--
ALTER TABLE `selling_price`
  ADD PRIMARY KEY (`selling_price_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `size_tbl`
--
ALTER TABLE `size_tbl`
  ADD PRIMARY KEY (`size_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `weight_cost`
--
ALTER TABLE `weight_cost`
  ADD PRIMARY KEY (`weight_cost_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `weight_tbl`
--
ALTER TABLE `weight_tbl`
  ADD PRIMARY KEY (`weight_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `counter`
--
ALTER TABLE `counter`
  MODIFY `counter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=209;

--
-- AUTO_INCREMENT for table `date_expired`
--
ALTER TABLE `date_expired`
  MODIFY `expired_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `image_product`
--
ALTER TABLE `image_product`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `product_name`
--
ALTER TABLE `product_name`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `product_sold`
--
ALTER TABLE `product_sold`
  MODIFY `sold_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `quantity_cost`
--
ALTER TABLE `quantity_cost`
  MODIFY `quantity_cost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `quantity_tbl`
--
ALTER TABLE `quantity_tbl`
  MODIFY `quantity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `selling_price`
--
ALTER TABLE `selling_price`
  MODIFY `selling_price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `size_tbl`
--
ALTER TABLE `size_tbl`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `weight_cost`
--
ALTER TABLE `weight_cost`
  MODIFY `weight_cost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `weight_tbl`
--
ALTER TABLE `weight_tbl`
  MODIFY `weight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `counter`
--
ALTER TABLE `counter`
  ADD CONSTRAINT `counter_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `date_expired`
--
ALTER TABLE `date_expired`
  ADD CONSTRAINT `date_expired_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `image_product`
--
ALTER TABLE `image_product`
  ADD CONSTRAINT `image_product_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `product_sold`
--
ALTER TABLE `product_sold`
  ADD CONSTRAINT `product_sold_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `quantity_cost`
--
ALTER TABLE `quantity_cost`
  ADD CONSTRAINT `quantity_cost_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `quantity_tbl`
--
ALTER TABLE `quantity_tbl`
  ADD CONSTRAINT `quantity_tbl_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `selling_price`
--
ALTER TABLE `selling_price`
  ADD CONSTRAINT `selling_price_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `size_tbl`
--
ALTER TABLE `size_tbl`
  ADD CONSTRAINT `size_tbl_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `weight_cost`
--
ALTER TABLE `weight_cost`
  ADD CONSTRAINT `weight_cost_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);

--
-- Constraints for table `weight_tbl`
--
ALTER TABLE `weight_tbl`
  ADD CONSTRAINT `weight_tbl_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_name` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
