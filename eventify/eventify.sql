CREATE DATABASE IF NOT EXISTS eventify_db 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE eventify_db;

CREATE TABLE IF NOT EXISTS event_details (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    event_name VARCHAR(150) NOT NULL,
    event_category VARCHAR(50) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    venue VARCHAR(200) NOT NULL,
    organizer_name VARCHAR(100) NOT NULL,
    contact_email VARCHAR(120) NOT NULL,
    ticket_price DECIMAL(8,2) DEFAULT 0.00,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_date (event_date),
    INDEX idx_category (event_category)
) ENGINE=InnoDB;