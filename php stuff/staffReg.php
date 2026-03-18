<?php
require_once 'dbc.php';

// Helper function to hash password
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

$generatedStaffId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $full_name = $_POST['fullName'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $emergency_name = $_POST['emergencyName'];
    $emergency_phone = $_POST['emergencyPhone'];
    $password = $_POST['password'];
    $password_hash = hashPassword($password);

    $stmt = $conn->prepare("INSERT INTO staff (role, full_name, gender, dob, address, phone, emergency_name, emergency_phone, password_hash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssssss', $role, $full_name, $gender, $dob, $address, $phone, $emergency_name, $emergency_phone, $password_hash);

    if ($stmt->execute()) {
        $dobYear = date('Y', strtotime($dob));
        $rand = mt_rand(1000, 9999);
        $generatedStaffId = 'STF' . $dobYear . ' ' . $rand;
        $newId = $conn->insert_id;
        $updateStmt = $conn->prepare("UPDATE staff SET staff_id = ? WHERE id = ?");
        $updateStmt->bind_param('si', $generatedStaffId, $newId);
        $updateStmt->execute();
        $updateStmt->close();
        echo '<div class="alert alert-success">Registration successful! Staff ID: <strong>' . $generatedStaffId . '</strong></div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }
    $stmt->close();
    $conn->close();
}
?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Registration - ibangubangu college</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
    .registration-card {
      max-width: 700px;
      margin: 2.5rem auto;
      border-radius: 1.2rem;
      box-shadow: 0 8px 32px rgba(44,62,80,0.13);
      background: #fff;
      padding: 0;
      overflow: hidden;
    }
    .registration-header {
      background: linear-gradient(90deg, #6366f1 0%, #7c3aed 100%);
      color: #fff;
      padding: 2rem 2rem 1.2rem 2rem;
      text-align: center;
      position: relative;
    }
    .registration-header i {
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }
    .section-title {
      font-size: 1.1rem;
      font-weight: 600;
      color: #6366f1;
      margin-bottom: 1rem;
      margin-top: 2rem;
      border-left: 4px solid #7c3aed;
      padding-left: 0.7rem;
      letter-spacing: 0.01em;
      background: linear-gradient(90deg, #f3f4f6 60%, #f8fafc 100%);
    }
    .form-label {
      color: #374151;
      font-weight: 500;
    }
    .form-control, .form-select {
      border-radius: 0.7rem;
      background: #f8fafc;
      border-color: #c7d2fe;
    }
    .form-control:focus, .form-select:focus {
      border-color: #7c3aed;
      box-shadow: 0 0 0 0.15rem rgba(124,58,237,0.13);
    }
    .btn-primary {
      background: linear-gradient(90deg, #6366f1 0%, #7c3aed 100%);
      border: none;
      font-weight: 600;
      letter-spacing: 0.03em;
    }
    .divider {
      border-top: 1.5px dashed #e0e7ff;
      margin: 2rem 0 1.5rem 0;
    }
  </style>
</head>
<body>
  <div class="registration-card">
    <div class="registration-header">
      <i class="bi bi-person-gear"></i>
      <h2 class="mb-1">Staff Registration</h2>
      <div class="fw-light">ibangubangu college</div>
    </div>
    <form method="POST" autocomplete="off" class="p-4">
      <div class="section-title">Staff Information</div>
      <div class="row mb-3">
        <div class="col-md-12">
          <label for="fullName" class="form-label">Full Name</label>
          <input type="text" class="form-control" id="fullName" name="fullName" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="gender" class="form-label">Gender</label>
          <select class="form-select" id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div class="col-md-6">
          <label for="dob" class="form-label">Date of Birth</label>
          <input type="date" class="form-control" id="dob" name="dob" required min="<?php echo date('Y-m-d', strtotime('-75 years')); ?>" max="<?php echo date('Y-m-d', strtotime('-20 years')); ?>">
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-12">
          <label for="address" class="form-label">Address</label>
          <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="phone" class="form-label">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="col-md-6">
          <label for="role" class="form-label">Role</label>
          <select class="form-select" id="role" name="role" required>
            <option value="">Select Role</option>
            <option value="Principal / Headmaster">Principal / Headmaster (Préfet des études)</option>
            <option value="Deputy Principal">Deputy Principal (Sous-préfet)</option>
            <option value="Academic Director">Academic Director (Directeur des études)</option>
            <option value="School Secretary">School Secretary (Secrétaire)</option>
            <option value="Bursar / Accountant">Bursar / Accountant (Économe / Comptable)</option>
            <option value="Prefect of Discipline">Prefect of Discipline (Préfet de discipline)</option>
          </select>
        </div>
      </div>
      <div class="divider"></div>
      <div class="section-title">Emergency & Security</div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="emergencyName" class="form-label">Emergency Contact Name</label>
          <input type="text" class="form-control" id="emergencyName" name="emergencyName" required>
        </div>
        <div class="col-md-6">
          <label for="emergencyPhone" class="form-label">Emergency Contact Phone</label>
          <input type="tel" class="form-control" id="emergencyPhone" name="emergencyPhone" required>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-md-6">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="col-md-6">
          <label for="confirmPassword" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
        </div>
      </div>
      <div class="d-grid mt-4">
        <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-person-check-fill me-2"></i> Register Staff</button>
      </div>
    </form>
  </div>
  <?php include 'footer.php'; ?>
  <script>
    function generateStaffId() {
      const now = new Date();
      const yyyy = now.getFullYear();
      const mm = String(now.getMonth() + 1).padStart(2, '0');
      const dd = String(now.getDate()).padStart(2, '0');
      const rand = Math.floor(1000 + Math.random() * 9000);
      return `STF-${yyyy}${mm}${dd}-${rand}`;
    }
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-generate Staff ID
      document.getElementById('staffId').value = generateStaffId();
      const dobField = document.getElementById('dob');
      const form = document.querySelector('form');
      const password = document.getElementById('password');
      const confirmPassword = document.getElementById('confirmPassword');
      form.addEventListener('submit', function(e) {
        // Age validation
        const dobValue = dobField.value;
        if (dobValue) {
          const [year, month, day] = dobValue.split('-').map(Number);
          const dobDate = new Date(year, month - 1, day);
          const today = new Date();
          today.setHours(0, 0, 0, 0);
          const minDate = new Date(today);
          minDate.setFullYear(minDate.getFullYear() - 75);
          const maxDate = new Date(today);
          maxDate.setFullYear(maxDate.getFullYear() - 20);
          if (dobDate < minDate || dobDate > maxDate) {
            e.preventDefault();
            dobField.classList.add('is-invalid');
            alert('Staff age must be between 20 and 75 years.');
            return;
          } else {
            dobField.classList.remove('is-invalid');
          }
        }
        // Password match validation
        if (password.value !== confirmPassword.value) {
          e.preventDefault();
          confirmPassword.classList.add('is-invalid');
          alert('Passwords do not match.');
        } else {
          confirmPassword.classList.remove('is-invalid');
        }
      });
    });
  </script>
</body>
</html>
