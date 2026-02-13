-- Database Schema for Jimma University Lost and Found

CREATE DATABASE IF NOT EXISTS jimma_lost_found;
USE jimma_lost_found;

CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type ENUM('lost', 'found') NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description TEXT,
    location VARCHAR(100) NOT NULL,
    event_date DATE NOT NULL,
    contact_name VARCHAR(100) NOT NULL,
    contact_phone VARCHAR(20) NOT NULL,
    contact_email VARCHAR(100),
    image_path VARCHAR(255),
    status ENUM('active', 'resolved') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Data
INSERT INTO items (type, item_name, description, location, event_date, contact_name, contact_phone, contact_email) VALUES
('lost', 'Blue Backpack', 'Nike backpack containing engineering textbooks.', 'Main Library', '2023-10-25', 'Abebe Kebede', '0911234567', 'abebe@example.com'),
('found', 'Samsung Phone', 'Black Samsung Galaxy S21 found on a bench.', 'Social Science Building', '2023-10-26', 'Sara Tadesse', '0922345678', 'sara@example.com');
