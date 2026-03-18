-- Tables for Proprietor Dashboard (dynamic data)

-- Table for reporting terms
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
    director VARCHAR(100),
    board_review_date DATE,
    enrollment INT,
    new_admissions INT,
    staff_count INT,
    teacher_count INT,
    compliance DECIMAL(5,2),
    audit_actions INT,
    pass_rate DECIMAL(5,2),
    outstanding_fees VARCHAR(20),
    retention_rate DECIMAL(5,2),
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for departments
CREATE TABLE departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    name VARCHAR(100),
    head VARCHAR(100),
    performance DECIMAL(5,2),
    status VARCHAR(50),
    badge VARCHAR(20),
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for fee summary by class group
CREATE TABLE fees_summary (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    class_group VARCHAR(100),
    expected_amount VARCHAR(20),
    collected_amount VARCHAR(20),
    balance_amount VARCHAR(20),
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for management tasks
CREATE TABLE tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    title VARCHAR(255),
    due_date DATE,
    priority VARCHAR(20),
    FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for announcements
CREATE TABLE announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    term_id INT,
    title VARCHAR(255),
    detail TEXT,
    date_posted DATE,
    FOREIGN KEY (term_id) REFERENCES terms(id)
);