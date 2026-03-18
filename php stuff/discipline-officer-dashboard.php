<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Discipline Officer Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <style>
    body { background: linear-gradient(135deg, #fff7ed 0%, #f8fafc 50%, #fef2f2 100%); min-height: 100vh; }
    .topbar { background: linear-gradient(120deg, #c2410c, #dc2626); color: #fff; border-radius: 1rem; padding: 1rem 1.25rem; box-shadow: 0 14px 30px rgba(30, 41, 59, 0.15); }
    .dashboard-card { border: 1px solid #e2e8f0; border-radius: 1rem; box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06); }
    .stat-card { border-radius: 0.85rem; color: #fff; padding: 1rem; min-height: 110px; }
    .stat-incidents { background: linear-gradient(120deg, #ef4444, #dc2626); }
    .stat-late { background: linear-gradient(120deg, #f59e0b, #ea580c); }
    .stat-followup { background: linear-gradient(120deg, #0ea5e9, #2563eb); }
    .section-title { font-size: 0.95rem; font-weight: 700; color: #334155; margin-bottom: 0.85rem; }
    .quick-btn { border-radius: 0.7rem; font-weight: 600; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container py-4 py-lg-5">
    <div class="topbar mb-4"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2"><div><h1 class="h4 mb-1">Discipline Officer / Prefect Dashboard</h1><p class="mb-0 small">Student conduct, punctuality, behavior cases, and parent follow-up.</p></div><a href="deputy-director-dashboard.html" class="btn btn-light btn-sm">Operations View</a></div></div>
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4"><div class="stat-card stat-incidents"><div class="small text-white-50">Incidents This Week</div><div class="display-6 fw-bold lh-1 mt-1">14</div><div class="small mt-2">Serious cases: 2</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-late"><div class="small text-white-50">Late Arrivals</div><div class="display-6 fw-bold lh-1 mt-1">23</div><div class="small mt-2">Repeat offenders: 6</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-followup"><div class="small text-white-50">Parent Meetings</div><div class="display-6 fw-bold lh-1 mt-1">8</div><div class="small mt-2">Pending follow-up: 3</div></div></div>
    </div>
    <div class="row g-3">
      <div class="col-12 col-lg-7"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Incident Register</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Student</th><th>Case</th><th>Action</th><th>Status</th></tr></thead><tbody><tr><td>John K.</td><td>Fighting</td><td>Parent called</td><td><span class="badge text-bg-warning">Open</span></td></tr><tr><td>Esther M.</td><td>Late arrivals</td><td>Warning letter</td><td><span class="badge text-bg-primary">Monitoring</span></td></tr><tr><td>David B.</td><td>Uniform violation</td><td>Counselling</td><td><span class="badge text-bg-success">Resolved</span></td></tr><tr><td>Sarah N.</td><td>Class disruption</td><td>Meeting scheduled</td><td><span class="badge text-bg-warning">Open</span></td></tr></tbody></table></div></div></div></div>
      <div class="col-12 col-lg-5"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Hotspot Classes</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0 d-flex justify-content-between"><span>Grade 8 - B</span><strong>5 cases</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Grade 10 - A</span><strong>4 cases</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Grade 9 - C</span><strong>3 cases</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Grade 7 - A</span><strong>2 cases</strong></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Required Actions</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0"><div class="fw-semibold">Conduct parent conference for Grade 10 case</div><div class="small text-secondary">High-priority meeting before Friday.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Review gate punctuality report</div><div class="small text-secondary">Morning gate records show increase in late arrivals.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Update weekly discipline bulletin</div><div class="small text-secondary">Share trends with Deputy Director.</div></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Quick Actions</h2><div class="d-grid gap-2"><button class="btn btn-primary quick-btn" type="button">Record Incident</button><button class="btn btn-outline-primary quick-btn" type="button">Print Discipline Report</button><button class="btn btn-outline-secondary quick-btn" type="button">Schedule Parent Meeting</button><button class="btn btn-outline-success quick-btn" type="button">Open Late Arrival Log</button></div></div></div></div>
    </div>
  </div>
</body>
</html>