-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 26, 2025 lúc 09:10 PM
-- Phiên bản máy phục vụ: 10.11.14-MariaDB-cll-lve
-- Phiên bản PHP: 8.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `toataikhoanvn_ad`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `image`, `content`, `status`, `created_at`) VALUES
(6, 'Portuguese label Ementa makes its Paris debut', 'hello-1', '1766529784_1956.jpg', 'Just a stone\'s throw from the bustle of Paris\' Les Halles, Ementa’s new boutique at 11, rue Montmartre gleams in green. The brand, \'driven by friendship,\' has been revealing itself there, beyond its stained-glass doorway, since its official opening on December 6. It marks a new milestone for founders Emídio Silva, Nikita Gorev, and Raphael Castilho, whose adventure began amid Portugal’s markets.\r\nBorn directly from the skateboarding world, Ementa launched in 2007. The three friends, then students at Academia da Amadora near Lisbon, shared the dream of creating their own label, inspired by the sponsor pieces from their sporting circle. They knew little about running a business, but that didn’t stop them. They took out a loan and financed production of their first thousand T-shirts.\r\nA retail turning point beginning in 2021\r\n\r\nBy 2021, time had passed, but Ementa remained active. That year, an opportunity arose to open its first boutique at LX Factory in the Portuguese capital. The shop was fitted out almost entirely in the DIY spirit cherished by its founders. Around six months later, Ementa opened a second brick-and-mortar shop on Rua da Boavista, near Cais do Sodré, again in Lisbon.\r\nThe third shop opened in 2023: Ementa’s flagship in Chiado, a lively district in southern Lisbon. \'This project represented a far greater challenge than the previous ones,\" the brand notes. \"In 2024, we opened a boutique dedicated to collaborations with artists and exclusive collections, located right next to our first boutique at LX Factory,\" it continues. The time then seemed ripe for Ementa to venture beyond the capital. On August 10, 2024, it inaugurated its fifth boutique, on Rua Sá da Bandeira in Porto- a \'major challenge\' for the brand.\r\nA mid-range positioning\r\nThis retail journey culminates today with the Paris opening. The brand also works with 27 stockists in total, including seven in France, one in Italy, two in Germany, and two in the Netherlands, with the remainder in Portugal. Its products are therefore available in several European countries. \"Our aim is to be represented by avant-garde stockists with a sophisticated image and clear objectives,\" says the brand.\r\nDrawing on its skateboarding heritage, the Portuguese brand’s offer spans a wide range of ready-to-wear pieces, including jackets, jumpers, screen-printed sweatshirts and T-shirts, cropped polo shirts, corduroy trousers, jeans, and accessories. As a lifestyle brand, Ementa also offers plenty of scarves, socks, sunglasses, caps, a few pieces of jewellery, and bags. Its prices sit below those of brands such as Palace Skateboards and Drôle de Monsieur, even though the majority of its production takes place in northern Portugal.\r\n\r\nEmenta now aims to maintain a rhythm of a drop every fortnight, to bridge the gap between its autumn-winter and spring-summer collections. The brand hopes to continue its retail adventure with new openings, strengthening its existing boutiques, and international expansion.', 1, '2025-12-24 05:43:04'),
(7, 'Rag & Bone names Swaim Hutson head of menswear design', 'hello-2', '1766530373_3204.jpg', 'The upcoming January edition of Pitti Uomo will mark Swaim Hutson’s debut as head of menswear design at Rag & Bone, unveiling his first collection for the New York-based brand for the autumn/ winter 2026–27 season.\r\n\"Rag & Bone has always stood for authenticity and innovation,\" Hutson commented. \"I want to build on these values, creating menswear that is both enduring and immediate, capable of expressing the spirit of New York and engaging with a global audience.\"\r\n\r\nHutson brings nearly two decades of experience in international menswear to the role. After founding Obedient Sons in New York- a CFDA/ Vogue Fashion Fund finalist- he held creative director roles at 3.1 Phillip Lim, Club Monaco, and Generra. He later launched The Academy New York, a label that has established itself within the fashion, art, and music communities.\r\n\r\n\"Swaim brings an innovative vision of creativity and craftsmanship, strengthening the essence of the brand: the elegance of British tailoring combined with the authenticity of American sportswear,\" said Andrew Rosen, executive chairman of Rag & Bone.', 1, '2025-12-24 05:52:53'),
(8, 'Six Stories is expanding at pace so looks for major hires', 'hello-3', '1766530458_8879.jpg', 'UK fast-growing bridal and occasionwear brand Six Stories is on a major recruitment drive in order to support its “next phase of scale” backed by a “significant investment in senior talent”. After three consecutive years of “exceptional commercial performance and continued demand across its core categories”, the hiring drive includes newly-created roles such as head of Trade, head of Brand, Social Media manager, CRM manager and Paid Media manager.\r\n\r\nFounder Lucy Menghini said the decision “reflects both the momentum behind the brand and the strategic foundations required for the business to accelerate further.”\r\n\r\nShe added: “Over the past three years our growth has exceeded every expectation, and it’s now essential that we build a senior team that can support the scale we’re heading into.”\r\n\r\nShe noted that its lofty 2026 strategy is about “elevating every part of the business, strengthening our brand, deepening our customer relationships, expanding internationally and continuing to lead in occasionwear.\r\n\r\n“To do that, we need experts in place who can help us evolve while staying true to what makes Six Stories special. Investing in the right people ensures we’re building a lifestyle brand with longevity, ambition and real creative impact.”\r\n\r\nThe brand’s expansion follows a period of “rapid and sustained momentum”, recording 110% annual sales growth over each of the last three years. Meanwhile, the brand’s signature occasionwear has seen sales jump 250% in the past two years, while the bridesmaid category also grew 120% in the same period. \r\n\r\nThe compamy says it sold eight dresses a second during Black Friday. \r\n\r\nAnd with 25% of sales already coming from the US, “international expansion will be a major focus for 2026”.\r\n\r\nThe retailer said demand for bridesmaid dresses and occasionwear in the US has “skyrocketed”, with sales up 391% year-on-year, prompting Six Stories to plan a series of “brand activations, partnerships, and targeted campaigns across key markets to leverage this strong customer base”.\r\n\r\nMenghini added: “As we grow, our vision extends beyond individual collections. We want to continue leading in the bridal space and set a new vision for the women of 2026, creating a lifestyle destination that celebrates them. I believe 2026 will be our most transformative year yet.”\r\n\r\nThat will come as the brand unveils new collections, explores collaborations “with leading creatives, talent and household brands”, while broadening into new product categories and investing in initiatives that “personalise the customer journey, strengthening its reach and impact internationally”.', 1, '2025-12-24 05:54:18');

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
(5, 1, 'active', 1, '2025-12-17 12:06:12', '2025-12-17 12:06:12'),
(6, 2, 'ordered', NULL, '2025-12-24 03:43:43', '2025-12-26 12:49:42'),
(7, 2, 'active', 1, '2025-12-26 12:49:42', '2025-12-26 12:49:42');

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
(44, 6, 11, 1, 680000.00, '2025-12-26 12:49:34'),
(45, 6, 10, 1, 980000.00, '2025-12-26 12:49:35');

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
(3, 'T-Shirt', 't-shirt', '2025-12-26 12:43:00'),
(4, 'Jacket', 'jacket', '2025-12-26 12:43:11'),
(5, 'Sneakers', 'sneakers', '2025-12-26 12:43:24'),
(6, 'Bag', 'bag', '2025-12-26 12:43:31'),
(7, 'Hat', 'hat', '2025-12-26 12:43:41'),
(8, 'Shorts', 'shorts', '2025-12-26 12:44:01');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Đang đổ dữ liệu cho bảng `collections`
--

