<?php
// index.php - Admin Dashboard (Main Content Only)
// Set breadcrumb for top navbar
$breadcrumb = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NeighborNest · Admin Dashboard</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    /* ===================================================
       MAIN LAYOUT STYLES
       =================================================== */
    :root {
      --nn-primary: #1E3A5F;
      --nn-primary-light: #4F46E5;
      --nn-gradient: linear-gradient(135deg, #1E3A5F 0%, #4F46E5 100%);
      --nn-lavender: #EEF2FF;
      --nn-success: #10B981;
      --nn-amber: #F59E0B;
      --nn-danger: #EF4444;
      --nn-teal: #0D9488;
      --nn-white: #FFFFFF;
      --nn-bg-light: #F8FAFC;
      --nn-text-primary: #1E293B;
      --nn-text-secondary: #64748B;
      --nn-text-muted: #94A3B8;
      --nn-border: #E2E8F0;
      --nn-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
      --nn-shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.08);
      --nn-radius-sm: 12px;
      --nn-transition: 0.25s ease;
      --nn-sidebar-width: 260px;
      --nn-navbar-height: 64px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: var(--nn-bg-light);
      color: var(--nn-text-primary);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    .heading-font {
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      font-weight: 700;
      letter-spacing: -0.02em;
    }

    .text-secondary-custom {
      color: var(--nn-text-secondary);
    }

    .text-muted-custom {
      color: var(--nn-text-muted);
    }

    /* Main content wrapper */
    .main-content {
      margin-left: var(--nn-sidebar-width);
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }

    .main-content.expanded {
      margin-left: 72px;
    }

    @media (max-width: 992px) {
      .main-content {
        margin-left: 0 !important;
      }

      .main-content.expanded {
        margin-left: 0 !important;
      }
    }

    /* ===================================================
       PAGE CONTENT STYLES
       =================================================== */
    .page-content {
      padding: 1.5rem 1.5rem 2rem;
    }

    .page-header {
      margin-bottom: 1.5rem;
    }

    .page-header h1 {
      font-size: 1.6rem;
      font-weight: 800;
      margin-bottom: 0.1rem;
    }

    .page-header p {
      color: var(--nn-text-secondary);
      font-size: 0.9rem;
      margin: 0;
    }

    /* Stats Cards */
    .stat-card {
      background: var(--nn-white);
      border-radius: var(--nn-radius-sm);
      padding: 1.2rem 1.2rem 1rem;
      box-shadow: var(--nn-shadow);
      border: 1px solid var(--nn-border);
      transition: var(--nn-transition);
      height: 100%;
    }

    .stat-card:hover {
      box-shadow: var(--nn-shadow-hover);
      transform: translateY(-2px);
    }

    .stat-card .stat-number {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--nn-primary);
      line-height: 1.1;
    }

    .stat-card .stat-label {
      font-size: 0.8rem;
      color: var(--nn-text-secondary);
      font-weight: 500;
    }

    .stat-card .stat-change {
      font-size: 0.7rem;
      font-weight: 600;
      padding: 0.1rem 0.6rem;
      border-radius: 40px;
      display: inline-block;
    }

    .stat-card .stat-change.up {
      background: #D1FAE5;
      color: var(--nn-success);
    }

    .stat-card .stat-change.down {
      background: #FEE2E2;
      color: var(--nn-danger);
    }

    .stat-card .stat-icon {
      font-size: 1.6rem;
      color: var(--nn-primary-light);
      opacity: 0.6;
    }

    /* Chart Placeholder */
    .chart-placeholder {
      background: var(--nn-white);
      border-radius: var(--nn-radius-sm);
      padding: 1.2rem 1.2rem 0.8rem;
      box-shadow: var(--nn-shadow);
      border: 1px solid var(--nn-border);
      height: 100%;
    }

    .chart-placeholder .chart-title {
      font-weight: 600;
      font-size: 0.95rem;
      margin-bottom: 0.25rem;
    }

    .chart-placeholder .chart-sub {
      font-size: 0.75rem;
      color: var(--nn-text-secondary);
    }

    .chart-placeholder .chart-bars {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      height: 140px;
      gap: 6px;
      padding: 1rem 0 0.5rem;
    }

    .chart-placeholder .chart-bars .bar {
      flex: 1;
      border-radius: 6px 6px 0 0;
      min-height: 12px;
      background: var(--nn-lavender);
      transition: var(--nn-transition);
      position: relative;
    }

    .chart-placeholder .chart-bars .bar:hover {
      opacity: 0.8;
    }

    .chart-placeholder .chart-bars .bar .bar-label {
      position: absolute;
      bottom: -1.2rem;
      left: 50%;
      transform: translateX(-50%);
      font-size: 0.55rem;
      color: var(--nn-text-muted);
      font-weight: 500;
      white-space: nowrap;
    }

    .chart-placeholder .chart-bars .bar.fill-primary {
      background: var(--nn-primary-light);
    }

    .chart-placeholder .chart-bars .bar.fill-teal {
      background: var(--nn-teal);
    }

    .chart-placeholder .chart-bars .bar.fill-amber {
      background: var(--nn-amber);
    }

    /* Table */
    .table-nn {
      background: var(--nn-white);
      border-radius: var(--nn-radius-sm);
      overflow: hidden;
      box-shadow: var(--nn-shadow);
      border: 1px solid var(--nn-border);
    }

    .table-nn thead th {
      background: var(--nn-bg-light);
      font-size: 0.65rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.05em;
      color: var(--nn-text-muted);
      border-bottom: 1px solid var(--nn-border);
      padding: 0.7rem 1rem;
    }

    .table-nn tbody td {
      font-size: 0.85rem;
      padding: 0.7rem 1rem;
      vertical-align: middle;
      border-bottom: 1px solid var(--nn-border);
    }

    .table-nn tbody tr:hover {
      background: var(--nn-bg-light);
    }

    .table-nn .status-badge {
      font-size: 0.65rem;
      font-weight: 600;
      padding: 0.15rem 0.7rem;
      border-radius: 40px;
      display: inline-block;
      white-space: nowrap;
    }

    .status-badge.pending {
      background: #FEF3C7;
      color: #D97706;
    }

    .status-badge.approved {
      background: #D1FAE5;
      color: #059669;
    }

    .status-badge.active {
      background: #DBEAFE;
      color: #2563EB;
    }

    .status-badge.completed {
      background: #CCFBF1;
      color: #0D9488;
    }

    .status-badge.rejected {
      background: #FEE2E2;
      color: #DC2626;
    }

    .btn-sm-nn {
      padding: 0.2rem 0.8rem;
      font-size: 0.7rem;
      font-weight: 600;
      border-radius: 40px;
      border: none;
      transition: var(--nn-transition);
    }

    .btn-sm-nn.primary {
      background: var(--nn-primary-light);
      color: #fff;
    }

    .btn-sm-nn.primary:hover {
      background: #4338CA;
    }

    .btn-sm-nn.success {
      background: var(--nn-success);
      color: #fff;
    }

    .btn-sm-nn.danger {
      background: var(--nn-danger);
      color: #fff;
    }

    .btn-sm-nn.outline {
      background: transparent;
      color: var(--nn-text-secondary);
      border: 1px solid var(--nn-border);
    }

    .btn-sm-nn.outline:hover {
      background: var(--nn-bg-light);
    }

    .btn-nn-primary {
      background: var(--nn-gradient);
      color: #fff;
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.85rem;
      transition: var(--nn-transition);
      box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-nn-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 16px 40px rgba(79, 70, 229, 0.35);
      color: #fff;
    }

    .btn-nn-outline {
      background: transparent;
      border: 1.5px solid var(--nn-primary-light);
      color: var(--nn-primary-light);
      padding: 0.5rem 1.5rem;
      border-radius: 60px;
      font-weight: 600;
      font-size: 0.85rem;
      transition: var(--nn-transition);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }

    .btn-nn-outline:hover {
      background: var(--nn-primary-light);
      color: #fff;
      transform: translateY(-3px);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .page-content {
        padding: 1rem;
      }

      .page-header h1 {
        font-size: 1.3rem;
      }

      .stat-card .stat-number {
        font-size: 1.4rem;
      }

      .table-nn {
        font-size: 0.75rem;
      }

      .table-nn thead th,
      .table-nn tbody td {
        padding: 0.4rem 0.6rem;
      }
    }

    @media (max-width: 576px) {
      .stat-card {
        padding: 0.8rem;
      }

      .stat-card .stat-number {
        font-size: 1.2rem;
      }

      .chart-placeholder .chart-bars {
        height: 100px;
      }
    }

    /* Animations */
    .fade-up {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeUp 0.5s ease forwards;
    }

    @keyframes fadeUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .delay-1 {
      animation-delay: 0.05s;
    }

    .delay-2 {
      animation-delay: 0.1s;
    }

    .delay-3 {
      animation-delay: 0.15s;
    }

    .delay-4 {
      animation-delay: 0.2s;
    }
  </style>
