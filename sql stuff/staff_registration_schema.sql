-- Table for Staff Registration
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    gender VARCHAR(10),
    date_of_birth DATE,
    position VARCHAR(100),
    department VARCHAR(100),
    email VARCHAR(150) UNIQUE,
    phone VARCHAR(30),
    address VARCHAR(255),
    date_joined DATE,
    staff_number VARCHAR(50) UNIQUE,
    qualifications TEXT,
    status VARCHAR(20) DEFAULT 'active',
    photo VARCHAR(255)
);
-- Add more fields as needed