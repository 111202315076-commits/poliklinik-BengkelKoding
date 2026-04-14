-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 14, 2026 at 05:34 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `poliklinik_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `daftar_poli`
--

CREATE TABLE `daftar_poli` (
  `id` bigint UNSIGNED NOT NULL,
  `id_pasien` bigint UNSIGNED NOT NULL,
  `id_jadwal` bigint UNSIGNED NOT NULL,
  `keluhan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_antrian` int NOT NULL,
  `status_periksa` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daftar_poli`
--

INSERT INTO `daftar_poli` (`id`, `id_pasien`, `id_jadwal`, `keluhan`, `no_antrian`, `status_periksa`, `created_at`, `updated_at`) VALUES
(1, 3, 1, 'demam + pusing dan mual', 1, '1', '2026-04-14 08:39:10', '2026-04-14 10:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `detail_periksa`
--

CREATE TABLE `detail_periksa` (
  `id` bigint UNSIGNED NOT NULL,
  `id_periksa` bigint UNSIGNED NOT NULL,
  `id_obat` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_periksa`
--

INSERT INTO `detail_periksa` (`id`, `id_periksa`, `id_obat`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '2026-04-14 10:17:50', '2026-04-14 10:17:50');

-- --------------------------------------------------------

--
-- Table structure for table `dokters`
--

CREATE TABLE `dokters` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_poli` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_periksa`
--

CREATE TABLE `jadwal_periksa` (
  `id` bigint UNSIGNED NOT NULL,
  `id_dokter` bigint UNSIGNED NOT NULL,
  `hari` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_periksa`
--

INSERT INTO `jadwal_periksa` (`id`, `id_dokter`, `hari`, `jam_mulai`, `jam_selesai`, `created_at`, `updated_at`) VALUES
(1, 2, 'Rabu', '08:00:00', '20:00:00', '2026-04-13 00:09:19', '2026-04-13 09:32:00'),
(2, 2, 'Jumat', '08:30:00', '20:00:00', '2026-04-13 09:18:15', '2026-04-13 09:18:15'),
(4, 2, 'Senin', '07:00:00', '17:00:00', '2026-04-13 09:32:34', '2026-04-13 09:32:34'),
(5, 4, 'Senin', '09:00:00', '22:00:00', '2026-04-14 08:11:32', '2026-04-14 08:11:32'),
(6, 4, 'Kamis', '06:00:00', '18:00:00', '2026-04-14 08:11:53', '2026-04-14 08:11:53'),
(7, 4, 'Sabtu', '08:00:00', '23:00:00', '2026-04-14 08:12:17', '2026-04-14 08:12:17'),
(8, 5, 'Selasa', '08:00:00', '22:00:00', '2026-04-14 08:13:14', '2026-04-14 08:13:14'),
(9, 5, 'Rabu', '08:00:00', '18:00:00', '2026-04-14 08:13:53', '2026-04-14 08:13:53'),
(10, 5, 'Jumat', '07:30:00', '22:00:00', '2026-04-14 08:14:20', '2026-04-14 08:14:20'),
(11, 6, 'Senin', '07:00:00', '18:30:00', '2026-04-14 08:15:24', '2026-04-14 08:15:24'),
(12, 6, 'Rabu', '08:00:00', '22:00:00', '2026-04-14 08:15:38', '2026-04-14 08:15:38'),
(13, 6, 'Jumat', '07:30:00', '22:00:00', '2026-04-14 08:15:58', '2026-04-14 08:15:58');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `queue`, `payload`, `attempts`, `reserved_at`, `available_at`, `created_at`) VALUES
(1, 'default', '{\"uuid\":\"98030a5a-b8da-4d8e-9a63-4a33830ccc93\",\"displayName\":\"App\\\\Events\\\\AntrianUpdated\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"failOnTimeout\":false,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\",\"command\":\"O:38:\\\"Illuminate\\\\Broadcasting\\\\BroadcastEvent\\\":14:{s:5:\\\"event\\\";O:25:\\\"App\\\\Events\\\\AntrianUpdated\\\":2:{s:9:\\\"id_jadwal\\\";i:1;s:19:\\\"no_antrian_sekarang\\\";i:1;}s:5:\\\"tries\\\";N;s:7:\\\"timeout\\\";N;s:7:\\\"backoff\\\";N;s:13:\\\"maxExceptions\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;}\"}}', 0, NULL, 1776187072, 1776187072);

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(4, '2026_04_02_013254_create_poli_table', 1),
(5, '2026_04_02_040613_create_jadwal_periksa_table', 1),
(6, '2026_04_02_040635_create_daftar_poli_table', 1),
(7, '2026_04_02_040647_create_periksa_table', 1),
(8, '2026_04_02_040655_create_obat_table', 1),
(9, '2026_04_02_040704_create_detail_periksa_table', 1),
(10, '2026_04_02_040712_add_id_poli_to_user_tabl', 1),
(12, '0001_01_01_000001_create_cache_table', 2),
(13, '0001_01_01_000002_create_jobs_table', 2),
(14, '2026_03_31_045507_create_poli_table', 2),
(15, '2026_03_31_045522_create_jadwal_periksa_table', 1),
(16, '2026_03_31_045533_create_daftar_poli_table', 1),
(17, '2026_03_31_045522_create_jadwal_periksa_table', 1),
(18, '2026_03_31_045533_create_daftar_poli_table', 1),
(19, '2026_03_31_045544_create_periksa_table', 1),
(20, '2026_03_31_045507_create_poli_table', 1),
(21, '2026_03_31_045611_create_obat_table', 1),
(22, '2026_03_31_045623_create_detail_periksa_table', 1),
(23, '2026_03_31_045507_create_poli_table', 1),
(24, '2026_03_31_045522_create_jadwal_periksa_table', 1),
(25, '2026_03_31_045533_create_daftar_poli_table', 1),
(26, '2026_03_31_045544_create_periksa_table', 1),
(27, '2026_03_31_045611_create_obat_table', 1),
(28, '2026_03_31_045623_create_detail_periksa_table', 1),
(29, '2026_03_31_045631_add_id_poli_to_user_table', 1),
(30, '2026_04_07_170812_add_keterangan_to_poli_table', 3),
(31, '2026_04_12_214133_create_dokters_table', 3),
(32, '2026_04_12_214309_create_pasiens_table', 3),
(33, '2026_04_14_024233_add_stok_to_obat_table', 1),
(34, '2026_04_14_024234_add_payment_fields_to_periksa_table', 1),
(35, '2026_04_14_024234_add_status_to_daftar_poli_table', 1),
(36, '2026_04_14_145717_rename_harga_to_harga_obat_in_obat_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `obat`
--

CREATE TABLE `obat` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_obat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kemasan` varchar(35) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_obat` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `stok` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `obat`
--

INSERT INTO `obat` (`id`, `nama_obat`, `kemasan`, `harga_obat`, `created_at`, `updated_at`, `stok`) VALUES
(2, 'Paracetamol', 'Sirup', 20000, '2026-04-12 12:25:48', '2026-04-14 10:17:50', 54),
(3, 'Bodrex', 'Tablet', 5000, '2026-04-12 12:26:11', '2026-04-14 08:00:02', 100),
(4, 'Amoxilin', 'Tablet', 10000, '2026-04-12 12:26:30', '2026-04-14 07:59:54', 100),
(8, 'Laserin', 'Sirup', 15000, '2026-04-12 12:48:21', '2026-04-14 07:58:59', 50);

-- --------------------------------------------------------

--
-- Table structure for table `periksa`
--

CREATE TABLE `periksa` (
  `id` bigint UNSIGNED NOT NULL,
  `id_daftar_poli` bigint UNSIGNED NOT NULL,
  `tgl_periksa` datetime NOT NULL,
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `biaya_periksa` int NOT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_bayar` enum('belum_bayar','menunggu_verifikasi','lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_bayar',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `periksa`
--

INSERT INTO `periksa` (`id`, `id_daftar_poli`, `tgl_periksa`, `catatan`, `biaya_periksa`, `bukti_bayar`, `status_bayar`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-04-14 17:17:00', 'diminum 3 kali sehari', 170000, 'bukti_bayar/PUMlMLiNXdDjHInxTWeIZlJcEVVRSvvwF45qJ0oR.png', 'lunas', '2026-04-14 10:17:50', '2026-04-14 10:22:18');

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_poli` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`id`, `nama_poli`, `keterangan`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Poli Umum', 'Poli umum adalah layanan kesehatan dasar di rumah sakit atau klinik yang ditangani oleh dokter umum. Poli ini biasanya menjadi tempat pertama pasien datang sebelum dirujuk ke dokter spesialis jika diperlukan.', NULL, '2026-04-12 16:42:49', '2026-04-12 16:42:49'),
(2, 'Poli Gigi', 'Poli Gigi adalah layanan di rumah sakit atau puskesmas yang khusus menangani kesehatan gigi dan mulut. Di sini pasien bisa memeriksakan, mengobati, dan merawat berbagai masalah gigi.', NULL, '2026-04-12 17:03:39', '2026-04-12 17:03:39'),
(3, 'Poli Mata', 'Poli mata', NULL, '2026-04-12 17:04:35', '2026-04-12 17:04:35'),
(4, 'Poli Anak', 'poli khusus anak dibawah 10thn', NULL, '2026-04-13 17:05:21', '2026-04-13 17:05:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_ktp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_rm` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_poli` bigint UNSIGNED DEFAULT NULL,
  `role` enum('admin','dokter','pasien') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pasien',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `alamat`, `no_ktp`, `no_hp`, `no_rm`, `id_poli`, `role`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nisrina Zulfa', 'Semarang', '33270041237', '085931425259', NULL, NULL, 'admin', 'admin@gmail.com', '$2y$12$LVlm8Gv4rnXjcEFsytbQ3uUiEfTNz7yNC0HJUB8skqsTg1w3CCfFe', NULL, '2026-04-12 11:11:56', '2026-04-12 11:11:56'),
(2, 'Ninis', 'Pemalang', '332255667080', '087731425877', NULL, 1, 'dokter', 'dokter@gmail.com', '$2y$12$gnk7yR7zt8BBPcT3WgyI7eKCG24BLJwADzqPdPjEck5zL.r4H3miy', NULL, '2026-04-12 11:13:41', '2026-04-13 07:15:03'),
(3, 'Rizqiyani', 'Ngaliyan, Semarang', '3322123456', '085967231234', NULL, NULL, 'pasien', 'pasien@gmail.com', '$2y$12$pDtOrR5uFu7R343q4PfWYet2ACR6ChYalOF3LiE9zn.m5i7NM.zma', NULL, '2026-04-12 11:16:13', '2026-04-12 11:16:13'),
(4, 'Ryan', 'Semarang', '33240507896', '087731425877', NULL, 2, 'dokter', 'ryanDokter@gmail.com', '$2y$12$x.g7om29cN287x91qxATNe8xhVkgO3ijH1lKaKMl/uQmgsCTQUyde', NULL, '2026-04-12 11:36:30', '2026-04-12 11:36:30'),
(5, 'Rara', 'Gunung Pati', '332451617180', '087841235050', NULL, 3, 'dokter', 'raraDokter@gmail.com', '$2y$12$FVlTz33vjQ7vV0QgR/vR8.oHMQX5dLysVuH5wi0Hi9qojWAGnPufW', NULL, '2026-04-12 11:46:40', '2026-04-13 07:14:34'),
(6, 'Davin', 'Jepara', '33326500003', '08123456789', NULL, 4, 'dokter', 'davinDokter@gmail.com', '$2y$12$IudpYI4tEBUEX3Bk2gSRb.dpH42szSUWiAAVrP3PX7lNHstBwjhDi', NULL, '2026-04-12 13:47:45', '2026-04-13 07:14:49'),
(7, 'Gani', 'Salatiga', '332723570003', '087731425877', NULL, NULL, 'pasien', 'gani@gmail.com', '$2y$12$KGyave57kePtNz9ie/hXKubSOVqKoY4nPYaDwdYIYMJvBlk9FCHw6', NULL, '2026-04-12 14:05:25', '2026-04-12 14:05:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD PRIMARY KEY (`id`),
  ADD KEY `daftar_poli_id_pasien_foreign` (`id_pasien`),
  ADD KEY `daftar_poli_id_jadwal_foreign` (`id_jadwal`);

--
-- Indexes for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_periksa_id_periksa_foreign` (`id_periksa`),
  ADD KEY `detail_periksa_id_obat_foreign` (`id_obat`);

--
-- Indexes for table `dokters`
--
ALTER TABLE `dokters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_periksa_id_dokter_foreign` (`id_dokter`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `obat`
--
ALTER TABLE `obat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `periksa`
--
ALTER TABLE `periksa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `periksa_id_daftar_poli_foreign` (`id_daftar_poli`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dokters`
--
ALTER TABLE `dokters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `obat`
--
ALTER TABLE `obat`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `periksa`
--
ALTER TABLE `periksa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `poli`
--
ALTER TABLE `poli`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `daftar_poli`
--
ALTER TABLE `daftar_poli`
  ADD CONSTRAINT `daftar_poli_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_periksa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `daftar_poli_id_pasien_foreign` FOREIGN KEY (`id_pasien`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `detail_periksa`
--
ALTER TABLE `detail_periksa`
  ADD CONSTRAINT `detail_periksa_id_obat_foreign` FOREIGN KEY (`id_obat`) REFERENCES `obat` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_periksa_id_periksa_foreign` FOREIGN KEY (`id_periksa`) REFERENCES `periksa` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `jadwal_periksa`
--
ALTER TABLE `jadwal_periksa`
  ADD CONSTRAINT `jadwal_periksa_id_dokter_foreign` FOREIGN KEY (`id_dokter`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `periksa`
--
ALTER TABLE `periksa`
  ADD CONSTRAINT `periksa_id_daftar_poli_foreign` FOREIGN KEY (`id_daftar_poli`) REFERENCES `daftar_poli` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
