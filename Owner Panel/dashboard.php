<?php
// Owner Panel dashboard.php - Host Dashboard Overview
$pageTitle = 'Dashboard · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$owner = $_SESSION['owner'] ?? [];
$properties = $_SESSION['owner_properties'] ?? [];
$bookings = $_SESSION['owner_bookings'] ?? [];
$earnings = $_SESSION['owner_earnings'] ?? [];

$activePropertiesCount = count(array_filter($properties, fn($p) => $p['status'] === 'Active'));
$pendingBookingsCount = count(array_filter($bookings, fn($b) => $b['status'] === 'Pending'));
$activeBookingsCount = count(array_filter($bookings, fn($b) => $b['status'] === 'Active'));
$totalRevenue = $earnings['this_month'] ?? 485000;
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- WELCOME HEADER BANNER -->
    <div class="card border-0 rounded-4 p-4 p-md-5 mb-4 shadow-sm"
      style="background: linear-gradient(135deg, #EEF2FF 0%, #F8FAFC 100%); border: 1px solid var(--nh-lavender-border) !important;">
      <div class="row align-items-center gy-4">
        <div class="col-lg-8">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="badge bg-success text-white px-3 py-1.5 rounded-pill extra-small">
              <i class="fas fa-shield-check me-1"></i> Verified Property Host
            </span>
            <span class="extra-small text-secondary-custom">• <?= htmlspecialchars($owner['company_name']) ?></span>
          </div>

          <h2 class="fw-bold mb-2">Welcome Back, <?= htmlspecialchars(explode(' ', $owner['name'])[0]) ?>! 👋</h2>
          <p class="text-secondary-custom small mb-0 max-w-2xl">
            You currently have <strong class="text-dark"><?= $pendingBookingsCount ?> pending booking requests</strong> awaiting your review and <strong class="text-dark"><?= $activeBookingsCount ?> active student leases</strong> across your listed properties.
          </p>
        </div>

        <div class="col-lg-4 text-lg-end">
          <div class="d-flex flex-wrap justify-content-lg-end gap-2">
            <a href="add-property.php" class="btn btn-nh-primary px-3.5 py-2 shadow-sm">
              <i class="fas fa-plus"></i> Add New Property
            </a>
            <a href="bookings.php" class="btn btn-nh-outline px-3.5 py-2">
              <i class="fas fa-calendar-check"></i> View Bookings
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- 4 STATS COUNTER CARDS -->
    <div class="row g-3 mb-4">
      <!-- Stat 1: Total Listed Properties -->
      <div class="col-6 col-md-3">
        <a href="properties.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper bg-soft-lavender text-royal-blue">
              <i class="fas fa-city"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark"><?= count($properties) ?></h3>
              <span class="extra-small text-secondary-custom">Listed Properties</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Stat 2: Pending Requests -->
      <div class="col-6 col-md-3">
        <a href="bookings.php?status=Pending" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper bg-warning-subtle text-warning-emphasis">
              <i class="fas fa-clock"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark"><?= $pendingBookingsCount ?></h3>
              <span class="extra-small text-secondary-custom">Pending Requests</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Stat 3: Active Tenants -->
      <div class="col-6 col-md-3">
        <a href="bookings.php?status=Active" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper bg-success-subtle text-success">
              <i class="fas fa-house-user"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark"><?= $activeBookingsCount ?></h3>
              <span class="extra-small text-secondary-custom">Active Tenants</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Stat 4: Monthly Earnings -->
      <div class="col-6 col-md-3">
        <a href="earnings.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper bg-info-subtle text-info">
              <i class="fas fa-indian-rupee-sign"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark">₹<?= number_format($totalRevenue) ?></h3>
              <span class="extra-small text-secondary-custom">Monthly Revenue</span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- MAIN TWO-COLUMN DASHBOARD CONTENT -->
    <div class="row g-4 mb-4">
      
      <!-- LEFT COLUMN: RECENT BOOKING REQUESTS -->
      <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
              <h5 class="fw-bold mb-0">Recent Booking Requests</h5>
              <span class="extra-small text-secondary-custom">Student accommodation applications awaiting your confirmation</span>
            </div>
            <a href="bookings.php" class="extra-small text-primary fw-semibold text-decoration-none hover-primary">View All Bookings <i class="fas fa-arrow-right ms-1"></i></a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle extra-small mb-0">
              <thead class="table-light">
                <tr>
                  <th>Booking ID</th>
                  <th>Student Tenant</th>
                  <th>Property & Room</th>
                  <th>Move-in Date</th>
                  <th>Token Fee</th>
                  <th>Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach (array_slice($bookings, 0, 4) as $bk): 
                  $badgeClass = 'status-' . strtolower($bk['status']);
                ?>
                  <tr>
                    <td><strong class="text-royal-blue">#<?= htmlspecialchars($bk['id']) ?></strong></td>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img src="<?= htmlspecialchars($bk['tenant']['avatar']) ?>" alt="<?= htmlspecialchars($bk['tenant']['name']) ?>" class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" />
                        <div>
                          <strong class="d-block text-dark lh-1 mb-0.5"><?= htmlspecialchars($bk['tenant']['name']) ?></strong>
                          <span class="fs-xs text-muted"><?= htmlspecialchars($bk['tenant']['college']) ?></span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <strong class="d-block text-dark mb-0.5"><?= htmlspecialchars($bk['property_title']) ?></strong>
                      <span class="fs-xs text-secondary-custom"><?= htmlspecialchars($bk['room_type']) ?></span>
                    </td>
                    <td><span class="fw-semibold text-dark"><?= htmlspecialchars($bk['move_in_date']) ?></span></td>
                    <td><span class="text-success fw-bold">₹<?= number_format($bk['token_fee']) ?></span></td>
                    <td><span class="badge-status <?= $badgeClass ?>"><?= htmlspecialchars($bk['status']) ?></span></td>
                    <td class="text-end">
                      <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn-action-sm btn-nh-outline px-2.5 py-1">
                        <i class="fas fa-eye"></i> View
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: TODAY'S SCHEDULE & QUICK ACTIONS -->
      <div class="col-lg-4">
        
        <!-- TODAY'S SCHEDULE WIDGET -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h5 class="fw-bold mb-0"><i class="fas fa-calendar-day text-bright-indigo me-2"></i> Today's Schedule</h5>
            <span class="extra-small badge bg-soft-lavender text-royal-blue"><?= date('M d, Y') ?></span>
          </div>

          <div class="d-flex flex-column gap-2.5 extra-small">
            <div class="p-3 bg-light rounded-3 border-start border-success border-4">
              <div class="d-flex justify-content-between mb-1">
                <strong class="text-dark"><i class="fas fa-circle-check text-success me-1"></i> Tenant Check-in Today</strong>
                <span class="text-muted">10:00 AM</span>
              </div>
              <p class="mb-0 text-secondary-custom">Vishal Patel (Christ University) check-in scheduled for St. Mark's Executive PG (Room 102).</p>
            </div>

            <div class="p-3 bg-light rounded-3 border-start border-warning border-4">
              <div class="d-flex justify-content-between mb-1">
                <strong class="text-dark"><i class="fas fa-hourglass-half text-warning me-1"></i> Physical Room Visit Request</strong>
                <span class="text-muted">02:30 PM</span>
              </div>
              <p class="mb-0 text-secondary-custom">Rohan Sharma requested physical inspection visit at Koramangala Studio Flat.</p>
            </div>

            <div class="p-3 bg-light rounded-3 border-start border-info border-4">
              <div class="d-flex justify-content-between mb-1">
                <strong class="text-dark"><i class="fas fa-screwdriver-wrench text-info me-1"></i> Housekeeping Inspection</strong>
                <span class="text-muted">05:00 PM</span>
              </div>
              <p class="mb-0 text-secondary-custom">Daily common areas & dining area sanitation audit by warden.</p>
            </div>
          </div>
        </div>

        <!-- QUICK ACTIONS SHORTCUT CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-bolt text-warning me-2"></i> Host Quick Actions</h5>
          
          <div class="d-flex flex-column gap-2">
            <a href="add-property.php" class="btn btn-action-sm btn-light-custom text-start justify-content-start w-100 p-2.5">
              <i class="fas fa-plus text-primary fs-6 me-2"></i> Add New Accommodation Listing
            </a>
            <a href="properties.php" class="btn btn-action-sm btn-light-custom text-start justify-content-start w-100 p-2.5">
              <i class="fas fa-bed text-success fs-6 me-2"></i> Update Room Availability & Prices
            </a>
            <a href="earnings.php" class="btn btn-action-sm btn-light-custom text-start justify-content-start w-100 p-2.5">
              <i class="fas fa-wallet text-info fs-6 me-2"></i> Request Payout Withdrawal
            </a>
            <a href="messages.php" class="btn btn-action-sm btn-light-custom text-start justify-content-start w-100 p-2.5">
              <i class="fas fa-comment-dots text-warning fs-6 me-2"></i> Reply to Tenant Inquiries
            </a>
          </div>
        </div>

      </div>

    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
