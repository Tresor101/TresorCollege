<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bursar Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <style>
    body { background: linear-gradient(135deg, #f0fdf4 0%, #f8fafc 55%, #eff6ff 100%); min-height: 100vh; }
    .topbar { background: linear-gradient(120deg, #166534, #10b981); color: #fff; border-radius: 1rem; padding: 1rem 1.25rem; box-shadow: 0 14px 30px rgba(30, 41, 59, 0.15); }
    .dashboard-card { border: 1px solid #e2e8f0; border-radius: 1rem; box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06); }
    .stat-card { border-radius: 0.85rem; color: #fff; padding: 1rem; min-height: 110px; }
    .stat-collected { background: linear-gradient(120deg, #16a34a, #10b981); }
    .stat-balance { background: linear-gradient(120deg, #f59e0b, #ea580c); }
    .stat-payments { background: linear-gradient(120deg, #2563eb, #0ea5e9); }
    .section-title { font-size: 0.95rem; font-weight: 700; color: #334155; margin-bottom: 0.85rem; }
    .quick-btn { border-radius: 0.7rem; font-weight: 600; }
  </style>
</head>
<body>
  <?php include 'navbar.php'; ?>
  <div class="container py-4 py-lg-5">
    <div class="topbar mb-4"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2"><div><h1 class="h4 mb-1">Bursar / Accountant Dashboard</h1><p class="mb-0 small">Fee collection, balances, payment follow-up, and finance monitoring.</p></div><a href="proprietor-dashboard.html" class="btn btn-light btn-sm">Executive Finance</a></div></div>
    <div class="row g-3 mb-3">
      <div class="col-12 col-md-4"><div class="stat-card stat-collected"><div class="small text-white-50">Collected This Term</div><div class="display-6 fw-bold lh-1 mt-1">$114k</div><div class="small mt-2">Against target: 91%</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-balance"><div class="small text-white-50">Outstanding Balance</div><div class="display-6 fw-bold lh-1 mt-1">$12k</div><div class="small mt-2">128 accounts overdue</div></div></div>
      <div class="col-12 col-md-4"><div class="stat-card stat-payments"><div class="small text-white-50">Payments Today</div><div class="display-6 fw-bold lh-1 mt-1">37</div><div class="small mt-2">Cash and bank receipts</div></div></div>
    </div>
    <div class="row g-3">
      <div class="col-12 col-lg-8"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Collection by Level</h2><div class="table-responsive"><table class="table align-middle"><thead><tr><th>Level</th><th>Expected</th><th>Collected</th><th>Balance</th></tr></thead><tbody><tr><td>Nursery & Primary</td><td>$39,500</td><td>$36,700</td><td>$2,800</td></tr><tr><td>Lower Secondary</td><td>$48,400</td><td>$44,900</td><td>$3,500</td></tr><tr><td>Upper Secondary</td><td>$58,900</td><td>$53,200</td><td>$5,700</td></tr></tbody></table></div></div></div></div>
      <div class="col-12 col-lg-4"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Finance Alerts</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0"><div class="fw-semibold">Salary run due in 4 days</div><div class="small text-secondary">Payroll reconciliation pending.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Three high-balance families</div><div class="small text-secondary">Need promoter approval for payment plan.</div></li><li class="list-group-item px-0"><div class="fw-semibold">Transport vendor invoice</div><div class="small text-secondary">Awaiting supporting documents.</div></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Recent Transactions</h2><ul class="list-group list-group-flush"><li class="list-group-item px-0 d-flex justify-content-between"><span>Bank transfer batch</span><strong>$8,200</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Cash office receipts</span><strong>$1,650</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Uniform payments</span><strong>$740</strong></li><li class="list-group-item px-0 d-flex justify-content-between"><span>Transport fees</span><strong>$1,120</strong></li></ul></div></div></div>
      <div class="col-12 col-lg-6"><div class="card dashboard-card h-100"><div class="card-body"><h2 class="section-title">Quick Actions</h2><div class="d-grid gap-2"><button class="btn btn-primary quick-btn" type="button">Record Payment</button><button class="btn btn-outline-primary quick-btn" type="button">Print Debt Report</button><button class="btn btn-outline-secondary quick-btn" type="button">Export Cashbook</button><button class="btn btn-outline-success quick-btn" type="button">Open Fee Statements</button></div></div></div></div>
    </div>
  </div>
</body>
</html>