<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Proprietor Dashboard</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
    crossorigin="anonymous"
  />
  <style>
    body {
      background:
        radial-gradient(circle at 12% 18%, rgba(14, 165, 233, 0.14), transparent 26%),
        radial-gradient(circle at 88% 12%, rgba(245, 158, 11, 0.16), transparent 24%),
        linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #fefce8 100%);
      min-height: 100vh;
      color: #0f172a;
    }

    .topbar {
      background: linear-gradient(120deg, #0f172a, #1d4ed8 55%, #f59e0b);
      color: #fff;
      border-radius: 1rem;
      padding: 1rem 1.25rem;
      box-shadow: 0 16px 34px rgba(15, 23, 42, 0.16);
    }

    .dashboard-card {
      border: 1px solid #e2e8f0;
      border-radius: 1rem;
      box-shadow: 0 8px 18px rgba(15, 23, 42, 0.06);
      background: rgba(255, 255, 255, 0.95);
    }

    .stat-card {
      border-radius: 0.95rem;
      color: #fff;
      padding: 1rem;
      min-height: 118px;
      box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
    }

    .stat-enrollment { background: linear-gradient(120deg, #2563eb, #0ea5e9); }
    .stat-revenue { background: linear-gradient(120deg, #15803d, #10b981); }
    .stat-staff { background: linear-gradient(120deg, #7c3aed, #4338ca); }
    .stat-compliance { background: linear-gradient(120deg, #f59e0b, #ea580c); }

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

    .term-select {
      min-width: 250px;
      border-radius: 0.6rem;
      border: 0;
    }

    .metric-label {
      color: rgba(255, 255, 255, 0.78);
      font-size: 0.85rem;
    }

    .mini-kpi {
      border: 1px solid #e2e8f0;
      border-radius: 0.85rem;
      padding: 0.9rem;
      background: linear-gradient(180deg, #fff, #f8fafc);
    }
  </style>
</head>
<body>
  <div class="container py-4 py-lg-5">
    <div class="topbar mb-4">
      <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
        <div>
          <h1 class="h4 mb-1">Proprietor / Promoter Dashboard</h1>
          <p class="mb-0 small">Kivu Sunrise Private School • Executive overview • Last updated: Today</p>
        </div>
        <div class="d-flex flex-wrap gap-2 align-items-end">
          <div>
            <label for="termSelector" class="form-label small mb-1 text-white">Select Reporting Term</label>
            <select id="termSelector" class="form-select form-select-sm term-select"></select>
          </div>
          <a href="registration-form.html" class="btn btn-light btn-sm">Register Student</a>
        </div>
      </div>
    </div>

    <div class="row g-3 mb-3">
      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-enrollment">
          <div class="metric-label">Total Enrollment</div>
          <div id="statEnrollment" class="display-6 fw-bold lh-1 mt-1">824</div>
          <div id="statNewAdmissions" class="small mt-2">New admissions: 96</div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-revenue">
          <div class="metric-label">Fee Collection</div>
          <div id="statRevenue" class="display-6 fw-bold lh-1 mt-1">$124k</div>
          <div id="statCollectionRate" class="small mt-2">Collection rate: 88%</div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-staff">
          <div class="metric-label">Active Staff</div>
          <div id="statStaff" class="display-6 fw-bold lh-1 mt-1">61</div>
          <div id="statTeachers" class="small mt-2">Teachers: 44</div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-xl-3">
        <div class="stat-card stat-compliance">
          <div class="metric-label">Compliance Status</div>
          <div id="statCompliance" class="display-6 fw-bold lh-1 mt-1">92%</div>
          <div id="statAudit" class="small mt-2">Audit actions open: 3</div>
        </div>
      </div>
    </div>

    <div class="row g-3 mb-3">
      <div class="col-12 col-lg-4">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">School Overview</h2>
            <ul class="list-group list-group-flush">
              <li class="list-group-item px-0 d-flex justify-content-between"><span>School Name</span><strong>Kivu Sunrise Private School</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Academic Year</span><strong id="overviewYear">2025-2026</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Campuses</span><strong id="overviewCampuses">2</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>School Director</span><strong id="overviewDirector">Mr. Joel Mbuyi</strong></li>
              <li class="list-group-item px-0 d-flex justify-content-between"><span>Next Board Review</span><strong id="overviewReview">Mar 28, 2026</strong></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-8">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Executive Highlights</h2>
            <div class="row g-3">
              <div class="col-12 col-md-4">
                <div class="mini-kpi">
                  <div class="small text-secondary">Average Pass Rate</div>
                  <div id="passRate" class="h3 fw-bold mb-1">84%</div>
                  <div class="small text-secondary">Across all classes</div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="mini-kpi">
                  <div class="small text-secondary">Outstanding Fees</div>
                  <div id="outstandingFees" class="h3 fw-bold mb-1">$17k</div>
                  <div class="small text-secondary">Current reporting term</div>
                </div>
              </div>
              <div class="col-12 col-md-4">
                <div class="mini-kpi">
                  <div class="small text-secondary">Student Retention</div>
                  <div id="retentionRate" class="h3 fw-bold mb-1">95%</div>
                  <div class="small text-secondary">Compared to last term</div>
                </div>
              </div>
            </div>
            <div class="table-responsive mt-3">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th>Department</th>
                    <th>Head</th>
                    <th>Performance</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="departmentBody"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row g-3">
      <div class="col-12 col-lg-6">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Fee Collection Summary</h2>
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th>Class Group</th>
                    <th>Expected</th>
                    <th>Collected</th>
                    <th>Balance</th>
                  </tr>
                </thead>
                <tbody id="feesBody"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Management Tasks</h2>
            <ul id="tasksList" class="list-group list-group-flush"></ul>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Key Announcements</h2>
            <ul id="announcementsList" class="list-group list-group-flush"></ul>
          </div>
        </div>
      </div>

      <div class="col-12 col-lg-6">
        <div class="card dashboard-card h-100">
          <div class="card-body">
            <h2 class="section-title">Quick Actions</h2>
            <div class="d-grid gap-2">
              <button class="btn btn-primary quick-btn" type="button">View Financial Report</button>
              <button class="btn btn-outline-primary quick-btn" type="button">Approve Budget Request</button>
              <button class="btn btn-outline-secondary quick-btn" type="button">Review Staff Structure</button>
              <button class="btn btn-outline-success quick-btn" type="button">Open School Performance Report</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    const termSelector = document.getElementById("termSelector");
    const statEnrollment = document.getElementById("statEnrollment");
    const statNewAdmissions = document.getElementById("statNewAdmissions");
    const statRevenue = document.getElementById("statRevenue");
    const statCollectionRate = document.getElementById("statCollectionRate");
    const statStaff = document.getElementById("statStaff");
    const statTeachers = document.getElementById("statTeachers");
    const statCompliance = document.getElementById("statCompliance");
    const statAudit = document.getElementById("statAudit");
    const overviewYear = document.getElementById("overviewYear");
    const overviewCampuses = document.getElementById("overviewCampuses");
    const overviewDirector = document.getElementById("overviewDirector");
    const overviewReview = document.getElementById("overviewReview");
    const passRate = document.getElementById("passRate");
    const outstandingFees = document.getElementById("outstandingFees");
    const retentionRate = document.getElementById("retentionRate");
    const departmentBody = document.getElementById("departmentBody");
    const feesBody = document.getElementById("feesBody");
    const tasksList = document.getElementById("tasksList");
    const announcementsList = document.getElementById("announcementsList");

    const reports = [
      {
        id: "2025-T1",
        label: "2025-2026 • Term 1",
        academicYear: "2025-2026",
        campuses: 2,
        director: "Mr. Joel Mbuyi",
        boardReview: "Mar 28, 2026",
        enrollment: 824,
        newAdmissions: 96,
        revenue: "$124k",
        collectionRate: 88,
        staff: 61,
        teachers: 44,
        compliance: 92,
        auditActions: 3,
        passRate: 84,
        outstandingFees: "$17k",
        retentionRate: 95,
        departments: [
          { name: "Academics", head: "Mrs. Chantal Ilunga", performance: "86%", status: "Strong", badge: "success" },
          { name: "Finance", head: "Mr. Patrick Kasongo", performance: "88%", status: "Stable", badge: "primary" },
          { name: "Discipline", head: "Mr. Daniel Banza", performance: "81%", status: "Needs Follow-up", badge: "warning" },
          { name: "Administration", head: "Ms. Ruth Mukendi", performance: "90%", status: "On Track", badge: "success" }
        ],
        fees: [
          { group: "Nursery & Primary", expected: "$38,000", collected: "$33,600", balance: "$4,400" },
          { group: "Lower Secondary", expected: "$46,000", collected: "$40,900", balance: "$5,100" },
          { group: "Upper Secondary", expected: "$57,000", collected: "$50,100", balance: "$6,900" }
        ],
        tasks: [
          { title: "Approve revised transport budget", due: "Today", priority: "High" },
          { title: "Review bursar fee recovery plan", due: "Tomorrow", priority: "High" },
          { title: "Validate next term staffing proposal", due: "This week", priority: "Medium" },
          { title: "Sign ministry compliance letter", due: "This week", priority: "Medium" }
        ],
        announcements: [
          { title: "School inspection scheduled", detail: "Provincial inspection team expected on Mar 21." },
          { title: "Science lab renovation approved", detail: "Works start during the holiday break." },
          { title: "Fee payment extension", detail: "Extension granted to families affected by delayed salaries." }
        ]
      },
      {
        id: "2025-T2",
        label: "2025-2026 • Term 2",
        academicYear: "2025-2026",
        campuses: 2,
        director: "Mr. Joel Mbuyi",
        boardReview: "Jun 18, 2026",
        enrollment: 841,
        newAdmissions: 28,
        revenue: "$131k",
        collectionRate: 91,
        staff: 63,
        teachers: 46,
        compliance: 95,
        auditActions: 1,
        passRate: 87,
        outstandingFees: "$12k",
        retentionRate: 96,
        departments: [
          { name: "Academics", head: "Mrs. Chantal Ilunga", performance: "89%", status: "Strong", badge: "success" },
          { name: "Finance", head: "Mr. Patrick Kasongo", performance: "92%", status: "Excellent", badge: "success" },
          { name: "Discipline", head: "Mr. Daniel Banza", performance: "84%", status: "Improving", badge: "info" },
          { name: "Administration", head: "Ms. Ruth Mukendi", performance: "93%", status: "On Track", badge: "success" }
        ],
        fees: [
          { group: "Nursery & Primary", expected: "$39,500", collected: "$36,700", balance: "$2,800" },
          { group: "Lower Secondary", expected: "$48,400", collected: "$44,900", balance: "$3,500" },
          { group: "Upper Secondary", expected: "$58,900", collected: "$53,200", balance: "$5,700" }
        ],
        tasks: [
          { title: "Approve classroom furniture purchase", due: "Today", priority: "High" },
          { title: "Review teacher recruitment shortlist", due: "Tomorrow", priority: "High" },
          { title: "Confirm exam security budget", due: "This week", priority: "Medium" },
          { title: "Inspect girls dormitory maintenance report", due: "This week", priority: "Low" }
        ],
        announcements: [
          { title: "Term 2 exam preparation underway", detail: "Printing and supervision plans have started." },
          { title: "Fee recovery improved", detail: "Outstanding balance reduced by 29% compared to Term 1." },
          { title: "Teacher housing support proposal", detail: "Draft package submitted for promoter review." }
        ]
      }
    ];

    function renderDepartments(items) {
      departmentBody.innerHTML = items
        .map(
          (item) => `
            <tr>
              <td>${item.name}</td>
              <td>${item.head}</td>
              <td>${item.performance}</td>
              <td><span class="badge text-bg-${item.badge}">${item.status}</span></td>
            </tr>
          `
        )
        .join("");
    }

    function renderFees(items) {
      feesBody.innerHTML = items
        .map(
          (item) => `
            <tr>
              <td>${item.group}</td>
              <td>${item.expected}</td>
              <td>${item.collected}</td>
              <td>${item.balance}</td>
            </tr>
          `
        )
        .join("");
    }

    function priorityBadge(priority) {
      if (priority === "High") {
        return "danger";
      }
      if (priority === "Medium") {
        return "warning";
      }
      return "secondary";
    }

    function renderTasks(items) {
      tasksList.innerHTML = items
        .map(
          (item) => `
            <li class="list-group-item px-0 d-flex justify-content-between align-items-center gap-3">
              <div>
                <div class="fw-semibold">${item.title}</div>
                <div class="small text-secondary">Due: ${item.due}</div>
              </div>
              <span class="badge text-bg-${priorityBadge(item.priority)}">${item.priority}</span>
            </li>
          `
        )
        .join("");
    }

    function renderAnnouncements(items) {
      announcementsList.innerHTML = items
        .map(
          (item) => `
            <li class="list-group-item px-0">
              <div class="fw-semibold">${item.title}</div>
              <div class="small text-secondary">${item.detail}</div>
            </li>
          `
        )
        .join("");
    }

    function renderReport(report) {
      statEnrollment.textContent = report.enrollment;
      statNewAdmissions.textContent = `New admissions: ${report.newAdmissions}`;
      statRevenue.textContent = report.revenue;
      statCollectionRate.textContent = `Collection rate: ${report.collectionRate}%`;
      statStaff.textContent = report.staff;
      statTeachers.textContent = `Teachers: ${report.teachers}`;
      statCompliance.textContent = `${report.compliance}%`;
      statAudit.textContent = `Audit actions open: ${report.auditActions}`;
      overviewYear.textContent = report.academicYear;
      overviewCampuses.textContent = report.campuses;
      overviewDirector.textContent = report.director;
      overviewReview.textContent = report.boardReview;
      passRate.textContent = `${report.passRate}%`;
      outstandingFees.textContent = report.outstandingFees;
      retentionRate.textContent = `${report.retentionRate}%`;

      renderDepartments(report.departments);
      renderFees(report.fees);
      renderTasks(report.tasks);
      renderAnnouncements(report.announcements);
    }

    reports.forEach((report, index) => {
      const option = document.createElement("option");
      option.value = report.id;
      option.textContent = report.label;
      if (index === 0) {
        option.selected = true;
      }
      termSelector.appendChild(option);
    });

    termSelector.addEventListener("change", () => {
      const selectedReport = reports.find((item) => item.id === termSelector.value);
      if (selectedReport) {
        renderReport(selectedReport);
      }
    });

    renderReport(reports[0]);
  </script>
</body>
</html>