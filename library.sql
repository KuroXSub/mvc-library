-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 02, 2025 at 05:57 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(100) NOT NULL,
  `kategori_id` int NOT NULL,
  `tahun_terbit` year NOT NULL,
  `stok` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `judul`, `penulis`, `kategori_id`, `tahun_terbit`, `stok`, `created_at`) VALUES
(1, 'Belajar PHP dari Dasar', 'John Doe', 1, 2020, 9, '2025-03-01 02:23:46'),
(2, 'Pemrograman Web Modern', 'Jane Smith', 1, 2021, 5, '2025-03-01 02:23:46'),
(3, 'Harry Potter dan Batu Bertuah', 'J.K. Rowling', 2, 1997, 8, '2025-03-01 02:23:46'),
(4, 'The Lean Startup', 'Eric Ries', 5, 2011, 7, '2025-03-01 02:23:46'),
(5, 'Sejarah Dunia yang Disembunyikan', 'Jonathan Black', 5, 2015, 3, '2025-03-01 02:23:46'),
(70, 'Dasar-Dasar Python', 'Alice Johnson', 1, 2019, 12, '2025-03-02 02:46:37'),
(88, 'Algoritma dan Struktur Data', 'Bob Williams', 1, 2022, 6, '2025-03-02 02:48:28'),
(89, 'Laskar Pelangi', 'Andrea Hirata', 2, 2005, 15, '2025-03-02 02:48:28'),
(90, 'Bumi Manusia', 'Pramoedya Ananta Toer', 2, 1980, 9, '2025-03-02 02:48:28'),
(91, 'Sapiens: Riwayat Singkat Umat Manusia', 'Yuval Noah Harari', 3, 2014, 11, '2025-03-02 02:48:28'),
(92, 'Atomic Habits', 'James Clear', 3, 2018, 8, '2025-03-02 02:48:28'),
(93, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 4, 1997, 10, '2025-03-02 02:48:28'),
(94, 'The 7 Habits of Highly Effective People', 'Stephen R. Covey', 4, 1989, 7, '2025-03-02 02:48:28'),
(95, 'Sejarah Indonesia Modern', 'MC Ricklefs', 5, 2001, 5, '2025-03-02 02:48:28'),
(96, 'Perang Dunia II', 'Antony Beevor', 5, 2012, 4, '2025-03-02 02:48:28'),
(117, 'Pride and Prejudice', 'Jane Austen', 10, 1901, 15, '2025-03-02 02:50:23'),
(118, 'The Notebook', 'Nicholas Sparks', 10, 1996, 9, '2025-03-02 02:50:23'),
(119, 'The Hobbit', 'J.R.R. Tolkien', 11, 1937, 13, '2025-03-02 02:50:23'),
(120, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 11, 1997, 10, '2025-03-02 02:50:23'),
(121, 'The Adventures of Sherlock Holmes', 'Arthur Conan Doyle', 12, 1901, 8, '2025-03-02 02:50:23'),
(122, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 12, 2005, 7, '2025-03-02 02:50:23'),
(123, 'Mayo Clinic Diet', 'Mayo Clinic', 13, 2010, 11, '2025-03-02 02:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`, `created_at`) VALUES
(1, 'Pemrograman', '2025-03-01 02:23:45'),
(2, 'Fiksi', '2025-03-01 02:23:45'),
(3, 'Non-Fiksi', '2025-03-01 02:23:45'),
(4, 'Bisnis', '2025-03-01 02:23:45'),
(5, 'Sejarah', '2025-03-01 02:23:45'),
(10, 'Sains', '2025-03-02 00:56:31'),
(11, 'Teknologi', '2025-03-02 00:56:31'),
(12, 'Matematika', '2025-03-02 00:56:31'),
(13, 'Komedi', '2025-03-02 00:56:31'),
(14, 'Horor', '2025-03-02 00:56:31'),
(15, 'Romansa', '2025-03-02 00:56:31'),
(16, 'Fantasi', '2025-03-02 00:56:31'),
(17, 'Petualangan', '2025-03-02 00:56:31'),
(18, 'Misteri', '2025-03-02 00:56:31'),
(19, 'Kesehatan', '2025-03-02 00:56:31'),
(20, 'Psikologi', '2025-03-02 00:56:31'),
(21, 'Filosofi', '2025-03-02 00:56:31'),
(22, 'Kuliner', '2025-03-02 00:56:31'),
(23, 'Olahraga', '2025-03-02 00:56:31'),
(24, 'Seni', '2025-03-02 00:56:31'),
(25, 'Musik', '2025-03-02 00:56:31'),
(26, 'Fotografi', '2025-03-02 00:56:31'),
(27, 'Desain', '2025-03-02 00:56:31'),
(28, 'Arsitektur', '2025-03-02 00:56:31'),
(29, 'Lingkungan', '2025-03-02 00:56:31');

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jurusan` varchar(50) NOT NULL,
  `alamat` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nim`, `nama`, `jurusan`, `alamat`, `created_at`) VALUES