INSERT INTO `collections` (`id`, `title`, `subtitle`, `image`, `created_at`) VALUES
(2, 'LUXURIOUS STYLE', 'fashionable and elegant', '1766726507_6782.jpg', '2025-12-26 05:21:47'),
(3, 'SPORT STYLE', 'dynamic and individualistic', '1766726526_7909.jpg', '2025-12-26 05:22:06'),
(4, 'STREET STYLE', 'hip hop and cool', '1766726537_4700.jpg', '2025-12-26 05:22:17');

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
(5, 2, 6, 'OD20251226-3344', 'Trần Cường', '9855456863', 'Lương Phong, Hiệp Hòa , Bắc Giang', '75254045745', 1660000.00, 0.00, 0.00, 1660000.00, 'cod', 'unpaid', 'done', '2025-12-26 12:49:42', '2025-12-26 12:50:01');

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
(10, 5, 10, 'Monogram Travel Duffle', 980000.00, 1, 980000.00),
(11, 5, 11, 'Mini Monogram Handbag', 680000.00, 1, 680000.00);

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
(4, 3, 'Angel Graphic T-Shirt', 'angel-graphic-t-shirt', 'White T-shirt featuring a detailed angel illustration with artistic styling.', 180000.00, NULL, 0, 'uploads/products/p_1766727928_8873.png', 1, '2025-12-26 12:45:28', '2025-12-26 12:45:28'),
(5, 3, 'Minimal Logo Black T-Shirt', 'minimal-logo-black-t-shirt', 'Black T-shirt with a clean centered logo for a minimalist look.', 1600000.00, NULL, 0, 'uploads/products/p_1766727952_1545.png', 1, '2025-12-26 12:45:52', '2025-12-26 12:45:52'),
(6, 4, 'Signature Red Panel Jacket', 'signature-red-panel-jacket', 'Structured jacket with bold red panels and signature typography.', 450000.00, NULL, 0, 'uploads/products/p_1766727972_3278.png', 1, '2025-12-26 12:46:12', '2025-12-26 12:46:12'),
(7, 4, 'Leather Graphic Jacket', 'leather-graphic-jacket', 'Black leather jacket featuring graphic artwork on sleeves and body.', 850000.00, NULL, 0, 'uploads/products/p_1766727988_1562.png', 1, '2025-12-26 12:46:28', '2025-12-26 12:47:42'),
(8, 5, 'Classic High-Top Sneakers', 'classic-high-top-sneakers', 'High-top sneakers with a red, black, and white color combination.', 750000.00, NULL, 0, 'uploads/products/p_1766728352_9612.png', 1, '2025-12-26 12:46:47', '2025-12-26 12:52:32'),
(9, 5, 'Soft Tone High-Top Sneakers', 'soft-tone-high-top-sneakers', 'High-top sneakers with soft pink and white tones.', 720000.00, NULL, 0, 'uploads/products/p_1766728026_8610.png', 1, '2025-12-26 12:47:06', '2025-12-26 12:47:36'),
(10, 6, 'Monogram Travel Duffle', 'monogram-travel-duffle', 'Large travel duffle bag with all-over monogram pattern.', 980000.00, NULL, 0, 'uploads/products/p_1766728345_4795.png', 1, '2025-12-26 12:47:22', '2025-12-26 12:52:25'),
(11, 6, 'Mini Monogram Handbag', 'mini-monogram-handbag', 'Compact monogram handbag with structured handles.', 680000.00, NULL, 0, 'uploads/products/p_1766728078_8346.png', 1, '2025-12-26 12:47:58', '2025-12-26 12:47:58'),
(12, 7, 'Classic Logo Cap', 'classic-logo-cap', 'Black baseball cap with bold front logo.', 140000.00, NULL, 0, 'uploads/products/p_1766728093_1119.png', 1, '2025-12-26 12:48:13', '2025-12-26 12:48:13'),
(13, 7, 'Logo Bucket Hat', 'logo-bucket-hat', 'White bucket hat with centered logo design.', 130000.00, NULL, 0, 'uploads/products/p_1766728111_5652.png', 1, '2025-12-26 12:48:31', '2025-12-26 12:48:39'),
(14, 8, 'Graphic Black Denim Shorts', 'graphic-black-denim-shorts', 'Black denim shorts featuring a bold yellow cartoon-style graphic on the front.', 100000.00, NULL, 0, 'uploads/products/p_1766728136_1601.png', 1, '2025-12-26 12:48:56', '2025-12-26 12:48:56'),
(15, 8, 'Shark Graphic Black Denim Shorts', 'shark-graphic-black-denim-shorts', 'Black denim shorts with an aggressive shark face graphic split across both legs.', 120000.00, NULL, 0, 'uploads/products/p_1766728337_6922.png', 1, '2025-12-26 12:49:14', '2025-12-26 12:52:17');

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
(1, 'LE DINH NHAT HUY', 'admin@admin.com', '0376624457', '$2y$10$LvAc7gVi4xmxB7z5GNd7qunIUPRGcwh410WdP03NQYZqRO5nQbzc2', 'admin', 1, '2025-12-17 11:57:41', '2025-12-17 11:58:27'),
(2, 'Trần Cường', 'test@gmail.com', '9855456863', '$2y$10$R1sPMgq79UUpK0lqisJdDeQ9ovD5cCPRiMk1Fr1kN7bIrNHjDjaVq', 'admin', 1, '2025-12-24 02:30:04', '2025-12-24 02:30:20');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

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
-- Chỉ mục cho bảng `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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