-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2025 at 01:28 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si_smk`
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
-- Table structure for table `calon_siswa`
--

CREATE TABLE `calon_siswa` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_pendaftaran` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `jurusan_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `calon_siswa`
--

INSERT INTO `calon_siswa` (`id`, `nama`, `no_pendaftaran`, `no_hp`, `user_id`, `jurusan_id`, `created_at`, `updated_at`) VALUES
(6, 'Calon Siswa 6', 'REG0006', '089612345696', 7, 3, '2025-07-10 10:12:17', '2025-07-10 10:12:17'),
(7, 'Calon Siswa 7', 'REG0007', '089612345697', 8, 2, '2025-07-10 10:12:17', '2025-07-10 10:12:17'),
(8, 'Calon Siswa 8', 'REG0008', '089612345698', 9, 2, '2025-07-10 10:12:18', '2025-07-10 10:12:18'),
(9, 'Calon Siswa 9', 'REG0009', '089612345699', 10, 2, '2025-07-10 10:12:18', '2025-07-10 10:12:18'),
(10, 'Calon Siswa 10', 'REG0010', '0896123456910', 11, 1, '2025-07-10 10:12:19', '2025-07-10 10:12:19'),
(13, 'azzzzzz', 'REG11112', '98897123', 44, 2, '2025-07-20 12:30:39', '2025-07-20 23:52:10'),
(14, 'gghfgh', 'REG4444', '76786', 46, 3, '2025-07-27 22:38:41', '2025-07-27 22:38:41'),
(15, 'pp', 'REG121', '0988787', 49, 6, '2025-08-01 01:25:10', '2025-08-01 01:25:10');

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
-- Table structure for table `jenis_pembayaran`
--

CREATE TABLE `jenis_pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `jurusan_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '1,2,3',
  `nama_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'contoh: spp, ujian',
  `nominal` decimal(15,2) NOT NULL,
  `tahun_akademik` int NOT NULL,
  `semester` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kepada` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_pembayaran`
--

