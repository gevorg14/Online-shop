CREATE DATABASE IF NOT EXISTS shop;

USE shop;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, description, price, image)
VALUES
('iPhone 14', 'Apple smartphone', 699.99, 'images/iphone14.jpg'),
('MacBook Air', 'Apple laptop', 1199.00, 'images/macbook.jpg'),
('AirPods Pro', 'Wireless headphones', 249.99, 'images/airpods.jpg'),
('iPad Air', 'Apple tablet', 599.00, 'images/ipad.jpg'),
('Apple Watch', 'Smart watch', 399.99, 'images/watch.jpg');