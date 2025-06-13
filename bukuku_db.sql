-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 10:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bukuku_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `buku_id` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `tanggal_booking` datetime DEFAULT current_timestamp(),
  `batas_waktu_pengambilan` datetime DEFAULT NULL,
  `status` enum('pending','approved','denied') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `buku_id`, `nama_user`, `no_hp`, `tanggal_booking`, `batas_waktu_pengambilan`, `status`) VALUES
(9, 1, 7, 'ramaditya', '087742855057', '2025-06-13 12:12:35', '2025-06-14 12:12:35', 'approved'),
(10, 1, 7, 'ramaditya', '087742855057', '2025-06-13 18:31:00', '2025-06-14 18:31:00', 'denied');

-- --------------------------------------------------------

--
-- Table structure for table `katalog`
--

CREATE TABLE `katalog` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `tentang_buku` text DEFAULT NULL,
  `sinopsis` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `katalog`
--

INSERT INTO `katalog` (`id`, `judul`, `deskripsi`, `gambar`, `genre`, `tentang_buku`, `sinopsis`, `created_at`, `updated_at`) VALUES
(7, 'Petualangan di Hutan Ajaib', 'Buku ini menceritakan kisah seorang anak bernama Raka yang tersesat di hutan ajaib dan bertemu dengan berbagai makhluk mitos. Cocok untuk anak-anak usia 7-12 tahun yang menyukai fantasi dan petualangan.', '1749812295_4ef64bc341fee60a1198.png', NULL, NULL, NULL, '2025-06-13 10:55:12', '2025-06-13 11:03:33'),
(8, 'kocak gaming simulator', 'asda', '1749812128_258e9032729a876b18ef.png', 'saasas', 'saas', 'saas', '2025-06-13 10:55:28', '2025-06-13 19:41:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'rama', 'ramadityaekaprasetyo@gmail.com', '$2y$10$02ANEbUgr2RwGaCfNpRTqunCXOnKU5/jrQb5bv6rmQIcgg1fARcGO', '2025-06-11 03:06:31', '2025-06-11 03:06:31'),
(2, 'admin', 'admin@gmail.com', '$2y$10$u17wd.Tk0qbkriSGbys5guqP2A4/6c1mpiHkxFO6ynZ/Aw5.sA7Oq', '2025-06-11 03:06:31', '2025-06-11 03:06:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_booking_user` (`user_id`),
  ADD KEY `fk_booking_buku` (`buku_id`);

--
-- Indexes for table `katalog`
--
ALTER TABLE `katalog`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `katalog`
--
ALTER TABLE `katalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_buku` FOREIGN KEY (`buku_id`) REFERENCES `katalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
