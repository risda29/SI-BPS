-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2024 at 05:10 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek_hjmahni`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama_barang` varchar(20) NOT NULL,
  `harga` varchar(20) NOT NULL,
  `jenis_barang` enum('skincare','obat') NOT NULL,
  `stok` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `username` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `jenis_barang`, `stok`, `tanggal`, `username`) VALUES
(17, 'Bodrex', '10.000', 'obat', '34', '2024-06-11', 'hayatadmin'),
(20, 'Panadol', '20.000', 'obat', '14', '2024-06-11', 'hayatadmin'),
(21, 'toner', '50.000', 'skincare', '44', '2024-06-11', 'hayatkaryawan');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detailT` int(11) NOT NULL,
  `id_transaksi` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah_barang` int(11) NOT NULL,
  `harga_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detailT`, `id_transaksi`, `id_barang`, `jumlah_barang`, `harga_total`) VALUES
(102, 49, 17, 1, 10000),
(103, 50, 17, 2, 20000),
(105, 52, 17, 1, 10000),
(106, 53, 20, 1, 20),
(107, 54, 17, 1, 10000),
(108, 55, 20, 1, 20),
(109, 56, 20, 1, 20),
(110, 57, 20, 1, 20),
(111, 58, 17, 1, 10000),
(112, 59, 20, 1, 20000),
(113, 60, 17, 1, 10);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` enum('admin','karyawan') NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`username`, `password`, `role`, `nama`, `alamat`) VALUES
('hayatadmin', '$2y$10$Vj8dT6jzXZFu85RaW4mEZ.ib.j86pOd16AoKrottkIeQFKi1shE0y', 'admin', 'hayat', 'dimana'),
('hayatkaryawan', '$2y$10$AQ38VqemrpTRHMQz5ZebHuzthXbUpRCvY1Uvnsbn7X8i9e0HmLgNy', 'karyawan', 'hayat11', 'dimanaaaa');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `jenis_transaksi` enum('barang_masuk','barang_keluar') NOT NULL,
  `jumlah_barang` varchar(20) NOT NULL,
  `harga_total` varchar(20) NOT NULL,
  `id_pengguna` varchar(20) NOT NULL,
  `tanggal_transaksi` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `jenis_transaksi`, `jumlah_barang`, `harga_total`, `id_pengguna`, `tanggal_transaksi`) VALUES
(49, 'barang_masuk', '1', '10000', 'hayatadmin', '2024-06-15'),
(50, 'barang_masuk', '2', '20000', 'hayatadmin', '2024-06-15'),
(52, 'barang_masuk', '1', '10000', 'hayatadmin', '2024-06-15'),
(53, 'barang_masuk', '1', '20', 'hayatadmin', '2024-06-15'),
(54, 'barang_masuk', '1', '10000', 'hayatadmin', '2024-06-15'),
(55, 'barang_masuk', '1', '20', 'hayatadmin', '2024-06-15'),
(56, 'barang_masuk', '1', '20', 'hayatadmin', '2024-06-15'),
(57, 'barang_masuk', '1', '20', 'hayatadmin', '2024-06-15'),
(58, 'barang_masuk', '1', '10.000', 'hayatadmin', '2024-06-15'),
(59, 'barang_masuk', '1', '20000', 'hayatadmin', '2024-06-15'),
(60, 'barang_masuk', '1', '10.000', 'hayatadmin', '2024-06-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_username` (`username`);

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detailT`),
  ADD KEY `brang` (`id_barang`),
  ADD KEY `transaksi` (`id_transaksi`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `pengguna` (`id_pengguna`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detailT` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_username` FOREIGN KEY (`username`) REFERENCES `pengguna` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `brang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi` FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `pengguna` FOREIGN KEY (`id_pengguna`) REFERENCES `pengguna` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
