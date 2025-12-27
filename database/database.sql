-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 17, 2025 lúc 12:08 PM
-- Phiên bản máy phục vụ: 10.3.39-MariaDB-cll-lve
-- Phiên bản PHP: 8.3.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `gtaphoatoolcom_vnuk`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cart_status` enum('active','ordered') NOT NULL DEFAULT 'active',
  `is_active` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `cart_status`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'ordered', NULL, '2025-12-17 11:57:51', '2025-12-17 11:58:11'),
(2, 1, 'ordered', NULL, '2025-12-17 11:58:11', '2025-12-17 11:59:01'),
(3, 1, 'ordered', NULL, '2025-12-17 11:59:01', '2025-12-17 11:59:36'),
(4, 1, 'ordered', NULL, '2025-12-17 11:59:36', '2025-12-17 12:06:12'),
(5, 1, 'active', 1, '2025-12-17 12:06:12', '2025-12-17 12:06:12');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `unit_price`, `created_at`) VALUES
(1, 1, 3, 2, 12000.00, '2025-12-17 11:57:51'),
(3, 1, 1, 2, 15000.00, '2025-12-17 11:58:00'),
(5, 1, 2, 2, 16000.00, '2025-12-17 11:58:02'),
(7, 2, 2, 1, 16000.00, '2025-12-17 11:58:53'),
(8, 2, 3, 1, 12000.00, '2025-12-17 11:58:54'),
(9, 3, 3, 2, 12000.00, '2025-12-17 11:59:26'),
(10, 3, 2, 2, 16000.00, '2025-12-17 11:59:27'),
(11, 3, 1, 2, 15000.00, '2025-12-17 11:59:27'),
(15, 4, 2, 2, 16000.00, '2025-12-17 12:04:50');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`) VALUES
(1, 'Sneakers', 'sneakers', '2025-12-17 04:56:27'),
(2, 'Accessories', 'accessories', '2025-12-17 04:56:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_code` varchar(30) NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` varchar(255) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `shipping_fee` decimal(12,2) DEFAULT 0.00,
  `discount` decimal(12,2) DEFAULT 0.00,
  `total` decimal(12,2) NOT NULL,
  `payment_method` enum('cod','bank','momo') DEFAULT 'cod',
  `payment_status` enum('unpaid','paid') DEFAULT 'unpaid',
  `order_status` enum('pending','confirmed','shipping','done','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cart_id`, `order_code`, `full_name`, `phone`, `address`, `note`, `subtotal`, `shipping_fee`, `discount`, `total`, `payment_method`, `payment_status`, `order_status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'OD20251217-2406', 'Nhật Hoàng Lê', '0376624457', 'Thị Trấn Hà Lam', 'MB BANK Chuyen Khoan', 86000.00, 0.00, 0.00, 86000.00, 'cod', 'paid', 'done', '2025-12-17 11:58:11', '2025-12-17 11:58:45'),
(2, 1, 2, 'OD20251217-4545', 'LE DINH NHAT HUY', '0376624457', 'Thị Trấn Hà Lam', 'MB BANK Chuyen Khoan', 28000.00, 0.00, 0.00, 28000.00, 'cod', 'paid', 'done', '2025-12-17 11:59:01', '2025-12-17 11:59:17'),
(3, 1, 3, 'OD20251217-8019', 'LE DINH NHAT HUY', '0376624457', 'Thị Trấn Hà Lam', 'ccc', 86000.00, 0.00, 0.00, 86000.00, 'cod', 'unpaid', 'confirmed', '2025-12-17 11:59:36', '2025-12-17 12:06:31'),
(4, 1, 4, 'OD20251217-1511', 'Nhật Hoàng Lê', '0376624457', 'Thị Trấn Hà Lam', 'MB BANK Chuyen Khoan', 32000.00, 0.00, 0.00, 32000.00, 'cod', 'unpaid', 'done', '2025-12-17 12:06:12', '2025-12-17 12:06:22');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(180) NOT NULL,
  `unit_price` decimal(12,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `line_total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `unit_price`, `quantity`, `line_total`) VALUES
(1, 1, 2, 'MilkBite Chocolate 50g', 16000.00, 2, 32000.00),
(2, 1, 1, 'MilkBite Original 50g', 15000.00, 2, 30000.00),
(3, 1, 3, 'Fresh Milk 180ml', 12000.00, 2, 24000.00),
(4, 2, 3, 'Fresh Milk 180ml', 12000.00, 1, 12000.00),
(5, 2, 2, 'MilkBite Chocolate 50g', 16000.00, 1, 16000.00),
(6, 3, 1, 'MilkBite Original 50g', 15000.00, 2, 30000.00),
(7, 3, 2, 'MilkBite Chocolate 50g', 16000.00, 2, 32000.00),
(8, 3, 3, 'Fresh Milk 180ml', 12000.00, 2, 24000.00),
(9, 4, 2, 'MilkBite Chocolate 50g', 16000.00, 2, 32000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `sale_price`, `stock`, `thumbnail`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'MilkBite Original 50g', 'milkbite-original-50g', 'Demo product', 15000.00, NULL, 100, 'uploads/p1.png', 1, '2025-12-17 04:56:27', '2025-12-17 04:56:27'),
(2, 1, 'MilkBite Chocolate 50g', 'milkbite-choco-50g', 'Demo product', 16000.00, NULL, 100, 'uploads/p2.png', 1, '2025-12-17 04:56:27', '2025-12-17 04:56:27'),
(3, 2, 'Fresh Milk 180ml', 'fresh-milk-180ml', 'Demo product', 12000.00, NULL, 200, 'uploads/p3.png', 1, '2025-12-17 04:56:27', '2025-12-17 04:56:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `phone`, `password_hash`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'LE DINH NHAT HUY', 'admin@admin.com', '0376624457', '$2y$10$LvAc7gVi4xmxB7z5GNd7qunIUPRGcwh410WdP03NQYZqRO5nQbzc2', 'admin', 1, '2025-12-17 11:57:41', '2025-12-17 11:58:27');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_user_active_cart` (`user_id`,`is_active`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_cart_product` (`cart_id`,`product_id`),
  ADD KEY `fk_cart_items_product` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_code` (`order_code`),
  ADD KEY `fk_orders_user` (`user_id`),
  ADD KEY `fk_orders_cart` (`cart_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_items_order` (`order_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `fk_carts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`),
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
