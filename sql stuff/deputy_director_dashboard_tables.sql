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
