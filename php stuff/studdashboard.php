<?php
session_start();
require_once 'dbc.php';
include 'navbar.php';
// Use student_id from GET if provided, else from session
$student_id = $_GET['student_id'] ?? ($_SESSION['student_id'] ?? null);
$student = null;
$results = [];
$error = '';
if ($student_id) {
  $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
  $stmt->bind_param('s', $student_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result && $result->num_rows > 0) {
    $student = $result->fetch_assoc();
    // Only fetch results if student_subject_results table exists
    $student_numeric_id = $student['id'];
    $table_check = $conn->query("SHOW TABLES LIKE 'student_subject_results'");
    if ($table_check && $table_check->num_rows > 0) {
      $grades_stmt = $conn->prepare("SELECT subjects.name AS subject, ssr.score, ssr.grade, ssr.remark FROM student_subject_results ssr JOIN subjects ON ssr.subject_id = subjects.id WHERE ssr.student_id = ?");
      $grades_stmt->bind_param('i', $student_numeric_id);
      $grades_stmt->execute();
      $grades_result = $grades_stmt->get_result();
      while ($row = $grades_result->fetch_assoc()) {
        $results[] = $row;
      }
      $grades_stmt->close();
    }
  } else {
    $error = 'Student record not found.';
  }
  $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(270deg, #3a415a, #2d3748, #4b5563, #3a415a, #232946);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    .topbar {
      background: linear-gradient(120deg, #0ea5e9, #2563eb);
      color: #fff;
      border-radius: 1rem;
      padding: 1rem 1.25rem;
      box-shadow: 0 14px 30px rgba(30, 41, 59, 0.15);
    }
    .dashboard-card {
      border: 1px solid #e2e8f0;
      border-radius: 1rem;
      box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
    }
    .stat-card {
      border-radius: 0.85rem;
      color: #fff;
      padding: 1rem;
      min-height: 110px;
    }
    .stat-attendance { background: linear-gradient(120deg, #0ea5e9, #2563eb); }
    .stat-average { background: linear-gradient(120deg, #8b5cf6, #7c3aed); }
    .stat-assignments { background: linear-gradient(120deg, #f97316, #ef4444); }
    .section-title {
      font-size: 0.95rem;
      font-weight: 700;
      color: #334155;
      margin-bottom: 0.85rem;
    }
    .quick-btn {
      border-radius: 0.7rem;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container py-4 py-lg-5">
    <div class="topbar mb-4">
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
          <h1 class="h4 mb-1">Student Dashboard</h1>
          <p class="mb-0 small">
            <?php if ($student): ?>
              Welcome back,
              <?php
                // Try to show full name, fallback to name, else show student_id
                if (!empty($student['full_name'])) {
                  echo htmlspecialchars($student['full_name']);
                } elseif (!empty($student['name'])) {
                  echo htmlspecialchars($student['name']);
                } elseif (!empty($student['student_id'])) {
                  echo htmlspecialchars($student['student_id']);
                } else {
                  echo 'Student';
                }
              ?>
            <?php else: ?>
              Welcome
            <?php endif; ?>
            • Last updated: <?php echo date('F j, Y'); ?>
          </p>
        </div>
        <a href="index.php" class="btn btn-light btn-sm">Go back home</a>
      </div>
    </div>
    <?php if ($error): ?>
      <div class="alert alert-danger text-center"><?php echo $error; ?></div>
    <?php endif; ?>
    <?php if ($student): ?>
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4">
        <div class="stat-card stat-attendance">
          <div class="small text-white-50">Attendance</div>
          <div class="display-6 fw-bold lh-1 mt-1">--%</div>
          <div class="small mt-2">Present: -- / -- days</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card stat-average">
          <div class="small text-white-50">Current Average</div>
          <div class="display-6 fw-bold lh-1 mt-1">--%</div>
          <div class="small mt-2">Term performance</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="stat-card stat-assignments">
          <div class="small text-white-50">Pending Assignments</div>
          <div class="display-6 fw-bold lh-1 mt-1">--</div>
          <div class="small mt-2">Next due: --</div>
        </div>
      </div>
    </div>
    <div class="row g-3">
      <div class="col-12 col-lg-4">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">My Profile</h2>
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Index (ID)</span><strong><?php echo htmlspecialchars($student['id']); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Student ID</span><strong><?php echo htmlspecialchars($student['student_id']); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Full Name</span><strong><?php echo htmlspecialchars($student['name'] ?? ($student['full_name'] ?? '')); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Gender</span><strong><?php echo htmlspecialchars($student['gender']); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Date of Birth</span><strong><?php echo htmlspecialchars($student['dob']); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Place of Birth</span><strong><?php echo htmlspecialchars($student['place_of_birth'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Nationality</span><strong><?php echo htmlspecialchars($student['nationality'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Guardian Name</span><strong><?php echo htmlspecialchars($student['parent_name'] ?? $student['guardian_name'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Relationship</span><strong><?php echo htmlspecialchars($student['relationship'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Guardian Phone</span><strong><?php echo htmlspecialchars($student['parent_contact'] ?? $student['guardian_phone'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Guardian Occupation</span><strong><?php echo htmlspecialchars($student['guardian_occupation'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Address</span><strong><?php echo htmlspecialchars($student['student_address'] ?? $student['address'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Emergency Name</span><strong><?php echo htmlspecialchars($student['emergency_contact'] ?? $student['emergency_name'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Emergency Phone</span><strong><?php echo htmlspecialchars($student['emergency_phone'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Medical Conditions</span><strong><?php echo htmlspecialchars($student['health_info'] ?? $student['medical_conditions'] ?? ''); ?></strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Created At</span><strong><?php echo htmlspecialchars($student['created_at']); ?></strong></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-8">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">My Results</h2>
            <div class="table-responsive">
              <table class="table align-middle">
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Score</th>
                    <th>Grade</th>
                    <th>Remark</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($results)): ?>
                    <?php foreach ($results as $row): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($row['subject']); ?></td>
                        <td><?php echo htmlspecialchars($row['score']); ?></td>
                        <td><?php echo htmlspecialchars($row['grade']); ?></td>
                        <td><?php echo htmlspecialchars($row['remark']); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="4" class="text-center">No results available.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Today’s Schedule</h2>
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-0 d-flex justify-content-between"><span>08:00 - 09:00</span><strong>Mathematics</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>09:15 - 10:15</span><strong>English</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>10:30 - 11:30</span><strong>Science</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>13:00 - 14:00</span><strong>History</strong></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-12 col-lg-6">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Quick Actions</h2>
            <div class="d-grid gap-2">
              <button class="btn btn-primary quick-btn" type="button">View Full Report Card</button>
              <button class="btn btn-outline-primary quick-btn" type="button">View Attendance Details</button>
              <button class="btn btn-outline-secondary quick-btn" type="button">Open Assignment List</button>
              <button class="btn btn-outline-success quick-btn" type="button">Download Timetable</button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card dashboard-card">
          <div class="card-body">
            <h2 class="section-title">Announcements</h2>
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-0">
                <div class="fw-semibold">Midterm Exam Starts Next Week</div>
                <div class="small text-secondary">Please review the updated schedule and prepare required materials.</div>
              </li>
              <li class="list-group-item px-0">
                <div class="fw-semibold">Science Project Submission</div>
                <div class="small text-secondary">Deadline: Mar 10 before 4:00 PM.</div>
              </li>
              <li class="list-group-item px-0">
                <div class="fw-semibold">Sports Day Practice</div>
                <div class="small text-secondary">Practice sessions start this Friday at 3:30 PM.</div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</body>
</html>