(1, '10118001', 'Andi Wijaya', 'Teknik Informatika', 'Jl. Merdeka No. 10, Bandung', '2025-03-01 02:23:45'),
(2, '10118002', 'Budi Santoso', 'Sistem Informasi', 'Jl. Pahlawan No. 5, Jakarta', '2025-03-01 02:23:45'),
(3, '10118003', 'Citra Lestari', 'Manajemen', 'Jl. Sudirman No. 15, Surabaya', '2025-03-01 02:23:45'),
(4, '10118004', 'Dewi Kusuma', 'Akuntansi', 'Jl. Gatot Subroto No. 20, Yogyakarta', '2025-03-01 02:23:45'),
(5, '10118005', 'Eko Prasetyo', 'Hukum', 'Jl. Diponegoro No. 25, Semarang', '2025-03-01 02:23:45'),
(9, '10118006', 'Fajar Nugroho', 'Teknik Mesin', 'Jl. Thamrin No. 30, Medan', '2025-03-02 03:58:32'),
(10, '10118007', 'Gita Cahyani', 'Psikologi', 'Jl. Hasanuddin No. 35, Makassar', '2025-03-02 03:58:32'),
(11, '10118008', 'Hendra Setiawan', 'Arsitektur', 'Jl. Pattimura No. 40, Palembang', '2025-03-02 03:58:32'),
(12, '10118009', 'Indah Permata', 'Kedokteran', 'Jl. Udayana No. 45, Denpasar', '2025-03-02 03:58:32'),
(13, '10118010', 'Joko Susilo', 'Matematika', 'Jl. Gajah Mada No. 50, Banjarmasin', '2025-03-02 03:58:32'),
(14, '10118011', 'Kartika Dewi', 'Fisika', 'Jl. Ahmad Yani No. 55, Pontianak', '2025-03-02 03:58:32'),
(15, '10118012', 'Lukman Hakim', 'Kimia', 'Jl. Teuku Umar No. 60, Bandar Lampung', '2025-03-02 03:58:32'),
(16, '10118013', 'Maya Sari', 'Biologi', 'Jl. Sultan Hasanuddin No. 65, Manado', '2025-03-02 03:58:32'),
(17, '10118014', 'Nanda Putra', 'Statistika', 'Jl. Jenderal Sudirman No. 70, Jayapura', '2025-03-02 03:58:32'),
(18, '10118015', 'Olivia Putri', 'Geografi', 'Jl. Imam Bonjol No. 75, Ambon', '2025-03-02 03:58:32'),
(19, '10118016', 'Pandu Pratama', 'Sosiologi', 'Jl. Pangeran Antasari No. 80, Palangkaraya', '2025-03-02 03:58:32'),
(20, '10118017', 'Qori Aisyah', 'Antropologi', 'Jl. KH. Ahmad Dahlan No. 85, Mataram', '2025-03-02 03:58:32'),
(21, '10118018', 'Rizky Maulana', 'Ilmu Politik', 'Jl. WR. Supratman No. 90, Kendari', '2025-03-02 03:58:32'),
(22, '10118019', 'Siti Rahayu', 'Ilmu Komunikasi', 'Jl. Raya Puputan No. 95, Kupang', '2025-03-02 03:58:32'),
(23, '10118020', 'Taufik Hidayat', 'Sastra Inggris', 'Jl. Cendrawasih No. 100, Sorong', '2025-03-02 03:58:32'),
(24, '10118021', 'Umar Faruq', 'Sastra Indonesia', 'Jl. Nusantara No. 105, Ternate', '2025-03-02 03:58:32'),
(25, '10118022', 'Vina Amelia', 'Sastra Jepang', 'Jl. Maluku No. 110, Gorontalo', '2025-03-02 03:58:32'),
(26, '10118023', 'Wawan Setiawan', 'Sastra Arab', 'Jl. Sulawesi No. 115, Mamuju', '2025-03-02 03:58:32'),
(27, '10118024', 'Xena Febriani', 'Sastra Prancis', 'Jl. Kalimantan No. 120, Tanjung Selor', '2025-03-02 03:58:32'),
(28, '10118025', 'Yusuf Ramadhan', 'Sastra Jerman', 'Jl. Sumatera No. 125, Bengkulu', '2025-03-02 03:58:32');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int NOT NULL,
  `mahasiswa_id` int NOT NULL,
  `buku_id` int NOT NULL,
  `petugas_id` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') DEFAULT 'dipinjam',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `mahasiswa_id`, `buku_id`, `petugas_id`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `created_at`) VALUES