INSERT INTO `jenis_pembayaran` (`id`, `jurusan_id`, `kelas`, `nama_pembayaran`, `nominal`, `tahun_akademik`, `semester`, `keterangan`, `kepada`, `created_at`, `updated_at`) VALUES
(15, '[\"1\"]', '[\"3\"]', 'Perpisahan', '123123.00', 2025, 'Ganjil', 'zxasd', 'siswa', '2025-07-24 19:13:07', '2025-07-24 19:13:07'),
(16, '[\"-\"]', '[\"1\"]', 'Penilaian Sumatif Akhir Tahun', '12312.00', 2025, 'Ganjil', 'XZsadad', 'siswa', '2025-07-25 01:31:23', '2025-07-25 01:31:23'),
(17, '[\"-\"]', '[\"-\"]', 'Penilaian Sumatif Akhir Tahun', '12331.00', 2025, 'Ganjil', 'asdasd', 'calon_siswa', '2025-07-25 01:55:16', '2025-08-01 01:11:28'),
(18, '[\"-\"]', '[\"-\"]', 'Penilaian Sumatif Tengah Semester', '1111111.00', 2025, 'Ganjil', 'dsfdfds', 'siswa', '2025-07-27 22:18:09', '2025-07-27 22:18:09'),
(19, '[\"5\"]', '[\"-\"]', 'asdsa', '1111.00', 2023, 'Genap', 'sad', 'calon_siswa', '2025-08-06 02:42:17', '2025-08-06 02:42:17');

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
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Akutansi', '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(2, 'Manajemen', '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(3, 'Perkantoran', '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(5, 'aaa', NULL, NULL),
(6, 'aa', '2025-07-19 07:06:49', '2025-07-19 07:08:42');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint UNSIGNED NOT NULL,
  `kelas` enum('1','2','3') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '1,2,3',
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'A,B,C',
  `tahun_masuk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jurusan_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `kelas`, `nama`, `tahun_masuk`, `jurusan_id`, `created_at`, `updated_at`) VALUES
(1, '3', 'A', '2022', 1, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(2, '3', 'B', '2022', 1, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(3, '3', 'A', '2022', 1, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(4, '3', 'B', '2022', 1, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(5, '3', 'A', '2022', 1, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(6, '3', 'B', '2022', 1, '2025-07-10 10:12:14', '2025-07-10 10:12:14'),
(7, '3', 'A', '2022', 2, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(8, '3', 'B', '2022', 2, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(9, '3', 'A', '2022', 2, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(10, '3', 'B', '2022', 2, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(11, '3', 'A', '2022', 2, '2025-07-10 10:12:14', '2025-07-10 10:12:14'),
(12, '3', 'B', '2022', 2, '2025-07-10 10:12:14', '2025-07-10 10:12:14'),
(13, '3', 'A', '2022', 3, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(14, '3', 'B', '2022', 3, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(15, '3', 'A', '2022', 3, '2025-07-10 10:12:14', '2025-07-16 06:06:05'),
(16, '3', 'B', '2022', 3, '2025-07-10 10:12:14', '2025-07-10 10:12:14'),
(17, '3', 'A', '2022', 3, '2025-07-10 10:12:14', '2025-07-10 10:12:14'),
(18, '3', 'B', '2022', 3, '2025-07-10 10:12:14', '2025-07-10 10:12:14'),
(25, '3', 'F', '2001', 5, NULL, NULL),
(27, '3', 'F', '2001', 5, '2025-07-19 07:55:59', '2025-07-19 07:55:59'),
(29, '2', 'F', '2024', 3, '2025-07-21 10:18:10', '2025-07-21 10:18:10'),
(30, '3', 'D', '2022', 1, '2025-07-21 10:27:35', '2025-07-21 10:27:35'),
(31, '2', 'F', '2024', 3, '2025-07-21 10:31:50', '2025-07-21 10:31:50'),
(32, '1', 'E', '2025', 1, '2025-07-24 19:03:42', '2025-07-24 19:03:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_27_063954_create_jurusan', 1),
(5, '2025_06_27_063954_create_kelas', 1),
(6, '2025_06_27_063955_create_calon_siswa', 1),
(7, '2025_06_27_063955_create_siswa', 1),
(8, '2025_06_27_064010_create_jenis_pembayaran', 1),
(9, '2025_06_27_064020_create_tagihan', 1),
(10, '2025_06_27_064040_create_pembayaran', 1),
(11, '2025_07_02_031313_create_jenis_jurusan', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nama_pembayaran`
--

CREATE TABLE `nama_pembayaran` (
  `id` int NOT NULL,
  `nama_pembayaran` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nama_pembayaran`
--

INSERT INTO `nama_pembayaran` (`id`, `nama_pembayaran`, `created_at`, `updated_at`) VALUES
(1, 'asdsa', '2025-08-06 09:15:02', '2025-08-06 09:15:02'),
(2, 'Perpisahan', '2025-08-06 09:34:06', '2025-08-06 09:34:06'),
(3, 'Penilaian Sumatif Akhir Tahun	', '2025-08-06 09:34:21', '2025-08-06 09:34:21'),
(4, 'Penilaian Sumatif Tengah Semester	', '2025-08-06 09:34:39', '2025-08-06 09:34:39'),
(5, 'asdasdasdas', '2025-08-06 15:24:20', '2025-08-06 15:24:20');

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int NOT NULL,
  `user_id` int NOT NULL,
  `id_tagihan` int NOT NULL,
  `pesan` varchar(255) NOT NULL,
  `tgl_kirim` date NOT NULL,
  `status_baca` enum('0','1') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notifikasi`
--

INSERT INTO `notifikasi` (`id_notifikasi`, `user_id`, `id_tagihan`, `pesan`, `tgl_kirim`, `status_baca`, `created_at`, `updated_at`) VALUES
(1, 45, 86, 'aaaa', '2025-08-05', '1', '2025-08-06 16:11:29', '2025-08-06 16:11:29'),
(2, 45, 86, 'Pembayaran Rp 123 diterima. Sisa: Rp 1110988', '2025-08-07', '1', '2025-08-07 16:44:41', '2025-08-07 16:44:41'),
(3, 45, 86, 'Pembayaran Rp 100 diterima. Sisa: Rp 1110888', '2025-08-07', '1', '2025-08-07 16:47:44', '2025-08-07 16:47:44'),
(4, 45, 86, 'Pembayaran Rp 100 diterima. Sisa: Rp 1110888', '2025-08-07', '1', '2025-08-07 16:50:51', '2025-08-07 16:50:51'),
(5, 45, 86, 'Pembayaran Rp 100 diterima. Sisa: Rp 1110788', '2025-08-07', '1', '2025-08-07 16:51:46', '2025-08-07 16:51:46'),
(6, 45, 86, 'Pembayaran Rp 77 diterima. Sisa: Rp 1110711', '2025-08-08', '1', '2025-08-08 11:37:28', '2025-08-08 11:37:28'),
(7, 45, 86, 'Pembayaran Rp 0 ditolak.', '2025-08-08', '1', '2025-08-08 12:01:39', '2025-08-08 12:01:39'),
(8, 45, 86, 'Pembayaran Rp Penilaian Sumatif Tengah Semester ditolak.', '2025-08-08', '1', '2025-08-08 12:05:31', '2025-08-08 12:05:31'),
(9, 45, 86, 'Pembayaran Penilaian Sumatif Tengah Semester ditolak.', '2025-08-08', '1', '2025-08-08 12:06:45', '2025-08-08 12:06:45'),
(10, 45, 86, 'Pembayaran Rp 11111111 diterima. Sisa: Rp -10000400', '2025-08-08', '0', '2025-08-08 12:13:27', '2025-08-08 12:13:27'),
(11, 44, 102, 'Pembayaran Rp 100 diterima. Sisa: Rp 11900', '2025-08-08', '1', '2025-08-08 12:40:07', '2025-08-08 12:40:07'),
(12, 44, 102, 'Pembayaran Rp 100 diterima. Sisa: Rp 11800', '2025-08-08', '1', '2025-08-08 12:42:40', '2025-08-08 12:42:40'),
(13, 44, 102, 'Pembayaran Penilaian Sumatif Akhir Tahun ditolak.', '2025-08-08', '1', '2025-08-08 12:44:17', '2025-08-08 12:44:17'),
(14, 44, 102, 'Tagihan Penilaian Sumatif Akhir Tahun Rp 12331 telah diverifikasi dan Lunas.', '2025-08-08', '1', '2025-08-08 12:46:00', '2025-08-08 12:46:00'),
(15, 44, 95, 'Pembayaran Rp 111 diterima. Sisa: Rp 12109', '2025-08-08', '1', '2025-08-08 12:47:26', '2025-08-08 12:47:26'),
(16, 44, 95, 'Pembayaran Rp 111 diterima. Sisa: Rp 12109', '2025-08-08', '1', '2025-08-08 12:48:20', '2025-08-08 12:48:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `tagihan_id` bigint UNSIGNED NOT NULL,
  `nominal_bayar` int NOT NULL,
  `bukti_bayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `metode_bayar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'qris,bank,tunai',
  `dibayar_oleh` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'siswa, staf',
  `status` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `tagihan_id`, `nominal_bayar`, `bukti_bayar`, `tanggal_bayar`, `metode_bayar`, `dibayar_oleh`, `status`, `created_at`, `updated_at`) VALUES
(1, 36, 23234, 'bukti_1753470388.png', '2025-07-28', 'transfer', 'siswa', '0', NULL, NULL),
(2, 70, 500000, 'bukti_1753680537.png', '2025-07-27', 'transfer', 'siswa', '0', NULL, NULL),
(3, 70, 620000, 'bukti_1753680660.png', '2025-07-28', 'transfer', 'siswa', '0', NULL, NULL),
(4, 55, 0, 'bukti_1754015813.png', '2025-08-02', 'cash', 'siswa', '2', NULL, NULL),
(6, 55, 12312312, 'bukti_1754032888.png', '2025-07-31', 'transfer', 'siswa', '1', NULL, NULL),
(7, 104, 0, 'bukti_1754037517.png', '2025-08-08', 'transfer', 'siswa', '2', NULL, NULL),
(8, 104, 5000, 'bukti_1754037571.png', '2025-08-09', 'transfer', 'siswa', '1', NULL, NULL),
(9, 104, 7611, 'bukti_1754037594.png', '2025-08-14', 'transfer', 'siswa', '1', NULL, NULL),
(10, 86, 123, 'bukti_1754584663.jpg', '2025-08-08', 'transfer', 'siswa', '1', NULL, NULL),
(11, 86, 100, 'bukti_1754585264.png', '2025-08-08', 'transfer', 'siswa', '1', NULL, NULL),
(12, 86, 100, 'bukti_1754585506.png', '2025-08-15', 'transfer', 'staf', '1', NULL, NULL),
(13, 86, 77, 'bukti_1754653048.png', '2025-08-09', 'transfer', 'staf', '1', NULL, NULL),
(14, 86, 0, 'bukti_1754653718.jpg', '2025-08-15', 'transfer', 'siswa', '2', NULL, NULL),
(15, 86, 0, 'bukti_1754654655.png', '2025-08-09', 'cash', 'siswa', '2', NULL, NULL),
(16, 86, 0, 'bukti_1754654788.jpg', '2025-08-09', 'transfer', 'siswa', '2', NULL, NULL),
(17, 86, 11111111, 'bukti_1754655009.jpg', '2025-08-09', 'cash', 'siswa', '1', NULL, NULL),
(18, 102, 331, 'bukti_1754656572.png', '2025-08-07', 'transfer', 'siswa', '1', NULL, NULL),
(19, 102, 100, 'bukti_1754656795.png', '2025-08-07', 'transfer', 'siswa', '1', NULL, NULL),
(20, 102, 100, 'bukti_1754656946.jpg', '2025-08-08', 'transfer', 'siswa', '1', NULL, NULL),
(21, 102, 0, 'bukti_1754657000.jpg', '2025-08-07', 'transfer', 'siswa', '2', NULL, NULL),
(22, 102, 130000, 'bukti_1754657133.jpg', '2025-08-07', 'transfer', 'siswa', '0', NULL, NULL),
(23, 95, 111, 'bukti_1754657204.png', '2025-08-08', 'cash', 'siswa', '1', NULL, NULL),
(24, 95, 111, 'bukti_1754657246.jpg', '2025-08-09', 'cash', 'staf', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3IFwhKO0GtaXy5kSH0XJmTGS6LEHonyWOxBaxRrZ', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZ3RkRXJhZk9IQURsdU1yeldmdTZWcUtuazdMTTZVeGttdFQ0eTFrNyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hL3RhZ2loYW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1753279316),
('zr5MLEkMhbWp1bEku8aoi7KaqBx4LpKoxlXyBYhb', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoicXRXQk1qV1pvYmt1UE1EUnNhSjNSMWtUM3JscGJXNDR0UGJOWG5mYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hL3RhZ2loYW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1753239953);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `kelas_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nisn`, `no_hp`, `user_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 'Siswaaaaa', '1234567801111', '0896111111122', 12, 12, '2025-07-10 10:12:19', '2025-07-20 05:52:15'),
(2, 'Siswa 2', '1234567802', '08961111112', 13, 17, '2025-07-10 10:12:20', '2025-07-10 10:12:20'),
(3, 'Siswa 3', '1234567803', '08961111113', 14, 10, '2025-07-10 10:12:21', '2025-07-10 10:12:21'),
(5, 'Siswa 5', '1234567805', '08961111115', 16, 18, '2025-07-10 10:12:22', '2025-07-10 10:12:22'),
(6, 'Siswa 6', '1234567806', '08961111116', 17, 17, '2025-07-10 10:12:22', '2025-07-10 10:12:22'),
(7, 'Siswa 7', '1234567807', '08961111117', 18, 11, '2025-07-10 10:12:23', '2025-07-10 10:12:23'),
(8, 'Siswa 8', '1234567808', '08961111118', 19, 1, '2025-07-10 10:12:23', '2025-07-10 10:12:23'),
(9, 'Siswa 9', '1234567809', '08961111119', 20, 8, '2025-07-10 10:12:24', '2025-07-10 10:12:24'),
(10, 'Siswa 10', '1234567810', '089611111110', 21, 7, '2025-07-10 10:12:24', '2025-07-10 10:12:24'),
(11, 'Siswa 11', '1234567811', '089611111111', 22, 17, '2025-07-10 10:12:25', '2025-07-10 10:12:25'),
(15, 'Siswa 15', '1234567815', '089611111115', 26, 1, '2025-07-10 10:12:27', '2025-07-10 10:12:27'),
(16, 'Siswa 16', '1234567816', '089611111116', 27, 11, '2025-07-10 10:12:27', '2025-07-10 10:12:27'),
(17, 'Siswa 17', '1234567817', '089611111117', 28, 5, '2025-07-10 10:12:28', '2025-07-10 10:12:28'),
(26, 'xczc', '1233', '3453454', 45, 32, '2025-07-24 19:46:45', '2025-07-24 19:46:45');

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `id` bigint UNSIGNED NOT NULL,
  `siswa_id` bigint UNSIGNED DEFAULT NULL,
  `calon_siswa_id` bigint UNSIGNED DEFAULT NULL,
  `jenis_pembayaran_id` bigint UNSIGNED NOT NULL,
  `total_tagihan` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_jatuh_tempo` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihan`
--

INSERT INTO `tagihan` (`id`, `siswa_id`, `calon_siswa_id`, `jenis_pembayaran_id`, `total_tagihan`, `status`, `tanggal_jatuh_tempo`, `created_at`, `updated_at`) VALUES
(31, 8, NULL, 15, 123123, 0, '2025-07-26', '2025-07-24 19:13:22', '2025-07-24 19:13:22'),
(32, 15, NULL, 15, 123123, 0, '2025-07-26', '2025-07-24 19:13:22', '2025-07-24 19:13:22'),
(33, 17, NULL, 15, 123123, 0, '2025-07-26', '2025-07-24 19:13:22', '2025-07-24 19:13:22'),
(36, 26, NULL, 16, 12312, 1, '2025-07-26', '2025-07-25 01:31:39', '2025-07-25 01:31:39'),
(40, NULL, 6, 17, 12331, 0, '2025-07-26', '2025-07-25 02:00:20', '2025-07-25 02:00:20'),
(41, NULL, 7, 17, 12331, 0, '2025-07-26', '2025-07-25 02:00:20', '2025-07-25 02:00:20'),
(42, NULL, 8, 17, 12331, 0, '2025-07-26', '2025-07-25 02:00:20', '2025-07-25 02:00:20'),
(43, NULL, 9, 17, 12331, 0, '2025-07-26', '2025-07-25 02:00:20', '2025-07-25 02:00:20'),
(44, NULL, 10, 17, 12331, 0, '2025-07-26', '2025-07-25 02:00:20', '2025-07-25 02:00:20'),
(49, NULL, 6, 17, 12331, 0, '2025-07-31', '2025-07-27 22:13:36', '2025-07-27 22:13:36'),
(50, NULL, 7, 17, 12331, 0, '2025-07-31', '2025-07-27 22:13:36', '2025-07-27 22:13:36'),
(51, NULL, 8, 17, 12331, 0, '2025-07-31', '2025-07-27 22:13:36', '2025-07-27 22:13:36'),
(52, NULL, 9, 17, 12331, 0, '2025-07-31', '2025-07-27 22:13:36', '2025-07-27 22:13:36'),
(53, NULL, 10, 17, 12331, 0, '2025-07-31', '2025-07-27 22:13:36', '2025-07-27 22:13:36'),
(55, 1, NULL, 18, 1111111, 1, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(56, 2, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(57, 3, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(58, 5, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(59, 6, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(60, 7, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(61, 8, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(62, 9, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(63, 10, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(66, 15, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(67, 16, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:31', '2025-07-27 22:18:31'),
(68, 17, NULL, 18, 1111111, 0, '2025-07-30', '2025-07-27 22:18:32', '2025-07-27 22:18:32'),
(70, 26, NULL, 18, 1111111, 1, '2025-07-30', '2025-07-27 22:18:32', '2025-07-27 22:18:32'),
(71, 1, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(72, 2, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(73, 3, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(74, 5, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(75, 6, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(76, 7, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(77, 8, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(78, 9, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(79, 10, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(80, 11, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(82, 15, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(83, 16, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(84, 17, NULL, 18, 1111111, 0, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(86, 26, NULL, 18, 1111111, 1, '2025-08-08', '2025-08-01 00:35:25', '2025-08-01 00:35:25'),
(90, NULL, 6, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(91, NULL, 7, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(92, NULL, 8, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(93, NULL, 9, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(94, NULL, 10, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(95, NULL, 13, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(96, NULL, 14, 17, 12331, 0, '2025-08-23', '2025-08-01 01:11:51', '2025-08-01 01:11:51'),
(97, NULL, 6, 17, 12331, 0, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(98, NULL, 7, 17, 12331, 0, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(99, NULL, 8, 17, 12331, 0, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(100, NULL, 9, 17, 12331, 0, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(101, NULL, 10, 17, 12331, 0, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(102, NULL, 13, 17, 12331, 1, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(103, NULL, 14, 17, 12331, 0, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40'),
(104, NULL, 15, 17, 12331, 1, '2025-08-08', '2025-08-01 01:28:40', '2025-08-01 01:28:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','siswa','staf','calon_siswa') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'staf',
  `auth_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `nama`, `email`, `email_verified_at`, `password`, `role`, `auth_key`, `created_at`, `updated_at`) VALUES
(1, 'staf', 'staf', 'staf@gmail.com', NULL, '$2y$12$MQKXHb/8KPi16bCEVIO2cuJos0yoiF2mbtuxHH5Va1Hqpp13abv2S', 'staf', NULL, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(4, 'calonuser3', 'Calon Siswa 3', 'calon3@mail.com', NULL, '$2y$12$6SBnLVWzqtqtTe1MrC5ZBOKfTxGD2aHoz7nIfINSot1seUd/zi036', 'calon_siswa', NULL, '2025-07-10 10:12:15', '2025-07-10 10:12:15'),
(5, 'calonuser4', 'Calon Siswa 4', 'calon4@mail.com', NULL, '$2y$12$O94T.SmX.h.nOa.lCXCpKuzcUp5Oswdr3FTO9jC8ALiko.CD8kQh6', 'calon_siswa', NULL, '2025-07-10 10:12:16', '2025-07-10 10:12:16'),
(7, 'calonuser6', 'Calon Siswa 6', 'calon6@mail.com', NULL, '$2y$12$TTP5SIRloNPiZsCT9..PoezLNEXjhWLDl5IemM6S/QVR1Og.E/lw2', 'calon_siswa', NULL, '2025-07-10 10:12:17', '2025-07-10 10:12:17'),
(8, 'calonuser7', 'Calon Siswa 7', 'calon7@mail.com', NULL, '$2y$12$ZOzKTp2yDGn7oh8YeuSFquDCIvdLbHLCrdI.wGCv5ZFGuG9ffxydS', 'calon_siswa', NULL, '2025-07-10 10:12:17', '2025-07-10 10:12:17'),
(9, 'calonuser8', 'Calon Siswa 8', 'calon8@mail.com', NULL, '$2y$12$q7VU9BWI5lanmsQp9/zYwekQsHy4i83zRSMT88amz2i1Zv5y1NbZG', 'calon_siswa', NULL, '2025-07-10 10:12:18', '2025-07-10 10:12:18'),
(10, 'calonuser9', 'Calon Siswa 9', 'calon9@mail.com', NULL, '$2y$12$AqJz/kDlnjOfeTBm9QvEXeQhiDbNhpL8CQY8XfB/.A063TMd4ZTIq', 'calon_siswa', NULL, '2025-07-10 10:12:18', '2025-07-10 10:12:18'),
(11, 'calonuser10', 'Calon Siswa 10', 'calon10@mail.com', NULL, '$2y$12$Z4z71d/37PUDRzeifEGxquFO1s1ttZ2V7LaqDRunEUrV5fXO9OWr2', 'calon_siswa', NULL, '2025-07-10 10:12:19', '2025-07-10 10:12:19'),
(12, 'siswauser1', 'Siswaaaaa', 'siswa1@mail.com', NULL, '$2y$12$gMXukIIZKD.a1EFbilM1mOHlhRKzh7ntqOLvoRqb8dGCqPI3eOjh2', 'siswa', NULL, '2025-07-10 10:12:19', '2025-07-20 05:52:15'),
(13, 'siswauser2', 'Siswa 2', 'siswa2@mail.com', NULL, '$2y$12$SA1MRP7rgm68A3BVjbY0Tu2eNob5F6ggL/g6W7eKrEP7wh2u.Oql2', 'siswa', NULL, '2025-07-10 10:12:20', '2025-07-10 10:12:20'),
(14, 'siswauser3', 'Siswa 3', 'siswa3@mail.com', NULL, '$2y$12$yiH6W9LH18hqpSLBqgo2buQ.lPmLJRlRV9TKi7Fp5k5gp5AjQPkqi', 'siswa', NULL, '2025-07-10 10:12:21', '2025-07-10 10:12:21'),
(15, 'siswauser4', 'Siswa 4', 'siswa4@mail.com', NULL, '$2y$12$FJNvagRiXSo9kr.PXLKvCOeUhcFUocVj0rjRW.gfESUxCO4LtyTsa', 'siswa', NULL, '2025-07-10 10:12:21', '2025-07-10 10:12:21'),
(16, 'siswauser5', 'Siswa 5', 'siswa5@mail.com', NULL, '$2y$12$b.ATkeFfRVj/bmH73jSWW.fmUyPfY99RRPI59GZ83pF0H0zPJwj4G', 'siswa', NULL, '2025-07-10 10:12:22', '2025-07-10 10:12:22'),
(17, 'siswauser6', 'Siswa 6', 'siswa6@mail.com', NULL, '$2y$12$HQ1kr2sKOuadutTLBpqoJ.f63XBfcSE1xaRRlM6UlD/wTzZHnNI2.', 'siswa', NULL, '2025-07-10 10:12:22', '2025-07-10 10:12:22'),
(18, 'siswauser7', 'Siswa 7', 'siswa7@mail.com', NULL, '$2y$12$AbUr/SnVYMSBhHyJFRLMNe8rXc97be0KJs6WjsycwzqTVwHuW/trC', 'siswa', NULL, '2025-07-10 10:12:23', '2025-07-10 10:12:23'),
(19, 'siswauser8', 'Siswa 8', 'siswa8@mail.com', NULL, '$2y$12$k7UQ1U2iFttG8xLAJFGZLOPbbpaO0een8dIOVTyX1jY2HQXwO7Mra', 'siswa', NULL, '2025-07-10 10:12:23', '2025-07-10 10:12:23'),
(20, 'siswauser9', 'Siswa 9', 'siswa9@mail.com', NULL, '$2y$12$.UDS8TWAasE2QxDrhAo2..wjZHR5enqD3YyI.Af4zaIWec5N/S/b.', 'siswa', NULL, '2025-07-10 10:12:24', '2025-07-10 10:12:24'),
(21, 'siswauser10', 'Siswa 10', 'siswa10@mail.com', NULL, '$2y$12$7Zn77JRg7ZGCK1PYSfgpSOi9cYbrOG39HevPMhCgns7qsdgAsQJoa', 'siswa', NULL, '2025-07-10 10:12:24', '2025-07-10 10:12:24'),
(22, 'siswauser11', 'Siswa 11', 'siswa11@mail.com', NULL, '$2y$12$4ICg3QfkgpaMRLX8tpcMV.Pl43OIYUXDi9SBXPyE7OteL6AmgtwnG', 'siswa', NULL, '2025-07-10 10:12:25', '2025-07-10 10:12:25'),
(23, 'siswauser12', 'Siswa 12', 'siswa12@mail.com', NULL, '$2y$12$hyX/xu6DdXlGbkb0AfNKo.ZI3p2HD4EKG38rqS3RmbPga5f4HviQW', 'siswa', NULL, '2025-07-10 10:12:25', '2025-07-10 10:12:25'),
(25, 'siswauser14', 'Siswa 14', 'siswa14@mail.com', NULL, '$2y$12$jpVmpsd1isPKqdTBCleOaulwz1TYfm8iOqd9ZhOlWlV7QJFoDtG2W', 'siswa', NULL, '2025-07-10 10:12:26', '2025-07-10 10:12:26'),
(26, 'siswauser15', 'Siswa 15', 'siswa15@mail.com', NULL, '$2y$12$M6SpciQfaWbipoN2IiIBjuzqYabCC4NVszVegQtfNIn0hWWgEna22', 'siswa', NULL, '2025-07-10 10:12:27', '2025-07-10 10:12:27'),
(27, 'siswauser16', 'Siswa 16', 'siswa16@mail.com', NULL, '$2y$12$E9VAliEtpLYuq1A.rk9SrOdDMw5MkdgEjkH0mfHXopg.LursBtgNa', 'siswa', NULL, '2025-07-10 10:12:27', '2025-07-10 10:12:27'),
(28, 'siswauser17', 'Siswa 17', 'siswa17@mail.com', NULL, '$2y$12$AYCFx1FSnIi3cgW9xT2XTe1pKp4GtBe8O6VRKI8q69IPOGlxl1tuu', 'siswa', NULL, '2025-07-10 10:12:28', '2025-07-10 10:12:28'),
(30, 'siswauser19', 'Siswa 19', 'siswa19@mail.com', NULL, '$2y$12$.s4cHag49WdtEHvj12tiSeMmM01B0yqggbAadeWxS4E5v1AOOjrZ6', 'siswa', NULL, '2025-07-10 10:12:30', '2025-07-10 10:12:30'),
(31, 'siswauser20', 'Siswa 20', 'siswa20@mail.com', NULL, '$2y$12$CWV8/BHL8HqWH2eSZDrT5.A/NuB9S///NRyeYLJB7kvfSMKF/A8Wu', 'siswa', NULL, '2025-07-10 10:12:31', '2025-07-10 10:12:31'),
(32, 'zxc', 'zxc', 'zxc@gmail.com', NULL, '$2y$12$e9uvzbKvVyqnRRHn763Q6eCv7liaut8E0tGQROiYZaVT6BHKBkPbu', 'calon_siswa', NULL, '2025-07-19 08:05:37', '2025-07-19 08:05:37'),
(33, 'sdsdd', 'sdsdd', 'aa@gmail.com', NULL, '$2y$12$uUgGx48p10SpvKQ7yWq5mutBhCuMXfNS9tCkiJ5mI563ZTEpm4LQa', 'staf', NULL, '2025-07-19 08:06:49', '2025-07-19 08:07:10'),
(34, 'aaazzzz', 'aaazzzz', 'aaazzzz@gmail.com', NULL, '$2y$12$4rNPK0J3y79RxVq7sGDO1exR6pW9Of57f1pNH/jCECe6U.0/GiBXG', 'staf', NULL, '2025-07-19 08:07:34', '2025-07-19 08:07:34'),
(35, 'uts gasal', 'uts gasal', 'uts gasal@gmail.com', NULL, '$2y$12$yZH4ToRZkhZmfC/sRvc9O.e/.ErRxba9kYPR4r232hlJpkUklBzTS', 'calon_siswa', NULL, '2025-07-19 08:08:11', '2025-07-19 08:08:11'),
(36, 'zzz', 'zzz', 'zzz@gmail.com', NULL, '$2y$12$vNThq2pAjI2lBFJer0C6J.MAU6J9sjLQEC9lz0x6UjGeZYHSpXLHe', 'siswa', NULL, '2025-07-19 08:08:39', '2025-07-19 08:08:39'),
(37, 'aasssa', 'aasssa', 'aasssa@gmail.com', NULL, '$2y$10$ZvYkAObTBtjQRxN9BKXfY.AGQUSUwhN1yDAxN8fSGr3/E5qYydEWu', 'siswa', NULL, NULL, NULL),
(38, 'matien', 'matien', 'matien@gmail.com', NULL, '$2y$10$DHrSyv.8n6J4R2d7GyVEIOP1AXefNCOWeqXwTspRiIsdcS20dQQum', 'siswa', NULL, NULL, NULL),
(39, 'aac', 'aac', 'aac@gmail.com', NULL, '$2y$13$w7SGsupvUczoHGJBmFJlQeeTA0PFRJBKqiEB6QzmefMA0S0KEynEq', 'siswa', NULL, '2025-07-20 00:59:55', '2025-07-20 00:59:55'),
(41, 'pp', 'ppp', 'p@gmail.com', NULL, '$2y$13$3RBBSNgbZzaQzOU1HuKheu6aQ1w8q969Xeuxh589.6zkquzIJbq3W', 'staf', NULL, '2025-07-20 09:48:32', '2025-07-20 09:48:32'),
(44, 'REG11112', 'azzzzzz', 'aaasss@gmail.com', NULL, '$2y$13$z0RSNWc91F7NIn8TiyPBQOcBSPbufAoY4KlRJIvfGAgpaBsHY.Raq', 'siswa', NULL, '2025-07-20 12:30:38', '2025-07-20 23:52:10'),
(45, '1233', 'xczc', 'xczc@gmail.com', NULL, '$2y$13$BYQ/XtpSGYjYHoOtSkVcVuv5fzl5sd9GPnUHG6KEe.uVktS5Zk6t6', 'siswa', NULL, '2025-07-24 19:46:43', '2025-07-24 19:46:43'),
(46, 'REG4444', 'gghfgh', 'gghfgh@gmail.com', NULL, '$2y$13$gbiN/PqZDXBHh.VOeD31QOz2qLkT78Kpf4yGrC.YRPOzkG2H1O.2m', 'siswa', NULL, '2025-07-27 22:38:40', '2025-07-27 22:38:40'),
(48, 'admin', 'admin', 'admin@gmail.com', NULL, '$2y$12$MQKXHb/8KPi16bCEVIO2cuJos0yoiF2mbtuxHH5Va1Hqpp13abv2S', 'admin', NULL, '2025-07-10 10:12:13', '2025-07-10 10:12:13'),
(49, 'REG121', 'pp', 'pp@gmail.com', NULL, '$2y$13$fsiJICddievrnLTt4PcLD.WZPEIqoE9QQY3TlYR/lejw8ImF3WzHe', 'siswa', NULL, '2025-08-01 01:25:09', '2025-08-01 01:25:09');

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
-- Indexes for table `calon_siswa`
--
ALTER TABLE `calon_siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `calon_siswa_user_id_foreign` (`user_id`),
  ADD KEY `calon_siswa_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_jurusan_id_foreign` (`jurusan_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nama_pembayaran`
--
ALTER TABLE `nama_pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_tagihan_id_foreign` (`tagihan_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_user_id_foreign` (`user_id`),
  ADD KEY `siswa_kelas_id_foreign` (`kelas_id`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tagihan_siswa_id_foreign` (`siswa_id`),
  ADD KEY `tagihan_calon_siswa_id_foreign` (`calon_siswa_id`),
  ADD KEY `tagihan_jenis_pembayaran_id_foreign` (`jenis_pembayaran_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calon_siswa`
--
ALTER TABLE `calon_siswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `nama_pembayaran`
--
ALTER TABLE `nama_pembayaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calon_siswa`
--
ALTER TABLE `calon_siswa`
  ADD CONSTRAINT `calon_siswa_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `calon_siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_jurusan_id_foreign` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_tagihan_id_foreign` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_kelas_id_foreign` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_calon_siswa_id_foreign` FOREIGN KEY (`calon_siswa_id`) REFERENCES `calon_siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tagihan_jenis_pembayaran_id_foreign` FOREIGN KEY (`jenis_pembayaran_id`) REFERENCES `jenis_pembayaran` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tagihan_siswa_id_foreign` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
