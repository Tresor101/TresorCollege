<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Check Result</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(270deg, #7c3aed, #2563eb, #f59e42, #7c3aed, #2563eb);
      background-size: 400% 400%;
      animation: gradientBG 10s ease-in-out infinite;
      display: grid;
      place-items: center;
      padding: 1rem;
      overflow: hidden;
    }
    @keyframes gradientBG {
      0% {background-position: 0% 50%;}
      50% {background-position: 100% 50%;}
      100% {background-position: 0% 50%;}
    }
    .dancer-shape {
      position: absolute;
      border-radius: 50%;
      opacity: 0.18;
      pointer-events: none;
      animation: floatShape 6s ease-in-out infinite;
    }
    @keyframes floatShape {
      0% {transform: translateY(0) scale(1);}
      50% {transform: translateY(-40px) scale(1.1);}
      100% {transform: translateY(0) scale(1);}
    }

    .entry-card {
      width: 100%;
      max-width: 520px;
      border: 0;
      border-radius: 1rem;
      box-shadow: 0 18px 38px rgba(15, 23, 42, 0.14);
      overflow: hidden;
    }

    .entry-header {
      background: linear-gradient(120deg, #2563eb, #7c3aed);
      color: #fff;
      padding: 1.2rem 1.4rem;
    }

    .entry-header h1 {
      margin: 0;
      font-size: 1.3rem;
      font-weight: 700;
    }

    .entry-header p {
      margin: 0.35rem 0 0;
      opacity: 0.95;
      font-size: 0.95rem;
    }
  </style>
</head>
<body>
  <!-- Dancer shapes for background effect -->
  <div class="dancer-shape" style="width:120px;height:120px;top:10%;left:8%;background:#fff;animation-delay:0s;"></div>
  <div class="dancer-shape" style="width:80px;height:80px;top:70%;left:80%;background:#f59e42;animation-delay:1s;"></div>
  <div class="dancer-shape" style="width:100px;height:100px;top:50%;left:60%;background:#2563eb;animation-delay:2s;"></div>
  <div class="dancer-shape" style="width:60px;height:60px;top:30%;left:85%;background:#7c3aed;animation-delay:3s;"></div>
  <div class="dancer-shape" style="width:90px;height:90px;top:80%;left:20%;background:#fff;animation-delay:4s;"></div>
  <main class="card entry-card">
    <div class="entry-header">
      <h1>Welcome</h1>
      <p>Please choose an option below.</p>
    </div>
    <div class="card-body p-4">
      <div class="d-grid gap-3 mb-4">
        <a href="studReg.php" class="btn btn-outline-success btn-lg"><i class="bi bi-person-plus-fill me-1"></i> Register Student</a>
        <a href="teachReg.php" class="btn btn-outline-info btn-lg"><i class="bi bi-person-badge-fill me-1"></i> Register Teacher</a>
        <a href="staffReg.php" class="btn btn-outline-primary btn-lg"><i class="bi bi-people-fill me-1"></i> Register Staff</a>
      </div>
      <hr>
      <form id="studentIdForm" class="needs-validation" novalidate method="get" action="studdashboard.php">
        <div class="mb-3">
          <label for="studentId" class="form-label">Check Student Info</label>
          <input type="text" class="form-control" id="studentId" name="student_id" placeholder="Enter Student ID" required pattern="[A-Za-z0-9\-]+">
          <div class="invalid-feedback">Please enter a valid Student ID.</div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Check Info</button>
        <div id="formMessage" class="alert mt-3 d-none" role="alert" aria-live="polite"></div>
      </form>
      <form id="teacherIdForm" class="needs-validation mt-4" novalidate method="get" action="teadashboard.php">
        <div class="mb-3">
          <label for="teacherId" class="form-label">Check Teacher Info</label>
          <input type="text" class="form-control" id="teacherId" name="teacher_id" placeholder="Enter Teacher ID" required pattern="[A-Za-z0-9\-]+">
          <div class="invalid-feedback">Please enter a valid Teacher ID.</div>
        </div>
        <button type="submit" class="btn btn-info w-100">Check Info</button>
        <div id="teacherFormMessage" class="alert mt-3 d-none" role="alert" aria-live="polite"></div>
      </form>
    </div>
  </main>
  <!-- Bootstrap Icons CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <!-- No custom JS needed: form submits directly to studdashboard.php -->
</body>
</html>
