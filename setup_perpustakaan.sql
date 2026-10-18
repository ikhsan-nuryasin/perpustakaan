e-- Perpustakaan Digital v2.0 - Fresh Database Setup
-- Run this in phpMyAdmin or mysql CLI: mysql -u root -p < setup_perpustakaan.sql
-- Default login: admin / admin123

DROP DATABASE IF EXISTS `perpustakaan_digital`;
CREATE DATABASE `perpustakaan_digital` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `perpustakaan_digital`;

-- Users table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) DEFAULT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','petugas','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Books table
CREATE TABLE `buku` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `penulis` varchar(255) NOT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `cover` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `judul` (`judul`),
  KEY `stok` (`stok`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Loans table
CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `tanggal_kembali_real` datetime DEFAULT NULL,
  `status` enum('menunggu_konfirmasi','dipinjam','dikembalikan') NOT NULL DEFAULT 'menunggu_konfirmasi',
  `rating_status` enum('belum','sudah') NOT NULL DEFAULT 'belum',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `buku_id` (`buku_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Ratings table
CREATE TABLE `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `buku_id` int(11) NOT NULL,
  `rating` tinyint(1) NOT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
  `komentar` text,
  `tanggal` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `buku_id` (`buku_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin
INSERT INTO `users` (`username`, `email`, `password`, `role`) VALUES 
('admin', 'admin@perpustakaan.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
-- Password: admin123 (bcrypt)

-- Sample books
INSERT INTO `buku` (`judul`, `penulis`, `penerbit`, `tahun`, `stok`, `cover`) VALUES
('PHP Modern', 'BLACKBOXAI', 'XAMPP Press', 2024, 5, 'default-cover.jpg'),
('MySQL Advanced', 'Root User', 'Oracle', 2023, 3, 'default-cover.jpg');

-- Success message
SELECT 'Database setup complete! Login: admin/admin123' as message;
