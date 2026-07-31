<?php
// sidebar.php - Admin Panel Sidebar Navigation
$currentPath = $_SERVER['PHP_SELF'];
$adminDirName = '/Admin Panel';
$adminRoot = $currentPath;
$pos = strpos($currentPath, $adminDirName);
if ($pos !== false) {
  $adminRoot = substr($currentPath, 0, $pos + strlen($adminDirName));
}
$currentPage = basename($currentPath);
$userManagementPages = ['User_management.php', 'Students.php', 'Owners.php', 'Admins.php', 'Blocked_Users.php', 'verification_requests.php'];
?>
<aside class="sidebar" id="sidebar">

  <nav class="sidebar-nav">
    <!-- Dashboard -->
    <a href="<?php echo $adminRoot; ?>/index.php" class="nav-item <?php echo ($currentPage == 'index.php' || $currentPage == '') ? 'active' : ''; ?>">
      <i class="fas fa-th-large"></i>
      <span>Dashboard</span>
    </a>

    <!-- User Management -->
    <div class="nav-section">User Management</div>
    <a href="<?php echo $adminRoot; ?>/All users/User_management.php" class="nav-item <?php echo in_array($currentPage, $userManagementPages) ? 'active' : ''; ?>">
      <i class="fas fa-users"></i>
      <span>All Users</span>
      <span class="badge-nav">156</span>
    </a>
    <div class="nav-sub">
      <a href="<?php echo $adminRoot; ?>/All users/Students.php" class="nav-item <?php echo $currentPage == 'Students.php' ? 'active' : ''; ?>"><i class="fas fa-user-graduate"></i><span>Students</span><span class="badge-nav">98</span></a>
      <a href="<?php echo $adminRoot; ?>/All users/Owners.php" class="nav-item <?php echo $currentPage == 'Owners.php' ? 'active' : ''; ?>"><i class="fas fa-user-tie"></i><span>Owners</span><span class="badge-nav">42</span></a>
      <a href="<?php echo $adminRoot; ?>/All users/Admins.php" class="nav-item <?php echo $currentPage == 'Admins.php' ? 'active' : ''; ?>"><i class="fas fa-user"></i><span>Admins</span><span class="badge-nav danger">16</span></a>
      <a href="<?php echo $adminRoot; ?>/All users/Blocked_Users.php" class="nav-item <?php echo $currentPage == 'Blocked_Users.php' ? 'active' : ''; ?>"><i class="fas fa-user-slash"></i><span>Blocked Users</span><span class="badge-nav danger">16</span></a>
      <a href="<?php echo $adminRoot; ?>/All users/verification_requests.php" class="nav-item <?php echo $currentPage == 'verification_requests.php' ? 'active' : ''; ?>"><i class="fas fa-user-check"></i><span>Verification Requests</span></a>
    </div>

    <!-- Property Management -->
    <div class="nav-section">Property Management</div>
    <a href="#" class="nav-item">
      <i class="fas fa-building"></i>
      <span>All Properties</span>
      <span class="badge-nav">234</span>
    </a>
    <div class="nav-sub">
      <a href="#" class="nav-item"><i class="fas fa-clock"></i><span>Pending Approval</span><span class="badge-nav danger">12</span></a>
      <a href="#" class="nav-item"><i class="fas fa-check-circle"></i><span>Approved</span><span class="badge-nav">198</span></a>
      <a href="#" class="nav-item"><i class="fas fa-times-circle"></i><span>Rejected</span><span class="badge-nav">24</span></a>
      <a href="#" class="nav-item"><i class="fas fa-flag"></i><span>Reported</span><span class="badge-nav danger">5</span></a>
    </div>

    <!-- Booking Management -->
    <div class="nav-section">Booking Management</div>
    <a href="#" class="nav-item">
      <i class="fas fa-calendar-check"></i>
      <span>All Bookings</span>
      <span class="badge-nav">342</span>
    </a>
    <div class="nav-sub">
      <a href="#" class="nav-item"><i class="fas fa-clock"></i><span>Pending</span><span class="badge-nav danger">28</span></a>
      <a href="#" class="nav-item"><i class="fas fa-check-circle"></i><span>Active</span><span class="badge-nav">45</span></a>
      <a href="#" class="nav-item"><i class="fas fa-check-double"></i><span>Completed</span><span class="badge-nav">269</span></a>
    </div>

    <!-- Financial -->
    <div class="nav-section">Financial</div>
    <a href="#" class="nav-item">
      <i class="fas fa-wallet"></i>
      <span>Payment Management</span>
      <span class="badge-nav">$187k</span>
    </a>
    <div class="nav-sub">
      <a href="#" class="nav-item"><i class="fas fa-credit-card"></i><span>Transactions</span></a>
      <a href="#" class="nav-item"><i class="fas fa-exclamation-triangle"></i><span>Disputes</span><span class="badge-nav danger">3</span></a>
    </div>

    <!-- Reviews & Complaints -->
    <div class="nav-section">Community</div>
    <a href="#" class="nav-item">
      <i class="fas fa-star"></i>
      <span>Reviews Management</span>
      <span class="badge-nav">4.6★</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-exclamation-circle"></i>
      <span>Complaints</span>
      <span class="badge-nav danger">7</span>
    </a>

    <!-- Analytics & Reports -->
    <div class="nav-section">Analytics</div>
    <a href="#" class="nav-item">
      <i class="fas fa-chart-line"></i>
      <span>Analytics</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-file-alt"></i>
      <span>Reports</span>
    </a>
    <a href="#" class="nav-item">
      <i class="fas fa-history"></i>
      <span>Activity Logs</span>
    </a>

    <!-- Settings -->
    <div class="nav-section">System</div>
    <a href="#" class="nav-item">
      <i class="fas fa-cog"></i>
      <span>Settings</span>
    </a>

    <!-- Divider -->
    <hr class="nav-divider" />

    <!-- Logout -->
    <a href="#" class="nav-item logout">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span>
    </a>
  </nav>
