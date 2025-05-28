-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2025 at 07:59 AM
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
-- Database: `sislemda`
--

-- --------------------------------------------------------

--
-- Table structure for table `dekan`
--

CREATE TABLE `dekan` (
  `id_dekan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_fakultas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dekan`
--

INSERT INTO `dekan` (`id_dekan`, `id_user`, `id_fakultas`) VALUES
(3, 12, 2);

-- --------------------------------------------------------

--
-- Table structure for table `disposisi`
--

CREATE TABLE `disposisi` (
  `id_disposisi` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `dari_user_id` int(11) NOT NULL,
  `ke_user_id` int(11) NOT NULL,
  `urutan` int(11) NOT NULL,
  `tanggal_disposisi` date NOT NULL,
  `catatan` text NOT NULL,
  `status_disposisi` enum('ditolk','direvisi','disetujui') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `id_user`, `id_prodi`) VALUES
(1, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `fakultas`
--

CREATE TABLE `fakultas` (
  `id_fakultas` int(11) NOT NULL,
  `nama_fakultas` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fakultas`
--

INSERT INTO `fakultas` (`id_fakultas`, `nama_fakultas`) VALUES
(1, 'Fakultas Ekonomi'),
(2, 'Fakultas Teknik');

-- --------------------------------------------------------

--
-- Table structure for table `kaprodi`
--

CREATE TABLE `kaprodi` (
  `id_kaprodi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_prodi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kaprodi`
--

INSERT INTO `kaprodi` (`id_kaprodi`, `id_user`, `id_prodi`) VALUES
(12, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `klasifikasi_surat`
--

CREATE TABLE `klasifikasi_surat` (
  `id_klasifikasi_surat` int(11) NOT NULL,
  `kode_surat` varchar(10) NOT NULL,
  `nama_surat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klasifikasi_surat`
--

INSERT INTO `klasifikasi_surat` (`id_klasifikasi_surat`, `kode_surat`, `nama_surat`) VALUES
(1, '1.1', 'Produk Hukum'),
(2, '1.2', 'Statuta dan Peraturan lainnya'),
(3, '1.3', 'RPJP, RPJM, Renop dan RKAT institusi'),
(4, '1.4', 'Sistem dan Pedoman Kerja'),
(5, '1.5', 'Akreditasi'),
(6, '1.6', 'Koordinasi'),
(7, '1.7', 'Edaran'),
(8, '1.8', 'Kerjasama'),
(9, '1.9', 'Kurikulum'),
(10, '1.10', 'Laporan'),
(11, '1.11', 'Jaminan Mutu'),
(12, '1.12', 'SDM'),
(13, '1.13', 'Lainnya'),
(14, '2.1', 'Produk Hukum'),
(15, '2.2', 'Statuta dan Peraturan lainnya'),
(16, '2.3', 'RPJP, RPJM, Renop dan RKAT institusi'),
(17, '2.4', 'Sistem dan Pedoman Kerja Akademik'),
(18, '2.5', 'Kerjasama bidang akademik'),
(19, '2.6', 'Kurikulum'),
(20, '2.7', 'Riset & PKM'),
(21, '2.8', 'Edaran'),
(22, '2.9', 'Kerjasama'),
(23, '2.10', 'Lainnya'),
(24, '3.1', 'Produk Hukum'),
(25, '3.2', 'Statuta dan Peraturan lainnya'),
(26, '3.3', 'RPJP, RPJM, dan Renop/RKAT institusi'),
(27, '3.4', 'Sistem dan Pedoman Kerja Akademik'),
(28, '3.5', 'Kerjasama bidang Non akademik'),
(29, '3.6', 'Sarpras'),
(30, '3.7', 'SDM'),
(31, '3.8', 'Keuangan'),
(32, '3.9', 'Edaran'),
(33, '3.10', 'Kerjasama'),
(34, '3.11', 'Lainnya');

-- --------------------------------------------------------

--
-- Table structure for table `lampiran`
--

CREATE TABLE `lampiran` (
  `id_lampiran` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pengajuan` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `status` enum('belum dibaca','sudah dibaca') NOT NULL,
  `waktu_tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan`
--

CREATE TABLE `pengajuan` (
  `id_pengajuan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_klasifikasi_surat` int(11) NOT NULL,
  `no_surat` varchar(20) NOT NULL,
  `perihal` varchar(50) NOT NULL,
  `tanggal_pengajuan` date NOT NULL,
  `status_pengajuan` enum('ditolak','disetujui','kadaluarsa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodi`
--

CREATE TABLE `prodi` (
  `id_prodi` int(11) NOT NULL,
  `nama_prodi` varchar(100) NOT NULL,
  `id_fakultas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prodi`
--

INSERT INTO `prodi` (`id_prodi`, `nama_prodi`, `id_fakultas`) VALUES
(1, 'Program Sarjana Akuntansi', 1),
(2, 'Program Sarjana Manajemen', 1),
(3, 'Program Sarjana Bisnis Digital', 1),
(4, 'Program Sarjana Teknik Informatika', 2),
(5, 'Program Sarjana Sistem Informasi', 2),
(6, 'Program Sarjana Rekayasa Perangkat Lunak', 2),
(7, 'Program Sarjana Desain Komunikasi Visual', 2),
(8, 'Program Diploma Tiga Akuntansi', 1),
(9, 'Program Diploma Tiga Sekretari / Adm. Perkantoran', 1),
(10, 'Program Diploma Tiga Manajemen Administrasi', 1),
(11, 'Program Diploma Tiga Manajemen Informatika', 2);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int(11) NOT NULL,
  `nama_role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `nama_role`) VALUES
(1, 'admin'),
(2, 'dosen'),
(3, 'kaprodi'),
(4, 'dekan'),
(5, 'rektor'),
(6, 'warek1'),
(7, 'warek2'),
(8, 'yayasan'),
(9, 'keuangan'),
(16, 'SDM'),
(17, 'pelayanan_akademik'),
(18, 'komputasi_data'),
(19, 'penelitian_pkm'),
(20, 'publikasi_hki'),
(21, 'inkubator_bisnis'),
(22, 'pendidikan_pelatihan'),
(23, 'pengembangan_karir'),
(24, 'pelayanan'),
(25, 'akuntansi'),
(26, 'pajak'),
(27, 'kerumahtanggaan'),
(28, 'sarpras'),
(29, 'upt_perpustakaan'),
(30, 'lab'),
(31, 'ppks'),
(32, 'data_analyst'),
(33, 'konten_editor'),
(34, 'monitoring_evaluasi'),
(35, 'pelaporan_data'),
(36, 'spme'),
(37, 'bak'),
(38, 'lppm'),
(39, 'kerjasama'),
(40, 'umum'),
(41, 'si_infrastruktur_jaringan'),
(42, 'kemahasiswaan'),
(43, 'marketing_promosi'),
(44, 'bic'),
(45, 'ppm'),
(46, 'warek3');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `inisial` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nik` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nama`, `username`, `password`, `inisial`, `email`, `nik`) VALUES
(1, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'ADM', 'admin@binainsani.ac.id', '1234567890'),
(5, 'Mardi Yudhi Putra, S.T., M.Kom.', 'Mardi', 'e07824324e70bccc0d35498fee0ead05', 'MD', 'MardiYudhi@biu.ac.id', '9887867676'),
(10, 'Muhammad Nabil', 'nabil', 'eb96f4b33c211219dc8a7e2db9d7b448', 'NBL', 'Nabildeja@biu.ac.id', '2023340003'),
(12, 'Rita Wahyuni Arifin, S.Kom., M.Kom.', 'Rita', '5318ed7beac30ead69703502bb80b56c', 'RWA', 'Ritawahyuni@biu.ac.id', '9088978967');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id_user`, `id_role`) VALUES
(1, 1),
(5, 2),
(5, 3),
(10, 1),
(12, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dekan`
--
ALTER TABLE `dekan`
  ADD PRIMARY KEY (`id_dekan`),
  ADD KEY `dekan_user` (`id_user`),
  ADD KEY `dekan_fakultas` (`id_fakultas`);

--
-- Indexes for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD PRIMARY KEY (`id_disposisi`),
  ADD KEY `disposisi_pengajuan` (`id_pengajuan`),
  ADD KEY `fk_dari_user_id` (`dari_user_id`),
  ADD KEY `fk_ke_user_id` (`ke_user_id`);

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD KEY `dosen_user` (`id_user`),
  ADD KEY `dosen_prodi` (`id_prodi`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id_fakultas`);

--
-- Indexes for table `kaprodi`
--
ALTER TABLE `kaprodi`
  ADD PRIMARY KEY (`id_kaprodi`),
  ADD KEY `kaprodi_user` (`id_user`),
  ADD KEY `kaprodi_prodi` (`id_prodi`);

--
-- Indexes for table `klasifikasi_surat`
--
ALTER TABLE `klasifikasi_surat`
  ADD PRIMARY KEY (`id_klasifikasi_surat`),
  ADD UNIQUE KEY `kode_surat` (`kode_surat`);

--
-- Indexes for table `lampiran`
--
ALTER TABLE `lampiran`
  ADD PRIMARY KEY (`id_lampiran`),
  ADD KEY `lampiran_pengajuan` (`id_pengajuan`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `notifikasi_pengajuan` (`id_pengajuan`),
  ADD KEY `notifikasi_user` (`id_user`);

--
-- Indexes for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD PRIMARY KEY (`id_pengajuan`),
  ADD UNIQUE KEY `no_surat` (`no_surat`),
  ADD KEY `user_pengajuan` (`id_user`),
  ADD KEY `klasifikasi_pengajuan` (`id_klasifikasi_surat`);

--
-- Indexes for table `prodi`
--
ALTER TABLE `prodi`
  ADD PRIMARY KEY (`id_prodi`),
  ADD KEY `prodi_fakultas` (`id_fakultas`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `inisial` (`inisial`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD KEY `fk_role` (`id_role`),
  ADD KEY `fk_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dekan`
--
ALTER TABLE `dekan`
  MODIFY `id_dekan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `disposisi`
--
ALTER TABLE `disposisi`
  MODIFY `id_disposisi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id_fakultas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kaprodi`
--
ALTER TABLE `kaprodi`
  MODIFY `id_kaprodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `klasifikasi_surat`
--
ALTER TABLE `klasifikasi_surat`
  MODIFY `id_klasifikasi_surat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `lampiran`
--
ALTER TABLE `lampiran`
  MODIFY `id_lampiran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan`
--
ALTER TABLE `pengajuan`
  MODIFY `id_pengajuan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prodi`
--
ALTER TABLE `prodi`
  MODIFY `id_prodi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dekan`
--
ALTER TABLE `dekan`
  ADD CONSTRAINT `dekan_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dekan_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `disposisi`
--
ALTER TABLE `disposisi`
  ADD CONSTRAINT `disposisi_pengajuan` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id_pengajuan`),
  ADD CONSTRAINT `fk_dari_user_id` FOREIGN KEY (`dari_user_id`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `fk_ke_user_id` FOREIGN KEY (`ke_user_id`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dosen_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kaprodi`
--
ALTER TABLE `kaprodi`
  ADD CONSTRAINT `kaprodi_prodi` FOREIGN KEY (`id_prodi`) REFERENCES `prodi` (`id_prodi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kaprodi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `lampiran`
--
ALTER TABLE `lampiran`
  ADD CONSTRAINT `lampiran_pengajuan` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id_pengajuan`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_pengajuan` FOREIGN KEY (`id_pengajuan`) REFERENCES `pengajuan` (`id_pengajuan`),
  ADD CONSTRAINT `notifikasi_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `pengajuan`
--
ALTER TABLE `pengajuan`
  ADD CONSTRAINT `klasifikasi_pengajuan` FOREIGN KEY (`id_klasifikasi_surat`) REFERENCES `klasifikasi_surat` (`id_klasifikasi_surat`),
  ADD CONSTRAINT `user_pengajuan` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Constraints for table `prodi`
--
ALTER TABLE `prodi`
  ADD CONSTRAINT `prodi_fakultas` FOREIGN KEY (`id_fakultas`) REFERENCES `fakultas` (`id_fakultas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `fk_role` FOREIGN KEY (`id_role`) REFERENCES `role` (`id_role`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
