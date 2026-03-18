-- Subjects table
CREATE TABLE IF NOT EXISTS subjects (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL,
    code VARCHAR(30),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_subjects_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Teachers table
CREATE TABLE IF NOT EXISTS teachers (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    full_name VARCHAR(150) NOT NULL,
    teacher_code VARCHAR(30) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(30),
    specialization VARCHAR(120),
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_teachers_code (teacher_code),
    UNIQUE KEY uq_teachers_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Classes table
CREATE TABLE IF NOT EXISTS classes (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    class_code VARCHAR(40) NOT NULL,
    class_grade VARCHAR(50) NOT NULL,
    section VARCHAR(50),
    academic_year VARCHAR(20) NOT NULL,
    room_label VARCHAR(50),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_classes_code_year (class_code, academic_year),
    KEY idx_classes_grade_year (class_grade, academic_year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Teacher-Class-Subjects mapping
CREATE TABLE IF NOT EXISTS teacher_class_subjects (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    teacher_id BIGINT UNSIGNED NOT NULL,
    class_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_teacher_class_subject (teacher_id, class_id, subject_id),
    KEY idx_teacher_class_subjects_class (class_id),
    CONSTRAINT fk_tcs_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tcs_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_tcs_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Class sessions (for lesson coverage)
CREATE TABLE IF NOT EXISTS class_sessions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    class_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED,
    teacher_id BIGINT UNSIGNED,
    session_date DATE NOT NULL,
    start_time TIME,
    end_time TIME,
    status ENUM('scheduled', 'completed', 'cancelled') NOT NULL DEFAULT 'scheduled',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_class_sessions_class_date (class_id, session_date),
    CONSTRAINT fk_class_sessions_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_class_sessions_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_class_sessions_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Class assignments (for exam readiness)
CREATE TABLE IF NOT EXISTS class_assignments (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    class_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED,
    teacher_id BIGINT UNSIGNED,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    assigned_date DATE NOT NULL,
    due_date DATE NOT NULL,
    max_score DECIMAL(5,2) DEFAULT 100,
    status ENUM('active', 'closed') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_class_assignments_class_due (class_id, due_date),
    CONSTRAINT fk_class_assignments_class FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_class_assignments_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_class_assignments_teacher FOREIGN KEY (teacher_id) REFERENCES teachers(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Assignment submissions (for grading status)
CREATE TABLE IF NOT EXISTS assignment_submissions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    assignment_id BIGINT UNSIGNED NOT NULL,
    student_id BIGINT UNSIGNED NOT NULL,
    submitted_at DATETIME,
    submission_status ENUM('pending', 'submitted', 'late', 'missing', 'graded') NOT NULL DEFAULT 'pending',
    score DECIMAL(5,2),
    feedback TEXT,
    graded_by_teacher_id BIGINT UNSIGNED,
    graded_at DATETIME,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_assignment_submission_student (assignment_id, student_id),
    KEY idx_assignment_submissions_status (submission_status),
    CONSTRAINT fk_assignment_submissions_assignment FOREIGN KEY (assignment_id) REFERENCES class_assignments(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_assignment_submissions_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_assignment_submissions_grader FOREIGN KEY (graded_by_teacher_id) REFERENCES teachers(id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Student subject results (for subject performance)
CREATE TABLE IF NOT EXISTS student_subject_results (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    student_id BIGINT UNSIGNED NOT NULL,
    subject_id BIGINT UNSIGNED NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    term_label VARCHAR(30),
    score DECIMAL(5,2) NOT NULL,
    grade VARCHAR(10) NOT NULL,
    remark VARCHAR(50),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_student_subject_term (student_id, subject_id, academic_year, term_label),
    KEY idx_results_student_year (student_id, academic_year),
    CONSTRAINT fk_results_student FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_results_subject FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Students table
CREATE TABLE IF NOT EXISTS students (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    student_id VARCHAR(30) NOT NULL,
    admission_no VARCHAR(30) NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100),
    last_name VARCHAR(100) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    date_of_birth DATE NOT NULL,
    place_of_birth VARCHAR(150) NOT NULL,
    nationality VARCHAR(100) NOT NULL,
    photo_filename VARCHAR(255) NOT NULL,
    photo_mime_type VARCHAR(100),
    photo_storage_path TEXT NOT NULL,
    home_address TEXT NOT NULL,
    city_commune VARCHAR(120) NOT NULL,
    province VARCHAR(120) NOT NULL,
    country VARCHAR(120) NOT NULL,
    student_email VARCHAR(255),
    admission_date DATE NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    class_grade VARCHAR(50) NOT NULL,
    section VARCHAR(50),
    previous_school VARCHAR(200) NOT NULL,
    last_grade_completed VARCHAR(80) NOT NULL,
    emergency_contact_name VARCHAR(150) NOT NULL,
    emergency_contact_phone VARCHAR(30) NOT NULL,
    medical_conditions TEXT,
    allergies TEXT,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_students_student_id (student_id),
    UNIQUE KEY uq_students_admission_no (admission_no),
    KEY idx_students_class_grade (class_grade)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Tables for Bursar Dashboard

-- 1. Payments table
CREATE TABLE payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_date DATE NOT NULL,
    payment_method VARCHAR(50), -- e.g. cash, bank transfer
    receipt_number VARCHAR(50),
    term VARCHAR(20),
    notes TEXT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 2. Student Fee Balances table
CREATE TABLE student_fee_balances (
    balance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    expected_amount DECIMAL(10,2) NOT NULL,
    collected_amount DECIMAL(10,2) NOT NULL,
    outstanding_balance DECIMAL(10,2) NOT NULL,
    term VARCHAR(20),
    last_update DATE,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 3. Transactions table
CREATE TABLE transactions (
    transaction_id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_type VARCHAR(50), -- e.g. bank transfer, cash receipt
    amount DECIMAL(10,2) NOT NULL,
    transaction_date DATE NOT NULL,
    description TEXT,
    related_payment_id INT,
    FOREIGN KEY (related_payment_id) REFERENCES payments(payment_id)
);

-- 4. Payroll table
CREATE TABLE payroll (
    payroll_id INT AUTO_INCREMENT PRIMARY KEY,
    salary_run_date DATE NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status VARCHAR(30), -- e.g. pending, reconciled
    notes TEXT
);

-- 5. Finance Alerts table (optional)
CREATE TABLE finance_alerts (
    alert_id INT AUTO_INCREMENT PRIMARY KEY,
    alert_title VARCHAR(100) NOT NULL,
    alert_description TEXT,
    alert_date DATE,
    status VARCHAR(20) -- e.g. active, resolved
);

-- Tables for Deputy Director Dashboard

-- 1. Operational Tasks
CREATE TABLE operational_tasks (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    task_name VARCHAR(100) NOT NULL,
    owner VARCHAR(50) NOT NULL,
    progress INT NOT NULL, -- percentage (0-100)
    deadline DATE,
    status VARCHAR(30) -- e.g. Open, Done, In Progress
);

-- 2. Attendance Records
CREATE TABLE attendance_records (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    person_type VARCHAR(10) NOT NULL, -- 'student' or 'staff'
    person_id INT NOT NULL,
    attendance_date DATE NOT NULL,
    status VARCHAR(20) NOT NULL -- e.g. Present, Absent, Late
);

-- 3. Incidents
CREATE TABLE incidents (
    incident_id INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT NOT NULL,
    status VARCHAR(30) NOT NULL, -- e.g. Pending, Resolved, Escalated
    escalation_level VARCHAR(30), -- e.g. Parent Meeting, Director
    reported_date DATE NOT NULL,
    resolved_date DATE
);

-- 4. Supervision Checklist
CREATE TABLE supervision_checklist (
    checklist_id INT AUTO_INCREMENT PRIMARY KEY,
    activity VARCHAR(100) NOT NULL,
    status VARCHAR(30) NOT NULL, -- e.g. Completed, In Progress, Pending, Scheduled
    checklist_date DATE
);

-- 5. Maintenance Tasks
CREATE TABLE maintenance_tasks (
    maintenance_id INT AUTO_INCREMENT PRIMARY KEY,
    area VARCHAR(100) NOT NULL,
    issue_description TEXT,
    progress INT NOT NULL, -- percentage (0-100)
    deadline DATE,
    status VARCHAR(30) -- e.g. Open, Resolved, Scheduled
);

-- Tables for Discipline Officer Dashboard

-- 1. Discipline Incidents
CREATE TABLE discipline_incidents (
    incident_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    case_description VARCHAR(100) NOT NULL,
    action_taken VARCHAR(100),
    status VARCHAR(30) NOT NULL, -- e.g. Open, Monitoring, Resolved
    incident_date DATE NOT NULL,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 2. Late Arrivals
CREATE TABLE late_arrivals (
    late_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    arrival_date DATE NOT NULL,
    repeat_offender BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 3. Parent Meetings
CREATE TABLE parent_meetings (
    meeting_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    meeting_date DATE,
    status VARCHAR(30) NOT NULL, -- e.g. Scheduled, Pending, Completed
    followup_required BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- 4. Hotspot Classes
CREATE TABLE hotspot_classes (
    hotspot_id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(50) NOT NULL,
    incident_count INT NOT NULL
);

-- 5. Discipline Actions
CREATE TABLE discipline_actions (
    action_id INT AUTO_INCREMENT PRIMARY KEY,
    action_description VARCHAR(150) NOT NULL,
    priority VARCHAR(20), -- e.g. High, Medium, Low
    deadline DATE,
    status VARCHAR(30) -- e.g. Pending, Completed
);


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