</aside>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
  /* ===================================================
     SIDEBAR STYLES (Admin Panel)
     =================================================== */
  :root {
    --nn-primary: #1E3A5F;
    --nn-primary-light: #4F46E5;
    --nn-lavender: #EEF2FF;
    --nn-success: #10B981;
    --nn-danger: #EF4444;
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
    --nn-sidebar-collapsed: 72px;
    --nn-navbar-height: 64px;
  }

  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--nn-sidebar-width);
    height: 100vh;
    background: var(--nn-white);
    border-right: 1px solid var(--nn-border);
    box-shadow: var(--nn-shadow);
    z-index: 1050;
    overflow-y: auto;
    overflow-x: hidden;
    transition: width 0.3s ease, transform 0.3s ease;
    padding: 0 0 1.5rem 0;
    display: flex;
    flex-direction: column;
  }





  .sidebar-nav {
    flex: 1;
    padding: 1rem 0.75rem;
    overflow-y: auto;
  }

  .sidebar-nav .nav-section {
    font-size: 0.65rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--nn-text-muted);
    padding: 0.75rem 1rem 0.4rem;
    margin-top: 0.25rem;
  }

  .sidebar-nav .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 0.6rem 1rem;
    border-radius: var(--nn-radius-sm);
    color: var(--nn-text-secondary);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.85rem;
    transition: var(--nn-transition);
    cursor: pointer;
    position: relative;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
  }

  .sidebar-nav .nav-item:hover {
    background: var(--nn-bg-light);
    color: var(--nn-text-primary);
  }

  .sidebar-nav .nav-item.active {
    background: var(--nn-lavender);
    color: var(--nn-primary-light);
    font-weight: 600;
  }

  .sidebar-nav .nav-item.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 10%;
    height: 80%;
    width: 3px;
    background: var(--nn-primary-light);
    border-radius: 0 4px 4px 0;
  }

  .sidebar-nav .nav-item i {
    width: 20px;
    font-size: 1rem;
    color: var(--nn-text-muted);
    flex-shrink: 0;
    transition: var(--nn-transition);
  }

  .sidebar-nav .nav-item.active i {
    color: var(--nn-primary-light);
  }

  .sidebar-nav .nav-item .badge-nav {
    margin-left: auto;
    background: var(--nn-primary-light);
    color: #fff;
    font-size: 0.6rem;
    font-weight: 700;
    padding: 0.15rem 0.6rem;
    border-radius: 40px;
    line-height: 1.4;
  }

  .sidebar-nav .nav-item .badge-nav.danger {
    background: var(--nn-danger);
  }

  .sidebar-nav .nav-sub {
    padding-left: 2.2rem;
  }

  .sidebar-nav .nav-sub .nav-item {
    font-size: 0.8rem;
    padding: 0.35rem 1rem;
    font-weight: 400;
  }

  .sidebar-nav .nav-sub .nav-item i {
    font-size: 0.7rem;
    width: 16px;
  }

  .sidebar-nav .nav-divider {
    border: none;
    border-top: 1px solid var(--nn-border);
    margin: 0.5rem 1rem;
    opacity: 0.6;
  }

  .sidebar-nav .nav-item.logout {
    margin-top: 0.5rem;
    border-top: 1px solid var(--nn-border);
    padding-top: 0.8rem;
    color: var(--nn-danger);
  }

  .sidebar-nav .nav-item.logout i {
    color: var(--nn-danger);
  }

  .sidebar-nav .nav-item.logout:hover {
    background: #FEF2F2;
    color: var(--nn-danger);
  }

  .sidebar.collapsed {
    width: var(--nn-sidebar-collapsed);
  }


  .sidebar.collapsed .nav-item span:not(.badge-nav),
  .sidebar.collapsed .nav-section,
  .sidebar.collapsed .nav-sub {
    display: none;
  }

  .sidebar.collapsed .nav-item {
    justify-content: center;
    padding: 0.6rem 0;
  }

  .sidebar.collapsed .nav-item i {
    font-size: 1.2rem;
    margin: 0;
  }

  .sidebar.collapsed .nav-item .badge-nav {
    position: absolute;
    top: 2px;
    right: 2px;
    font-size: 0.5rem;
    padding: 0.1rem 0.4rem;
  }



  .sidebar::-webkit-scrollbar {
    width: 4px;
  }

  .sidebar::-webkit-scrollbar-track {
    background: transparent;
  }

  .sidebar::-webkit-scrollbar-thumb {
    background: var(--nn-border);
    border-radius: 10px;
  }

  .sidebar::-webkit-scrollbar-thumb:hover {
    background: var(--nn-text-muted);
  }

  /* Mobile overlay */
  .sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1045;
  }

  .sidebar-overlay.active {
    display: block;
  }

  @media (max-width: 992px) {
    .sidebar {
      transform: translateX(-100%);
      width: 280px;
    }

    .sidebar.open {
      transform: translateX(0);
    }

    .sidebar.collapsed {
      width: 280px;
      transform: translateX(-100%);
    }

    .sidebar.collapsed.open {
      transform: translateX(0);
    }


    .sidebar.collapsed .nav-item span:not(.badge-nav),
    .sidebar.collapsed .nav-section,
    .sidebar.collapsed .nav-sub {
      display: inline;
    }

    .sidebar.collapsed .nav-item {
      justify-content: flex-start;
      padding: 0.6rem 1rem;
    }

    .sidebar.collapsed .nav-item i {
      font-size: 1rem;
      margin-right: 12px;
    }


  }
</style>