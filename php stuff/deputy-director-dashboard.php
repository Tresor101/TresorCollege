<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Deputy Director Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"/>
  <style>
    body { background: linear-gradient(135deg, #f8fafc 0%, #eff6ff 55%, #f0fdf4 100%); min-height: 100vh; }
    .topbar { background: linear-gradient(120deg, #0f766e, #2563eb); color: #fff; border-radius: 1rem; padding: 1rem 1.25rem; box-shadow: 0 14px 30px rgba(30, 41, 59, 0.15); }
    .dashboard-card { border: 1px solid #e2e8f0; border-radius: 1rem; box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06); }
    .stat-card { border-radius: 0.85rem; color: #fff; padding: 1rem; min-height: 110px; }
    .stat-ops { background: linear-gradient(120deg, #14b8a6, #0f766e); }
    .stat-attendance { background: linear-gradient(120deg, #3b82f6, #2563eb); }
    .stat-issues { background: linear-gradient(120deg, #f97316, #ef4444); }
    .section-title { font-size: 0.95rem; font-weight: 700; color: #334155; margin-bottom: 0.85rem; }
    .quick-btn { border-radius: 0.7rem; font-weight: 600; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container py-4 py-lg-5">
    <div class="topbar mb-4"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2"><div><h1 class="h4 mb-1">Deputy Director Dashboard</h1><p class="mb-0 small">Daily school operations, coordination, supervision, and incident follow-up.</p></div><a href="school-director-dashboard.html" class="btn btn-light btn-sm">Director View</a></div></div>
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4"><div class="stat-card stat-ops"><div class="small text-white-50">Open Operational Tasks</div><div class="display-6 fw-bold lh-1 mt-1">18</div><div class="small mt-2">9 due today</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-attendance"><div class="small text-white-50">Student Attendance</div><div class="display-6 fw-bold lh-1 mt-1">94%</div><div class="small mt-2">Staff attendance: 97%</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-issues"><div class="small text-white-50">Incidents Pending</div><div class="display-6 fw-bold lh-1 mt-1">5</div><div class="small mt-2">2 require parent meetings</div></div></div>
    </div>
    <div class="row g-3">
      <div class="col-12 col-lg-7"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Campus Operations Board</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Area</th><th>Owner</th><th>Progress</th><th>Deadline</th></tr></thead><tbody><tr><td>Exam room setup</td><td>Admin Office</td><td>80%</td><td>Mar 15</td></tr><tr><td>Transport schedule</td><td>Operations</td><td>100%</td><td>Done</td></tr><tr><td>Facility maintenance</td><td>Caretaker</td><td>65%</td><td>Mar 14</td></tr><tr><td>Parent circular dispatch</td><td>Registrar</td><td>90%</td><td>Today</td></tr></tbody></table></div></div></div></div>
      <div class="col-12 col-lg-5"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Escalations</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0"><div class="fw-semibold">Late teacher arrivals</div><div class="small text-secondary">3 repeated cases this week.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Water supply issue</div><div class="small text-secondary">Resolved temporarily, vendor follow-up pending.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Bus route complaint</div><div class="small text-secondary">Parent feedback under review.</div></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Supervision Checklist</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0 d-flex justify-content-between"><span>Morning assembly</span><strong>Completed</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Classroom rounds</span><strong>In Progress</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Teacher register audit</span><strong>Pending</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Facilities inspection</span><strong>Scheduled</strong></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Quick Actions</h2><div class="d-grid gap-2"><button class="btn btn-primary quick-btn" type="button">View Incident Log</button><button class="btn btn-outline-primary quick-btn" type="button">Open Staff Attendance</button><button class="btn btn-outline-secondary quick-btn" type="button">Track Maintenance Tasks</button><button class="btn btn-outline-success quick-btn" type="button">Print Daily Brief</button></div></div></div></div>
    </div>
  </div>
</body>
</html>