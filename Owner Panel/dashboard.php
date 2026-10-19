<?php
// Owner Panel dashboard.php - Host Dashboard Overview
$pageTitle = 'Dashboard · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

// Handle Quick Accept / Reject actions from dashboard
if (isset($_GET['accept'])) {
    $acceptId = trim($_GET['accept']);
    foreach ($_SESSION['owner_bookings'] as &$b) {
        if ($b['id'] === $acceptId && $b['status'] === 'Pending') {
            $b['status'] = 'Approved';
            break;
        }
    }
    header('Location: dashboard.php?approved=' . urlencode($acceptId));
    exit;
}

if (isset($_GET['reject'])) {
    $rejectId = trim($_GET['reject']);
    foreach ($_SESSION['owner_bookings'] as &$b) {
        if ($b['id'] === $rejectId && in_array($b['status'], ['Pending', 'Approved'])) {
            $b['status'] = 'Cancelled';
            break;
        }
    }
    header('Location: dashboard.php?rejected=' . urlencode($rejectId));
    exit;
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$owner = $_SESSION['owner'] ?? [];
$ownerName = trim((string) ($owner['name'] ?? 'Owner'));
$ownerFirstName = (string) (explode(' ', $ownerName)[0] ?? 'Owner');
$companyName = (string) ($owner['company_name'] ?? 'NeighborNest Host');
$properties = $_SESSION['owner_properties'] ?? [];
$bookings = $_SESSION['owner_bookings'] ?? [];
$earnings = $_SESSION['owner_earnings'] ?? [];

$filterStatus = $_GET['status'] ?? 'all';
$displayedBookings = array_filter($bookings, function($b) use ($filterStatus) {
    if ($filterStatus === 'all') return true;
    return (strcasecmp($b['status'], $filterStatus) === 0);
});

$activePropertiesCount = count(array_filter($properties, fn($p) => ($p['status'] ?? '') === 'Active'));
$pendingBookingsCount = count(array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'Pending'));
$approvedBookingsCount = count(array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'Approved'));
$activeBookingsCount = count(array_filter($bookings, fn($b) => ($b['status'] ?? '') === 'Active'));
$totalRevenue = $earnings['this_month'] ?? 0;
$totalTokenFees = array_sum(array_column($bookings, 'token_fee'));
$totalPendingBalance = array_sum(array_column($bookings, 'move_in_balance'));
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

          <h2 class="fw-bold mb-2">Welcome Back, <?= htmlspecialchars($ownerFirstName) ?></h2>
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
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 h-100 d-flex flex-column justify-content-between">
          <div>
            <!-- Header Row with Title & View All -->
            <div class="dashboard-section-heading d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2 mb-3 pb-2 border-bottom">
              <div>
                <h5 class="fw-bold mb-1"><i class="fas fa-calendar-check text-bright-indigo me-1.5"></i> Recent Booking Requests</h5>
                <span class="extra-small text-secondary-custom">Review student applications, accept reservations, and manage tenant check-in passes</span>
              </div>
              <a href="bookings.php" class="extra-small text-primary fw-semibold text-decoration-none hover-primary ms-2 text-nowrap">
                View All Bookings (<?= count($bookings) ?>) <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>

            <!-- Action Status Alerts -->
            <?php if (isset($_GET['approved'])): ?>
              <div class="alert alert-success alert-dismissible fade show rounded-3 extra-small mb-3 py-2" role="alert">
                <i class="fas fa-circle-check text-success me-2"></i>
                Booking <strong>#<?= htmlspecialchars($_GET['approved']) ?></strong> has been successfully accepted! The student tenant has been notified.
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
              </div>
            <?php elseif (isset($_GET['rejected'])): ?>
              <div class="alert alert-warning alert-dismissible fade show rounded-3 extra-small mb-3 py-2" role="alert">
                <i class="fas fa-circle-exclamation text-warning me-2"></i>
                Booking <strong>#<?= htmlspecialchars($_GET['rejected']) ?></strong> has been marked as cancelled.
                <button type="button" class="btn-close py-2" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <!-- Status Filter Tabs Bar -->
            <div class="d-flex flex-wrap gap-2 mb-3 p-1.5 bg-light rounded-pill border" style="width: fit-content;">
              <a href="dashboard.php?status=all" class="btn btn-sm <?= ($filterStatus === 'all') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 py-1 extra-small fw-semibold">
                All (<?= count($bookings) ?>)
              </a>
              <a href="dashboard.php?status=Pending" class="btn btn-sm <?= ($filterStatus === 'Pending') ? 'btn-warning text-dark' : 'btn-light' ?> rounded-pill px-3 py-1 extra-small fw-semibold position-relative">
                Pending (<?= $pendingBookingsCount ?>)
                <?php if ($pendingBookingsCount > 0 && $filterStatus !== 'Pending'): ?>
                  <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                <?php endif; ?>
              </a>
              <a href="dashboard.php?status=Approved" class="btn btn-sm <?= ($filterStatus === 'Approved') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 py-1 extra-small fw-semibold">
                Approved (<?= $approvedBookingsCount ?>)
              </a>
              <a href="dashboard.php?status=Active" class="btn btn-sm <?= ($filterStatus === 'Active') ? 'btn-success text-white' : 'btn-light' ?> rounded-pill px-3 py-1 extra-small fw-semibold">
                Active Leases (<?= $activeBookingsCount ?>)
              </a>
            </div>

            <!-- Enhanced Booking Table -->
            <div class="table-responsive">
              <table class="table table-hover align-middle extra-small mb-0 dashboard-bookings-table">
                <thead class="table-light">
                  <tr>
                    <th class="py-2.5 ps-3">Booking / Date</th>
                    <th class="py-2.5">Student Tenant</th>
                    <th class="py-2.5">Property & Stay Duration</th>
                    <th class="py-2.5">Rent & Token</th>
                    <th class="py-2.5">Status</th>
                    <th class="text-end py-2.5 pe-3">Host Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($displayedBookings)): ?>
                    <tr>
                      <td colspan="6" class="text-center py-4 text-secondary-custom">
                        <i class="fas fa-calendar-xmark fa-2x d-block mb-2 text-muted"></i>
                        No requests found under status "<strong><?= htmlspecialchars($filterStatus) ?></strong>".
                        <br>
                        <a href="dashboard.php?status=all" class="btn btn-sm btn-nh-primary mt-2">View All Requests</a>
                      </td>
                    </tr>
                  <?php else: ?>
                    <?php foreach ($displayedBookings as $bk):
                      $badgeClass = 'status-' . strtolower($bk['status']);
                    ?>
                      <tr>
                        <!-- Booking ID & Placed Time -->
                        <td class="ps-3">
                          <strong class="text-royal-blue d-block">#<?= htmlspecialchars($bk['id']) ?></strong>
                          <span class="fs-xs text-muted d-block"><?= htmlspecialchars($bk['created_at']) ?></span>
                        </td>

                        <!-- Tenant Details -->
                        <td>
                          <div class="d-flex align-items-center gap-2">
                            <div class="position-relative flex-shrink-0">
                              <img src="<?= htmlspecialchars($bk['tenant']['avatar']) ?>" alt="<?= htmlspecialchars($bk['tenant']['name']) ?>" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;" />
                              <?php if (!empty($bk['tenant']['verified_student'])): ?>
                                <span class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-white" style="width: 10px; height: 10px;" title="Verified Student"></span>
                              <?php endif; ?>
                            </div>
                            <div class="overflow-hidden">
                              <strong class="d-block text-dark lh-sm text-truncate"><?= htmlspecialchars($bk['tenant']['name']) ?></strong>
                              <span class="fs-xs text-muted d-block text-truncate"><?= htmlspecialchars($bk['tenant']['college']) ?></span>
                              <span class="fs-xs text-secondary-custom"><i class="fas fa-phone fs-xs me-1 text-muted"></i><?= htmlspecialchars($bk['tenant']['phone']) ?></span>
                            </div>
                          </div>
                        </td>

                        <!-- Property & Duration -->
                        <td>
                          <strong class="d-block text-dark lh-sm mb-0.5 text-truncate" style="max-width: 220px;"><?= htmlspecialchars($bk['property_title']) ?></strong>
                          <span class="fs-xs text-secondary-custom d-block"><?= htmlspecialchars($bk['room_type']) ?></span>
                          <span class="badge bg-light text-secondary border extra-small mt-0.5">
                            <i class="fas fa-clock me-1 text-muted"></i><?= htmlspecialchars($bk['duration']) ?> · Move-in <?= htmlspecialchars($bk['move_in_date']) ?>
                          </span>
                        </td>

                        <!-- Financials -->
                        <td>
                          <div class="fw-bold text-dark">₹<?= number_format($bk['rent']) ?><span class="fs-xs fw-normal text-muted">/mo</span></div>
                          <span class="badge bg-success-subtle text-success extra-small fw-semibold mt-0.5">
                            <i class="fas fa-check-circle me-1"></i>₹<?= number_format($bk['token_fee']) ?> Token Paid
                          </span>
                        </td>

                        <!-- Status Badge -->
                        <td>
                          <span class="badge-status <?= $badgeClass ?>">
                            <?php if ($bk['status'] === 'Pending'): ?><i class="fas fa-clock"></i><?php endif; ?>
                            <?php if ($bk['status'] === 'Approved'): ?><i class="fas fa-circle-check"></i><?php endif; ?>
                            <?php if ($bk['status'] === 'Active'): ?><i class="fas fa-house-user"></i><?php endif; ?>
                            <?php if ($bk['status'] === 'Completed'): ?><i class="fas fa-check-double"></i><?php endif; ?>
                            <?= htmlspecialchars($bk['status']) ?>
                          </span>
                        </td>

                        <!-- Inline Action Buttons -->
                        <td class="text-end pe-3">
                          <div class="d-inline-flex align-items-center gap-1.5">
                            <?php if ($bk['status'] === 'Pending'): ?>
                              <a href="dashboard.php?accept=<?= urlencode($bk['id']) ?>" class="btn btn-sm btn-success py-1 px-2.5 extra-small fw-semibold shadow-sm" title="Accept Student Booking">
                                <i class="fas fa-check me-1"></i> Accept
                              </a>
                              <a href="dashboard.php?reject=<?= urlencode($bk['id']) ?>" class="btn btn-sm btn-outline-danger py-1 px-2 extra-small" title="Decline Request" onclick="return confirm('Are you sure you want to decline this booking request?');">
                                <i class="fas fa-xmark"></i>
                              </a>
                              <a href="booking-details.php?id=<?= urlencode($bk['id']) ?>" class="btn btn-sm btn-light border py-1 px-2 extra-small text-secondary" title="View Full Application">
                                <i class="fas fa-eye"></i>
                              </a>
                            <?php elseif ($bk['status'] === 'Approved' || $bk['status'] === 'Active'): ?>
                              <a href="messages.php?chat=chat_1" class="btn btn-sm btn-nh-primary py-1 px-2.5 extra-small fw-semibold" title="Chat with Tenant">
                                <i class="fas fa-comment-dots me-1"></i> Chat
                              </a>
                              <a href="booking-details.php?id=<?= urlencode($bk['id']) ?>" class="btn btn-sm btn-light border py-1 px-2 extra-small text-secondary" title="View Details">
                                <i class="fas fa-eye"></i>
                              </a>
                            <?php else: ?>
                              <a href="booking-details.php?id=<?= urlencode($bk['id']) ?>" class="btn btn-sm btn-light border py-1 px-2.5 extra-small text-secondary" title="View Details">
                                <i class="fas fa-receipt me-1"></i> Details
                              </a>
                            <?php endif; ?>
                          </div>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Bottom Section: Booking Pipeline Highlights & Host Tip Banner (Effectively uses space!) -->
          <div class="pt-3 mt-3 border-top">
            <!-- 3 Mini Summary Metric Cards -->
            <div class="row g-2 mb-3">
              <div class="col-sm-4">
                <div class="p-2.5 rounded-3 bg-light border d-flex align-items-center gap-2">
                  <div class="p-2 rounded-circle bg-success-subtle text-success flex-shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-wallet fs-xs"></i>
                  </div>
                  <div class="overflow-hidden">
                    <strong class="d-block text-dark small lh-sm">₹<?= number_format($totalTokenFees) ?></strong>
                    <span class="fs-xs text-muted d-block text-truncate">Token Fees Collected</span>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="p-2.5 rounded-3 bg-light border d-flex align-items-center gap-2">
                  <div class="p-2 rounded-circle bg-primary-subtle text-primary flex-shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-hand-holding-dollar fs-xs"></i>
                  </div>
                  <div class="overflow-hidden">
                    <strong class="d-block text-dark small lh-sm">₹<?= number_format($totalPendingBalance) ?></strong>
                    <span class="fs-xs text-muted d-block text-truncate">Pending Check-in Dues</span>
                  </div>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="p-2.5 rounded-3 bg-light border d-flex align-items-center gap-2">
                  <div class="p-2 rounded-circle bg-info-subtle text-info flex-shrink-0" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shield-halved fs-xs"></i>
                  </div>
                  <div class="overflow-hidden">
                    <strong class="d-block text-dark small lh-sm">100% Verified</strong>
                    <span class="fs-xs text-muted d-block text-truncate">Student ID Validated</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Host Tip Advice Strip -->
            <div class="p-2.5 rounded-3 bg-soft-lavender border border-lavender d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div class="d-flex align-items-center gap-2">
                <i class="fas fa-bolt text-warning fs-6 flex-shrink-0"></i>
                <span class="extra-small text-dark">
                  <strong>Host Response Tip:</strong> Accepting or contacting applicants within <strong>2 hours</strong> increases lease confirmation by <strong>85%</strong>.
                </span>
              </div>
              <a href="bookings.php" class="extra-small text-primary fw-semibold text-decoration-none hover-primary text-nowrap">
                Manage Booking Rules <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
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