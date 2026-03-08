CREATE DATABASE jambertair;

USE jambertair;

-- TABLE 1: USERS

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLE 2: SENSOR READINGS

CREATE TABLE sensor_readings (
    sensor_id INT AUTO_INCREMENT PRIMARY KEY,
    co2 INT NOT NULL,
    pm25 FLOAT NOT NULL,
    temperature FLOAT NOT NULL,
    humidity FLOAT NOT NULL,
    recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- TABLE 3: FAN STATUS

CREATE TABLE fan_status (
    fan_status_id INT AUTO_INCREMENT PRIMARY KEY,
    status ENUM('ON','OFF') NOT NULL,
    user_id INT,
    changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- TABLE 4: SYSTEM LOGS

CREATE TABLE system_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    fan_status_id INT,
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,
       
    FOREIGN KEY (fan_status_id) REFERENCES fan_status(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);

-- Insert users

INSERT INTO users (username, email, password, role)
VALUES 
('admin', 'admin@jambertair.com', 'admin123', 'admin'),
('user', 'user@jambertair.com', 'user123', 'user');


-- Insert  fan status

INSERT INTO fan_status (status, user_id)
VALUES 
('OFF', 1), 
('ON', 2);


-- Insert example logs

INSERT INTO system_logs (user_id, fan_status_id, message)
VALUES
(1, 1, 'Fan turned OFF by admin'),
(2, 2, 'Fan turned ON by user');