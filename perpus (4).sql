-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2025 at 01:29 PM
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
-- Database: `perpus`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_admin` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_admin`) VALUES
(1, 'admin', '123', 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `penulis`, `penerbit`, `tahun`, `stok`) VALUES
(1, 'Algoritma dan Pemrograman Dasar', 'Rinaldi Munir', 'Informatika Bandung', 2018, 5),
(2, 'Struktur Data dan Algoritma', 'Abdul Kadir', 'Andi Offset', 2019, 4),
(3, 'Basis Data', 'Fathansyah', 'Informatika Bandung', 2015, 6),
(4, 'Sistem Informasi Manajemen', 'Gordon B. Davis', 'McGraw-Hill', 2013, 3),
(5, 'Rekayasa Perangkat Lunak', 'Roger S. Pressman', 'McGraw-Hill', 2014, 5),
(6, 'Pemrograman Web dengan PHP & MySQL', 'Budi Raharjo', 'Informatika Bandung', 2020, 7),
(7, 'Jaringan Komputer', 'Andrew S. Tanenbaum', 'Pearson Education', 2011, 4),
(8, 'Analisis dan Perancangan Sistem', 'Jogiyanto H.M', 'Andi Offset', 2017, 6),
(9, 'Kecerdasan Buatan', 'Stuart Russell', 'Pearson Education', 2016, 3),
(10, 'Interaksi Manusia dan Komputer', 'Alan Dix', 'Pearson Education', 2014, 5),
(11, 'Pengantar Teknologi Informasi', 'Turban & Volonino', 'Wiley', 2015, 3),
(12, 'Statistika untuk Penelitian', 'Sugiyono', 'Alfabeta', 2018, 6),
(13, 'Matematika Diskrit', 'Kenneth H. Rosen', 'McGraw-Hill', 2012, 5),
(14, 'Manajemen Proyek TI', 'Kathy Schwalbe', 'Cengage Learning', 2014, 3),
(15, 'Keamanan Sistem Informasi', 'William Stallings', 'Pearson Education', 2017, 4);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_pinjam` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','kembali') DEFAULT 'dipinjam',
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_pinjam`, `id_user`, `id_buku`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `denda`) VALUES
(1, 1, 14, '2025-12-16', '2025-12-17', 'kembali', 0),
(2, 1, 11, '2025-12-16', '2025-12-17', 'kembali', 0),
(3, 1, 11, '2025-12-16', '2025-12-17', 'kembali', 0),
(4, 1, 11, '2025-12-16', '2025-12-17', 'kembali', 0),
(5, 1, 11, '2025-12-16', NULL, 'dipinjam', 0),
(6, 1, 14, '2025-12-17', '2025-12-17', 'kembali', 0),
(7, 1, 15, '2025-12-17', '2025-12-17', 'kembali', 0),
(8, 2, 9, '2025-12-18', '2025-12-18', 'kembali', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nim`, `nama`, `jurusan`, `username`, `password`, `role`) VALUES
(1, '2405', 'Ba', 'TRPL', 'yu', '$2y$10$GXfL827e2iJvyWCJCSTMeuzFjFvIJ0yh6utH68dsqxxQkyQYQMAGa', 'user'),
(2, '2405181021', 'Nazwa Yumna Zharifah', 'TRPL', 'Nazwa06', '$2y$10$9QJNO4v1F4OVJ5aBv901juAPH57tEhHAko7psF9.XCZvsL5IjrKtq', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_pinjam`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_pinjam` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
