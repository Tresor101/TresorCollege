<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Teacher Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
  <style>
    body {
      background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 58%, #f0fdf4 100%);
      min-height: 100vh;
    }
    .dashboard-card {
      border: 1px solid #e2e8f0;
      border-radius: 1rem;
      box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
    }
    .section-title {
      font-size: 1.1rem;
      font-weight: 700;
      color: #334155;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h1 class="mb-4 text-center">Teacher Dashboard</h1>
    <?php include 'dbc.php'; ?>
    <?php
    $teacherInfo = null;
    if (isset($_GET['teacher_id'])) {
        $teacher_id = $conn->real_escape_string($_GET['teacher_id']);
        $sql = "SELECT * FROM teachers WHERE teacher_id = '$teacher_id' LIMIT 1";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $teacherInfo = $result->fetch_assoc();
        }
    }
    ?>
    <?php if ($teacherInfo): ?>
      <div class="row justify-content-center mb-4">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="card dashboard-card shadow">
            <div class="card-body">
              <h2 class="section-title mb-3">Teacher Information</h2>
              <ul class="list-group list-group-flush">
                <?php
                  $skip = ['password_hash'];
                  $labels = [
                    'teacher_id' => 'ID',
                    'first_name' => 'First Name',
                    'middle_name' => 'Middle Name',
                    'last_name' => 'Last Name',
                    'gender' => 'Gender',
                    'dob' => 'Date of Birth',
                    'qualification' => 'Qualification',
                    'phone' => 'Phone',
                    'address' => 'Address',
                    'emergency_name' => 'Emergency Contact',
                    'emergency_phone' => 'Emergency Phone',
                  ];
                  foreach ($teacherInfo as $key => $value):
                    if (in_array($key, $skip)) continue;
                    if ($key === 'emergency_name') {
                      $display = $labels[$key];
                      $emergency = htmlspecialchars($teacherInfo['emergency_name']) . ' (' . htmlspecialchars($teacherInfo['emergency_phone']) . ')';
                      echo "<li class='list-group-item px-0 d-flex justify-content-between'><span>$display</span><strong>$emergency</strong></li>";
                    } elseif ($key !== 'emergency_phone') {
                      $display = $labels[$key] ?? ucfirst(str_replace('_', ' ', $key));
                      echo "<li class='list-group-item px-0 d-flex justify-content-between'><span>$display</span><strong>" . htmlspecialchars($value) . "</strong></li>";
                    }
                  endforeach;
                ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    <?php elseif(isset($_GET['teacher_id'])): ?>
      <div class="alert alert-warning text-center">No teacher found with that ID.</div>
    <?php else: ?>
      <div class="alert alert-info text-center">Enter a Teacher ID to view information.</div>
    <?php endif; ?>
  </div>
</body>
</html>
