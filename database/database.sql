-- =========================================
-- DATABASE: simple_shop (FINAL)
-- =========================================

DROP DATABASE IF EXISTS simple_shop;
CREATE DATABASE simple_shop
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE simple_shop;

SET sql_mode = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';

-- =========================================
-- 1) USERS
-- =========================================
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(30),
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  status TINYINT NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================
-- 2) CATEGORIES
-- =========================================
CREATE TABLE categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================
-- 3) PRODUCTS
-- =========================================
CREATE TABLE products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id BIGINT UNSIGNED NULL,
  name VARCHAR(180) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  description TEXT,
  price DECIMAL(12,2) NOT NULL DEFAULT 0,
  sale_price DECIMAL(12,2),
  stock INT NOT NULL DEFAULT 0,
  thumbnail VARCHAR(255),
  is_active TINYINT NOT NULL DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================================
-- 4) CARTS
-- 1 user = 1 cart active duy nhất
-- =========================================
CREATE TABLE carts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  status ENUM('active','ordered') NOT NULL DEFAULT 'active',
  is_active TINYINT DEFAULT 1,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_carts_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- enforce: mỗi user chỉ có 1 cart active
CREATE UNIQUE INDEX uq_user_active_cart ON carts(user_id, is_active);

-- =========================================
-- 5) CART ITEMS
-- =========================================
CREATE TABLE cart_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cart_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(12,2) NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_cart_items_cart
    FOREIGN KEY (cart_id) REFERENCES carts(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_cart_items_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT,
  UNIQUE KEY uq_cart_product (cart_id, product_id)
) ENGINE=InnoDB;

-- =========================================
-- 6) ORDERS
-- =========================================
CREATE TABLE orders (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  cart_id BIGINT UNSIGNED,
  order_code VARCHAR(30) NOT NULL UNIQUE,
  full_name VARCHAR(120) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  address VARCHAR(255) NOT NULL,
  note VARCHAR(255),
  subtotal DECIMAL(12,2) NOT NULL,
  shipping_fee DECIMAL(12,2) DEFAULT 0,
  discount DECIMAL(12,2) DEFAULT 0,
  total DECIMAL(12,2) NOT NULL,
  payment_method ENUM('cod','bank','momo') DEFAULT 'cod',
  payment_status ENUM('unpaid','paid') DEFAULT 'unpaid',
  order_status ENUM('pending','confirmed','shipping','done','cancelled') DEFAULT 'pending',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_orders_cart
    FOREIGN KEY (cart_id) REFERENCES carts(id)
) ENGINE=InnoDB;

-- =========================================
-- 7) ORDER ITEMS (snapshot)
-- =========================================
CREATE TABLE order_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  product_name VARCHAR(180) NOT NULL,
  unit_price DECIMAL(12,2) NOT NULL,
  quantity INT NOT NULL,
  line_total DECIMAL(12,2) NOT NULL,
  CONSTRAINT fk_order_items_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================
-- SEED DATA
-- =========================================
INSERT INTO categories (name, slug) VALUES
('Snack', 'snack'),
('Đồ uống', 'do-uong');

INSERT INTO products (category_id, name, slug, description, price, stock, thumbnail) VALUES
(1, 'MilkBite Original', 'milkbite-original', 'Bánh snack vị sữa', 15000, 100, 'uploads/p1.png'),
(1, 'MilkBite Chocolate', 'milkbite-chocolate', 'Bánh snack socola', 16000, 100, 'uploads/p2.png'),
(2, 'Sữa tươi 180ml', 'sua-tuoi-180ml', 'Sữa tươi Vinamilk', 12000, 200, 'uploads/p3.png');

-- =========================================
-- NOTE: tạo ADMIN
-- PHP:
-- $hash = password_hash('admin123', PASSWORD_DEFAULT);
-- SQL:
-- INSERT INTO users(full_name,email,password_hash,role)
-- VALUES ('Admin','admin@shop.local','<HASH>','admin');
-- =========================================
