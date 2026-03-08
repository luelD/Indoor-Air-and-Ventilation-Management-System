-- Create database
CREATE DATABASE IF NOT EXISTS jambertair;

USE jambertair;


-- TABLE 1: USERS

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLE 2: SENSOR READINGS

CREATE TABLE IF NOT EXISTS sensor_readings (
    sensor_id INT AUTO_INCREMENT PRIMARY KEY,
    co2 INT NOT NULL,
    pm25 FLOAT NOT NULL,
    temperature FLOAT NOT NULL,
    humidity FLOAT NOT NULL,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- TABLE 3: FAN STATUS

CREATE TABLE IF NOT EXISTS fan_status (
    fan_status_id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('ON','OFF') NOT NULL,
    user_id INT NULL,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- TABLE 4: SYSTEM LOGS

CREATE TABLE IF NOT EXISTS system_logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    fan_status_id INT NULL,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(user_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
    CONSTRAINT fk_log_fan FOREIGN KEY (fan_status_id) REFERENCES fan_status(fan_status_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


-- INSERT USERS

INSERT INTO users (username, email, password, role)
VALUES 
('admin', 'admin@jambertair.com', 'admin123', 'admin'),
('user', 'user@jambertair.com', 'user123', 'user');


-- INSERT FAN STATUS

INSERT INTO fan_status (status, user_id)
VALUES 
('OFF', 1),
('ON', 2);


-- INSERT SYSTEM LOGS

INSERT INTO system_logs (user_id, fan_status_id, message)
VALUES
(1, 1, 'Fan turned OFF by admin'),
(2, 2, 'Fan turned ON by user');