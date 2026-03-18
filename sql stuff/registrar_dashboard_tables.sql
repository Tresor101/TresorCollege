-- Tables for Registrar Dashboard (dynamic data)

-- Table for academic terms
CREATE TABLE terms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL,
    start_date DATE,
    end_date DATE
);

-- Table for students
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    date_of_birth DATE,
    admission_number VARCHAR(50) UNIQUE
    -- Add other student details as needed
);

-- Table for admissions
CREATE TABLE admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    term_id INT,
    status VARCHAR(30), -- e.g., submitted, under review, approved, awaiting documents
    submission_date DATE,
    reviewed_by VARCHAR(100),
    approved_by VARCHAR(100),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for student records
CREATE TABLE student_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    record_type VARCHAR(50), -- e.g., transcript, birth certificate
    status VARCHAR(20),      -- e.g., complete, missing, pending
    last_updated DATE,
    FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Table for document requests
CREATE TABLE document_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    request_type VARCHAR(50), -- e.g., transfer letter, transcript
    status VARCHAR(20),       -- e.g., pending, ready, completed
    request_date DATE,
    processed_by VARCHAR(100),
    FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Table for communication queue
CREATE TABLE communication_queue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50),      -- e.g., admission confirmation, fee reminder
    count INT,
    status VARCHAR(20),    -- e.g., pending, sent
    created_at DATE
);