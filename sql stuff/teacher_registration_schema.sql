-- Table for Teacher Registration
CREATE TABLE teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    last_name VARCHAR(100) NOT NULL,
    gender VARCHAR(10),
    dob DATE,
    address VARCHAR(255),
    phone VARCHAR(30),
    qualification VARCHAR(255),
    emergency_name VARCHAR(100),
    emergency_phone VARCHAR(30),
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);