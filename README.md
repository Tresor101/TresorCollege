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
- Calculate letter grades automatically (A, B, C, D, F)
- Edit and delete marks as needed

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

## License

This project is open source and available for educational purposes.

## Support

For issues or questions, please open an issue on GitHub.

## Author

Tresor101

---

**Note**: This is a client-side application using localStorage. Data is stored locally in the browser and will be lost if browser data is cleared. For production use, consider implementing a backend server with a proper database.
