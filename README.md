# TresorCollege - School Management System

A comprehensive web-based school management system for managing students, teachers, applications, marks, and news. Built with vanilla JavaScript, HTML5, and CSS3 with no backend dependencies.

## Features

### Student Features
- **Student ID Login** - Simple authentication using Student ID only
- **View Marks** - Check academic performance across all subjects
- **View Application Status** - Track application approval/rejection status
- **View Personal Information** - Access student and guardian details

### Admin Features
- **Application Management** - Review, approve, or reject student applications
- **Student Management** - Register, edit, and delete student records
- **Teacher Management** - Register, edit, and delete teacher records with class assignments
- **Marks Management** - Add, edit, and delete student marks
- **News Management** - Create and manage school news visible on homepage
- **Full Edit Capabilities** - Edit all student and teacher information

### Teacher Management
- **Primary School (Grades 1-7)** - Teachers assigned to one class only
- **High School (Grades 8-12)** - Teachers can teach multiple subjects to multiple classes
- **Next of Kin Information** - Store emergency contact details with addresses

### Application System
- Student information (name, surname, DOB, gender, address)
- Guardian 1 and Guardian 2 details (name, relationship, phone, address)
- Address autofill functionality for convenience
- Academic information and grade selection

## Technology Stack

- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Storage**: Browser LocalStorage (no backend required)
- **Authentication**: Session-based with localStorage
- **Design**: Fully responsive (mobile, tablet, desktop, 4K+)

## Responsive Design

The system is optimized for:
- **Mobile Phones** (up to 768px)
- **Tablets** (768px - 1024px)
- **Desktop** (1024px - 1366px)
- **Large Desktop** (1366px - 1920px)
- **4K+ Screens** (1920px+)
- **Landscape modes** for phones and tablets

## File Structure

```
TresorCollege/
├── index.html          # Home page with news and login
├── student.html        # Student dashboard
├── admin.html          # Admin dashboard
├── apply.html          # Student application form
├── functions.js        # All business logic
├── home.css            # Complete styling with responsive design
└── README.md           # This file
```

## System Architecture

### Architecture Overview

```
┌─────────────────────────────────────────────────────────────────┐
│                         CLIENT BROWSER                          │
│                                                                 │
│  ┌───────────────┐  ┌───────────────┐  ┌───────────────┐     │
│  │  index.html   │  │  admin.html   │  │ student.html  │     │
│  │   (Home)      │  │   (Admin)     │  │  (Student)    │     │
│  └───────┬───────┘  └───────┬───────┘  └───────┬───────┘     │
│          │                  │                  │               │
│          └──────────────────┼──────────────────┘               │
│                             │                                  │
│                    ┌────────▼────────┐                         │
│                    │  functions.js   │                         │
│                    │ (Business Logic)│                         │
│                    └────────┬────────┘                         │
│                             │                                  │
│                    ┌────────▼────────┐                         │
│                    │  localStorage   │                         │
│                    │  (Data Layer)   │                         │
│                    └─────────────────┘                         │
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
```

### How It Works

#### 1. **Application Entry Points**

**Homepage (index.html)**
- Displays school news
- Role selection (Student/Admin/Applicant)
- Dynamic login form based on role
- Navigation to apply.html for new applicants

**Flow:**
```
User visits index.html
    ├─→ Select "Student" → Enter Student ID → student.html
    ├─→ Select "Admin" → Enter credentials → admin.html
    └─→ Click "Apply Now" → apply.html
```

#### 2. **Authentication System**

**Student Authentication:**
```javascript
sessionStorage: {
    isLoggedIn: true,
    userRole: 'student',
    studentId: 'STD1000'
}
```

**Admin Authentication:**
```javascript
sessionStorage: {
    isLoggedIn: true,
    userRole: 'admin'
}

localStorage: {
    adminCredentials: {
        username: 'admin',
        password: 'admin123'
    }
}
```

#### 3. **Data Flow Architecture**