(1, 1, 1, 2, '2023-10-01', '2023-10-08', 'dikembalikan', '2025-03-01 02:23:46'),
(2, 2, 3, 3, '2023-10-02', NULL, 'dipinjam', '2025-03-01 02:23:46'),
(3, 3, 2, 2, '2023-10-03', '2023-10-10', 'dikembalikan', '2025-03-01 02:23:46'),
(4, 4, 4, 3, '2023-10-04', NULL, 'dipinjam', '2025-03-01 02:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalian`
--

CREATE TABLE `pengembalian` (
  `id` int NOT NULL,
  `peminjaman_id` int NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `denda` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengembalian`
--

INSERT INTO `pengembalian` (`id`, `peminjaman_id`, `tanggal_kembali`, `denda`, `created_at`) VALUES
(1, 1, '2023-10-08', '0.00', '2025-03-01 02:23:46'),
(2, 3, '2023-10-10', '6004.00', '2025-03-01 02:23:46');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `nama`, `username`, `password`, `created_at`) VALUES
(1, 'Admin Utama', 'admin', '240be518fabd2724ddb6f04eeb1da5967448d7e831c08c8fa822809f74c720a9', '2025-03-01 10:26:30'),
(2, 'Petugas 1', 'petugas1', '2dad904f71aa0dcf6ea1addaa084a5865ffe448e4d3f900668e1cc7e7b6153d7', '2025-03-01 02:23:46'),
(3, 'Petugas 2', 'petugas2', '2dad904f71aa0dcf6ea1addaa084a5865ffe448e4d3f900668e1cc7e7b6153d7', '2025-03-01 02:23:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nim` (`nim`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`),
  ADD KEY `buku_id` (`buku_id`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indexes for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `peminjaman_id` (`peminjaman_id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `pengembalian`
--
ALTER TABLE `pengembalian`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`buku_id`) REFERENCES `buku` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_3` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`);

--
-- Constraints for table `pengembalian`
--
ALTER TABLE `pengembalian`
  ADD CONSTRAINT `pengembalian_ibfk_1` FOREIGN KEY (`peminjaman_id`) REFERENCES `peminjaman` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
