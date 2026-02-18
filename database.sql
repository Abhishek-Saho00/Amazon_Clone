-- Amazon Clone Database Setup
-- This file creates the complete database structure for the Amazon Clone website

CREATE DATABASE IF NOT EXISTS amazon_clone;
USE amazon_clone;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
);

-- Insert sample admin user (password: admin123)
-- Hash generated from: password_hash('admin123', PASSWORD_DEFAULT)
INSERT INTO users (username, email, password, is_admin) 
VALUES (
    'admin',
    'admin@amazon.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    1
) 
ON DUPLICATE KEY UPDATE username=VALUES(username);

