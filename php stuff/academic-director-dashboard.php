<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Academic Director Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    crossorigin="anonymous"
  />
  <style>
    body { background: linear-gradient(135deg, #eef2ff 0%, #f8fafc 52%, #ecfeff 100%); min-height: 100vh; }
    .topbar { background: linear-gradient(120deg, #4f46e5, #2563eb); color: #fff; border-radius: 1rem; padding: 1rem 1.25rem; box-shadow: 0 14px 30px rgba(30, 41, 59, 0.15); }
    .dashboard-card { border: 1px solid #e2e8f0; border-radius: 1rem; box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06); }
    .stat-card { border-radius: 0.85rem; color: #fff; padding: 1rem; min-height: 110px; }
    .stat-pass { background: linear-gradient(120deg, #2563eb, #4f46e5); }
    .stat-exams { background: linear-gradient(120deg, #8b5cf6, #7c3aed); }
    .stat-lessons { background: linear-gradient(120deg, #14b8a6, #0f766e); }
    .section-title { font-size: 0.95rem; font-weight: 700; color: #334155; margin-bottom: 0.85rem; }
    .quick-btn { border-radius: 0.7rem; font-weight: 600; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container py-4 py-lg-5">
    <div class="topbar mb-4"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2"><div><h1 class="h4 mb-1">Academic Director / Prefect of Studies</h1><p class="mb-0 small">Curriculum delivery, teacher performance, exams, and academic outcomes.</p></div><a href="teacher-dashboard.html" class="btn btn-light btn-sm">Teacher View</a></div></div>
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4"><div class="stat-card stat-pass"><div class="small text-white-50">Pass Rate</div><div class="display-6 fw-bold lh-1 mt-1">87%</div><div class="small mt-2">Term target: 90%</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-exams"><div class="small text-white-50">Exam Readiness</div><div class="display-6 fw-bold lh-1 mt-1">78%</div><div class="small mt-2">Papers approved: 39 / 50</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-lessons"><div class="small text-white-50">Lesson Coverage</div><div class="display-6 fw-bold lh-1 mt-1">82%</div><div class="small mt-2">Syllabus progress this term</div></div></div>
    </div>
    <div class="row g-3">
      <div class="col-12 col-lg-8"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Subject Performance</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Subject</th><th>Teacher</th><th>Average</th><th>Coverage</th></tr></thead><tbody><tr><td>Mathematics</td><td>Sarah Smith</td><td>84%</td><td>86%</td></tr><tr><td>English</td><td>Peter Okito</td><td>81%</td><td>88%</td></tr><tr><td>Science</td><td>Anne Kabedi</td><td>86%</td><td>80%</td></tr><tr><td>History</td><td>Grace Mushi</td><td>79%</td><td>77%</td></tr></tbody></table></div></div></div></div>
      <div class="col-12 col-lg-4"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Exam Control</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0 d-flex justify-content-between"><span>Papers submitted</span><strong>39</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Papers moderated</span><strong>31</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Invigilators assigned</span><strong>22</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Printing status</span><strong>Pending</strong></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Academic Actions</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0"><div class="fw-semibold">Approve low-performing class intervention</div><div class="small text-secondary">Grade 8 science needs remedial support.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Follow up on incomplete lesson plans</div><div class="small text-secondary">4 teachers have not uploaded weekly plans.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Finalize exam timetable</div><div class="small text-secondary">One lab session conflict remains.</div></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Quick Actions</h2><div class="d-grid gap-2"><button class="btn btn-primary quick-btn" type="button">Open Exam Tracker</button><button class="btn btn-outline-primary quick-btn" type="button">Review Subject Scores</button><button class="btn btn-outline-secondary quick-btn" type="button">See Lesson Plan Gaps</button><button class="btn btn-outline-success quick-btn" type="button">Print Academic Summary</button></div></div></div></div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