**Application Submission Flow:**
```
apply.html (Form)
    ↓
submitApplication() in functions.js
    ↓
localStorage.applications[] (pending status)
    ↓
admin.html loads pending applications
    ↓
Admin approves/rejects
    ↓
    ├─→ Approve: Create student record in localStorage.students[]
    │            Assign Student ID (STD1000, STD1001, etc.)
    └─→ Reject: Update application status with reason
```

**Marks Management Flow:**
```
Admin selects student
    ↓
loadStudentMarks() - Get student's grade
    ↓
Populate subjects based on grade level:
    ├─→ Primary (1-7): Predefined subjects with specific max marks
    └─→ High School (8-12): Custom subjects with 100 max marks
    ↓
Admin enters marks
    ↓
saveMarks() validates and stores:
    localStorage.marks[studentId] = [
        { subject, marks, maxMarks }
    ]
    ↓
Student views marks with calculated percentages
```

**Teacher Assignment Flow:**
```
Admin registers teacher
    ↓
Select teaching level (Primary/High School)
    ↓
    ├─→ Primary: Assign single class (1-7)
    │            Teacher becomes class teacher
    │
    └─→ High School: Select main class (optional)
                     Select subjects teaching
                     Select multiple classes (8-12)
    ↓
Store in localStorage.teachers[]
    ↓
System uses teacher data for:
    - Student cards (show class teacher)
    - Reports (show class teacher)
```

#### 4. **Primary School Subject Structure**

```javascript
primarySchoolSubjects = {
    1: [
        { name: 'Mathematics', maxMarks: 100 },
        { name: 'English', maxMarks: 100 },
        { name: 'Science', maxMarks: 50 },
        { name: 'Social Studies', maxMarks: 50 },
        { name: 'Art', maxMarks: 25 }
    ],
    // Grade 2-7 with progressive subjects
}
```

**How it works:**
1. When admin adds marks, system detects student's grade
2. System loads corresponding subject list
3. Subjects appear in dropdown with max marks shown
4. Validation ensures marks don't exceed maximum
5. Percentage calculated: (marks/maxMarks) × 100

#### 5. **Student Features Architecture**

**Student Dashboard (student.html):**
```
loadStudentData()
    ↓
Fetch from localStorage:
    ├─→ students[] - Personal info, guardian info
    ├─→ applications[] - Application status
    └─→ marks[studentId] - Academic performance
    ↓
Display:
    ├─→ Personal Information section
    ├─→ Application Status section
    ├─→ Marks table with percentages
    ├─→ Generate Student Card button
    └─→ Generate Report button
```

**Student Card Generation:**
```
generateStudentCard()
    ↓
Fetch: student data + teachers
    ↓
Find class teacher:
    ├─→ Primary: Teacher with assignedClass matching student grade
    └─→ High School: Teacher with mainClass matching student grade
    ↓
Populate card with:
    - School name
    - Student initials (photo placeholder)
    - Student ID, Name, Grade
    - Class Teacher name
    - Academic year
    ↓
Display modal → Print functionality
```

**Report Generation:**
```
generateReport()
    ↓
Fetch: student data + marks + teachers
    ↓
Build report table:
    - For each subject: marks, maxMarks, percentage
    - Calculate average percentage
    ↓
Format professional report with:
    - Header (school name, date)
    - Student details
    - Marks table
    - Signature section
    ↓
Display modal → Print functionality
```

#### 6. **Admin Dashboard Architecture**

**Tab-based Interface:**
```
admin.html
    ├─→ Applications Tab
    │   └─→ loadApplications() → Review/Approve/Reject
    │
    ├─→ Students Tab
    │   └─→ loadRegisteredStudents() → View/Edit/Delete
    │
    ├─→ Teachers Tab
    │   └─→ loadTeachers() → Register/Edit/Delete
    │
    ├─→ Marks Tab
    │   └─→ loadStudentMarks() → Add/Edit/Delete marks
    │
    └─→ News Tab
        └─→ loadAdminNews() → Add/Delete news
```

