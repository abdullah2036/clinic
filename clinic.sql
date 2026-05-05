
CREATE DATABASE IF NOT EXISTS clinic_db;
USE clinic_db;

-- Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Appointments
CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    doctor VARCHAR(100) NOT NULL,
    specialty VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample data
INSERT INTO users (name, email, password) VALUES
('Ali Hassan', 'ali@example.com', MD5('123456')),
('Sara Ahmed', 'sara@example.com', MD5('123456'));

INSERT INTO appointments (user_id, doctor, specialty, date, time, status) VALUES
(1, 'Dr. Khaled Nasser', 'General Medicine', '2026-05-10', '09:00:00', 'Confirmed'),
(1, 'Dr. Layla Omar', 'Cardiology', '2026-05-15', '11:00:00', 'Pending'),
(2, 'Dr. Tariq Saleh', 'Dermatology', '2026-05-12', '14:00:00', 'Pending');
