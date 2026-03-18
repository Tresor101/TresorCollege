-- Tables for School Director Dashboard (dynamic data)

-- Table for academic terms
CREATE TABLE terms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL,
    start_date DATE,
    end_date DATE
);

-- Table for school-wide info per term
CREATE TABLE school_info (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    academic_year VARCHAR(20),
    campuses INT,
    open_issues INT,
    next_inspection DATE,
    enrollment INT,
    attendance_rate DECIMAL(5,2),
    pass_rate DECIMAL(5,2),
    staff_count INT,
    teacher_count INT,
    support_count INT,
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for departments
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    name VARCHAR(100),
    lead VARCHAR(100),
    score DECIMAL(5,2),
    status VARCHAR(50),
    badge VARCHAR(20),
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for priority actions
CREATE TABLE priority_actions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    title VARCHAR(255),
    detail TEXT,
    FOREIGN KEY (term_id) REFERENCES terms(id)
);