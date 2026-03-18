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
