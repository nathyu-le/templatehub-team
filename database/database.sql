-- =========================================
-- DATABASE FULL: simple_shop (newbie friendly)
-- =========================================

DROP DATABASE IF EXISTS simple_shop;
CREATE DATABASE simple_shop
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE simple_shop;

SET sql_mode = 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';

-- =========================================
-- 1) USERS: admin / user
-- =========================================
CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  phone VARCHAR(30) NULL,
  password_hash VARCHAR(255) NOT NULL,         -- PHP password_hash()
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  status TINYINT NOT NULL DEFAULT 1,           -- 1=active, 0=locked
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================
-- 2) CATEGORIES
-- =========================================
CREATE TABLE categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL UNIQUE,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================================
-- 3) PRODUCTS
-- =========================================
CREATE TABLE products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id BIGINT UNSIGNED NULL,
  name VARCHAR(180) NOT NULL,
  slug VARCHAR(200) NOT NULL UNIQUE,
  description TEXT NULL,
  price DECIMAL(12,2) NOT NULL DEFAULT 0,
  sale_price DECIMAL(12,2) NULL,
  stock INT NOT NULL DEFAULT 0,
  thumbnail VARCHAR(255) NULL,                 -- ví dụ: uploads/p1.png
  is_active TINYINT NOT NULL DEFAULT 1,        -- 1=show, 0=hide
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_products_category
    FOREIGN KEY (category_id) REFERENCES categories(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_products_category ON products(category_id);
CREATE INDEX idx_products_active ON products(is_active);
CREATE INDEX idx_products_price ON products(price);

-- =========================================
-- 4) CARTS
-- Mỗi user có 1 cart active duy nhất (giữ mãi), chỉ đổi trạng thái khi đặt hàng.
-- Trick: is_active = 1 với cart active, còn cart đã đặt thì set is_active = NULL
-- UNIQUE(user_id, is_active) => mỗi user chỉ có 1 dòng is_active=1, còn NULL thì được nhiều.
-- =========================================
CREATE TABLE carts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  status ENUM('active','ordered') NOT NULL DEFAULT 'active',
  is_active TINYINT NULL DEFAULT 1,            -- active: 1 ; ordered: NULL
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_carts_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Enforce: mỗi user chỉ có 1 cart active (is_active=1)
CREATE UNIQUE INDEX uq_user_one_active_cart ON carts(user_id, is_active);
CREATE INDEX idx_carts_user_status ON carts(user_id, status);

-- =========================================
-- 5) CART ITEMS
-- =========================================
CREATE TABLE cart_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cart_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(12,2) NOT NULL DEFAULT 0, -- chốt giá tại thời điểm thêm giỏ
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_cart_items_cart
    FOREIGN KEY (cart_id) REFERENCES carts(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_cart_items_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  UNIQUE KEY uq_cart_product (cart_id, product_id)
) ENGINE=InnoDB;

CREATE INDEX idx_cart_items_cart ON cart_items(cart_id);

-- =========================================
-- 6) ORDERS
-- =========================================
CREATE TABLE orders (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  cart_id BIGINT UNSIGNED NULL,                -- cart đã dùng để đặt
  order_code VARCHAR(30) NOT NULL UNIQUE,      -- ví dụ: OD20251215-0001

  full_name VARCHAR(120) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  address VARCHAR(255) NOT NULL,
  note VARCHAR(255) NULL,

  subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
  shipping_fee DECIMAL(12,2) NOT NULL DEFAULT 0,
  discount DECIMAL(12,2) NOT NULL DEFAULT 0,
  total DECIMAL(12,2) NOT NULL DEFAULT 0,

  payment_method ENUM('cod','bank','momo') NOT NULL DEFAULT 'cod',
  payment_status ENUM('unpaid','paid','refunded') NOT NULL DEFAULT 'unpaid',
  order_status ENUM('pending','confirmed','shipping','done','cancelled') NOT NULL DEFAULT 'pending',

  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  CONSTRAINT fk_orders_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,

  CONSTRAINT fk_orders_cart
    FOREIGN KEY (cart_id) REFERENCES carts(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_status ON orders(order_status);
CREATE INDEX idx_orders_created ON orders(created_at);

-- =========================================
-- 7) ORDER ITEMS (snapshot)
-- =========================================
CREATE TABLE order_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,

  product_name VARCHAR(180) NOT NULL,          -- snapshot name
  unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
  quantity INT NOT NULL DEFAULT 1,
  line_total DECIMAL(12,2) NOT NULL DEFAULT 0,

  CONSTRAINT fk_order_items_order
    FOREIGN KEY (order_id) REFERENCES orders(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  CONSTRAINT fk_order_items_product
    FOREIGN KEY (product_id) REFERENCES products(id)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE INDEX idx_order_items_order ON order_items(order_id);

-- =========================================
-- SEED DATA (demo)
-- =========================================
INSERT INTO categories (name, slug) VALUES
('Đồ uống', 'do-uong'),
('Snack', 'snack'),
('Phụ kiện', 'phu-kien');

INSERT INTO products (category_id, name, slug, description, price, sale_price, stock, thumbnail) VALUES
(2, 'MilkBite Original 50g',   'milkbite-original-50g',   'Bánh snack vị sữa',        15000, 12000, 200, 'uploads/p1.png'),
(2, 'MilkBite Chocolate 50g',  'milkbite-chocolate-50g',  'Bánh snack vị socola',     16000, NULL,  150, 'uploads/p2.png'),
(1, 'Sữa tươi không đường 180ml','sua-tuoi-180ml',         'Sữa tươi tiện lợi',        12000, NULL,  300, 'uploads/p3.png');

-- =========================================
-- NOTE: tạo admin/user
-- Vì password cần bcrypt hash của PHP, bạn tạo bằng code:
-- $hash = password_hash('admin123', PASSWORD_DEFAULT);
-- rồi INSERT vào DB.
-- Ví dụ:
-- INSERT INTO users(full_name,email,password_hash,role) VALUES ('Admin','admin@shop.local','<HASH>','admin');
-- =========================================