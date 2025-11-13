// Data Storage using localStorage
let currentRole = null;
let currentApplicationId = null;

// Primary School Subjects by Grade
const primarySchoolSubjects = {
    1: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 50 },
        { name: 'Social Studies', maxMarks: 50 },
        { name: 'Art', maxMarks: 25 }
    ],
    2: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 50 },
        { name: 'Social Studies', maxMarks: 50 },
        { name: 'Art', maxMarks: 25 },
        { name: 'Physical Education', maxMarks: 25 }
    ],
    3: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 75 },
        { name: 'Social Studies', maxMarks: 75 },
        { name: 'Art', maxMarks: 25 },
        { name: 'Physical Education', maxMarks: 25 }
    ],
    4: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 75 },
        { name: 'Social Studies', maxMarks: 75 },
        { name: 'Art', maxMarks: 25 },
        { name: 'Physical Education', maxMarks: 25 },
        { name: 'Computer Studies', maxMarks: 50 }
    ],
    5: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 100 },
        { name: 'Social Studies', maxMarks: 100 },
        { name: 'Art', maxMarks: 25 },
        { name: 'Physical Education', maxMarks: 25 },
        { name: 'Computer Studies', maxMarks: 50 }
    ],
    6: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 100 },
        { name: 'Social Studies', maxMarks: 100 },
        { name: 'Art', maxMarks: 25 },
        { name: 'Physical Education', maxMarks: 25 },
        { name: 'Computer Studies', maxMarks: 50 },
        { name: 'French', maxMarks: 50 }
    ],
    7: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 100 },
        { name: 'Social Studies', maxMarks: 100 },
        { name: 'Art', maxMarks: 25 },
        { name: 'Physical Education', maxMarks: 25 },
        { name: 'Computer Studies', maxMarks: 50 },
        { name: 'French', maxMarks: 50 }
    ]
};

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
    if (!localStorage.getItem('news')) {
        // Initialize with some default news
        localStorage.setItem('news', JSON.stringify([
            {
                id: Date.now(),
                title: 'Welcome to Tresor College',
                content: 'We are excited to announce our new online student management system. Students can now check their marks and application status online!',
                type: 'announcement',
                date: new Date().toLocaleDateString(),
                timestamp: Date.now()
            }
        ]));
    }
    if (!localStorage.getItem('teachers')) {
        localStorage.setItem('teachers', JSON.stringify([]));
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
    const surname = document.getElementById('surname').value;
    const dob = document.getElementById('dob').value;
    const gender = document.getElementById('gender').value;
    const studentAddress = document.getElementById('studentAddress').value;
    
    const guardian1FullName = document.getElementById('guardian1FullName').value;
    const guardian1Phone = document.getElementById('guardian1Phone').value;
    const guardian1Relationship = document.getElementById('guardian1Relationship').value;
    const guardian1Address = document.getElementById('guardian1Address').value;
    
    const guardian2FullName = document.getElementById('guardian2FullName').value;
    const guardian2Phone = document.getElementById('guardian2Phone').value;
    const guardian2Relationship = document.getElementById('guardian2Relationship').value;
    const guardian2Address = document.getElementById('guardian2Address').value;
    
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const previousSchool = document.getElementById('previousSchool').value;
    const grade = document.getElementById('grade').value;
    
    // Create application
    const application = {
        id: 'APP' + Date.now(),
        firstName,
        surname,
        fullName: firstName + ' ' + surname,
        dob,
        gender,
        studentAddress,
        guardian1: {
            fullName: guardian1FullName,
            phone: guardian1Phone,
            relationship: guardian1Relationship,
            address: guardian1Address
        },
        guardian2: {
            fullName: guardian2FullName,
            phone: guardian2Phone,
            relationship: guardian2Relationship,
            address: guardian2Address
        },
        email,
        phone,
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

// Autofill address function
function autofillAddress(guardianNumber, source = 'student') {
    const checkbox1 = document.getElementById('sameAsStudent' + guardianNumber);
    const checkbox2 = guardianNumber === 2 ? document.getElementById('sameAsGuardian1') : null;
    
    if (guardianNumber === 1) {
        if (checkbox1.checked) {
            const studentAddress = document.getElementById('studentAddress').value;
            document.getElementById('guardian1Address').value = studentAddress;
        } else {
            document.getElementById('guardian1Address').value = '';
        }
    } else if (guardianNumber === 2) {
        // Uncheck other checkbox
        if (source === 'student') {
            if (checkbox2) checkbox2.checked = false;
            if (checkbox1.checked) {
                const studentAddress = document.getElementById('studentAddress').value;
                document.getElementById('guardian2Address').value = studentAddress;
            } else {
                document.getElementById('guardian2Address').value = '';
            }
        } else if (source === 'guardian1') {
            if (checkbox1) checkbox1.checked = false;
            if (checkbox2.checked) {
                const guardian1Address = document.getElementById('guardian1Address').value;
                document.getElementById('guardian2Address').value = guardian1Address;
            } else {
                document.getElementById('guardian2Address').value = '';
            }
        }
    }
}

// Autofill address for teacher's next of kin
function autofillTeacherAddress() {
    const checkbox = document.getElementById('sameAsTeacher');
    
    if (checkbox.checked) {
        const teacherAddress = document.getElementById('teacherAddress').value;
        document.getElementById('nextOfKinAddress').value = teacherAddress;
    } else {
        document.getElementById('nextOfKinAddress').value = '';
    }
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
    
    // Display additional student info if available
    if (document.getElementById('dobDisplay')) {
        document.getElementById('dobDisplay').textContent = userData.dob || 'N/A';
    }
    if (document.getElementById('genderDisplay')) {
        document.getElementById('genderDisplay').textContent = userData.gender || 'N/A';
    }
    if (document.getElementById('studentAddressDisplay')) {
        document.getElementById('studentAddressDisplay').textContent = userData.studentAddress || userData.address || 'N/A';
    }
    
    // Display guardian information if available
    if (userData.guardian1 && document.getElementById('guardian1Name')) {
        document.getElementById('guardian1Name').textContent = userData.guardian1.fullName;
        document.getElementById('guardian1Relationship').textContent = userData.guardian1.relationship;
        document.getElementById('guardian1Phone').textContent = userData.guardian1.phone;
    }
    if (userData.guardian2 && document.getElementById('guardian2Name')) {
        document.getElementById('guardian2Name').textContent = userData.guardian2.fullName;
        document.getElementById('guardian2Relationship').textContent = userData.guardian2.relationship;
        document.getElementById('guardian2Phone').textContent = userData.guardian2.phone;
    }
    
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
        let totalPercentage = 0;
        
        marksBody.innerHTML = '';
        studentMarks.forEach(mark => {
            const maxMarks = mark.maxMarks || 100;
            const percentage = ((mark.marks / maxMarks) * 100).toFixed(1);
            totalPercentage += parseFloat(percentage);
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${mark.subject}</td>
                <td>${mark.marks}</td>
                <td>${maxMarks}</td>
                <td>${percentage}%</td>
            `;
            marksBody.appendChild(row);
        });
        
        const average = (totalPercentage / studentMarks.length).toFixed(1);
        document.getElementById('averageMarks').textContent = average + '%';
    } else {
        marksBody.innerHTML = '<tr><td colspan="4" style="text-align: center;">No marks available yet</td></tr>';
        document.getElementById('averageMarks').textContent = 'N/A';
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

// Student Card and Report Functions
function generateStudentCard() {
    const studentId = sessionStorage.getItem('studentId');
    const students = JSON.parse(localStorage.getItem('students'));
    const student = students.find(s => s.id === studentId);
    
    if (!student) {
        alert('Student information not found');
        return;
    }
    
    // Get class teacher
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const grade = parseInt(student.grade);
    let classTeacher = 'Not Assigned';
    
    if (grade >= 1 && grade <= 7) {
        // Primary school - find teacher assigned to this grade
        const teacher = teachers.find(t => t.isPrimaryTeacher && parseInt(t.assignedClass) === grade);
        if (teacher) classTeacher = teacher.fullName;
    } else if (grade >= 8 && grade <= 12) {
        // High school - find main class teacher
        const teacher = teachers.find(t => t.isHighSchoolTeacher && parseInt(t.mainClass) === grade);
        if (teacher) classTeacher = teacher.fullName;
    }
    
    // Get initials for photo placeholder
    const initials = student.firstName.charAt(0) + student.surname.charAt(0);
    
    // Populate card
    document.getElementById('cardInitials').textContent = initials.toUpperCase();
    document.getElementById('cardStudentId').textContent = student.id;
    document.getElementById('cardStudentName').textContent = student.fullName;
    document.getElementById('cardGrade').textContent = `Grade ${student.grade}`;
    document.getElementById('cardTeacher').textContent = classTeacher;
    document.getElementById('cardYear').textContent = new Date().getFullYear() + ' - ' + (new Date().getFullYear() + 1);
    
    // Show modal
    document.getElementById('studentCardModal').classList.remove('hidden');
}

function closeStudentCard() {
    document.getElementById('studentCardModal').classList.add('hidden');
}

function printStudentCard() {
    window.print();
}

function generateReport() {
    const studentId = sessionStorage.getItem('studentId');
    const students = JSON.parse(localStorage.getItem('students'));
    const student = students.find(s => s.id === studentId);
    const marks = JSON.parse(localStorage.getItem('marks'));
    const studentMarks = marks[studentId] || [];
    
    if (!student) {
        alert('Student information not found');
        return;
    }
    
    if (studentMarks.length === 0) {
        alert('No marks available to generate report');
        return;
    }
    
    // Get class teacher
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const grade = parseInt(student.grade);
    let classTeacher = 'Not Assigned';
    
    if (grade >= 1 && grade <= 7) {
        const teacher = teachers.find(t => t.isPrimaryTeacher && parseInt(t.assignedClass) === grade);
        if (teacher) classTeacher = teacher.fullName;
    } else if (grade >= 8 && grade <= 12) {
        const teacher = teachers.find(t => t.isHighSchoolTeacher && parseInt(t.mainClass) === grade);
        if (teacher) classTeacher = teacher.fullName;
    }
    
    // Populate report header
    document.getElementById('reportDate').textContent = 'Report Generated: ' + new Date().toLocaleDateString();
    document.getElementById('reportStudentId').textContent = student.id;
    document.getElementById('reportStudentName').textContent = student.fullName;
    document.getElementById('reportGrade').textContent = `Grade ${student.grade}`;
    document.getElementById('reportTeacher').textContent = classTeacher;
    
    // Populate marks table
    const tbody = document.getElementById('reportMarksBody');
    tbody.innerHTML = '';
    
    let totalPercentage = 0;
    
    studentMarks.forEach(mark => {
        const maxMarks = mark.maxMarks || 100;
        const percentage = ((mark.marks / maxMarks) * 100).toFixed(1);
        totalPercentage += parseFloat(percentage);
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${mark.subject}</td>
            <td>${mark.marks}</td>
            <td>${maxMarks}</td>
            <td>${percentage}%</td>
        `;
        tbody.appendChild(row);
    });
    
    const average = (totalPercentage / studentMarks.length).toFixed(1);
    
    document.getElementById('reportAverage').textContent = average + '%';
    
    // Show modal
    document.getElementById('reportModal').classList.remove('hidden');
}

function closeReport() {
    document.getElementById('reportModal').classList.add('hidden');
}

function printReport() {
    window.print();
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
            <td>${app.studentId || '-'}</td>
            <td>${app.fullName}</td>
            <td>${app.grade}</td>
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
            <td>${student.grade || 'N/A'}</td>
            <td>${student.email}</td>
            <td>${student.phone}</td>
            <td>${student.registrationDate}</td>
            <td>
                <button class="action-btn btn-view" onclick="editStudent('${student.studentId}')">Edit</button>
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
        <p><strong>Date of Birth:</strong> ${app.dob}</p>
        <p><strong>Gender:</strong> ${app.gender || 'N/A'}</p>
        <p><strong>Student Address:</strong> ${app.studentAddress}</p>
        <hr style="margin: 15px 0;">
        <p><strong>Guardian 1:</strong> ${app.guardian1.fullName}</p>
        <p><strong>Relationship:</strong> ${app.guardian1.relationship}</p>
        <p><strong>Phone:</strong> ${app.guardian1.phone}</p>
        <p><strong>Address:</strong> ${app.guardian1.address}</p>
        <hr style="margin: 15px 0;">
        <p><strong>Guardian 2:</strong> ${app.guardian2.fullName}</p>
        <p><strong>Relationship:</strong> ${app.guardian2.relationship}</p>
        <p><strong>Phone:</strong> ${app.guardian2.phone}</p>
        <p><strong>Address:</strong> ${app.guardian2.address}</p>
        <hr style="margin: 15px 0;">
        <p><strong>Email:</strong> ${app.email}</p>
        <p><strong>Contact Phone:</strong> ${app.phone}</p>
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
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('rejectionReason').value = '';
}

// Edit Student Function
function editStudent(studentId) {
    const students = JSON.parse(localStorage.getItem('students'));
    const student = students.find(s => s.studentId === studentId);
    
    if (!student) return;
    
    document.getElementById('editModalTitle').textContent = 'Edit Student Information';
    document.getElementById('editFormContainer').innerHTML = `
        <form id="editStudentForm" onsubmit="saveStudentEdit(event, '${studentId}')">
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" id="editFirstName" value="${student.firstName}" required>
            </div>
            <div class="form-group">
                <label>Surname:</label>
                <input type="text" id="editSurname" value="${student.surname}" required>
            </div>
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" id="editDob" value="${student.dob}" required>
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <select id="editGender" required>
                    <option value="Male" ${student.gender === 'Male' ? 'selected' : ''}>Male</option>
                    <option value="Female" ${student.gender === 'Female' ? 'selected' : ''}>Female</option>
                </select>
            </div>
            <div class="form-group">
                <label>Grade:</label>
                <select id="editGrade" required>
                    <option value="">-- Select Grade --</option>
                    <optgroup label="Primary School">
                        ${[1,2,3,4,5,6,7].map(g => `<option value="${g}" ${student.grade == g ? 'selected' : ''}>Grade ${g}</option>`).join('')}
                    </optgroup>
                    <optgroup label="High School">
                        ${[8,9,10,11,12].map(g => `<option value="${g}" ${student.grade == g ? 'selected' : ''}>Grade ${g}</option>`).join('')}
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label>Student Address:</label>
                <textarea id="editStudentAddress" rows="3" required>${student.studentAddress || student.address || ''}</textarea>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" id="editEmail" value="${student.email}" required>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="tel" id="editPhone" value="${student.phone}" required>
            </div>
            <h3 style="color: #667eea; margin-top: 20px;">Guardian 1</h3>
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" id="editGuardian1Name" value="${student.guardian1?.fullName || ''}" required>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="tel" id="editGuardian1Phone" value="${student.guardian1?.phone || ''}" required>
            </div>
            <div class="form-group">
                <label>Relationship:</label>
                <select id="editGuardian1Relationship" required>
                    <option value="">-- Select --</option>
                    ${['Father', 'Mother', 'Grandfather', 'Grandmother', 'Uncle', 'Aunt', 'Brother', 'Sister', 'Legal Guardian', 'Other'].map(rel => 
                        `<option value="${rel}" ${student.guardian1?.relationship === rel ? 'selected' : ''}>${rel}</option>`
                    ).join('')}
                </select>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <textarea id="editGuardian1Address" rows="2" required>${student.guardian1?.address || ''}</textarea>
            </div>
            <h3 style="color: #667eea; margin-top: 20px;">Guardian 2</h3>
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" id="editGuardian2Name" value="${student.guardian2?.fullName || ''}" required>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="tel" id="editGuardian2Phone" value="${student.guardian2?.phone || ''}" required>
            </div>
            <div class="form-group">
                <label>Relationship:</label>
                <select id="editGuardian2Relationship" required>
                    <option value="">-- Select --</option>
                    ${['Father', 'Mother', 'Grandfather', 'Grandmother', 'Uncle', 'Aunt', 'Brother', 'Sister', 'Legal Guardian', 'Other'].map(rel => 
                        `<option value="${rel}" ${student.guardian2?.relationship === rel ? 'selected' : ''}>${rel}</option>`
                    ).join('')}
                </select>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <textarea id="editGuardian2Address" rows="2" required>${student.guardian2?.address || ''}</textarea>
            </div>
            <div class="modal-actions">
                <button type="submit" class="btn-success">Save Changes</button>
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    `;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function saveStudentEdit(event, studentId) {
    event.preventDefault();
    
    const students = JSON.parse(localStorage.getItem('students'));
    const studentIndex = students.findIndex(s => s.studentId === studentId);
    
    if (studentIndex === -1) return;
    
    const firstName = document.getElementById('editFirstName').value;
    const surname = document.getElementById('editSurname').value;
    
    students[studentIndex].firstName = firstName;
    students[studentIndex].surname = surname;
    students[studentIndex].fullName = firstName + ' ' + surname;
    students[studentIndex].dob = document.getElementById('editDob').value;
    students[studentIndex].gender = document.getElementById('editGender').value;
    students[studentIndex].grade = document.getElementById('editGrade').value;
    students[studentIndex].studentAddress = document.getElementById('editStudentAddress').value;
    students[studentIndex].email = document.getElementById('editEmail').value;
    students[studentIndex].phone = document.getElementById('editPhone').value;
    
    students[studentIndex].guardian1 = {
        fullName: document.getElementById('editGuardian1Name').value,
        phone: document.getElementById('editGuardian1Phone').value,
        relationship: document.getElementById('editGuardian1Relationship').value,
        address: document.getElementById('editGuardian1Address').value
    };
    
    students[studentIndex].guardian2 = {
        fullName: document.getElementById('editGuardian2Name').value,
        phone: document.getElementById('editGuardian2Phone').value,
        relationship: document.getElementById('editGuardian2Relationship').value,
        address: document.getElementById('editGuardian2Address').value
    };
    
    localStorage.setItem('students', JSON.stringify(students));
    
    closeModal();
    loadRegisteredStudents();
    alert('Student information updated successfully!');
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
    const subjectSelect = document.getElementById('subject');
    
    if (!studentId) {
        document.getElementById('marksFormSection').classList.add('hidden');
        return;
    }
    
    document.getElementById('marksFormSection').classList.remove('hidden');
    
    // Get student's grade to load appropriate subjects
    const students = JSON.parse(localStorage.getItem('students'));
    const student = students.find(s => s.id === studentId);
    
    if (!student) return;
    
    const grade = parseInt(student.grade);
    
    // Populate subject dropdown based on grade
    subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';
    
    if (grade >= 1 && grade <= 7) {
        // Primary school - use predefined subjects
        const subjects = primarySchoolSubjects[grade] || [];
        subjects.forEach(subject => {
            const option = document.createElement('option');
            option.value = subject.name;
            option.textContent = `${subject.name} (Max: ${subject.maxMarks})`;
            option.dataset.maxMarks = subject.maxMarks;
            subjectSelect.appendChild(option);
        });
    } else {
        // High school - allow custom subjects with 100 max marks
        const marks = JSON.parse(localStorage.getItem('marks'));
        const studentMarks = marks[studentId] || [];
        const uniqueSubjects = [...new Set(studentMarks.map(m => m.subject))];
        
        uniqueSubjects.forEach(subj => {
            const option = document.createElement('option');
            option.value = subj;
            option.textContent = `${subj} (Max: 100)`;
            option.dataset.maxMarks = 100;
            subjectSelect.appendChild(option);
        });
        
        // Add custom subject option
        const customOption = document.createElement('option');
        customOption.value = 'custom';
        customOption.textContent = '+ Add New Subject';
        customOption.dataset.maxMarks = 100;
        subjectSelect.appendChild(customOption);
    }
    
    const marks = JSON.parse(localStorage.getItem('marks'));
    const studentMarks = marks[studentId] || [];
    
    const tbody = document.getElementById('currentMarksBody');
    tbody.innerHTML = '';
    
    if (studentMarks.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No marks added yet</td></tr>';
        return;
    }
    
    studentMarks.forEach((mark, index) => {
        const maxMarks = mark.maxMarks || 100;
        const percentage = ((mark.marks / maxMarks) * 100).toFixed(1);
        
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${mark.subject}</td>
            <td>${mark.marks}</td>
            <td>${maxMarks}</td>
            <td>${percentage}%</td>
            <td>
                <button class="action-btn btn-delete" onclick="deleteMark('${studentId}', ${index})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Update max marks info when subject changes
function updateMaxMarks() {
    const subjectSelect = document.getElementById('subject');
    const marksInput = document.getElementById('marks');
    const maxMarksInfo = document.getElementById('maxMarksInfo');
    
    const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
    if (selectedOption && selectedOption.dataset.maxMarks) {
        const maxMarks = selectedOption.dataset.maxMarks;
        marksInput.max = maxMarks;
        maxMarksInfo.textContent = `Maximum marks: ${maxMarks}`;
    } else {
        marksInput.max = 100;
        maxMarksInfo.textContent = '';
    }
}

function saveMarks(event) {
    event.preventDefault();
    
    const studentId = document.getElementById('studentSelect').value;
    const subjectSelect = document.getElementById('subject');
    let subject = subjectSelect.value;
    const marksValue = parseInt(document.getElementById('marks').value);
    
    if (!subject) {
        alert('Please select a subject');
        return;
    }
    
    // Handle custom subject for high school
    if (subject === 'custom') {
        subject = prompt('Enter the subject name:');
        if (!subject || subject.trim() === '') {
            alert('Subject name is required');
            return;
        }
        subject = subject.trim();
    }
    
    const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
    const maxMarks = parseInt(selectedOption.dataset.maxMarks) || 100;
    
    if (marksValue > maxMarks) {
        alert(`Marks cannot exceed ${maxMarks} for this subject`);
        return;
    }
    
    const marks = JSON.parse(localStorage.getItem('marks'));
    
    if (!marks[studentId]) {
        marks[studentId] = [];
    }
    
    // Check if subject already has marks
    const existingIndex = marks[studentId].findIndex(m => m.subject === subject);
    if (existingIndex !== -1) {
        if (!confirm(`${subject} already has marks. Do you want to replace them?`)) {
            return;
        }
        marks[studentId][existingIndex] = {
            subject,
            marks: marksValue,
            maxMarks
        };
    } else {
        marks[studentId].push({
            subject,
            marks: marksValue,
            maxMarks
        });
    }
    
    localStorage.setItem('marks', JSON.stringify(marks));
    
    document.getElementById('subject').value = '';
    document.getElementById('marks').value = '';
    document.getElementById('maxMarksInfo').textContent = '';
    
    loadStudentMarks();
    alert('Marks saved successfully!');
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

// News Management Functions
function loadNews() {
    const news = JSON.parse(localStorage.getItem('news'));
    const container = document.getElementById('newsContainer');
    
    if (!container) return;
    
    container.innerHTML = '';
    
    if (news.length === 0) {
        container.innerHTML = '<p class="no-news">No news available at the moment.</p>';
        return;
    }
    
    // Sort news by timestamp (newest first) and show latest 5
    const sortedNews = news.sort((a, b) => b.timestamp - a.timestamp).slice(0, 5);
    
    sortedNews.forEach(item => {
        const newsCard = document.createElement('div');
        newsCard.className = 'news-card news-' + item.type;
        newsCard.innerHTML = `
            <div class="news-header">
                <h3>${item.title}</h3>
                <span class="news-date">${item.date}</span>
            </div>
            <p class="news-content">${item.content}</p>
        `;
        container.appendChild(newsCard);
    });
}

function loadAdminNews() {
    const news = JSON.parse(localStorage.getItem('news'));
    const container = document.getElementById('adminNewsContainer');
    
    if (!container) return;
    
    container.innerHTML = '';
    
    if (news.length === 0) {
        container.innerHTML = '<p class="no-news">No news published yet.</p>';
        return;
    }
    
    // Sort news by timestamp (newest first)
    const sortedNews = news.sort((a, b) => b.timestamp - a.timestamp);
    
    sortedNews.forEach(item => {
        const newsCard = document.createElement('div');
        newsCard.className = 'news-card news-' + item.type;
        newsCard.innerHTML = `
            <div class="news-header">
                <h3>${item.title}</h3>
                <span class="news-date">${item.date}</span>
            </div>
            <p class="news-content">${item.content}</p>
            <button class="action-btn btn-delete" onclick="deleteNews(${item.id})">Delete</button>
        `;
        container.appendChild(newsCard);
    });
}

function addNews(event) {
    event.preventDefault();
    
    const title = document.getElementById('newsTitle').value;
    const content = document.getElementById('newsContent').value;
    const type = document.getElementById('newsType').value;
    
    const newsItem = {
        id: Date.now(),
        title,
        content,
        type,
        date: new Date().toLocaleDateString(),
        timestamp: Date.now()
    };
    
    const news = JSON.parse(localStorage.getItem('news'));
    news.push(newsItem);
    localStorage.setItem('news', JSON.stringify(news));
    
    // Clear form
    document.getElementById('newsTitle').value = '';
    document.getElementById('newsContent').value = '';
    document.getElementById('newsType').value = 'announcement';
    
    loadAdminNews();
    alert('News published successfully!');
}

// Teacher Management Functions
function handleTeacherLevelChange() {
    const level = document.getElementById('teacherLevel').value;
    const primaryFields = document.getElementById('primaryFields');
    const highschoolFields = document.getElementById('highschoolFields');
    
    if (level === 'primary') {
        primaryFields.classList.remove('hidden');
        highschoolFields.classList.add('hidden');
        document.getElementById('primaryClass').required = true;
        document.getElementById('subjects').required = false;
    } else if (level === 'highschool') {
        primaryFields.classList.add('hidden');
        highschoolFields.classList.remove('hidden');
        document.getElementById('primaryClass').required = false;
        document.getElementById('subjects').required = true;
    } else {
        primaryFields.classList.add('hidden');
        highschoolFields.classList.add('hidden');
    }
}

function registerTeacher(event) {
    event.preventDefault();
    
    const firstName = document.getElementById('teacherFirstName').value;
    const lastName = document.getElementById('teacherLastName').value;
    const phone = document.getElementById('teacherPhone').value;
    const address = document.getElementById('teacherAddress').value;
    const nextOfKinName = document.getElementById('nextOfKinName').value;
    const nextOfKinPhone = document.getElementById('nextOfKinPhone').value;
    const nextOfKinAddress = document.getElementById('nextOfKinAddress').value;
    const nextOfKinRelationship = document.getElementById('nextOfKinRelationship').value;
    const level = document.getElementById('teacherLevel').value;
    
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const teacherId = 'TCH' + (1000 + teachers.length);
    
    let teacher = {
        id: teacherId,
        firstName,
        lastName,
        fullName: firstName + ' ' + lastName,
        phone,
        address,
        nextOfKin: {
            name: nextOfKinName,
            phone: nextOfKinPhone,
            address: nextOfKinAddress,
            relationship: nextOfKinRelationship
        },
        level,
        registrationDate: new Date().toLocaleDateString()
    };
    
    if (level === 'primary') {
        const primaryClass = document.getElementById('primaryClass').value;
        teacher.assignedClass = primaryClass;
        teacher.isPrimaryTeacher = true;
    } else if (level === 'highschool') {
        const mainClass = document.getElementById('mainClass').value;
        const subjects = document.getElementById('subjects').value;
        const checkboxes = document.querySelectorAll('#highschoolFields .checkbox-grid input[type="checkbox"]:checked');
        const teachingClasses = Array.from(checkboxes).map(cb => cb.value);
        
        teacher.mainClass = mainClass || null;
        teacher.subjects = subjects.split(',').map(s => s.trim()).filter(s => s);
        teacher.teachingClasses = teachingClasses;
        teacher.isHighSchoolTeacher = true;
    }
    
    teachers.push(teacher);
    localStorage.setItem('teachers', JSON.stringify(teachers));
    
    // Reset form
    document.getElementById('teacherForm').reset();
    document.getElementById('primaryFields').classList.add('hidden');
    document.getElementById('highschoolFields').classList.add('hidden');
    
    // Uncheck all checkboxes
    document.querySelectorAll('#highschoolFields .checkbox-grid input[type="checkbox"]').forEach(cb => {
        cb.checked = false;
    });
    
    loadTeachers();
    alert('Teacher registered successfully!\nTeacher ID: ' + teacherId);
}

function loadTeachers() {
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const tbody = document.getElementById('teachersBody');
    
    if (!tbody) return;
    
    tbody.innerHTML = '';
    
    if (teachers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align: center;">No teachers registered yet</td></tr>';
        return;
    }
    
    teachers.forEach(teacher => {
        const row = document.createElement('tr');
        
        let classInfo = '';
        if (teacher.isPrimaryTeacher) {
            classInfo = `Grade ${teacher.assignedClass}`;
        } else if (teacher.isHighSchoolTeacher) {
            const subjectList = teacher.subjects.join(', ');
            const classList = teacher.teachingClasses.map(c => `G${c}`).join(', ');
            const mainClassInfo = teacher.mainClass ? ` (Main: G${teacher.mainClass})` : '';
            classInfo = `${subjectList}<br><small>Classes: ${classList}${mainClassInfo}</small>`;
        }
        
        row.innerHTML = `
            <td>${teacher.id}</td>
            <td>${teacher.fullName}</td>
            <td>${teacher.level === 'primary' ? 'Primary' : 'High School'}</td>
            <td>${classInfo}</td>
            <td>${teacher.phone}</td>
            <td>${teacher.nextOfKin.name}<br><small>${teacher.nextOfKin.relationship}</small></td>
            <td>
                <button class="action-btn btn-view" onclick="editTeacher('${teacher.id}')">Edit</button>
                <button class="action-btn btn-delete" onclick="deleteTeacher('${teacher.id}')">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

// Edit Teacher Function
function editTeacher(teacherId) {
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const teacher = teachers.find(t => t.id === teacherId);
    
    if (!teacher) return;
    
    const isPrimary = teacher.level === 'primary';
    const isHighSchool = teacher.level === 'highschool';
    
    document.getElementById('editModalTitle').textContent = 'Edit Teacher Information';
    document.getElementById('editFormContainer').innerHTML = `
        <form id="editTeacherForm" onsubmit="saveTeacherEdit(event, '${teacherId}')">
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" id="editTeacherFirstName" value="${teacher.firstName}" required>
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" id="editTeacherLastName" value="${teacher.lastName}" required>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="tel" id="editTeacherPhone" value="${teacher.phone}" required>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <textarea id="editTeacherAddress" rows="3" required>${teacher.address}</textarea>
            </div>
            <h3 style="color: #667eea; margin-top: 20px;">Next of Kin</h3>
            <div class="form-group">
                <label>Name:</label>
                <input type="text" id="editNextOfKinName" value="${teacher.nextOfKin.name}" required>
            </div>
            <div class="form-group">
                <label>Phone:</label>
                <input type="tel" id="editNextOfKinPhone" value="${teacher.nextOfKin.phone}" required>
            </div>
            <div class="form-group">
                <label>Address:</label>
                <textarea id="editNextOfKinAddress" rows="3" required>${teacher.nextOfKin.address}</textarea>
            </div>
            <div class="form-group">
                <label>Relationship:</label>
                <select id="editNextOfKinRelationship" required>
                    ${['Spouse', 'Parent', 'Sibling', 'Child', 'Friend', 'Other'].map(rel => 
                        `<option value="${rel}" ${teacher.nextOfKin.relationship === rel ? 'selected' : ''}>${rel}</option>`
                    ).join('')}
                </select>
            </div>
            <h3 style="color: #667eea; margin-top: 20px;">Teaching Assignment</h3>
            <div class="form-group">
                <label>Teaching Level:</label>
                <select id="editTeacherLevel" onchange="handleEditTeacherLevelChange()" required>
                    <option value="primary" ${isPrimary ? 'selected' : ''}>Primary School (Grade 1-7)</option>
                    <option value="highschool" ${isHighSchool ? 'selected' : ''}>High School (Grade 8-12)</option>
                </select>
            </div>
            
            <div id="editPrimaryFields" class="${!isPrimary ? 'hidden' : ''}">
                <div class="form-group">
                    <label>Assigned Class:</label>
                    <select id="editPrimaryClass">
                        ${[1,2,3,4,5,6,7].map(g => 
                            `<option value="${g}" ${teacher.assignedClass == g ? 'selected' : ''}>Grade ${g}</option>`
                        ).join('')}
                    </select>
                </div>
            </div>
            
            <div id="editHighschoolFields" class="${!isHighSchool ? 'hidden' : ''}">
                <div class="form-group">
                    <label>Main Class (Class Teacher):</label>
                    <select id="editMainClass">
                        <option value="">-- None --</option>
                        ${[8,9,10,11,12].map(g => 
                            `<option value="${g}" ${teacher.mainClass == g ? 'selected' : ''}>Grade ${g}</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <label>Subjects Teaching:</label>
                    <input type="text" id="editSubjects" value="${teacher.subjects?.join(', ') || ''}" placeholder="e.g., Mathematics, Physics">
                </div>
                <div class="form-group">
                    <label>Classes Teaching:</label>
                    <div class="checkbox-grid">
                        ${[8,9,10,11,12].map(g => 
                            `<label><input type="checkbox" class="editTeachingClass" value="${g}" ${teacher.teachingClasses?.includes(g.toString()) ? 'checked' : ''}> Grade ${g}</label>`
                        ).join('')}
                    </div>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="submit" class="btn-success">Save Changes</button>
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
            </div>
        </form>
    `;
    
    document.getElementById('editModal').classList.remove('hidden');
}

function handleEditTeacherLevelChange() {
    const level = document.getElementById('editTeacherLevel').value;
    const primaryFields = document.getElementById('editPrimaryFields');
    const highschoolFields = document.getElementById('editHighschoolFields');
    
    if (level === 'primary') {
        primaryFields.classList.remove('hidden');
        highschoolFields.classList.add('hidden');
    } else {
        primaryFields.classList.add('hidden');
        highschoolFields.classList.remove('hidden');
    }
}

function saveTeacherEdit(event, teacherId) {
    event.preventDefault();
    
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const teacherIndex = teachers.findIndex(t => t.id === teacherId);
    
    if (teacherIndex === -1) return;
    
    const firstName = document.getElementById('editTeacherFirstName').value;
    const lastName = document.getElementById('editTeacherLastName').value;
    const level = document.getElementById('editTeacherLevel').value;
    
    teachers[teacherIndex].firstName = firstName;
    teachers[teacherIndex].lastName = lastName;
    teachers[teacherIndex].fullName = firstName + ' ' + lastName;
    teachers[teacherIndex].phone = document.getElementById('editTeacherPhone').value;
    teachers[teacherIndex].address = document.getElementById('editTeacherAddress').value;
    teachers[teacherIndex].level = level;
    
    teachers[teacherIndex].nextOfKin = {
        name: document.getElementById('editNextOfKinName').value,
        phone: document.getElementById('editNextOfKinPhone').value,
        address: document.getElementById('editNextOfKinAddress').value,
        relationship: document.getElementById('editNextOfKinRelationship').value
    };
    
    if (level === 'primary') {
        teachers[teacherIndex].assignedClass = document.getElementById('editPrimaryClass').value;
        teachers[teacherIndex].isPrimaryTeacher = true;
        teachers[teacherIndex].isHighSchoolTeacher = false;
        delete teachers[teacherIndex].mainClass;
        delete teachers[teacherIndex].subjects;
        delete teachers[teacherIndex].teachingClasses;
    } else {
        const mainClass = document.getElementById('editMainClass').value;
        const subjects = document.getElementById('editSubjects').value;
        const checkboxes = document.querySelectorAll('.editTeachingClass:checked');
        const teachingClasses = Array.from(checkboxes).map(cb => cb.value);
        
        teachers[teacherIndex].mainClass = mainClass || null;
        teachers[teacherIndex].subjects = subjects.split(',').map(s => s.trim()).filter(s => s);
        teachers[teacherIndex].teachingClasses = teachingClasses;
        teachers[teacherIndex].isHighSchoolTeacher = true;
        teachers[teacherIndex].isPrimaryTeacher = false;
        delete teachers[teacherIndex].assignedClass;
    }
    
    localStorage.setItem('teachers', JSON.stringify(teachers));
    
    closeModal();
    loadTeachers();
    alert('Teacher information updated successfully!');
}

function viewTeacher(teacherId) {
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const teacher = teachers.find(t => t.id === teacherId);
    
    if (!teacher) return;
    
    let details = `
        <p><strong>Teacher ID:</strong> ${teacher.id}</p>
        <p><strong>Name:</strong> ${teacher.fullName}</p>
        <p><strong>Phone:</strong> ${teacher.phone}</p>
        <p><strong>Address:</strong> ${teacher.address}</p>
        <p><strong>Level:</strong> ${teacher.level === 'primary' ? 'Primary School' : 'High School'}</p>
        <p><strong>Registration Date:</strong> ${teacher.registrationDate}</p>
        <hr style="margin: 15px 0;">
        <h4 style="color: #667eea;">Next of Kin Information</h4>
        <p><strong>Name:</strong> ${teacher.nextOfKin.name}</p>
        <p><strong>Phone:</strong> ${teacher.nextOfKin.phone}</p>
        <p><strong>Address:</strong> ${teacher.nextOfKin.address}</p>
        <p><strong>Relationship:</strong> ${teacher.nextOfKin.relationship}</p>
        <hr style="margin: 15px 0;">
    `;
    
    if (teacher.isPrimaryTeacher) {
        details += `<p><strong>Assigned Class:</strong> Grade ${teacher.assignedClass}</p>`;
    } else if (teacher.isHighSchoolTeacher) {
        if (teacher.mainClass) {
            details += `<p><strong>Main Class (Class Teacher):</strong> Grade ${teacher.mainClass}</p>`;
        }
        details += `<p><strong>Subjects:</strong> ${teacher.subjects.join(', ')}</p>`;
        details += `<p><strong>Teaching Classes:</strong> ${teacher.teachingClasses.map(c => 'Grade ' + c).join(', ')}</p>`;
    }
    
    document.getElementById('applicationDetails').innerHTML = details;
    document.getElementById('reviewModal').classList.remove('hidden');
    
    // Hide approval/rejection buttons
    const modalActions = document.querySelector('.modal-actions');
    modalActions.innerHTML = '<button class="btn-secondary" onclick="closeModal()">Close</button>';
}

function deleteTeacher(teacherId) {
    if (!confirm('Are you sure you want to delete this teacher?')) return;
    
    const teachers = JSON.parse(localStorage.getItem('teachers'));
    const updatedTeachers = teachers.filter(t => t.id !== teacherId);
    localStorage.setItem('teachers', JSON.stringify(updatedTeachers));
    
    loadTeachers();
}

function deleteNews(newsId) {
    if (!confirm('Are you sure you want to delete this news item?')) return;
    
    const news = JSON.parse(localStorage.getItem('news'));
    const updatedNews = news.filter(item => item.id !== newsId);
    localStorage.setItem('news', JSON.stringify(updatedNews));
    
    loadAdminNews();
}

// Initialize data on page load
initializeData();
