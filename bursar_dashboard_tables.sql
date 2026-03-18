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