</head>

<body>

  <!-- Include Sidebar -->
  <?php include 'sidebar.php'; ?>

  <!-- Main Content Wrapper -->
  <div class="main-content" id="mainContent">

    <!-- Include Top Navbar -->
    <?php include 'top_nevbar.php'; ?>

    <!-- ============================================================
         PAGE CONTENT (Admin Dashboard)
         ============================================================ -->
    <div class="page-content">

      <!-- Stats Cards -->
      <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-md-3 fade-up delay-1">
          <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="stat-number">156</div>
                <div class="stat-label">Total Users</div>
              </div>
              <div class="stat-icon"><i class="fas fa-users"></i></div>
            </div>
            <div class="mt-2">
              <span class="stat-change up">↑ 12 this week</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3 fade-up delay-2">
          <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="stat-number">234</div>
                <div class="stat-label">Properties</div>
              </div>
              <div class="stat-icon"><i class="fas fa-building"></i></div>
            </div>
            <div class="mt-2">
              <span class="stat-change up">↑ 8 new this week</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3 fade-up delay-3">
          <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="stat-number">342</div>
                <div class="stat-label">Total Bookings</div>
              </div>
              <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
            </div>
            <div class="mt-2">
              <span class="stat-change up">↑ 28 pending</span>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-3 fade-up delay-4">
          <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="stat-number">$187K</div>
                <div class="stat-label">Total Revenue</div>
              </div>
              <div class="stat-icon"><i class="fas fa-wallet"></i></div>
            </div>
            <div class="mt-2">
              <span class="stat-change up">↑ 15% vs last month</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Charts Row -->
      <div class="row g-3 g-md-4 mb-4">
        <div class="col-md-6 fade-up delay-1">
          <div class="chart-placeholder">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="chart-title">📈 Revenue Overview</div>
                <div class="chart-sub">Monthly platform revenue trend</div>
              </div>
              <span class="fw-bold text-primary">$187K</span>
            </div>
            <div class="chart-bars">
              <div class="bar fill-primary" style="height:35%;"><span class="bar-label">Jan</span></div>
              <div class="bar fill-primary" style="height:42%;"><span class="bar-label">Feb</span></div>
              <div class="bar fill-primary" style="height:38%;"><span class="bar-label">Mar</span></div>
              <div class="bar fill-primary" style="height:50%;"><span class="bar-label">Apr</span></div>
              <div class="bar fill-primary" style="height:45%;"><span class="bar-label">May</span></div>
              <div class="bar fill-primary" style="height:62%;"><span class="bar-label">Jun</span></div>
              <div class="bar fill-primary" style="height:58%;"><span class="bar-label">Jul</span></div>
              <div class="bar fill-primary" style="height:70%;"><span class="bar-label">Aug</span></div>
              <div class="bar fill-primary" style="height:65%;"><span class="bar-label">Sep</span></div>
              <div class="bar fill-primary" style="height:78%;"><span class="bar-label">Oct</span></div>
              <div class="bar fill-primary" style="height:72%;"><span class="bar-label">Nov</span></div>
              <div class="bar fill-primary" style="height:85%;"><span class="bar-label">Dec</span></div>
            </div>
            <div class="text-end">
              <span class="stat-change up">↑ 15% from last month</span>
            </div>
          </div>
        </div>
        <div class="col-md-6 fade-up delay-2">
          <div class="chart-placeholder">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <div class="chart-title">📊 Platform Activity</div>
                <div class="chart-sub">Users vs Bookings growth</div>
              </div>
              <span class="text-secondary-custom small">+28% YoY</span>
            </div>
            <div class="chart-bars">
              <div class="bar fill-primary" style="height:60%;"><span class="bar-label">Users</span></div>
              <div class="bar fill-teal" style="height:45%;"><span class="bar-label">Bookings</span></div>
              <div class="bar fill-primary" style="height:70%;"><span class="bar-label">Users</span></div>
              <div class="bar fill-teal" style="height:55%;"><span class="bar-label">Bookings</span></div>
              <div class="bar fill-primary" style="height:80%;"><span class="bar-label">Users</span></div>
              <div class="bar fill-teal" style="height:65%;"><span class="bar-label">Bookings</span></div>
              <div class="bar fill-primary" style="height:90%;"><span class="bar-label">Users</span></div>
              <div class="bar fill-teal" style="height:75%;"><span class="bar-label">Bookings</span></div>
            </div>
            <div class="d-flex justify-content-between small text-secondary-custom">
              <span><span class="text-primary">■</span> New Users</span>
              <span><span class="text-teal" style="color:var(--nn-teal);">■</span> Bookings</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Activity Table -->
      <div class="fade-up delay-3">
        <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
          <h5 class="fw-bold mb-0">🔄 Recent Activity</h5>
          <a href="#" class="text-primary text-decoration-none small fw-semibold">View All <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="table-responsive">
          <table class="table table-nn mb-0">
            <thead>
              <tr>
                <th>User</th>
                <th>Action</th>
                <th>Property</th>
                <th>Date</th>
                <th>Status</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span class="fw-medium">Ravi Kumar</span><br /><span class="text-muted-custom small">Student</span></td>
                <td>New Booking</td>
                <td>Sunrise PG</td>
                <td>Jun 15, 2024</td>
                <td><span class="status-badge pending">Pending</span></td>
                <td class="text-end">
                  <button class="btn-sm-nn success me-1">✓</button>
                  <button class="btn-sm-nn danger">✗</button>
                </td>
              </tr>
              <tr>
                <td><span class="fw-medium">Priya Shah</span><br /><span class="text-muted-custom small">Owner</span></td>
                <td>New Property</td>
                <td>Green Nest</td>
                <td>Jun 14, 2024</td>
                <td><span class="status-badge pending">Pending</span></td>
                <td class="text-end">
                  <button class="btn-sm-nn success me-1">Approve</button>
                  <button class="btn-sm-nn danger">Reject</button>
                </td>
              </tr>
              <tr>
                <td><span class="fw-medium">Amit Singh</span><br /><span class="text-muted-custom small">Student</span></td>
                <td>Review Posted</td>
                <td>Lake View</td>
                <td>Jun 13, 2024</td>
                <td><span class="status-badge approved">Approved</span></td>
                <td class="text-end">
                  <button class="btn-sm-nn outline">View</button>
                </td>
              </tr>
              <tr>
                <td><span class="fw-medium">Sara Khan</span><br /><span class="text-muted-custom small">Owner</span></td>
                <td>Reported Issue</td>
                <td>Sky PG</td>
                <td>Jun 12, 2024</td>
                <td><span class="status-badge rejected">Flagged</span></td>
                <td class="text-end">
                  <button class="btn-sm-nn primary">Review</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="row g-3 mt-3 fade-up delay-4">
        <div class="col-12">
          <div class="d-flex flex-wrap gap-2">
            <a href="#" class="btn-nn-primary"><i class="fas fa-user-plus me-1"></i> Add Admin</a>
            <a href="#" class="btn-nn-outline"><i class="fas fa-building me-1"></i> Manage Properties</a>
            <a href="#" class="btn-nn-outline"><i class="fas fa-file-alt me-1"></i> Generate Report</a>
            <a href="#" class="btn-nn-outline"><i class="fas fa-cog me-1"></i> Platform Settings</a>
          </div>
        </div>
      </div>

    </div><!-- /page-content -->
  </div><!-- /main-content -->

  <!-- ============================================================
     BOOTSTRAP JS
     ============================================================ -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
  </script>

  <!-- ============================================================
     CUSTOM JS
     ============================================================ -->
  <script>
    (function() {
      'use strict';

      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const toggleBtn = document.getElementById('toggleSidebar');
      const overlay = document.getElementById('sidebarOverlay');
      let isCollapsed = false;
      let isMobile = window.innerWidth < 992;

      function handleSidebarToggle() {
        if (isMobile) {
          sidebar.classList.toggle('open');
          overlay.classList.toggle('active');
        } else {
          isCollapsed = !isCollapsed;
          sidebar.classList.toggle('collapsed', isCollapsed);
          mainContent.classList.toggle('expanded', isCollapsed);
        }
      }

      if (toggleBtn) {
        toggleBtn.addEventListener('click', handleSidebarToggle);
      }

      if (overlay) {
        overlay.addEventListener('click', function() {
          sidebar.classList.remove('open');
          overlay.classList.remove('active');
        });
      }

      // Close sidebar on nav item click (mobile)
      document.querySelectorAll('.sidebar-nav .nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
          if (isMobile) {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
          }
          document.querySelectorAll('.sidebar-nav .nav-item').forEach(el => el.classList.remove('active'));
          this.classList.add('active');
        });
      });

      function handleResize() {
        const nowMobile = window.innerWidth < 992;
        if (nowMobile !== isMobile) {
          isMobile = nowMobile;
          if (isMobile) {
            sidebar.classList.remove('collapsed');
            mainContent.classList.remove('expanded');
            sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
          } else {
            sidebar.classList.remove('open');
            if (overlay) overlay.classList.remove('active');
            if (isCollapsed) {
              sidebar.classList.add('collapsed');
              mainContent.classList.add('expanded');
            }
          }
        }
      }

      window.addEventListener('resize', handleResize);

      console.log('NeighborNest · Admin Dashboard loaded.');
    })();
  </script>

</body>

</html>