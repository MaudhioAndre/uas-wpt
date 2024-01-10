-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jan 2024 pada 16.29
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uas-wpt`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `idUser` int(15) NOT NULL,
  `keterangan` varchar(50) NOT NULL DEFAULT 'Pembayaran Kuliah',
  `biaya` int(15) NOT NULL,
  `tahun_ajar` varchar(15) NOT NULL,
  `periode` varchar(10) NOT NULL,
  `jatuh_tempo` date NOT NULL,
  `tanggal_pembayaran` timestamp NULL DEFAULT NULL,
  `bukti_pembayaran` text DEFAULT NULL,
  `status_pembayaran` varchar(50) NOT NULL DEFAULT 'Belum Bayar',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `idUser`, `keterangan`, `biaya`, `tahun_ajar`, `periode`, `jatuh_tempo`, `tanggal_pembayaran`, `bukti_pembayaran`, `status_pembayaran`, `created_at`) VALUES
(3900610, 1, 'Pembayaran Kuliah', 10000, '2024/2025', 'Ganjil', '2024-01-15', '2024-01-10 12:52:00', 'http://localhost/uas-wpt/api/assets/file/2024/01/10/468095Bukti-Transfer-BCA-Mobile.jpg', 'Terkonfirmasi', '2024-01-10 12:50:53'),
(7980592, 1, 'Pembayaran Kuliah', 100000, '2023/2024', 'Ganjil', '2024-01-11', '2024-01-10 12:29:00', 'http://localhost/uas-wpt/api/assets/file/2024/01/10/691328Bukti-Transfer-BCA-Mobile.jpg', 'Terkonfirmasi', '2024-01-10 12:29:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `nama`, `username`, `password`, `role`) VALUES
(1, 'Maudhio Andre Wijaya', 'dio', '123', 'Mahasiswa'),
(2, 'Doni', 'doni', '123', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
