-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2025 at 07:16 AM
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
-- Database: `project1`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_email`, `item_id`, `quantity`, `created_at`) VALUES
(12, 'kanzariyarahul2005@gmail.com', 9, 1, '2025-04-27 14:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(4, 'kanzariya rahul', 'kanzariyarahul31@gmail.com', 'very good website....', '2025-03-22 08:47:11'),
(5, 'RAHUL kanzariya', 'kanzariyarahul2005@gmail.com', 'wow very creative site ... ', '2025-03-22 08:48:21'),
(6, 'kanzariya rahul', 'kanzariyarahul31@gmail.com', 'hello very good and responsive web site. thank you.....', '2025-04-08 11:29:15'),
(7, 'RAHUL kanzariya', 'rkanzariya861@rku.ac.in', 'hello this is very good web site...... ', '2025-04-09 03:02:36'),
(8, 'Nihar paresha', 'kanzariyarahul31@gmail.com', 'this is best site for cloths ... ', '2025-04-09 03:40:49'),
(9, 'ajay vaghela', 'ajaysinh.vaghela@rku.ac.in', 'not good website plese improve\r\n\r\n', '2025-04-09 07:49:50');

-- --------------------------------------------------------

--
-- Table structure for table `edituser`
--

CREATE TABLE `edituser` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_pic` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edituser`
--

INSERT INTO `edituser` (`id`, `name`, `email`, `gender`, `phone_no`, `address`, `created_at`, `profile_pic`) VALUES
(1, 'kanzariya rahul', 'kanzariyarahul2005@gmail.com', 'Male', '9712155571', 'vajepar street number 3 morbi 363641', '2025-03-22 08:40:11', '1744807470_67ffa62e7bfe1.jpg'),
(4, 'Rahul', 'rkanzariya861@rku.ac.in', 'Male', '9712155571', 'Rajkot RK University', '2025-03-29 05:02:19', 'default.png'),
(6, 'Hardik parekh', 'hardikparekh7426@gmail.com', 'Male', '1234567890', 'Rajkot', '2025-04-08 07:52:20', '1744098740_67f4d5b4b3864.jpg'),
(8, 'kanzariya rahul', 'kanzariyarahul31@gmail.com', 'Male', '8128240416', 'vajepar street number 3 morbi 363641', '2025-04-09 03:01:51', '1744167711_67f5e31f6e6b1.jpg'),
(9, 'Nihar paresha', 'niharparecha@gmail.com', 'Male', '1234567890', 'vajepar street number 3 morbi 363641', '2025-04-09 03:08:24', '1744168104_67f5e4a8226c4.jpg'),
(10, 'ajay vaghela', 'ajaysinh.vaghela@rku.ac.in', 'Male', '9712155571', 'vajepar street number 3 morbi 363641', '2025-04-09 07:48:53', '1744184933_67f6266560830.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_email`, `item_id`) VALUES
(14, 'kanzariyarahul2005@gmail.com', 8),
(12, 'kanzariyarahul2005@gmail.com', 21),
(13, 'kanzariyarahul2005@gmail.com', 34),
(8, 'kanzariyarahul31@gmail.com', 27);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `price`, `image`, `category`) VALUES
(8, 'New marriage shout ', 'very good design for men ', 999.00, 'photo/items/m3.jpg', 'Men'),
(9, 'new yellow dress for girls', 'very good design ', 699.00, 'photo/items/w3.jpg', 'Women'),
(11, 'beautiful dress ', 'very good design', 999.00, 'photo/items/w2.jpg', 'Women'),
(13, 'New Kurta ', 'very good design for men', 499.00, 'photo/items/m14.jpg', 'Men'),
(20, 'new dress', 'new', 500.00, 'photo/items/w6.jpg', 'Women'),
(21, 'choli for girls', 'very beautiful choli ', 1999.00, 'photo/items/w5.jpg', 'Women'),
(22, 'new dress for girls', 'very good dress', 999.00, 'photo/items/w9.jpg', 'Women'),
(24, 'new  shout', 'new design for men', 999.00, 'photo/items/m7.jpg', 'Men'),
(34, 'New marrage shout', 'for girls ', 4999.00, 'photo/items/w7.jpg', 'Women'),
(35, 'Rajvadi T shirt ', 'this T shirt is best for men....', 899.00, 'photo/items/m12.jpg', 'Men'),
(36, 'Sharewani for men', 'best design for men ', 1499.00, 'photo/items/m13.jpg', 'Men'),
(37, 'Saadi for girls ', 'new design and best color combo 😍', 999.00, 'photo/items/w4.jpg', 'Women');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `items` text NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `email`, `items`, `total_price`, `order_date`) VALUES
(1, '0', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":999},{\"name\":\"beautiful dress \",\"quantity\":1,\"price\":999}]', 1998.00, '2025-03-22 07:12:31'),
(2, '0', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":999}]', 999.00, '2025-03-22 07:13:48'),
(3, '0', '[{\"name\":\"beautiful dress \",\"quantity\":1,\"price\":999}]', 999.00, '2025-03-22 07:14:02'),
(4, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":199},{\"name\":\"new dress\",\"quantity\":1,\"price\":600}]', 799.00, '2025-03-22 07:21:09'),
(5, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":199}]', 199.00, '2025-03-22 07:38:19'),
(6, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":999}]', 999.00, '2025-03-22 08:45:26'),
(7, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":199},{\"name\":\"choli for girls\",\"quantity\":1,\"price\":1999}]', 2198.00, '2025-03-24 05:03:20'),
(8, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new dress\",\"quantity\":1,\"price\":199},{\"name\":\"beautiful dress \",\"quantity\":1,\"price\":999}]', 1198.00, '2025-03-24 05:36:37'),
(9, 'rkanzariya861@rku.ac.in', '[{\"name\":\"beautiful dress \",\"quantity\":1,\"price\":999}]', 999.00, '2025-03-25 04:35:17'),
(10, 'apandit@gmail.com', '[{\"name\":\"beautiful dress \",\"quantity\":1,\"price\":999},{\"name\":\"new yellow dress for girls\",\"quantity\":1,\"price\":699}]', 1698.00, '2025-03-25 04:57:57'),
(11, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"choli for girls\",\"quantity\":1,\"price\":1999},{\"name\":\"New marriage shout\",\"quantity\":1,\"price\":999}]', 2998.00, '2025-03-28 03:05:57'),
(12, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new yellow dress for girls\",\"quantity\":1,\"price\":699},{\"name\":\"New Kurta \",\"quantity\":1,\"price\":499}]', 1198.00, '2025-04-01 13:35:06'),
(13, 'kanzariyarahul2005@gmail.com', '[{\"name\":\"new  shout\",\"quantity\":1,\"price\":999}]', 999.00, '2025-04-07 05:47:15');

-- --------------------------------------------------------

--
-- Table structure for table `pending_users`
--

CREATE TABLE `pending_users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `otp` varchar(6) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pending_users`
--

INSERT INTO `pending_users` (`id`, `name`, `email`, `password`, `otp`, `created_at`) VALUES
(11, 'Nihar paresha', 'apandit@gmail.com', '$2y$10$29SChrc/Yk1yWVxMKSvDDOknxOT9MZUOH5xeGkOHOS9239Ip8UKO2', '711077', '2025-04-27 15:13:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `create_at`) VALUES
(2, 'kanzariya rahul', 'kanzariyarahul2005@gmail.com', '$2y$10$Q7tbrkE9SsnOOxWc7HT.zuM2bpclxSYfOqzlO7gecrIsRF/pID2my', '2025-03-19 12:33:37'),
(4, 'kanzariya rahul', 'rkanzariya861@rku.ac.in', '$2y$10$SMXLPEzThU5qtvEX2SyH0eDDqA9i4fgjlKg/A6gcd3xEAukYZuKIC', '2025-03-20 12:51:20'),
(13, 'Hardik parekh', 'hardikparekh7426@gmail.com', '$2y$10$iQegMtVXgWkC4W0LdcNEye2Em/7JRHVJFnYUgAXoPO0zJyhpbsDCy', '2025-04-08 07:51:45'),
(15, 'RAHUL kanzariya', 'kanzariyarahul31@gmail.com', '$2y$10$DCvBppTTkPh1H/6BVwYLZ.cm6Y0MSwWPgxRp4aWRNUvMLQ85LdKnS', '2025-04-09 03:00:37'),
(16, 'Nihar paresha', 'niharparecha@gmail.com', '$2y$10$EPEKuFVkWIeJIlBhKShrCuuL0SH.06v0qam1sU1sxtW9c/8hkZtte', '2025-04-09 03:07:52'),
(17, 'KANZARIYA RAHUL HARISHBHAI', 'parechanihar@gmail.com', '$2y$10$EC0OFKUNxXtR6I7iow9AjunnnYTvKaYx1QgE.wFL9v/4Ki59hPTdi', '2025-04-09 03:16:13'),
(19, 'ajay vaghela', 'ajaysinh.vaghela@rku.ac.in', '$2y$10$CYexkme2DNEMb3OA6H/ok.9N6Cff4KworIA3Zfs.zZHgsjZq8H5Yi', '2025-04-09 07:47:26'),
(20, 'bansi aghera', 'agherabansi2@gmail.com', '$2y$10$H9pPEfc916lLMClGa7HTSOvnvhUFqOuFpkVUaCVt5i/Nx9/hJZ87i', '2025-04-09 07:58:27'),
(21, 'kanzariya rahul', 'abhijeetparmar707@gmail.com', '$2y$10$KmXrrcCe.ilR0RplxOMcuev.z3NWKMQfuE9clNvYJ/aBzQ.XybrTK', '2025-04-27 12:27:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `edituser`
--
ALTER TABLE `edituser`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_favorite` (`user_email`,`item_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pending_users`
--
ALTER TABLE `pending_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `edituser`
--
ALTER TABLE `edituser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pending_users`
--
ALTER TABLE `pending_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`);

--
-- Constraints for table `edituser`
--
ALTER TABLE `edituser`
  ADD CONSTRAINT `edituser_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
