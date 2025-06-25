-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 09, 2025 at 07:15 AM
-- Server version: 8.0.30
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_keluar`
--

CREATE TABLE `barang_keluar` (
  `id_barang_keluar` int NOT NULL,
  `id_penjualan` int DEFAULT NULL,
  `id_return` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_sub_kategori` int DEFAULT NULL,
  `id_gudang` int DEFAULT NULL,
  `harga_awal` int DEFAULT NULL,
  `harga_jual` int DEFAULT NULL,
  `status` enum('penjualan','return') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang_keluar`
--

INSERT INTO `barang_keluar` (`id_barang_keluar`, `id_penjualan`, `id_return`, `id_kategori`, `id_sub_kategori`, `id_gudang`, `harga_awal`, `harga_jual`, `status`) VALUES
(13, 2, NULL, 1, 7, 1, 28000, 50000, 'penjualan'),
(14, 2, NULL, 1, 7, 1, 28000, 50000, 'penjualan'),
(15, 2, NULL, 1, 7, 1, 28000, 50000, 'penjualan'),
(16, 2, NULL, 1, 7, 1, 28000, 50000, 'penjualan'),
(17, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(18, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(19, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(20, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(21, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(22, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(23, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(24, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(25, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(26, 2, NULL, 1, 7, 4, 32000, 50000, 'penjualan'),
(27, NULL, 2, 2, 9, 2, 12000, 25000, 'return'),
(28, NULL, 2, 2, 9, 2, 12000, 25000, 'return'),
(29, NULL, 2, 2, 9, 2, 12000, 25000, 'return'),
(30, NULL, 2, 2, 9, 2, 12000, 25000, 'return'),
(31, NULL, 2, 1, 7, 1, 28000, 50000, 'return'),
(32, NULL, 2, 1, 7, 1, 28000, 50000, 'return'),
(33, NULL, 2, 1, 7, 1, 28000, 50000, 'return'),
(34, NULL, 2, 1, 7, 1, 28000, 50000, 'return'),
(35, NULL, 2, 1, 7, 1, 28000, 50000, 'return');

-- --------------------------------------------------------

--
-- Table structure for table `barang_masuk`
--

CREATE TABLE `barang_masuk` (
  `id_barang_masuk` int NOT NULL,
  `id_pembelian` int DEFAULT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_sub_kategori` int DEFAULT NULL,
  `id_gudang` int DEFAULT NULL,
  `harga_awal` int DEFAULT NULL,
  `harga_jual` int DEFAULT NULL,
  `status` enum('masuk','keluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'masuk'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `barang_masuk`
--

INSERT INTO `barang_masuk` (`id_barang_masuk`, `id_pembelian`, `id_kategori`, `id_sub_kategori`, `id_gudang`, `harga_awal`, `harga_jual`, `status`) VALUES
(10, 11, 2, 9, 2, 12000, 25000, 'keluar'),
(11, 11, 2, 9, 2, 12000, 25000, 'keluar'),
(12, 11, 2, 9, 2, 12000, 25000, 'keluar'),
(13, 11, 2, 9, 2, 12000, 25000, 'keluar'),
(14, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(15, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(16, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(17, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(18, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(19, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(20, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(21, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(22, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(23, 12, 1, 7, 4, 32000, 50000, 'keluar'),
(24, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(25, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(26, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(27, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(28, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(29, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(30, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(31, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(32, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(33, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(34, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(35, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(36, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(37, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(38, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(39, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(40, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(41, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(42, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(43, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(44, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(45, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(46, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(47, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(48, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(49, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(50, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(51, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(52, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(53, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(54, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(55, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(56, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(57, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(58, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(59, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(60, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(61, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(62, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(63, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(64, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(65, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(66, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(67, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(68, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(69, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(70, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(71, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(72, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(73, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(74, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(75, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(76, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(77, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(78, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(79, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(80, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(81, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(82, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(83, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(84, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(85, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(86, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(87, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(88, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(89, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(90, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(91, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(92, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(93, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(94, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(95, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(96, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(97, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(98, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(99, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(100, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(101, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(102, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(103, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(104, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(105, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(106, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(107, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(108, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(109, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(110, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(111, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(112, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(113, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(114, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(115, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(116, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(117, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(118, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(119, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(120, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(121, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(122, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(123, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(124, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(125, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(126, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(127, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(128, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(129, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(130, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(131, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(132, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(133, 12, 1, 7, 4, 32000, NULL, 'masuk'),
(134, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(135, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(136, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(137, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(138, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(139, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(140, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(141, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(142, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(143, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(144, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(145, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(146, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(147, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(148, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(149, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(150, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(151, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(152, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(153, 13, 1, 7, 4, 45000, NULL, 'masuk'),
(154, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(155, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(156, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(157, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(158, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(159, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(160, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(161, 14, 1, 7, 1, 28000, 50000, 'keluar'),
(162, 14, 1, 7, 1, 28000, 50000, 'keluar');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id_gudang` int NOT NULL,
  `nama_gudang` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id_gudang`, `nama_gudang`) VALUES
(1, 'Gudang A'),
(2, 'Gudang B'),
(3, 'Gudang C'),
(4, 'Gudang D');

-- --------------------------------------------------------

--
-- Table structure for table `harga_jual`
--

CREATE TABLE `harga_jual` (
  `id_harga_jual` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `id_sub_kategori` int DEFAULT NULL,
  `harga_jual` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `harga_jual`
--

INSERT INTO `harga_jual` (`id_harga_jual`, `id_kategori`, `id_sub_kategori`, `harga_jual`) VALUES
(1, 1, 7, 50000),
(2, 2, 9, 25000);

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Rokok'),
(2, 'Sabun');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int NOT NULL,
  `desc` text,
  `harga` int DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `file_code` varchar(255) DEFAULT NULL,
  `tgl_buat` timestamp NULL DEFAULT NULL,
  `tgl_beli` date DEFAULT NULL,
  `total_harga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `desc`, `harga`, `stok`, `id_user`, `file_code`, `tgl_buat`, `tgl_beli`, `total_harga`) VALUES
(11, 'adsadsad', 12000, 4, 1, '58e01a1998ca3d8e163308a342aa703f.jpg,79435e847ffd1daa2e3185df13b152f7.jpg', '2025-05-30 23:35:45', '2025-05-19', 48000),
(12, 'tes', 32000, 120, 1, NULL, '2025-05-30 23:37:12', '2025-05-12', 3840000),
(13, 'tes', 45000, 20, 1, NULL, '2025-05-30 23:38:17', '2025-05-19', 900000),
(14, 'hhh', 28000, 9, 1, NULL, '2025-05-31 04:48:37', '2025-05-13', 252000);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int NOT NULL,
  `desc` text,
  `id_user` int DEFAULT NULL,
  `file_code` varchar(255) DEFAULT NULL,
  `tgl_jual` date DEFAULT NULL,
  `total_stok` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `desc`, `id_user`, `file_code`, `tgl_jual`, `total_stok`, `total_harga`) VALUES
(2, 'asdasd', 1, NULL, '2025-06-02', 14, 700000);

-- --------------------------------------------------------

--
-- Table structure for table `return`
--

CREATE TABLE `return` (
  `id_return` int NOT NULL,
  `desc` text,
  `id_user` int DEFAULT NULL,
  `file_code` varchar(255) DEFAULT NULL,
  `tgl_return` date DEFAULT NULL,
  `total_stok` int DEFAULT NULL,
  `total_harga` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return`
--

INSERT INTO `return` (`id_return`, `desc`, `id_user`, `file_code`, `tgl_return`, `total_stok`, `total_harga`) VALUES
(2, 'desck', 1, NULL, '1970-01-01', 9, 350000);

-- --------------------------------------------------------

--
-- Table structure for table `sub_kategori`
--

CREATE TABLE `sub_kategori` (
  `id_sub_kategori` int NOT NULL,
  `id_kategori` int DEFAULT NULL,
  `sub_kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sub_kategori`
--

INSERT INTO `sub_kategori` (`id_sub_kategori`, `id_kategori`, `sub_kategori`) VALUES
(1, 1, 'SURYA 12'),
(3, 1, 'SAMPOERNA AGA'),
(4, 1, 'DJI SAM SOE REFIL'),
(5, 1, 'SAMPOERNA MILD'),
(6, 1, 'DUNHILL PUTIH'),
(7, 1, 'MARLBORO MERAH'),
(8, 2, 'PASTA GIGI PEPSODENT'),
(9, 2, 'PASTA GIGI CLOSE UP'),
(10, 2, 'PASTA GIGI CIPTADENT ALL VARIAN');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama_user` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','kasir') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama_user`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', '$2y$10$RuNMZvp5gi3.Yc.U2D040eyjCLctZP3rHhQqZfH2YtjZLrsMj.Ioy', 'admin'),
(2, 'kasir', 'kasir', '$2y$10$RuNMZvp5gi3.Yc.U2D040eyjCLctZP3rHhQqZfH2YtjZLrsMj.Ioy', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  ADD PRIMARY KEY (`id_barang_keluar`) USING BTREE,
  ADD KEY `id_penjualan` (`id_penjualan`);

--
-- Indexes for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  ADD PRIMARY KEY (`id_barang_masuk`) USING BTREE,
  ADD KEY `id_pembelian` (`id_pembelian`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id_gudang`);

--
-- Indexes for table `harga_jual`
--
ALTER TABLE `harga_jual`
  ADD PRIMARY KEY (`id_harga_jual`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`) USING BTREE;

--
-- Indexes for table `return`
--
ALTER TABLE `return`
  ADD PRIMARY KEY (`id_return`) USING BTREE;

--
-- Indexes for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  ADD PRIMARY KEY (`id_sub_kategori`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang_keluar`
--
ALTER TABLE `barang_keluar`
  MODIFY `id_barang_keluar` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `barang_masuk`
--
ALTER TABLE `barang_masuk`
  MODIFY `id_barang_masuk` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=163;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id_gudang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `harga_jual`
--
ALTER TABLE `harga_jual`
  MODIFY `id_harga_jual` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `return`
--
ALTER TABLE `return`
  MODIFY `id_return` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sub_kategori`
--
ALTER TABLE `sub_kategori`
  MODIFY `id_sub_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
