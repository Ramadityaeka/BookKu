-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2025 at 07:01 PM
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
-- Database: `db_bookku`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
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
(1, 2, 13, 'eka', '087742855057', '2025-06-18 15:10:26', '2025-06-19 15:10:26', 'approved'),
(2, 2, 14, 'eka', '087742855057', '2025-06-19 05:11:31', '2025-06-20 05:11:31', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `nama_event` varchar(255) NOT NULL,
  `deskripsi_event` text NOT NULL,
  `lokasi_event` varchar(255) NOT NULL,
  `tanggal_event` datetime NOT NULL,
  `gambar_event` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `nama_event`, `deskripsi_event`, `lokasi_event`, `tanggal_event`, `gambar_event`, `created_at`, `updated_at`) VALUES
(1, 'literasi bersama', 'Event Literasi Bersama adalah sebuah kegiatan edukatif dan interaktif yang dirancang untuk meningkatkan kesadaran masyarakat tentang pentingnya budaya literasi. Kegiatan ini menggabungkan berbagai bentuk aktivitas literasi, mulai dari bedah buku, talkshow dengan penulis, pelatihan menulis kreatif, hingga bazar buku murah.\r\n\r\nKegiatan ini terbuka untuk umum, khususnya pelajar SD, SMP, SMA, mahasiswa, dan komunitas literasi. Dengan semangat kebersamaan, acara ini juga menjadi ruang apresiasi bagi penulis lokal, penerbit indie, serta komunitas yang berperan dalam gerakan literasi di daerah.\r\n\r\n', 'Jl literasi', '2025-06-27 12:00:00', '1750309503_efc0aecb3974413e5d0f.png', '2025-06-19 05:05:03', '2025-06-19 05:19:52');

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
(12, ' The Lion, the Witch and the Wardrobe', 'Novel klasik anak-anak karya C. S. Lewis yang membuka seri The Chronicles of Narnia. Dipenuhi fantasi, petualangan, serta pesan moral dan religius yang halus.\r\n\r\n', '1749845423_9c058f1567d29a2e724c.png', 'Fiksi', '\r\nPenulis: Rick Riordan\r\nPenerbit: Disney Hyperion (imprint dari Disney Publishing Worldwide), terbit 4 Mei 2010 (hardcover)', 'Empat bersaudara Pevensie (Lucy, Edmund, Susan, dan Peter) mengungsi ke pedesaan selama Perang Dunia II. Lucy menemukan lemari tua yang ternyata pintu ke negeri Narnia, yang diperbudak oleh penyihir putih. Dengan bantuan singa Aslan, mereka memimpin perlawanan untuk membebaskan Narnia dan menyelamatkan musim dingin selamanya', '2025-06-13 20:10:23', '2025-06-13 20:10:23'),
(13, 'The Red Pyramid', 'Buku pertama dari seri The Kane Chronicles oleh Rick Riordan. Dipenuhi aksi, humor, dan mitologi Mesir yang dikemas modern untuk remaja.\r\n\r\n', '1749845512_8dbb1987d14eb1bb945a.png', 'Fiksi', 'Penulis: Rick Riordan\r\n\r\nPenerbit: Disney Hyperion (imprint dari Disney Publishing Worldwide), terbit 4 Mei 2010 (hardcover)', 'Carter dan Sadie Kane, saudara kandung, mengetahui bahwa mereka adalah keturunan firaun dan penyihir Mesir kuno. Setelah ayah mereka memicu kutukan yang membangkitkan dewa-dewa jahat, mereka harus mengejar artefak magis di Amerika dan Mesir untuk menghentikan kekacauan. Perjalanan ini memaksa mereka memahami warisan keluarga dan kekuatan sihir mereka ', '2025-06-13 20:11:52', '2025-06-13 20:11:52'),
(14, 'Fablehaven', 'Karya Brandon Mull yang menceritakan tentang sebuah suaka makhluk ajaib (“fable”) tersembunyi di properti keluarga Sorenson. Cocok untuk pembaca usia 10–14 tahun.\r\n\r\n', '1749845577_80310dd7cb08d5177b9f.png', 'Misteri', 'Penulis: Brandon Mull\r\n\r\nIlustrator: Brandon Dorman', 'Kendra dan Seth Sorenson datang mengunjungi Kakek Sorenson. Mereka segera mengetahui bahwa properti tersebut menyimpan makhluk ajaib dan dijaga oleh sihir. Saat kakek diculik oleh goblin, mereka harus menavigasi bahaya makhluk sihir dan mencegah seorang penyihir jahat melepaskan iblis kuat bernama Bahuma', '2025-06-13 20:12:57', '2025-06-13 20:12:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `no_hp` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `no_hp`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$u17wd.Tk0qbkriSGbys5guqP2A4/6c1mpiHkxFO6ynZ/Aw5.sA7Oq', 'admin', '081234567890', '2025-06-18 17:00:00', '2025-06-18 17:00:00'),
(2, 'eka', '$2y$10$UE54u0vazGsJNDpqXUJb2OUZc.V6lL23vDiTH408N6SdjRhYtJWG6', 'user', '087742855057', '2025-06-18 13:28:05', '2025-06-18 13:28:05'),
(3, 'ramaditya', '$2y$10$XiObKiaq5RO6C9v7nplYa.xVVG6t.mhAvZ0DNrOeangL5XPRqjwSq', 'user', '087742855057', '2025-06-19 15:04:53', '2025-06-19 15:04:53');

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
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `katalog`
--
ALTER TABLE `katalog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `fk_booking_buku` FOREIGN KEY (`buku_id`) REFERENCES `katalog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_booking_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
