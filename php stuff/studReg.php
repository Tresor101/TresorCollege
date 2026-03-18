<?php
require_once 'dbc.php';
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['fullName'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $dob = trim($_POST['dob'] ?? '');
    $place_of_birth = trim($_POST['placeOfBirth'] ?? '');
    $nationality = trim($_POST['nationality'] ?? '');
    $guardian_name = trim($_POST['guardianName'] ?? '');
    $relationship = trim($_POST['relationship'] ?? '');
    $guardian_phone = trim($_POST['guardianPhone'] ?? '');
    $guardian_occupation = trim($_POST['guardianOccupation'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $emergency_name = trim($_POST['emergencyName'] ?? '');
    $emergency_phone = trim($_POST['emergencyPhone'] ?? '');
    $medical_conditions = trim($_POST['medicalConditions'] ?? '');

    // Server-side required fields validation
    $required_fields = [
      'Full Name' => $full_name,
      'Gender' => $gender,
      'Date of Birth' => $dob,
      'Place of Birth' => $place_of_birth,
      'Nationality' => $nationality,
      'Guardian Name' => $guardian_name,
      'Relationship' => $relationship,
      'Guardian Phone' => $guardian_phone,
      'Guardian Occupation' => $guardian_occupation,
      'Address' => $address,
      'Emergency Name' => $emergency_name,
      'Emergency Phone' => $emergency_phone
    ];
    $missing = [];
    foreach ($required_fields as $label => $value) {
      if ($value === '') {
        $missing[] = $label;
      }
    }
    if (!empty($missing)) {
      $errorMsg = 'Please fill in all required fields: ' . implode(', ', $missing);
    } else {
      $stmt = $conn->prepare("INSERT INTO students (full_name, gender, dob, place_of_birth, nationality, guardian_name, relationship, guardian_phone, guardian_occupation, address, emergency_name, emergency_phone, medical_conditions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      if ($stmt === false) {
        $errorMsg = 'Prepare failed: ' . $conn->error;
      } else {
        $stmt->bind_param('sssssssssssss', $full_name, $gender, $dob, $place_of_birth, $nationality, $guardian_name, $relationship, $guardian_phone, $guardian_occupation, $address, $emergency_name, $emergency_phone, $medical_conditions);
        if ($stmt->execute()) {
          $newId = $conn->insert_id;
          $currentYear = date('Y');
          $dobYear = date('Y', strtotime($dob));
          $student_id = 'STU' . $currentYear . $dobYear . str_pad($newId, 5, '0', STR_PAD_LEFT);
          $updateStmt = $conn->prepare("UPDATE students SET student_id = ? WHERE id = ?");
          $updateStmt->bind_param('si', $student_id, $newId);
          $updateStmt->execute();
          $updateStmt->close();
          // Redirect to avoid resubmission
          header('Location: studReg.php?success=1&student_id=' . urlencode($student_id));
          exit();
        } else {
          $errorMsg = 'Error: ' . $stmt->error;
        }
        $stmt->close();
      }
      $conn->close();
    }
}
if (isset($_GET['success']) && $_GET['success'] == 1 && isset($_GET['student_id'])) {
    $successMsg = 'Registration successful! Student ID: <strong>' . htmlspecialchars($_GET['student_id']) . '</strong>';
}
?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Registration Form</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <style>
    :root {
      --bg-a: #eef2ff;
      --bg-b: #f5f3ff;
      --bg-c: #ecfeff;
      --header-a: #0d6efd;
      --header-b: #7c3aed;
      --header-c: #ec4899;
      --text-dark: #1e293b;
      --muted: #64748b;
    }

    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    body {
      flex: 1 0 auto;
      display: flex;
      flex-direction: column;
      background: linear-gradient(270deg, #e0e7ff, #f0fdfa, #a5b4fc, #f0fdfa, #e0e7ff);
      background-size: 400% 400%;
      animation: gradientBG 15s ease infinite;
    }
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    main {
      flex: 1 0 auto;
    }
    .main-content {
      flex: 1 0 auto;
      display: flex;
      flex-direction: column;
    }

    .registration-card {
      border: 1px solid rgba(148, 163, 184, 0.24);
      border-radius: 1.1rem;
      overflow: hidden;
      box-shadow: 0 18px 42px rgba(30, 41, 59, 0.12);
      backdrop-filter: blur(2px);
    }

    .registration-header {
      background: linear-gradient(120deg, var(--header-a), var(--header-b) 58%, var(--header-c));
      color: #fff;
      padding: 1.35rem 1.6rem;
      position: relative;
      isolation: isolate;
    }

    .registration-header::after {
      content: "";
      position: absolute;
      inset: 0;
      background: linear-gradient(90deg, rgba(255, 255, 255, 0.11), transparent 35%, rgba(255, 255, 255, 0.08));
      pointer-events: none;
      z-index: -1;
    }

    .registration-header h1 {
      font-size: 1.42rem;
      font-weight: 700;
      margin: 0;
    }

    .registration-header p {
      margin: 0.35rem 0 0;
      opacity: 0.97;
      font-size: 0.95rem;
    }

    .form-section {
      border: 1px solid #dbe3ef;
      border-left-width: 5px;
      border-radius: 0.9rem;
      padding: 1.05rem 1rem;
      background: linear-gradient(180deg, #ffffff, #fafcff);
      transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .form-section:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 22px rgba(15, 23, 42, 0.08);
    }

    .form-section:nth-of-type(1) {
      border-left-color: #3b82f6;
    }

    .form-section:nth-of-type(2) {
      border-left-color: #14b8a6;
    }

    .form-section:nth-of-type(3) {
      border-left-color: #8b5cf6;
    }

    .form-section:nth-of-type(4) {
      border-left-color: #f59e0b;
    }

    .form-section:nth-of-type(5) {
      border-left-color: #ef4444;
    }

    .section-title {
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 0.02em;
      font-weight: 700;
      color: #334155;
      margin-bottom: 0.9rem;
      padding-bottom: 0.55rem;
      border-bottom: 1px dashed #cbd5e1;
    }

    .form-label {
      color: #334155;
      font-weight: 600;
      margin-bottom: 0.35rem;
    }

    .form-control,
    .form-select {
      border-radius: 0.65rem;
      border-color: #cbd5e1;
      background-color: #f8fbff;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.18);
      background-color: #fff;
    }

    #admissionNo {
      background-color: #eef2ff;
      font-weight: 600;
    }

    .btn-primary {
      background: linear-gradient(120deg, #2563eb, #7c3aed);
      border: none;
      font-weight: 700;
      letter-spacing: 0.01em;
    }

    .btn-primary:hover,
    .btn-primary:focus {
      background: linear-gradient(120deg, #1d4ed8, #6d28d9);
    }

    #formMessage {
      border-radius: 0.7rem;
    }
  </style>
</head>
<body>
  <div class="main-content">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="card shadow registration-card">
          <div class="registration-header">
            <h1>Student Registration</h1>
            <p>Provide student, contact, guardian, academic, and emergency details.</p>
          </div>
          <div class="card-body p-3 p-md-4 p-lg-5">
            <?php if ($successMsg): ?>
              <div class="alert alert-success text-center"><?php echo $successMsg; ?></div>
            <?php elseif ($errorMsg): ?>
              <div class="alert alert-danger text-center"><?php echo $errorMsg; ?></div>
            <?php endif; ?>
            <form id="registrationForm" method="POST" novalidate>
              <script>
                // Client-side validation to ensure all required fields are filled
                document.addEventListener('DOMContentLoaded', function() {
                  const form = document.getElementById('registrationForm');
                  form.addEventListener('submit', function(e) {
                    let valid = true;
                    let firstInvalid = null;
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(function(field) {
                      if (!field.value || (field.type === 'select-one' && field.value === '')) {
                        valid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalid) firstInvalid = field;
                      } else {
                        field.classList.remove('is-invalid');
                      }
                    });
                    if (!valid) {
                      e.preventDefault();
                      if (firstInvalid) firstInvalid.focus();
                      const msg = document.getElementById('formMessage');
                      if (msg) {
                        msg.classList.remove('d-none', 'alert-success');
                        msg.classList.add('alert-danger');
                        msg.textContent = 'Please fill in all required fields.';
                      }
                    }
                  });
                });
              </script>
              <div class="d-grid gap-3">
                <section class="form-section">
                  <h2 class="section-title">Student Basic Information</h2>
                  <div class="row g-3">
                    <div class="col-12 col-md-6">
                      <label for="fullName" class="form-label">Full Name</label>
                      <input id="fullName" name="fullName" type="text" class="form-control" required autocomplete="name" />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="gender" class="form-label">Gender</label>
                      <select id="gender" name="gender" class="form-select" required>
                        <option value="" selected disabled>Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                      </select>
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="dob" class="form-label">Date of Birth</label>
                      <input id="dob" name="dob" type="date" class="form-control" required min="<?php echo date('Y-m-d', strtotime('-25 years')); ?>" max="<?php echo date('Y-m-d', strtotime('-3 years')); ?>" />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="placeOfBirth" class="form-label">Place of Birth</label>
                      <input id="placeOfBirth" name="placeOfBirth" type="text" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="nationality" class="form-label">Nationality</label>
                      <input id="nationality" name="nationality" type="text" class="form-control" required />
                    </div>
                  </div>
                </section>

                <section class="form-section">
                  <h2 class="section-title">Parent / Guardian Information</h2>
                  <div class="row g-3">
                    <div class="col-12 col-md-6">
                      <label for="guardianName" class="form-label">Parent/Guardian Full Name</label>
                      <input id="guardianName" name="guardianName" type="text" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="relationship" class="form-label">Relationship to Student</label>
                      <select id="relationship" name="relationship" class="form-select" required>
                        <option value="" selected disabled>Select relationship</option>
                        <option value="father">Father</option>
                        <option value="mother">Mother</option>
                        <option value="older brother">Older Brother</option>
                        <option value="older sister">Older Sister</option>
                        <option value="cousin">Cousin</option>
                        <option value="brother in law">Brother in Law</option>
                        <option value="sister in law">Sister in Law</option>
                      </select>
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="guardianPhone" class="form-label">Phone Number</label>
                      <input id="guardianPhone" name="guardianPhone" type="tel" class="form-control" pattern="[0-9+\-() ]{7,}" placeholder="e.g. +1 (555) 123-4567" required autocomplete="tel" />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="guardianOccupation" class="form-label">Occupation</label>
                      <input id="guardianOccupation" name="guardianOccupation" type="text" class="form-control" required />
                    </div>
                    <div class="col-12 ">
                      <label for="address" class="form-label">Address</label>
                      <input id="address" name="address" type="text" class="form-control" required />
                    </div>
                  </div>
                </section>


                <section class="form-section">
                  <h2 class="section-title">Emergency Information</h2>
                  <div class="row g-3">
                    <div class="col-12 col-md-6">
                      <label for="emergencyName" class="form-label">Emergency Contact Name</label>
                      <input id="emergencyName" name="emergencyName" type="text" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="emergencyPhone" class="form-label">Emergency Contact Phone</label>
                      <input id="emergencyPhone" name="emergencyPhone" type="tel" class="form-control" pattern="[0-9+\-() ]{7,}" placeholder="e.g. +1 (555) 123-4567" required />
                    </div>
                    <div class="col-12">
                      <label for="medicalConditions" class="form-label">Medical Conditions and Allergies (Optional)</label>
                      <textarea id="medicalConditions" name="medicalConditions" class="form-control" rows="2"></textarea>
                    </div>
                  </div>
                </section>

                <div class="d-grid">
                  <button type="submit" class="btn btn-danger btn-lg">Submit Registration</button>
                </div>
              </div>

              <div id="formMessage" class="alert mt-3 d-none" role="alert" aria-live="polite"></div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
</body>
</html>
