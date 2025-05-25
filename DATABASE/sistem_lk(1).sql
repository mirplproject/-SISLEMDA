-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2025 at 07:42 AM
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
-- Database: `sistem_lk`
--

-- --------------------------------------------------------

--
-- Table structure for table `history_surat`
--

CREATE TABLE `history_surat` (
  `id` int(11) NOT NULL,
  `surat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(100) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history_surat`
--

INSERT INTO `history_surat` (`id`, `surat_id`, `user_id`, `action`, `keterangan`, `created_at`) VALUES
(1, 1, 2, 'created', 'Surat dibuat sebagai draft', '2025-05-17 04:38:37'),
(2, 2, 2, 'submitted', 'Surat diajukan ke kaprodi', '2025-05-17 04:38:37'),
(3, 2, 4, 'approved', 'Surat disetujui oleh dekan', '2025-05-18 06:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrator sistem', '2025-05-17 04:38:05', '2025-05-17 04:38:05'),
(2, 'dosen', 'Dosen biasa', '2025-05-17 04:38:05', '2025-05-17 04:38:05'),
(3, 'kaprodi', 'Ketua Program Studi', '2025-05-17 04:38:05', '2025-05-17 04:38:05'),
(4, 'dekan', 'Dekan Fakultas', '2025-05-17 04:38:05', '2025-05-17 04:38:05'),
(5, 'warek1', 'Wakil Rektor I', '2025-05-17 04:38:05', '2025-05-17 04:38:05'),
(6, 'warek2', 'Wakil Rektor II', '2025-05-17 04:38:05', '2025-05-17 04:38:05'),
(7, 'rektor', 'Rektor Universitas', '2025-05-17 04:38:05', '2025-05-17 04:38:05');

-- --------------------------------------------------------

--
-- Table structure for table `struktur_jabatan`
--

CREATE TABLE `struktur_jabatan` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `parent_role_id` int(11) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `struktur_jabatan`
--

INSERT INTO `struktur_jabatan` (`id`, `role_id`, `parent_role_id`, `level`, `created_at`, `updated_at`) VALUES
(1, 7, NULL, 1, '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(2, 5, 7, 2, '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(3, 6, 7, 2, '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(4, 4, 5, 3, '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(5, 3, 4, 4, '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(6, 2, 3, 5, '2025-05-17 04:38:37', '2025-05-17 04:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `surat_lk`
--

CREATE TABLE `surat_lk` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nomor_surat` varchar(50) DEFAULT NULL,
  `judul_surat` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('draft','submitted','approved','rejected','completed') DEFAULT 'draft',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surat_lk`
--

INSERT INTO `surat_lk` (`id`, `user_id`, `nomor_surat`, `judul_surat`, `deskripsi`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'LK/2025/001', 'Pengajuan Seminar', 'Pengajuan seminar nasional', 'draft', '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(2, 2, 'LK/2025/002', 'Laporan Penelitian', 'Laporan hasil penelitian', 'submitted', '2025-05-17 04:38:37', '2025-05-17 04:38:37');

-- --------------------------------------------------------

--
-- Table structure for table `tracking_surat`
--

CREATE TABLE `tracking_surat` (
  `id` int(11) NOT NULL,
  `surat_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tracking_surat`
--

INSERT INTO `tracking_surat` (`id`, `surat_id`, `role_id`, `status`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 3, 'pending', 'Menunggu persetujuan kaprodi', '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(2, 2, 4, 'approved', 'Disetujui oleh dekan', '2025-05-17 04:38:37', '2025-05-18 06:07:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nip` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `name`, `nip`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@lk.ac.id', '0192023a7bbd73250516f069df18b500', 'Administrator', NULL, '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(2, 'dosen1', 'dosen1@lk.ac.id', 'd5bbfb47ac3160c31fa8c247827115aa', 'Dosen Ahmad', '1234567890', '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(3, 'kaprodi1', 'kaprodi1@lk.ac.id', '893ae99da3890c7b7730b9dd39ce51df', 'Kaprodi Budi', '0987654321', '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(4, 'dekan1', 'dekan1@lk.ac.id', '5318ed7beac30ead69703502bb80b56c', 'Dekan Siti', '1122334455', '2025-05-17 04:38:37', '2025-05-17 04:38:37'),
(5, 'nabil', 'nabildeja0@gmail.com', 'eb96f4b33c211219dc8a7e2db9d7b448', 'Admin nabil', '', '2025-05-17 06:24:23', '2025-05-17 06:35:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `user_id`, `role_id`, `created_at`) VALUES
(1, 1, 1, '2025-05-17 04:38:37'),
(2, 2, 2, '2025-05-17 04:38:37'),
(3, 3, 3, '2025-05-17 04:38:37'),
(4, 4, 4, '2025-05-17 04:38:37'),
(6, 5, 1, '2025-05-17 06:24:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history_surat`
--
ALTER TABLE `history_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_id` (`surat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `struktur_jabatan`
--
ALTER TABLE `struktur_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `parent_role_id` (`parent_role_id`);

--
-- Indexes for table `surat_lk`
--
ALTER TABLE `surat_lk`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor_surat` (`nomor_surat`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tracking_surat`
--
ALTER TABLE `tracking_surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `surat_id` (`surat_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nip` (`nip`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history_surat`
--
ALTER TABLE `history_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `struktur_jabatan`
--
ALTER TABLE `struktur_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `surat_lk`
--
ALTER TABLE `surat_lk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tracking_surat`
--
ALTER TABLE `tracking_surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history_surat`
--
ALTER TABLE `history_surat`
  ADD CONSTRAINT `history_surat_ibfk_1` FOREIGN KEY (`surat_id`) REFERENCES `surat_lk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `history_surat_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `struktur_jabatan`
--
ALTER TABLE `struktur_jabatan`
  ADD CONSTRAINT `struktur_jabatan_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `struktur_jabatan_ibfk_2` FOREIGN KEY (`parent_role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `surat_lk`
--
ALTER TABLE `surat_lk`
  ADD CONSTRAINT `surat_lk_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracking_surat`
--
ALTER TABLE `tracking_surat`
  ADD CONSTRAINT `tracking_surat_ibfk_1` FOREIGN KEY (`surat_id`) REFERENCES `surat_lk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tracking_surat_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `user_roles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_roles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
