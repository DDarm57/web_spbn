-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Agu 2023 pada 08.38
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spbn`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bbm`
--

CREATE TABLE `bbm` (
  `id_bbm` int(11) NOT NULL,
  `nama_bbm` varchar(100) NOT NULL,
  `harga_perliter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bbm`
--

INSERT INTO `bbm` (`id_bbm`, `nama_bbm`, `harga_perliter`) VALUES
(8, 'SOLAR', 6800),
(11, 'KEROSENE', 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` varchar(13) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `nama`, `jk`, `alamat`, `no_hp`, `created_at`, `updated_at`) VALUES
(7, 'IRA', 'P', 'Pamekasan, Branta Pesisir', '089604246652', '2023-07-15 11:52:50', '2023-07-15 11:52:50'),
(8, 'MALIK', 'L', 'Pamekasan, Branta Pesisir', '089600438931', '2023-08-07 12:19:44', '2023-08-07 12:19:44'),
(9, 'SUKUR', 'L', 'Pamekasan, Telanakan', '089604246657', '2023-08-16 17:38:33', '2023-08-16 17:38:33'),
(10, 'FAKRI', 'L', 'Pamekasan Branta Pesisir Dermaga', '087739080542', '2023-08-17 13:25:32', '2023-08-17 13:25:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `deposit`
--

CREATE TABLE `deposit` (
  `id_deposit` int(11) NOT NULL,
  `total_deposit` int(11) NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `deposit`
--

INSERT INTO `deposit` (`id_deposit`, `total_deposit`, `tanggal`) VALUES
(2, 50000000, '2023-08-17'),
(3, 20000000, '2023-08-17'),
(4, 30000000, '2023-08-17'),
(5, 2000000, '2023-08-17'),
(6, 150000000, '2023-08-17'),
(7, 100000000, '2023-08-19'),
(8, 50000000, '2023-08-19'),
(9, 268600000, '2023-08-21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id_karyawan` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nama_karyawan` varchar(100) NOT NULL,
  `jk` varchar(50) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_hp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id_karyawan`, `user_id`, `nama_karyawan`, `jk`, `alamat`, `no_hp`) VALUES
(8, 9, 'Darmawan Handoyo', 'L', 'PAMEKASAN KRAMAT', 2147483647),
(9, 10, 'M. Fathor R', 'P', 'PAMEKASAN TLANAKAN', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan`
--

CREATE TABLE `pemasukan` (
  `id_pemasukan` int(11) NOT NULL,
  `id_bbm` int(11) NOT NULL,
  `id_karyawan` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `tgl_pemasukan` date NOT NULL,
  `liter_terjual` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `pendapatan` int(11) NOT NULL,
  `hutang` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pemasukan`
--

INSERT INTO `pemasukan` (`id_pemasukan`, `id_bbm`, `id_karyawan`, `id_customer`, `tgl_pemasukan`, `liter_terjual`, `total`, `pendapatan`, `hutang`, `status`, `created_at`) VALUES
(67, 11, 8, 9, '2023-07-30', 1000, 10000000, 10000000, 0, 'lunas', '2023-08-16 22:51:16'),
(68, 8, 8, 7, '2023-07-30', 1000, 6800000, 6800000, 0, 'lunas', '2023-08-16 22:52:35'),
(69, 11, 8, 9, '2023-07-30', 5000, 50000000, 50000000, 0, 'lunas', '2023-08-16 22:53:19'),
(70, 8, 8, 8, '2023-07-31', 8000, 54400000, 54400000, 0, 'lunas', '2023-08-16 22:54:42'),
(71, 8, 8, 9, '2023-08-16', 1000, 6800000, 6800000, 0, 'lunas', '2023-08-16 23:04:03'),
(72, 8, 8, 8, '2023-08-16', 5000, 34000000, 34000000, 0, 'lunas', '2023-08-16 23:04:38'),
(73, 8, 8, 7, '2023-08-16', 2000, 13600000, 13600000, 0, 'lunas', '2023-08-16 23:05:53'),
(74, 8, 8, 8, '2023-08-17', 5000, 34000000, 34000000, 0, 'lunas', '2023-08-17 08:34:16'),
(75, 8, 8, 9, '2023-08-17', 3000, 20400000, 20400000, 0, 'lunas', '2023-08-17 08:36:51'),
(76, 8, 8, 9, '2023-08-17', 5000, 34000000, 34000000, 0, 'lunas', '2023-08-17 11:01:17'),
(77, 8, 8, 8, '2023-08-17', 2000, 13600000, 13600000, 0, 'lunas', '2023-08-17 11:01:38'),
(78, 8, 8, 7, '2023-08-17', 5000, 34000000, 34000000, 0, 'lunas', '2023-08-17 12:49:27'),
(79, 8, 8, 10, '2023-08-19', 3000, 20400000, 20400000, 0, 'lunas', '2023-08-19 09:38:14'),
(80, 8, 8, 8, '2023-08-19', 10000, 68000000, 68000000, 0, 'lunas', '2023-08-19 09:39:52'),
(81, 8, 8, 10, '2023-08-19', 4000, 27200000, 27200000, 0, 'lunas', '2023-08-19 09:40:09'),
(82, 8, 8, 7, '2023-08-19', 500, 3400000, 3400000, 0, 'lunas', '2023-08-19 09:41:38'),
(83, 8, 8, 7, '2023-08-19', 8000, 54400000, 54400000, 0, 'lunas', '2023-08-19 10:03:38'),
(84, 8, 8, 8, '2023-08-19', 6000, 40800000, 40800000, 0, 'lunas', '2023-08-19 10:05:09'),
(85, 8, 8, 7, '2023-08-19', 8000, 54400000, 54400000, 0, 'lunas', '2023-08-19 16:09:20'),
(86, 8, 8, 10, '2023-08-21', 5000, 34000000, 34000000, 0, 'lunas', '2023-08-21 23:47:09'),
(87, 8, 8, 7, '2023-08-21', 3000, 20400000, 20400000, 0, 'lunas', '2023-08-21 23:48:29'),
(88, 8, 8, 10, '2023-08-22', 8000, 54400000, 54400000, 0, 'lunas', '2023-08-22 00:04:47'),
(89, 8, 8, 7, '2023-08-22', 5000, 34000000, 25000000, 9000000, 'belum lunas', '2023-08-22 00:27:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerimaan`
--

CREATE TABLE `penerimaan` (
  `id_penerimaan` int(11) NOT NULL,
  `id_bbm` int(11) NOT NULL,
  `isi_liter` int(11) NOT NULL,
  `tgl_penerimaan` date NOT NULL,
  `rp_perliter` int(11) NOT NULL,
  `total_rp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `penerimaan`
--

INSERT INTO `penerimaan` (`id_penerimaan`, `id_bbm`, `isi_liter`, `tgl_penerimaan`, `rp_perliter`, `total_rp`) VALUES
(12, 8, 9000, '2023-07-29', 6680, 60120000),
(13, 11, 6000, '2023-07-28', 9800, 58800000),
(14, 8, 8000, '2023-08-16', 6680, 53440000),
(15, 8, 8000, '2023-08-17', 6680, 53440000),
(16, 8, 7000, '2023-08-17', 6680, 46760000),
(17, 8, 8000, '2023-08-17', 6680, 53440000),
(18, 8, 8000, '2023-08-19', 6680, 53440000),
(19, 8, 6500, '2023-08-19', 6680, 43420000),
(20, 8, 8000, '2023-08-19', 6680, 53440000),
(21, 8, 6000, '2023-08-19', 6680, 40080000),
(22, 8, 8000, '2023-08-19', 6680, 53440000),
(23, 8, 8000, '2023-08-21', 6680, 53440000),
(24, 8, 8000, '2023-08-21', 6680, 53440000),
(25, 8, 8000, '2023-08-22', 6680, 53440000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id_pengeluaran` int(11) NOT NULL,
  `tipe_pengeluaran` varchar(50) NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `total_biaya` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`id_pengeluaran`, `tipe_pengeluaran`, `deskripsi`, `tgl_pengeluaran`, `total_biaya`) VALUES
(2, 'Gaji Karyawan', 'Gaji karyawan fikrih seh', '2023-08-17', 1000000),
(3, 'Biaya Operasional', 'Biaya sopir truk', '2023-08-17', 500000),
(4, 'Gaji Karyawan', 'GAJI KARYAWAN SEH', '2023-08-19', 1000000),
(5, 'Biaya Operasional', 'Biaya Perbaikan Truk', '2023-08-22', 500000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tangki`
--

CREATE TABLE `tangki` (
  `id_tangki` int(11) NOT NULL,
  `nama_tangki` varchar(100) NOT NULL,
  `id_bbm` int(11) NOT NULL,
  `jumlah_liter` int(11) NOT NULL,
  `kapasitas_liter` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tangki`
--

INSERT INTO `tangki` (`id_tangki`, `nama_tangki`, `id_bbm`, `jumlah_liter`, `kapasitas_liter`) VALUES
(1, 'TANGKI 1', 8, 3000, 8000),
(3, 'TANGKI 2', 11, 0, 8000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `total_pemasukan`
--

CREATE TABLE `total_pemasukan` (
  `id_totalPemasukan` int(11) NOT NULL,
  `total_pendapatan` int(11) NOT NULL,
  `total_hutang` int(11) NOT NULL,
  `bulan` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `total_pemasukan`
--

INSERT INTO `total_pemasukan` (`id_totalPemasukan`, `total_pendapatan`, `total_hutang`, `bulan`) VALUES
(16, 121200000, 0, '2023-07'),
(17, 592800000, 9000000, '2023-08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 1),
(9, 'seh1', 'seh1', 2),
(10, '12345', '12345', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `wallet`
--

CREATE TABLE `wallet` (
  `id_wallet` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `wallet`
--

INSERT INTO `wallet` (`id_wallet`, `saldo`) VALUES
(2, 109820000);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bbm`
--
ALTER TABLE `bbm`
  ADD PRIMARY KEY (`id_bbm`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indeks untuk tabel `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`id_deposit`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id_karyawan`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`id_pemasukan`),
  ADD KEY `id_karyawan` (`id_karyawan`),
  ADD KEY `id_bbm` (`id_bbm`),
  ADD KEY `id_customer` (`id_customer`);

--
-- Indeks untuk tabel `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD PRIMARY KEY (`id_penerimaan`),
  ADD KEY `id_bbm` (`id_bbm`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indeks untuk tabel `tangki`
--
ALTER TABLE `tangki`
  ADD PRIMARY KEY (`id_tangki`),
  ADD KEY `id_bbm` (`id_bbm`);

--
-- Indeks untuk tabel `total_pemasukan`
--
ALTER TABLE `total_pemasukan`
  ADD PRIMARY KEY (`id_totalPemasukan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_wallet`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bbm`
--
ALTER TABLE `bbm`
  MODIFY `id_bbm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `deposit`
--
ALTER TABLE `deposit`
  MODIFY `id_deposit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id_karyawan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  MODIFY `id_pemasukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT untuk tabel `penerimaan`
--
ALTER TABLE `penerimaan`
  MODIFY `id_penerimaan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id_pengeluaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `tangki`
--
ALTER TABLE `tangki`
  MODIFY `id_tangki` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `total_pemasukan`
--
ALTER TABLE `total_pemasukan`
  MODIFY `id_totalPemasukan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `wallet`
--
ALTER TABLE `wallet`
  MODIFY `id_wallet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD CONSTRAINT `karyawan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD CONSTRAINT `pemasukan_ibfk_1` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`),
  ADD CONSTRAINT `pemasukan_ibfk_2` FOREIGN KEY (`id_bbm`) REFERENCES `bbm` (`id_bbm`),
  ADD CONSTRAINT `pemasukan_ibfk_3` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`);

--
-- Ketidakleluasaan untuk tabel `penerimaan`
--
ALTER TABLE `penerimaan`
  ADD CONSTRAINT `penerimaan_ibfk_1` FOREIGN KEY (`id_bbm`) REFERENCES `bbm` (`id_bbm`);

--
-- Ketidakleluasaan untuk tabel `tangki`
--
ALTER TABLE `tangki`
  ADD CONSTRAINT `tangki_ibfk_1` FOREIGN KEY (`id_bbm`) REFERENCES `bbm` (`id_bbm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
