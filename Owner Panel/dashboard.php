<?php
// Owner Panel dashboard.php - Host Dashboard Overview
$pageTitle = 'Dashboard · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$owner = $_SESSION['owner'] ?? [];
$ownerName = trim((string) ($owner['name'] ?? 'Owner'));
$ownerFirstName = (string) (explode(' ', $ownerName)[0] ?? 'Owner');
$companyName = (string) ($owner['company_name'] ?? 'NeighborNest Host');
$properties = $_SESSION['owner_properties'] ?? [];
$bookings = $_SESSION['owner_bookings'] ?? [];
$earnings = $_SESSION['owner_earnings'] ?? [];

$activePropertiesCount = count(array_filter($properties, fn($p) => ($p['status'] ?? '') === 'Active'));
$pendingBookingsCount = count(array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'Pending'));
$activeBookingsCount = count(array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'Active'));
$totalRevenue = $earnings['this_month'] ?? 485000;
?>

<style id="dashboard-layout-fixes">
  .dashboard-bookings-table {
    min-width: 760px;
  }

  .dashboard-section-heading>div {
    min-width: 0;
  }

  .dashboard-section-heading>a {
    flex: 0 0 auto;
    white-space: nowrap;
  }

  @media (max-width: 575.98px) {
    .dashboard-section-heading>a {
      align-self: flex-start;
    }
  }
