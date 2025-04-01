CREATE DATABASE IF NOT EXISTS my_store;
USE my_store;

-- Tạo bảng tài khoản (accounts) - đã cập nhật để phù hợp với AccountModel
CREATE TABLE accounts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    avatar VARCHAR(255) DEFAULT 'public/avatars/default.png',
    balance DECIMAL(10,2) DEFAULT 0.00,
    role ENUM('admin','user') DEFAULT 'user',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tạo bảng danh mục sản phẩm 
CREATE TABLE category ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100) NOT NULL, 
    description TEXT 
);

-- Tạo bảng sản phẩm 
CREATE TABLE product ( 
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100) NOT NULL, 
    description TEXT, 
    price DECIMAL(10,2) NOT NULL, 
    image VARCHAR(255) DEFAULT NULL, 
    category_id INT, 
    FOREIGN KEY (category_id) REFERENCES category(id) ON DELETE CASCADE 
);

-- Tạo bảng đơn hàng
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL, 
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES accounts(id) ON DELETE CASCADE
);

-- Tạo bảng chi tiết đơn hàng
CREATE TABLE order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Tạo bảng giỏ hàng
CREATE TABLE cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES accounts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE
);

-- Thêm dữ liệu mẫu vào bảng accounts
INSERT INTO accounts (username, password, email, role) VALUES
('admin', '$2y$10$hKt5U0eSUFnGY5RtYX9.GOKQgndDJ4BNMJfjS2VYGlEFOuMqEFTmG', 'admin@example.com', 'admin'),
('user1', '$2y$10$Nt81D7GOM66M2vwJA3WQgeuaZV61F6OqxeP.u.bHfNMy9d80cLdFm', 'user1@example.com', 'user');

-- Thêm dữ liệu mẫu vào bảng danh mục
INSERT INTO category (name, description) VALUES
('Xe sedan', 'Danh mục các loại xe sedan'),
('Xe SUV', 'Danh mục các loại xe SUV'),
('Xe bán tải', 'Danh mục các loại xe bán tải'),
('Xe thể thao', 'Danh mục các loại xe thể thao'),
('Xe điện', 'Danh mục các loại xe điện');

-- Thêm sản phẩm cho danh mục 'Xe sedan'
INSERT INTO product (name, description, price, image, category_id) VALUES
('Sedan BYD', 'Mô tả cho Sedan BYD', 500000.00, 'BYD.PNG', 1),
('Sedan Capture', 'Mô tả cho Sedan Capture', 520000.00, 'Capture.PNG', 1),
('Sedan Capture1', 'Mô tả cho Sedan Capture1', 540000.00, 'Capture1.PNG', 1);

-- Thêm sản phẩm cho danh mục 'Xe SUV'
INSERT INTO product (name, description, price, image, category_id) VALUES
('SUV Capture2', 'Mô tả cho SUV Capture2', 600000.00, 'Capture2.PNG', 2),
('SUV FORD', 'Mô tả cho SUV FORD', 620000.00, 'FORD.PNG', 2),
('SUV Honda Accord', 'Mô tả cho SUV Honda Accord', 640000.00, 'honda accrod.PNG', 2);

-- Thêm sản phẩm cho danh mục 'Xe bán tải'
INSERT INTO product (name, description, price, image, category_id) VALUES
('Bán tải Lambo', 'Mô tả cho Bán tải Lambo', 700000.00, 'lambo.PNG', 3),
('Bán tải Mazda6', 'Mô tả cho Bán tải Mazda6', 720000.00, 'mazda6.PNG', 3),
('Bán tải VF7', 'Mô tả cho Bán tải VF7', 740000.00, 'vf7.PNG', 3);

-- Thêm sản phẩm cho danh mục 'Xe thể thao'
INSERT INTO product (name, description, price, image, category_id) VALUES
('Thể thao VF8', 'Mô tả cho Thể thao VF8', 800000.00, 'vf8.PNG', 4),
('Thể thao VF9', 'Mô tả cho Thể thao VF9', 820000.00, 'vf9.PNG', 4),
('Thể thao Lambo', 'Mô tả cho Thể thao Lambo', 840000.00, 'lambo.PNG', 4);

-- Thêm sản phẩm cho danh mục 'Xe điện'
INSERT INTO product (name, description, price, image, category_id) VALUES
('Xe điện VF7', 'Mô tả cho Xe điện VF7', 900000.00, 'vf7.PNG', 5),
('Xe điện VF8', 'Mô tả cho Xe điện VF8', 920000.00, 'vf8.PNG', 5),
('Xe điện VF9', 'Mô tả cho Xe điện VF9', 940000.00, 'vf9.PNG', 5);