#### 7. **Data Persistence Model**

**LocalStorage Structure:**
```javascript
localStorage = {
    applications: [
        {
            id: "APP1699876543210",
            studentId: null, // Assigned on approval
            firstName: "John",
            surname: "Doe",
            dob: "2010-05-15",
            gender: "Male",
            address: "123 Main St",
            guardian1: { fullName, phone, relationship, address },
            guardian2: { fullName, phone, relationship, address },
            grade: "5",
            status: "pending", // pending/approved/rejected
            applicationDate: "2025-11-13",
            rejectionReason: null
        }
    ],
    
    students: [
        {
            id: "STD1000",
            firstName: "John",
            surname: "Doe",
            fullName: "John Doe",
            dob: "2010-05-15",
            gender: "Male",
            grade: "5",
            studentAddress: "123 Main St",
            email: "john@example.com",
            phone: "123-456-7890",
            guardian1: { ... },
            guardian2: { ... },
            enrollmentDate: "2025-11-13"
        }
    ],
    
    teachers: [
        {
            id: "TCH1000",
            firstName: "Jane",
            lastName: "Smith",
            fullName: "Jane Smith",
            phone: "987-654-3210",
            address: "456 Oak Ave",
            level: "primary", // or "highschool"
            isPrimaryTeacher: true,
            assignedClass: "5", // Primary only
            // High school fields:
            isHighSchoolTeacher: false,
            mainClass: null,
            subjects: [],
            teachingClasses: [],
            nextOfKin: {
                name: "Bob Smith",
                phone: "555-1234",
                address: "789 Pine St",
                relationship: "Spouse"
            }
        }
    ],
    
    marks: {
        "STD1000": [
            {
                subject: "Mathematics",
                marks: 85,
                maxMarks: 100
            }
        ]
    },
    
    news: [
        {
            id: 1699876543210,
            title: "Welcome",
            content: "News content...",
            type: "announcement",
            date: "11/13/2025",
            timestamp: 1699876543210
        }
    ],
    
    adminCredentials: {
        username: "admin",
        password: "admin123"
    }
}
```

#### 8. **Responsive Design System**

**Breakpoint Strategy:**
```css
/* Mobile First Approach */
Default: Mobile (< 768px)
    ↓
@media (min-width: 768px): Tablet
    ↓
@media (min-width: 1024px): Desktop
    ↓
@media (min-width: 1366px): Large Desktop
    ↓
@media (min-width: 1920px): 4K+

/* Landscape Orientations */
@media (orientation: landscape)
    - Phone landscape
    - Tablet landscape
```

#### 9. **Security Considerations**

**Current Implementation (Client-Side Only):**
- SessionStorage for temporary login state
- LocalStorage for data persistence
- No encryption (data visible in browser)
- No server-side validation

**For Production Use (Recommendations):**
- Backend API (Node.js, PHP, Python)
- Database (MySQL, PostgreSQL, MongoDB)
- JWT authentication
- Password hashing (bcrypt)
- HTTPS encryption
- Input validation and sanitization
- Role-based access control (RBAC)

## Getting Started

### Installation

1. Clone the repository:
```bash
git clone https://github.com/Tresor101/TresorCollege.git
cd TresorCollege
```

2. Open `index.html` in your web browser

That's it! No server or installation required.

### Default Credentials

**Admin Login:**
- Username: `admin`
- Password: `admin123`

**Test Student ID:**
- Student ID: `STD1000` (for demo student)

## Usage

### For Students

1. Go to homepage (`index.html`)
2. Select "Student" role
3. Enter your Student ID
4. Click "Login"
5. View your marks and application status

### For Administrators

1. Go to homepage (`index.html`)
2. Select "Admin" role
3. Enter username and password
4. Click "Login"
5. Use the tabs to manage:
   - **Applications** - Review pending applications
   - **Students** - Manage registered students
   - **Teachers** - Manage teaching staff
   - **Marks** - Add/edit student grades
   - **News** - Manage homepage news

