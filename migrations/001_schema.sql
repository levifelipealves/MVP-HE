-- Geek Heroes Store — Schema MVP
-- Execute: mysql -u root -p geek_store < migrations/001_schema.sql

CREATE DATABASE IF NOT EXISTS geek_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE geek_store;

CREATE TABLE IF NOT EXISTS store_settings (
    key_name  VARCHAR(100) PRIMARY KEY,
    key_value TEXT
);

INSERT INTO store_settings (key_name, key_value) VALUES
    ('store_name',        'Geek Heroes'),
    ('store_description', 'Colecionáveis e Action Figures'),
    ('store_phone',       ''),
    ('store_whatsapp',    ''),
    ('store_email',       ''),
    ('store_instagram',   ''),
    ('store_address',     ''),
    ('store_cnpj',        '')
ON DUPLICATE KEY UPDATE key_value = VALUES(key_value);

CREATE TABLE IF NOT EXISTS categories (
    id         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(100) NOT NULL,
    slug       VARCHAR(100) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED,
    name        VARCHAR(255) NOT NULL,
    slug        VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price       DECIMAL(10,2) NOT NULL,
    price_pix   DECIMAL(10,2),
    stock       INT DEFAULT 0,
    image       VARCHAR(500),
    is_active   TINYINT(1) DEFAULT 1,
    created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS orders (
    id               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    mp_preference_id VARCHAR(100),
    customer_name    VARCHAR(255) NOT NULL,
    customer_email   VARCHAR(255) NOT NULL,
    customer_phone   VARCHAR(20),
    customer_cpf     VARCHAR(14),
    customer_cep     VARCHAR(9),
    customer_address TEXT,
    subtotal         DECIMAL(10,2) NOT NULL,
    total            DECIMAL(10,2) NOT NULL,
    payment_method   VARCHAR(50) DEFAULT 'pending',
    status           VARCHAR(50) DEFAULT 'pending',
    created_at       DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS order_items (
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id     INT UNSIGNED NOT NULL,
    product_id   INT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    unit_price   DECIMAL(10,2) NOT NULL,
    quantity     INT NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
