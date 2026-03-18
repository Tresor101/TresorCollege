-- Tables for Student Dashboard (dynamic data)

-- Table for students (already exists, shown for reference)
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50) UNIQUE,
    name VARCHAR(100),
    full_name VARCHAR(150),
    gender VARCHAR(10),
    dob DATE,
    place_of_birth VARCHAR(100),
    nationality VARCHAR(50),
    parent_name VARCHAR(100),
    guardian_name VARCHAR(100),
    relationship VARCHAR(50),
    parent_contact VARCHAR(30),
    guardian_phone VARCHAR(30),
    guardian_occupation VARCHAR(100),
    student_address VARCHAR(255),
    address VARCHAR(255),
    emergency_contact VARCHAR(100),
    emergency_name VARCHAR(100),
    emergency_phone VARCHAR(30),
    health_info TEXT,
    medical_conditions TEXT,
    created_at DATETIME
);

-- Table for subjects (already exists, shown for reference)
CREATE TABLE IF NOT EXISTS subjects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- Table for student subject results (already exists, shown for reference)
CREATE TABLE IF NOT EXISTS student_subject_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    score DECIMAL(5,2),
    grade VARCHAR(5),
    remark VARCHAR(100),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Table for attendance records
CREATE TABLE student_attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    date DATE,
    status VARCHAR(20), -- Present, Absent, Late, etc.
    FOREIGN KEY (student_id) REFERENCES students(id)
);

-- Table for assignments
CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    description TEXT,
    due_date DATE,
    subject_id INT,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Table for student assignment submissions
CREATE TABLE student_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    assignment_id INT,
    submitted_date DATE,
    status VARCHAR(20), -- Pending, Submitted, Graded
    grade VARCHAR(5),
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (assignment_id) REFERENCES assignments(id)
);

-- Table for class schedules
CREATE TABLE class_schedule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    subject_id INT,
    day_of_week VARCHAR(15), -- e.g., Monday
    start_time TIME,
    end_time TIME,
    FOREIGN KEY (student_id) REFERENCES students(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Table for announcements
CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    detail TEXT,
    date_posted DATE
);