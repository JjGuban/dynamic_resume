-- database/db.sql
CREATE DATABASE IF NOT EXISTS resume_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE resume_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- NOTE: this hash is for password '123456789'
INSERT INTO users (username, email, password_hash) VALUES
('admin', 'admin@gmail.com', '$2y$10$5xQaUyeofXaEKkA8TwDege3CRUgaNoz8oCch/6wb9VpfAYcPnsyg6');

CREATE TABLE about (
  id INT AUTO_INCREMENT PRIMARY KEY,
  content TEXT,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE skills (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  category VARCHAR(100) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  tech_stack VARCHAR(255),
  image_path VARCHAR(255),
  project_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE education (
  id INT AUTO_INCREMENT PRIMARY KEY,
  school VARCHAR(255),
  degree VARCHAR(255),
  year VARCHAR(50),
  description TEXT,
  image_path VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  type ENUM('profile','cover') NOT NULL,
  file_path VARCHAR(255) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
