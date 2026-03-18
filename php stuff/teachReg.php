<?php include 'navbar.php'; ?>
<?php require_once 'dbc.php';

function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

$successMsg = '';
$errorMsg = '';
// Always generate unique Teacher ID for both GET and POST
$year = date('Y');
$prefix = 'TEA' . $year;
$result = $conn->query("SELECT teacher_id FROM teachers WHERE teacher_id LIKE '$prefix%' ORDER BY teacher_id DESC LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $lastIdNum = intval(substr($row['teacher_id'], 7));
    $newIdNum = $lastIdNum + 1;
} else {
    $newIdNum = 1;
}
$teacher_id = $prefix . str_pad($newIdNum, 4, '0', STR_PAD_LEFT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['firstName'] ?? '';
    $middle_name = $_POST['middleName'] ?? '';
    $last_name = $_POST['lastName'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $qualification = $_POST['qualification'] ?? '';
    $emergency_name = $_POST['emergencyName'] ?? '';
    $emergency_phone = $_POST['emergencyPhone'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_hash = hashPassword($password);

    // Age validation: must be between 20 and 80 years
    $today = new DateTime();
    $dobDate = DateTime::createFromFormat('Y-m-d', $dob);
    $age = $dobDate ? $today->diff($dobDate)->y : null;
    if ($age === null || $age < 20 || $age > 80) {
        $errorMsg = 'Teacher age must be between 20 and 80 years.';
    } else {
        $stmt = $conn->prepare("INSERT INTO teachers (teacher_id, first_name, middle_name, last_name, gender, dob, address, phone, qualification, emergency_name, emergency_phone, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
          $errorMsg = 'Prepare failed: ' . $conn->error;
        } else {
          $stmt->bind_param('ssssssssssss', $teacher_id, $first_name, $middle_name, $last_name, $gender, $dob, $address, $phone, $qualification, $emergency_name, $emergency_phone, $password_hash);
          if ($stmt->execute()) {
            // Redirect to avoid resubmission on refresh
            $stmt->close();
            $conn->close();
            header('Location: teachReg.php?success=1');
            exit();
          } else {
            $errorMsg = 'Error: ' . $stmt->error;
          }
          $stmt->close();
        }
        $conn->close();
    }
}
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Teacher Registration Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <style>
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
    .registration-card {
      border: 1px solid rgba(148, 163, 184, 0.24);
      border-radius: 1.1rem;
      overflow: hidden;
      box-shadow: 0 18px 42px rgba(30, 41, 59, 0.12);
      backdrop-filter: blur(2px);
    }
    .registration-header {
      background: linear-gradient(120deg, #0d6efd, #7c3aed 58%, #ec4899);
      color: #fff;
      padding: 1.35rem 1.6rem;
      position: relative;
      isolation: isolate;
    }
    .registration-header h1 {
      font-size: 1.42rem;
      font-weight: 700;
      margin: 0;
    }
    .form-section {
      border: 1px solid #dbe3ef;
      border-left-width: 5px;
      border-radius: 0.9rem;
      padding: 1.05rem 1rem;
      background: linear-gradient(180deg, #ffffff, #fafcff);
      margin-bottom: 1.2rem;
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
    .form-control, .form-select {
      border-radius: 0.65rem;
      border-color: #cbd5e1;
      background-color: #f8fbff;
    }
    .form-control:focus, .form-select:focus {
      border-color: #6366f1;
      box-shadow: 0 0 0 0.25rem rgba(99, 102, 241, 0.18);
      background-color: #fff;
    }
    #teacherId {
      background-color: #eef2ff;
      font-weight: 600;
    }
    .btn-primary {
      background: linear-gradient(120deg, #2563eb, #7c3aed);
      border: none;
      font-weight: 700;
      letter-spacing: 0.01em;
    }
    .btn-primary:hover, .btn-primary:focus {
      background: linear-gradient(120deg, #1d4ed8, #6d28d9);
    }
    #formMessage {
      border-radius: 0.7rem;
    }
  </style>
</head>
  <body>
  <?php include 'navbar.php'; ?>
  <div class="container py-4 py-lg-5">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-9">
        <div class="card shadow registration-card">
          <div class="registration-header">
            <h1>Teacher Registration</h1>
            <p>Provide teacher's personal, contact, professional, and emergency details.</p>
          </div>
          <div class="card-body p-3 p-md-4 p-lg-5">
            <?php if (isset($_GET['success'])): ?>
              <div class="alert alert-success">Registration successful!</div>
            <?php elseif (!empty($errorMsg)): ?>
              <div class="alert alert-danger"> <?= htmlspecialchars($errorMsg) ?> </div>
            <?php endif; ?>
            <form id="teacherRegistrationForm" action="teachReg.php" method="POST" novalidate>
              <div class="d-grid gap-3">
                <section class="form-section">
                  <h2 class="section-title">Personal Information</h2>
                  <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label for="firstName" class="form-label">First Name</label>
                        <input id="firstName" name="firstName" type="text" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="middleName" class="form-label">Middle Name (Optional)</label>
                      <input id="middleName" name="middleName" type="text" class="form-control" />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="lastName" class="form-label">Last Name</label>
                      <input id="lastName" name="lastName" type="text" class="form-control" required />
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
                      <input id="dob" name="dob" type="date" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="phone" class="form-label">Phone Number</label>
                      <input id="phone" name="phone" type="tel" class="form-control" required />
                    </div>
                    <div class="col-12">
                      <label for="address" class="form-label">Address</label>
                      <input id="address" name="address" type="text" class="form-control" required />
                    </div>
                  </div>
                </section>

                <section class="form-section">
                  <h2 class="section-title">Professional Information</h2>
                  <div class="row g-3">
                    <div class="col-12 col-md-6">
                      <label for="teacherId" class="form-label">Teacher ID (Auto-generated)</label>
                      <input id="teacherId" name="teacherId" type="text" class="form-control" value="<?php echo htmlspecialchars($teacher_id); ?>" readonly aria-readonly="true" />
                    </div>
                    <div class="col-12 col-md-6">
                      <label for="qualification" class="form-label">Highest Qualification</label>
                      <input id="qualification" name="qualification" type="text" class="form-control" required />
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                          <input id="password" name="password" type="password" class="form-control" required minlength="6" autocomplete="new-password" />
                          <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1">Show</button>
                        </div>
                        <div id="passwordHelp" class="form-text text-danger"></div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <div class="input-group">
                          <input id="confirmPassword" name="confirmPassword" type="password" class="form-control" required minlength="6" autocomplete="new-password" />
                          <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" tabindex="-1">Show</button>
                        </div>
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
                      <input id="emergencyPhone" name="emergencyPhone" type="tel" class="form-control" required />
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
  <script>
      // Simple math captcha
      document.addEventListener('DOMContentLoaded', function() {
        const captchaQuestion = document.getElementById('captchaQuestion');
        const captchaInput = document.getElementById('captchaInput');
        const captchaFeedback = document.getElementById('captchaFeedback');
        const form = document.getElementById('teacherRegistrationForm');
        let answer = 0;
        function generateCaptcha() {
          const a = Math.floor(Math.random() * 10) + 1;
          const b = Math.floor(Math.random() * 10) + 1;
          answer = a + b;
          captchaQuestion.textContent = `${a} + ${b} = ?`;
          captchaInput.value = '';
          captchaFeedback.textContent = '';
        }
        if (captchaQuestion && captchaInput && form) {
          generateCaptcha();
          form.addEventListener('submit', function(e) {
            if (parseInt(captchaInput.value, 10) !== answer) {
              e.preventDefault();
              captchaFeedback.textContent = 'Incorrect answer. Please try again.';
              captchaInput.classList.add('is-invalid');
              generateCaptcha();
            } else {
              captchaFeedback.textContent = '';
              captchaInput.classList.remove('is-invalid');
            }
          });
          captchaInput.addEventListener('input', function() {
            captchaInput.classList.remove('is-invalid');
            captchaFeedback.textContent = '';
          });
        }
      });
  // Input mask for phone numbers (format: +XXX-XXX-XXXX or similar)
    document.addEventListener('DOMContentLoaded', function() {
        const phoneFields = document.querySelectorAll('input[type="tel"]');
        phoneFields.forEach(function(field) {
            field.addEventListener('input', function(e) {
                let x = field.value.replace(/[^\d+]/g, '');
                let formatted = x.startsWith('+') ? '+' : '';
                x = x.replace(/^\+/, '');
                if (x.length > 0) formatted += x.substring(0, 3);
                if (x.length > 3) formatted += '-' + x.substring(3, 6);
                if (x.length > 6) formatted += '-' + x.substring(6, 10);
                if (x.length > 10) formatted += x.substring(10);
                field.value = formatted;
            });
                field.setAttribute('placeholder', '+123-456-7890');
                field.setAttribute('pattern', '^\\+?\d{3}-\d{3}-\d{4,}$');
                field.setAttribute('aria-describedby', 'phoneHelp');
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('teacherRegistrationForm');
            const requiredFields = form.querySelectorAll('input[required], select[required]');
            requiredFields.forEach(field => {
                field.addEventListener('input', function() {
                    if (field.value.trim() === '') {
                        field.classList.add('is-invalid');
                        field.setCustomValidity('This field is required');
                    } else {
                        field.classList.remove('is-invalid');
                        field.setCustomValidity('');
                    }
                });
            });
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
            if (password && confirmPassword) {
                function checkMatch() {
                    if (confirmPassword.value && password.value !== confirmPassword.value) {
                        confirmPassword.setCustomValidity('Passwords do not match');
                        confirmPassword.classList.add('is-invalid');
                    } else {
                            confirmPassword.setCustomValidity('');
                            confirmPassword.classList.remove('is-invalid');
                          }
                        }
                        password.addEventListener('input', checkMatch);
                        confirmPassword.addEventListener('input', checkMatch);
                      }

                      // Phone number validation (simple pattern: at least 7 digits)
                      const phoneFields = form.querySelectorAll('input[type="tel"]');
                      phoneFields.forEach(phone => {
                        phone.addEventListener('input', function() {
                          const valid = /^([+]?\d[- .()]*){7,}$/.test(phone.value.trim());
                          if (!valid) {
                            phone.classList.add('is-invalid');
                            phone.setCustomValidity('Enter a valid phone number');
                          } else {
                            phone.classList.remove('is-invalid');
                            phone.setCustomValidity('');
                          }
                        });
                      });
                    });
                // Strong password validation
                document.addEventListener('DOMContentLoaded', function() {
                  const password = document.getElementById('password');
                  const form = document.getElementById('teacherRegistrationForm');
                  if (password && form) {
                    const requirements = {
                      length: v => v.length >= 6,
                      upper: v => /[A-Z]/.test(v),
                      lower: v => /[a-z]/.test(v),
                      number: v => /[0-9]/.test(v),
                      symbol: v => /[^A-Za-z0-9]/.test(v)
                    };
                    function checkStrength(value) {
                      return Object.values(requirements).every(fn => fn(value));
                    }
                    function showPasswordFeedback(valid) {
                      let feedback = document.getElementById('passwordHelp');
                      if (!feedback) {
                        feedback = document.createElement('div');
                        feedback.id = 'passwordHelp';
                        feedback.className = 'form-text text-danger';
                        password.parentElement.appendChild(feedback);
                      }
                      if (!valid) {
                        feedback.textContent = 'Password must be at least 6 characters and include uppercase, lowercase, number, and symbol.';
                      } else {
                        feedback.textContent = '';
                      }
                    }
                    password.addEventListener('input', function() {
                      const valid = checkStrength(password.value);
                      password.setCustomValidity(valid ? '' : 'Password does not meet requirements');
                      showPasswordFeedback(valid);
                    });
                    form.addEventListener('submit', function(e) {
                      const valid = checkStrength(password.value);
                      if (!valid) {
                        password.setCustomValidity('Password does not meet requirements');
                        showPasswordFeedback(false);
                        password.reportValidity();
                        e.preventDefault();
                      } else {
                        password.setCustomValidity('');
                        showPasswordFeedback(true);
                      }
                    });
                  }
                });
            // Show/Hide password toggle
            document.addEventListener('DOMContentLoaded', function() {
              function setupToggle(inputId, buttonId) {
                const input = document.getElementById(inputId);
                const button = document.getElementById(buttonId);
                if (input && button) {
                  button.addEventListener('click', function() {
                    if (input.type === 'password') {
                      input.type = 'text';
                      button.textContent = 'Hide';
                    } else {
                      input.type = 'password';
                      button.textContent = 'Show';
                    }
                  });
                }
              }
              setupToggle('password', 'togglePassword');
              setupToggle('confirmPassword', 'toggleConfirmPassword');
            });
        // Password match validation
        document.addEventListener('DOMContentLoaded', function() {
          const form = document.getElementById('teacherRegistrationForm');
          const password = document.getElementById('password');
          const confirmPassword = document.getElementById('confirmPassword');
          if (form && password && confirmPassword) {
            form.addEventListener('submit', function(e) {
              if (password.value !== confirmPassword.value) {
                e.preventDefault();
                confirmPassword.setCustomValidity('Passwords do not match');
                confirmPassword.classList.add('is-invalid');
                confirmPassword.reportValidity();
              } else {
                confirmPassword.setCustomValidity('');
                confirmPassword.classList.remove('is-invalid');
              }
            });
            confirmPassword.addEventListener('input', function() {
              confirmPassword.setCustomValidity('');
              confirmPassword.classList.remove('is-invalid');
            });
          }
        });
    // Restrict DOB so age is between 20 and 80 at registration time
    function setDobAllowedRange() {
      const dobField = document.getElementById('dob');
      const today = new Date();
      const minDob = new Date(today);
      minDob.setFullYear(minDob.getFullYear() - 80);
      const maxDob = new Date(today);
      maxDob.setFullYear(maxDob.getFullYear() - 20);
      dobField.min = minDob.toISOString().split('T')[0];
      dobField.max = maxDob.toISOString().split('T')[0];
    }

    window.addEventListener('DOMContentLoaded', function() {
      setTeacherId();
      setDobAllowedRange();
    });
  </script>
</body>
<?php include 'footer.php'; ?>
</body>
</html>