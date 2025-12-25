-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Des 2025 pada 07.46
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `neat_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_log`
--

CREATE TABLE `login_log` (
  `login_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login_log`
--

INSERT INTO `login_log` (`login_id`, `user_id`, `login_time`, `logout_time`, `ip_address`) VALUES
(1, 2, '2025-12-07 16:54:13', '2025-12-07 17:30:44', '::1'),
(2, 2, '2025-12-07 17:30:54', NULL, '::1'),
(3, 2, '2025-12-21 09:06:30', '2025-12-21 10:14:32', '::1'),
(4, 2, '2025-12-21 16:53:17', '2025-12-21 16:56:30', '::1'),
(5, 2, '2025-12-21 16:56:38', '2025-12-21 16:57:58', '::1'),
(6, 2, '2025-12-21 16:58:06', '2025-12-21 17:05:30', '::1'),
(7, 2, '2025-12-21 17:05:51', NULL, '::1'),
(8, 2, '2025-12-22 16:36:31', NULL, '::1'),
(9, 2, '2025-12-23 13:50:58', NULL, '::1'),
(10, 2, '2025-12-23 20:01:49', NULL, '::1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` int(11) NOT NULL DEFAULT 0,
  `status` enum('Pending','Paid','Canceled') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `total_price`, `status`) VALUES
(1, 2, '2025-12-21 09:07:02', 70000, 'Pending'),
(2, 2, '2025-12-21 09:07:06', 70000, 'Pending'),
(3, 2, '2025-12-21 09:08:08', 70000, 'Pending'),
(4, 2, '2025-12-21 09:10:48', 140000, 'Pending'),
(5, 2, '2025-12-21 09:23:15', 71000, 'Pending'),
(6, 2, '2025-12-21 09:26:24', 28000, 'Pending'),
(7, 2, '2025-12-23 14:23:00', 105000, 'Pending'),
(8, 2, '2025-12-23 15:48:26', 42000, 'Pending'),
(9, 2, '2025-12-23 15:52:09', 77000, 'Pending'),
(10, 2, '2025-12-23 16:46:07', 115000, 'Pending'),
(11, 2, '2025-12-23 20:02:02', 70000, 'Pending'),
(12, 2, '2025-12-23 20:10:07', 70000, 'Pending'),
(13, 2, '2025-12-23 20:21:21', 126000, 'Pending'),
(14, 2, '2025-12-24 05:37:20', 70000, ''),
(15, 2, '2025-12-24 05:42:12', 100000, ''),
(16, 2, '2025-12-24 05:46:31', 100000, 'Pending'),
(17, 2, '2025-12-24 05:49:19', 100000, 'Paid'),
(18, 2, '2025-12-24 05:59:34', 100000, 'Paid'),
(19, 2, '2025-12-24 06:05:41', 100000, 'Paid'),
(20, 2, '2025-12-24 06:15:25', 135000, 'Paid'),
(21, 2, '2025-12-24 06:16:17', 135000, 'Paid'),
(22, 2, '2025-12-24 06:17:05', 135000, 'Paid'),
(23, 2, '2025-12-24 06:18:55', 135000, 'Paid'),
(24, 2, '2025-12-24 06:33:20', 35000, 'Paid'),
(25, 2, '2025-12-24 06:45:16', 35000, 'Paid');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(25, 20, 1, 1, 35000),
(27, 21, 1, 1, 35000),
(29, 22, 1, 1, 35000),
(31, 23, 1, 1, 35000),
(33, 24, 1, 1, 35000),
(34, 25, 1, 1, 35000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `method` enum('Cash','qris','ShopeePay','Dana','Ovo','GoPay','VA_BCA','VA_BRI','VA_Mandiri','VA_BNI','VA_BSI','VA_PERMATA','VA_CIMB','VA_OTHER') NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Success','Failed','Pending') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`payment_id`, `order_id`, `user_id`, `amount`, `method`, `payment_date`, `status`) VALUES
(1, 1, 2, 70000, 'Cash', '2025-12-21 09:07:02', 'Pending'),
(2, 2, 2, 70000, 'Cash', '2025-12-21 09:07:06', 'Pending'),
(3, 3, 2, 70000, 'Cash', '2025-12-21 09:08:08', 'Pending'),
(4, 5, 2, 71000, 'Cash', '2025-12-21 09:23:15', 'Pending'),
(5, 6, 2, 28000, 'Cash', '2025-12-21 09:26:24', 'Pending'),
(6, 7, 2, 105000, 'Cash', '2025-12-23 14:23:00', 'Pending'),
(7, 9, 2, 77000, 'Cash', '2025-12-23 15:52:09', 'Pending'),
(8, 10, 2, 115000, 'Cash', '2025-12-23 16:46:07', 'Pending'),
(9, 11, 2, 70000, 'Cash', '2025-12-23 20:02:02', 'Pending'),
(10, 12, 2, 70000, 'Cash', '2025-12-23 20:10:07', 'Pending'),
(11, 13, 2, 126000, 'Cash', '2025-12-23 20:21:21', 'Pending'),
(12, 14, 2, 70000, 'qris', '2025-12-24 05:37:20', ''),
(13, 15, 2, 100000, 'qris', '2025-12-24 05:42:12', ''),
(14, 16, 2, 100000, 'qris', '2025-12-24 05:46:31', 'Pending'),
(15, 24, 2, 35000, 'qris', '2025-12-24 06:33:20', ''),
(16, 25, 2, 35000, 'qris', '2025-12-24 06:45:16', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category` varchar(50) NOT NULL DEFAULT 'main'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image_url`, `is_best_seller`, `created_at`, `updated_at`, `category`) VALUES
(1, 'Breakfast Bowl', 'Sarapan sehat dengan sayur, telur, dan nasi hangat.', 35000, 'image/Ricebowl.jpg', 1, '2025-12-24 05:59:11', '2025-12-24 05:59:11', 'main'),
(2, 'Chicken Sandwich', 'Roti lapis ayam gurih, segar, dan lembut.', 42000, 'image/Sandwich.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 05:59:11', 'main'),
(3, 'Chicken Steak', 'Steak ayam panggang dengan saus spesial.', 50000, 'image/Steak.jpg', 1, '2025-12-24 05:59:11', '2025-12-24 05:59:11', 'main'),
(4, 'Mix Platter', 'Campuran snack favorit keluarga.', 28000, 'image/Mix.jpg', 1, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'snack'),
(5, 'Cookies', 'Kue kering manis dan renyah.', 15000, 'image/Cookies.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'snack'),
(6, 'French Fries', 'Kentang goreng renyah, cocok untuk teman minum kopi.', 20000, 'image/Kentang.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'snack'),
(7, 'Coffee Latte Hot', 'Kopi susu hangat dengan busa lembut.', 25000, 'image/Late.jpg', 1, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'coffee'),
(8, 'Cappuccino', 'Kopi klasik dengan sentuhan foam cappuccino.', 25000, 'image/Capucino.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'coffee'),
(9, 'Americano', 'Kopi hitam original, aroma kuat.', 22000, 'image/Americano.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'coffee'),
(10, 'Chocolate Milk', 'Susu cokelat manis dan creamy.', 28000, 'image/Choclate.jpg', 1, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'milk'),
(11, 'Matcha Milk', 'Susu hijau matcha asli Jepang.', 30000, 'image/Matcha.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'milk'),
(12, 'Strawberry Milk', 'Susu strawberry segar dengan rasa manis alami.', 28000, 'image/Strawbery.jpg', 0, '2025-12-24 05:59:11', '2025-12-24 06:30:31', 'milk');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `phone`, `role`, `created_at`) VALUES
(1, 'ahnaf', 'ahnaf@gmail.com', '202cb962ac59075b964b07152d234b70', NULL, 'admin', '2025-12-05 18:19:47'),
(2, 'risky', 'risky@com', '$2y$10$12BbE0tywLxLS.mNOKTmk.kNFACT1pUmr6H13dx.WomMZkxxvGXXG', NULL, 'user', '2025-12-07 16:53:50');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `login_log`
--
ALTER TABLE `login_log`
  ADD PRIMARY KEY (`login_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `login_log`
--
ALTER TABLE `login_log`
  MODIFY `login_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `login_log`
--
ALTER TABLE `login_log`
  ADD CONSTRAINT `login_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
