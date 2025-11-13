// Data Storage using localStorage
let currentRole = null;
let currentApplicationId = null;

// Initialize data if not exists
function initializeData() {
    if (!localStorage.getItem('applications')) {
        localStorage.setItem('applications', JSON.stringify([]));
    }
    if (!localStorage.getItem('students')) {
        localStorage.setItem('students', JSON.stringify([]));
    }
    if (!localStorage.getItem('marks')) {
        localStorage.setItem('marks', JSON.stringify({}));
    }
    if (!localStorage.getItem('adminCredentials')) {
        // Default admin credentials
        localStorage.setItem('adminCredentials', JSON.stringify({
            username: 'admin',
            password: 'admin123'
        }));
    }
}

// Home Page Functions
function showLoginForm(role) {
    currentRole = role;
    const loginForm = document.getElementById('loginForm');
    const formTitle = document.getElementById('formTitle');
    const applyLink = document.getElementById('applyLink');
    const studentIdGroup = document.getElementById('studentIdGroup');
    const adminCredentialsGroup = document.getElementById('adminCredentialsGroup');
    const adminPasswordGroup = document.getElementById('adminPasswordGroup');
    
    loginForm.classList.remove('hidden');
    
    if (role === 'admin') {
        formTitle.textContent = 'Admin Login';
        studentIdGroup.style.display = 'none';
        adminCredentialsGroup.style.display = 'block';
        adminPasswordGroup.style.display = 'block';
        applyLink.classList.add('hidden');
        document.getElementById('username').required = true;
        document.getElementById('password').required = true;
        document.getElementById('studentId').required = false;
    } else {
        formTitle.textContent = 'Student Login';
        studentIdGroup.style.display = 'block';
        adminCredentialsGroup.style.display = 'none';
        adminPasswordGroup.style.display = 'none';
        applyLink.classList.remove('hidden');
        document.getElementById('studentId').required = true;
        document.getElementById('username').required = false;
        document.getElementById('password').required = false;
    }
    
    // Scroll to form
    loginForm.scrollIntoView({ behavior: 'smooth' });
}

function hideLoginForm() {
    document.getElementById('loginForm').classList.add('hidden');
    document.getElementById('studentId').value = '';
    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
}

function handleLogin(event) {
    event.preventDefault();
    
    if (currentRole === 'admin') {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        loginAdmin(username, password);
    } else {
        const studentId = document.getElementById('studentId').value.trim();
        loginStudent(studentId);
    }
}

function loginAdmin(username, password) {
    const adminCreds = JSON.parse(localStorage.getItem('adminCredentials'));
    
    if (username === adminCreds.username && password === adminCreds.password) {
        sessionStorage.setItem('loggedIn', 'admin');
        window.location.href = 'admin.html';
    } else {
        alert('Invalid admin credentials!');
    }
}

function loginStudent(studentId) {
    const applications = JSON.parse(localStorage.getItem('applications'));
    const students = JSON.parse(localStorage.getItem('students'));
    
    // Check in applications (pending or rejected) - using application ID
    const application = applications.find(app => 
        app.id === studentId || app.studentId === studentId
    );
    
    // Check in registered students by student ID
    const student = students.find(std => std.studentId === studentId);
    
    if (application || student) {
        sessionStorage.setItem('loggedIn', 'student');
        sessionStorage.setItem('studentId', studentId);
        window.location.href = 'student.html';
    } else {
        alert('Invalid Student ID! Please check your Student ID.\n\nFor pending applications, use your Application ID (APP...).\nFor registered students, use your Student ID (STD...).');
    }
}

function logout() {
    sessionStorage.clear();
    window.location.href = 'index.html';
}

// Application Form Functions
function submitApplication(event) {
    event.preventDefault();
    
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const dob = document.getElementById('dob').value;
    const address = document.getElementById('address').value;
    const previousSchool = document.getElementById('previousSchool').value;
    const grade = document.getElementById('grade').value;
    
    // Create application
    const application = {
        id: 'APP' + Date.now(),
        firstName,
        lastName,
        fullName: firstName + ' ' + lastName,
        email,
        phone,
        dob,
        address,
        previousSchool,
        grade,
        status: 'pending',
        applicationDate: new Date().toLocaleDateString(),
        rejectionReason: null
    };
    
    const applications = JSON.parse(localStorage.getItem('applications'));
    applications.push(application);
    localStorage.setItem('applications', JSON.stringify(applications));
    
    // Show success message with Application ID
    document.getElementById('applicationForm').classList.add('hidden');
    document.getElementById('submittedApplicationId').textContent = application.id;
    document.getElementById('successMessage').classList.remove('hidden');
}