</style>
<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- WELCOME HEADER BANNER -->
    <div class="card border-0 rounded-4 p-4 p-lg-5 mb-4 shadow-sm"
      style="background: linear-gradient(135deg, #EEF2FF 0%, #F8FAFC 100%); border: 1px solid var(--nh-lavender-border) !important;">
      <div class="row align-items-center gy-3">
        <div class="col-lg-8">
          <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            <span class="badge bg-success text-white px-3 py-2 rounded-pill extra-small fw-semibold">
              <i class="fas fa-shield-check me-1"></i> Verified Property Host
            </span>
            <span class="extra-small text-secondary-custom">• <?= htmlspecialchars($companyName) ?></span>
          </div>

          <h2 class="fw-bold mb-2">Welcome Back, <?= htmlspecialchars($ownerFirstName) ?>S</h2>
          <p class="text-secondary-custom small mb-0" style="max-width: 600px;">
            You currently have <strong class="text-dark"><?= $pendingBookingsCount ?> pending booking requests</strong> awaiting your review and <strong class="text-dark"><?= $activeBookingsCount ?> active student leases</strong> across your listed properties.
          </p>
        </div>

        <div class="col-lg-4 text-lg-end">
          <div class="d-flex flex-wrap justify-content-start justify-content-lg-end gap-2">
            <a href="add-property.php" class="btn btn-nh-primary px-4 py-2 shadow-sm">
              <i class="fas fa-plus me-1"></i> Add New Property
            </a>
            <a href="bookings.php" class="btn btn-nh-outline px-4 py-2">
              <i class="fas fa-calendar-check me-1"></i> View Bookings
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
          <div class="stat-card h-100">
            <div class="stat-icon-wrapper bg-soft-lavender text-royal-blue">
              <i class="fas fa-city"></i>
            </div>
            <div class="flex-grow-1 overflow-hidden">
              <div class="stat-value text-dark"><?= count($properties) ?></div>
              <span class="extra-small text-secondary-custom d-block text-truncate">Listed Properties</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Stat 2: Pending Requests -->
      <div class="col-6 col-md-3">
        <a href="bookings.php?status=Pending" class="text-decoration-none">
          <div class="stat-card h-100">
            <div class="stat-icon-wrapper bg-warning-subtle text-warning-emphasis">
              <i class="fas fa-clock"></i>
            </div>
            <div class="flex-grow-1 overflow-hidden">
              <div class="stat-value text-dark"><?= $pendingBookingsCount ?></div>
              <span class="extra-small text-secondary-custom d-block text-truncate">Pending Requests</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Stat 3: Active Tenants -->
      <div class="col-6 col-md-3">
        <a href="bookings.php?status=Active" class="text-decoration-none">
          <div class="stat-card h-100">
            <div class="stat-icon-wrapper bg-success-subtle text-success">
              <i class="fas fa-house-user"></i>
            </div>
            <div class="flex-grow-1 overflow-hidden">
              <div class="stat-value text-dark"><?= $activeBookingsCount ?></div>
              <span class="extra-small text-secondary-custom d-block text-truncate">Active Tenants</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Stat 4: Monthly Earnings -->
      <div class="col-6 col-md-3">
        <a href="earnings.php" class="text-decoration-none">
          <div class="stat-card h-100">
            <div class="stat-icon-wrapper bg-info-subtle text-info">
              <i class="fas fa-indian-rupee-sign"></i>
            </div>
            <div class="flex-grow-1 overflow-hidden">
              <div class="stat-value text-dark">₹<?= number_format($totalRevenue) ?></div>
              <span class="extra-small text-secondary-custom d-block text-truncate">Monthly Revenue</span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- MAIN TWO-COLUMN DASHBOARD CONTENT -->
    <div class="row g-4 mb-4">

      <!-- LEFT COLUMN: RECENT BOOKING REQUESTS -->
      <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100">
          <div class="dashboard-section-heading d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2 mb-3 pb-2 border-bottom">
            <div>
              <h5 class="fw-bold mb-1">Recent Booking Requests</h5>
              <span class="extra-small text-secondary-custom">Student accommodation applications awaiting your confirmation</span>
            </div>
            <a href="bookings.php" class="extra-small text-primary fw-semibold text-decoration-none hover-primary ms-2">View All Bookings <i class="fas fa-arrow-right ms-1"></i></a>
          </div>

          <div class="table-responsive">
            <table class="table table-hover align-middle extra-small mb-0 dashboard-bookings-table">
              <thead class="table-light">
                <tr>
                  <th class="py-2">Booking ID</th>
                  <th class="py-2">Student Tenant</th>
                  <th class="py-2">Property & Room</th>
                  <th class="py-2">Move-in Date</th>
                  <th class="py-2">Token Fee</th>
                  <th class="py-2">Status</th>
                  <th class="text-end py-2">Actions</th>
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
                        <img src="<?= htmlspecialchars($bk['tenant']['avatar']) ?>" alt="<?= htmlspecialchars($bk['tenant']['name']) ?>" class="rounded-circle flex-shrink-0" style="width: 34px; height: 34px; object-fit: cover;" />
                        <div>
                          <strong class="d-block text-dark lh-sm mb-1"><?= htmlspecialchars($bk['tenant']['name']) ?></strong>
                          <span class="fs-xs text-muted d-block"><?= htmlspecialchars($bk['tenant']['college']) ?></span>
                        </div>
                      </div>
                    </td>
                    <td>
                      <strong class="d-block text-dark lh-sm mb-1"><?= htmlspecialchars($bk['property_title']) ?></strong>
                      <span class="fs-xs text-secondary-custom"><?= htmlspecialchars($bk['room_type']) ?></span>
                    </td>
                    <td><span class="fw-semibold text-dark"><?= htmlspecialchars($bk['move_in_date']) ?></span></td>
                    <td><span class="text-success fw-bold">₹<?= number_format($bk['token_fee']) ?></span></td>
                    <td><span class="badge-status <?= $badgeClass ?>"><?= htmlspecialchars($bk['status']) ?></span></td>
                    <td class="text-end">
                      <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn-action-sm btn-nh-outline px-3 py-1">
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
          <div class="dashboard-section-heading d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2 mb-3 pb-2 border-bottom">
            <h5 class="fw-bold mb-0"><i class="fas fa-calendar-day text-bright-indigo me-2"></i> Today's Schedule</h5>
            <span class="extra-small badge bg-soft-lavender text-royal-blue px-2 py-1"><?= date('M d, Y') ?></span>
          </div>

          <div class="d-flex flex-column gap-3 extra-small">
            <div class="p-3 bg-light rounded-3 border-start border-success border-4">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="text-dark"><i class="fas fa-circle-check text-success me-1"></i> Tenant Check-in Today</strong>
                <span class="text-muted fw-semibold">10:00 AM</span>
              </div>
              <p class="mb-0 text-secondary-custom">Vishal Patel (Christ University) check-in scheduled for St. Mark's Executive PG (Room 102).</p>
            </div>

            <div class="p-3 bg-light rounded-3 border-start border-warning border-4">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="text-dark"><i class="fas fa-hourglass-half text-warning me-1"></i> Room Visit Request</strong>
                <span class="text-muted fw-semibold">02:30 PM</span>
              </div>
              <p class="mb-0 text-secondary-custom">Rohan Sharma requested physical inspection visit at Koramangala Studio Flat.</p>
            </div>

            <div class="p-3 bg-light rounded-3 border-start border-info border-4">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="text-dark"><i class="fas fa-screwdriver-wrench text-info me-1"></i> Housekeeping Audit</strong>
                <span class="text-muted fw-semibold">05:00 PM</span>
              </div>
              <p class="mb-0 text-secondary-custom">Daily common areas & dining area sanitation audit by warden.</p>
            </div>
          </div>
        </div>

        <!-- QUICK ACTIONS SHORTCUT CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-bolt text-warning me-2"></i> Host Quick Actions</h5>

          <div class="d-flex flex-column gap-2">
            <a href="add-property.php" class="quick-action-link p-3 rounded-3 bg-light text-decoration-none d-flex align-items-center justify-content-between text-dark">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-primary-subtle text-primary" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-plus fs-6"></i>
                </div>
                <div>
                  <strong class="d-block extra-small text-dark mb-1">Add New Listing</strong>
                  <span class="fs-xs text-muted">Post PG or Hostel Property</span>
                </div>
              </div>
              <i class="fas fa-chevron-right fs-xs text-muted"></i>
            </a>

            <a href="properties.php" class="quick-action-link p-3 rounded-3 bg-light text-decoration-none d-flex align-items-center justify-content-between text-dark">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-success-subtle text-success" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-bed fs-6"></i>
                </div>
                <div>
                  <strong class="d-block extra-small text-dark mb-1">Update Availability</strong>
                  <span class="fs-xs text-muted">Manage Rent & Bed Status</span>
                </div>
              </div>
              <i class="fas fa-chevron-right fs-xs text-muted"></i>
            </a>

            <a href="earnings.php" class="quick-action-link p-3 rounded-3 bg-light text-decoration-none d-flex align-items-center justify-content-between text-dark">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-info-subtle text-info" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-wallet fs-6"></i>
                </div>
                <div>
                  <strong class="d-block extra-small text-dark mb-1">Payout Withdrawal</strong>
                  <span class="fs-xs text-muted">Request Earnings Payout</span>
                </div>
              </div>
              <i class="fas fa-chevron-right fs-xs text-muted"></i>
            </a>

            <a href="messages.php" class="quick-action-link p-3 rounded-3 bg-light text-decoration-none d-flex align-items-center justify-content-between text-dark">
              <div class="d-flex align-items-center gap-2">
                <div class="p-2 rounded-circle bg-warning-subtle text-warning-emphasis" style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-comment-dots fs-6"></i>
                </div>
                <div>
                  <strong class="d-block extra-small text-dark mb-1">Tenant Inquiries</strong>
                  <span class="fs-xs text-muted">Reply to Student Chats</span>
                </div>
              </div>
              <i class="fas fa-chevron-right fs-xs text-muted"></i>
            </a>
          </div>
        </div>

      </div>

    </div>
  </main>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>