### For New Applicants

1. Click "Apply Now" on homepage
2. Fill out the application form:
   - Personal information
   - Guardian 1 details
   - Guardian 2 details
   - Academic information
3. Submit application
4. Note your Application ID for tracking
5. Admin will review and approve/reject

## Data Structure

### LocalStorage Keys

- `applications` - Array of student applications
- `students` - Array of registered students
- `teachers` - Array of teacher records
- `marks` - Object with student marks (key: studentId)
- `news` - Array of news items
- `adminCredentials` - Admin login credentials
- `isLoggedIn` - Session state
- `userRole` - Current user role (student/admin)
- `studentId` - Current student ID (if student logged in)

### Grade Levels

- **Primary School**: Grades 1-7
- **High School**: Grades 8-12

## Features in Detail

### Edit Functionality
- Admins can edit all student information including guardian details
- Admins can edit teacher information including next of kin and class assignments
- Dynamic forms that adapt to Primary vs High School teacher types
- All changes are saved to localStorage

### Teacher Assignment Logic
- Primary teachers: Assigned to one class
- High School teachers: Can have a main class (as class teacher) and teach multiple subjects to multiple grades
- System prevents inappropriate assignments

### News System
- Admins can add news with title, content, and date
- News displays on homepage for all visitors
- Latest news shows first

### Marks System
- Track multiple subjects per student
- Primary school subjects have predefined max marks per grade
- Percentage-based grading system
- Edit and delete marks as needed

### Student Card & Reports
- Generate professional student ID cards with school branding
- Generate detailed academic reports with all marks
- Print-ready formats for both cards and reports
- Automatic class teacher assignment based on grade

## Browser Compatibility

Works on all modern browsers:
- Chrome/Edge (recommended)
- Firefox
- Safari
- Opera

## Development

No build process required. Simply edit the HTML, CSS, or JS files and refresh your browser.

### Key Functions (functions.js)

- `initializeData()` - Initialize localStorage with default data
- `loginStudent()` / `loginAdmin()` - Authentication
- `submitApplication()` - Handle new applications
- `registerTeacher()` - Register new teachers
- `editStudent()` / `editTeacher()` - Edit functionality
- `saveMarks()` - Save student marks
- `addNews()` - Add news items
- `loadNews()` - Display news on homepage

## Future Roadmap

### MySQL Database Integration (Planned)

The application is planned to be migrated to a MySQL database backend hosted on Hostinger. This will include:

**Database Structure:**
- Replace localStorage with MySQL tables
- Persistent data storage across devices
- Better data integrity and relationships
- Support for multiple concurrent users

**Backend API:**
- RESTful API using PHP/Node.js
- Secure authentication with JWT tokens
- Password encryption (bcrypt)
- Session management
- API endpoints for all CRUD operations

**Hosting on Hostinger:**
- MySQL database hosting
- cPanel management
- PHP/Node.js backend
- SSL certificate for HTTPS
- Regular database backups

**Migration Benefits:**
- Data persists permanently (not lost on browser clear)
- Multi-user access from different devices
- Better performance for large datasets
- Advanced reporting with SQL queries
- Real-time class average calculations
- Student performance analytics

## Current Limitations

**This is a client-side application using localStorage:**
- Data is stored locally in the browser
- Data will be lost if browser data/cache is cleared
- No multi-device synchronization
- Single-user access per browser
- Limited to browser storage capacity (~10MB)

**For production use with multiple users, the MySQL database migration is essential.**

## License

This project is open source and available for educational purposes.

## Support

For issues or questions, please open an issue on GitHub.

## Author

Tresor101

---

**Note**: This is currently a client-side demo application using localStorage. A MySQL database backend hosted on Hostinger is planned for production deployment to enable multi-user access, persistent data storage, and enterprise-level functionality.