// Student Dashboard Functions
function loadStudentData() {
    const studentId = sessionStorage.getItem('studentId');
    if (!studentId) {
        window.location.href = 'index.html';
        return;
    }
    
    const applications = JSON.parse(localStorage.getItem('applications'));
    const students = JSON.parse(localStorage.getItem('students'));
    const marks = JSON.parse(localStorage.getItem('marks'));
    
    // Find user by ID (could be application ID or student ID)
    let userData = applications.find(app => app.id === studentId || app.studentId === studentId);
    let isRegistered = false;
    
    if (!userData) {
        userData = students.find(std => std.studentId === studentId);
        isRegistered = true;
    }
    
    if (!userData) {
        alert('Student data not found!');
        logout();
        return;
    }
    
    // Display student info
    document.getElementById('studentName').textContent = 'Welcome, ' + userData.fullName;
    document.getElementById('studentId').textContent = userData.studentId || userData.id;
    document.getElementById('fullName').textContent = userData.fullName;
    document.getElementById('email').textContent = userData.email;
    document.getElementById('phone').textContent = userData.phone;
    
    // Display application status
    const statusElement = document.getElementById('status');
    statusElement.textContent = userData.status.toUpperCase();
    statusElement.className = 'status-badge status-' + userData.status;
    document.getElementById('appDate').textContent = userData.applicationDate;
    
    if (userData.status === 'rejected') {
        document.getElementById('rejectionReason').classList.remove('hidden');
        document.getElementById('reason').textContent = userData.rejectionReason || 'Not specified';
    }
    
    // Display marks (only for registered students)
    const marksBody = document.getElementById('marksBody');
    if (isRegistered && marks[userData.studentId]) {
        const studentMarks = marks[userData.studentId];
        let total = 0;
        
        marksBody.innerHTML = '';
        studentMarks.forEach(mark => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${mark.subject}</td>
                <td>${mark.marks}</td>
                <td>${calculateGrade(mark.marks)}</td>
            `;
            marksBody.appendChild(row);
            total += mark.marks;
        });
        
        document.getElementById('totalMarks').textContent = total;
        document.getElementById('averageMarks').textContent = 
            studentMarks.length > 0 ? (total / studentMarks.length).toFixed(2) : '0';
    } else {
        marksBody.innerHTML = '<tr><td colspan="3" style="text-align: center;">No marks available yet</td></tr>';
        document.getElementById('totalMarks').textContent = '0';
        document.getElementById('averageMarks').textContent = '0';
    }
}

function calculateGrade(marks) {
    if (marks >= 90) return 'A+';
    if (marks >= 80) return 'A';
    if (marks >= 70) return 'B';
    if (marks >= 60) return 'C';
    if (marks >= 50) return 'D';
    return 'F';
}

// Admin Dashboard Functions
function loadApplications() {
    const applications = JSON.parse(localStorage.getItem('applications'));
    const pendingApps = applications.filter(app => app.status === 'pending');
    
    const tbody = document.getElementById('applicationsBody');
    tbody.innerHTML = '';
    
    if (pendingApps.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No pending applications</td></tr>';
        return;
    }
    
    pendingApps.forEach(app => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${app.id}</td>
            <td>${app.fullName}</td>
            <td>${app.email}</td>
            <td>${app.phone}</td>
            <td>${app.applicationDate}</td>
            <td>
                <button class="action-btn btn-view" onclick="viewApplication('${app.id}')">Review</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function loadRegisteredStudents() {
    const students = JSON.parse(localStorage.getItem('students'));
    const tbody = document.getElementById('studentsBody');
    tbody.innerHTML = '';
    
    if (students.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No registered students</td></tr>';
        return;
    }
    
    students.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${student.studentId}</td>
            <td>${student.fullName}</td>
            <td>${student.email}</td>
            <td>${student.phone}</td>
            <td>${student.registrationDate}</td>
            <td>
                <button class="action-btn btn-delete" onclick="deleteStudent('${student.studentId}')">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function viewApplication(appId) {
    const applications = JSON.parse(localStorage.getItem('applications'));
    const app = applications.find(a => a.id === appId);
    
    if (!app) return;
    
    currentApplicationId = appId;
    
    const detailsDiv = document.getElementById('applicationDetails');
    detailsDiv.innerHTML = `
        <p><strong>Application ID:</strong> ${app.id}</p>
        <p><strong>Name:</strong> ${app.fullName}</p>
        <p><strong>Email:</strong> ${app.email}</p>
        <p><strong>Phone:</strong> ${app.phone}</p>
        <p><strong>Date of Birth:</strong> ${app.dob}</p>
        <p><strong>Address:</strong> ${app.address}</p>
        <p><strong>Previous School:</strong> ${app.previousSchool}</p>
        <p><strong>Grade:</strong> ${app.grade}</p>
        <p><strong>Application Date:</strong> ${app.applicationDate}</p>
    `;
    
    document.getElementById('reviewModal').classList.remove('hidden');
    document.getElementById('rejectForm').classList.add('hidden');
}

function approveApplication() {
    const applications = JSON.parse(localStorage.getItem('applications'));
    const students = JSON.parse(localStorage.getItem('students'));
    
    const appIndex = applications.findIndex(a => a.id === currentApplicationId);
    if (appIndex === -1) return;
    
    const app = applications[appIndex];
    
    // Generate student ID
    const studentId = 'STD' + (1000 + students.length);
    
    // Create student record
    const student = {
        ...app,
        studentId,
        status: 'approved',
        registrationDate: new Date().toLocaleDateString()
    };
    
    students.push(student);
    
    // Update application status
    applications[appIndex].status = 'approved';
    applications[appIndex].studentId = studentId;
    
    localStorage.setItem('applications', JSON.stringify(applications));
    localStorage.setItem('students', JSON.stringify(students));
    
    alert('Application approved! Student ID: ' + studentId);
    closeModal();
    loadApplications();
    loadRegisteredStudents();
    loadStudentOptions();
}

function showRejectForm() {
    document.getElementById('rejectForm').classList.remove('hidden');
}

function rejectApplication() {
    const reason = document.getElementById('rejectionReason').value;
    
    if (!reason.trim()) {
        alert('Please enter a rejection reason');
        return;
    }
    
    const applications = JSON.parse(localStorage.getItem('applications'));
    const appIndex = applications.findIndex(a => a.id === currentApplicationId);
    
    if (appIndex === -1) return;
    
    applications[appIndex].status = 'rejected';
    applications[appIndex].rejectionReason = reason;
    
    localStorage.setItem('applications', JSON.stringify(applications));
    
    alert('Application rejected');
    closeModal();
    loadApplications();
}

function closeModal() {
    document.getElementById('reviewModal').classList.add('hidden');
    document.getElementById('rejectionReason').value = '';
}

function deleteStudent(studentId) {
    if (!confirm('Are you sure you want to delete this student?')) return;
    
    const students = JSON.parse(localStorage.getItem('students'));
    const marks = JSON.parse(localStorage.getItem('marks'));
    
    const updatedStudents = students.filter(s => s.studentId !== studentId);
    delete marks[studentId];
    
    localStorage.setItem('students', JSON.stringify(updatedStudents));
    localStorage.setItem('marks', JSON.stringify(marks));
    
    loadRegisteredStudents();
    loadStudentOptions();
}

// Marks Management
function loadStudentOptions() {
    const students = JSON.parse(localStorage.getItem('students'));
    const select = document.getElementById('studentSelect');
    
    if (!select) return;
    
    select.innerHTML = '<option value="">-- Select Student --</option>';
    
    students.forEach(student => {
        const option = document.createElement('option');
        option.value = student.studentId;
        option.textContent = `${student.studentId} - ${student.fullName}`;
        select.appendChild(option);
    });
}

function loadStudentMarks() {
    const studentId = document.getElementById('studentSelect').value;
    
    if (!studentId) {
        document.getElementById('marksFormSection').classList.add('hidden');
        return;
    }
    
    document.getElementById('marksFormSection').classList.remove('hidden');
    
    const marks = JSON.parse(localStorage.getItem('marks'));
    const studentMarks = marks[studentId] || [];
    
    const tbody = document.getElementById('currentMarksBody');
    tbody.innerHTML = '';
    
    if (studentMarks.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No marks added yet</td></tr>';
        return;
    }
    
    studentMarks.forEach((mark, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${mark.subject}</td>
            <td>${mark.marks}</td>
            <td>${calculateGrade(mark.marks)}</td>
            <td>
                <button class="action-btn btn-delete" onclick="deleteMark('${studentId}', ${index})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function saveMarks(event) {
    event.preventDefault();
    
    const studentId = document.getElementById('studentSelect').value;
    const subject = document.getElementById('subject').value;
    const marksValue = parseInt(document.getElementById('marks').value);
    
    const marks = JSON.parse(localStorage.getItem('marks'));
    
    if (!marks[studentId]) {
        marks[studentId] = [];
    }
    
    marks[studentId].push({
        subject,
        marks: marksValue
    });
    
    localStorage.setItem('marks', JSON.stringify(marks));
    
    document.getElementById('subject').value = '';
    document.getElementById('marks').value = '';
    
    loadStudentMarks();
    alert('Marks added successfully!');
}

function deleteMark(studentId, index) {
    if (!confirm('Are you sure you want to delete this mark?')) return;
    
    const marks = JSON.parse(localStorage.getItem('marks'));
    marks[studentId].splice(index, 1);
    
    localStorage.setItem('marks', JSON.stringify(marks));
    loadStudentMarks();
}

// Tab Management
function showTab(tabName) {
    const tabs = document.querySelectorAll('.tab-content');
    const buttons = document.querySelectorAll('.tab-btn');
    
    tabs.forEach(tab => tab.classList.remove('active'));
    buttons.forEach(btn => btn.classList.remove('active'));
    
    document.getElementById(tabName + 'Tab').classList.add('active');
    event.target.classList.add('active');
}

// Initialize data on page load
initializeData();
