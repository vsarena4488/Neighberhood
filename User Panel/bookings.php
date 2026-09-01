<?php
require_once __DIR__ . '/includes/functions.php';

// Handle Cancel Booking Action
$cancelledNotice = false;
if (isset($_GET['cancel'])) {
  $cancelId = trim($_GET['cancel']);
  if (isset($_SESSION['user_bookings']) && is_array($_SESSION['user_bookings'])) {
    foreach ($_SESSION['user_bookings'] as $key => $b) {
      if ($b['id'] === $cancelId && in_array($b['status'], ['Pending', 'Approved'])) {
        $_SESSION['user_bookings'][$key]['status'] = 'Cancelled';
        if (isset($_SESSION['user_bookings'][$key]['timeline'])) {
          foreach ($_SESSION['user_bookings'][$key]['timeline'] as &$tStep) {
            if ($tStep['step'] === 'Booking Approved' && !$tStep['done']) {
              $tStep['date'] = 'Cancelled';
            }
          }
          unset($tStep);
        }
        break;
      }
    }
  }
  $statusParam = isset($_GET['status']) ? '&status=' . urlencode($_GET['status']) : '';
  header('Location: bookings.php?cancelled=1' . $statusParam);
  exit;
}

if (isset($_GET['cancelled'])) {
  $cancelledNotice = true;
}

$pageTitle = 'My Bookings · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$filterStatus = $_GET['status'] ?? 'all';
$bookings = $_SESSION['user_bookings'] ?? [];

$filteredBookings = array_filter($bookings, function ($b) use ($filterStatus) {
  if ($filterStatus === 'all') return true;
  return (strcasecmp($b['status'], $filterStatus) === 0);
});

$pendingCount = getActivePendingBookingsCount();
?>

<style>
  /* Bookings Page Custom Button & Layout Alignment Styles */
  .status-tabs-wrapper {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 4px;
    margin-bottom: 1.5rem;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .status-tabs-wrapper::-webkit-scrollbar {
    display: none;
  }

  .status-tab-bar {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem;
    background: #FFFFFF;
    border: 1px solid var(--nh-border);
    border-radius: 50px;
    box-shadow: var(--nh-shadow-subtle);
  }

  .status-tab-btn {
    font-size: 0.83rem;
    font-weight: 600;
    padding: 0.45rem 1.1rem;
    border-radius: 50px;
    color: var(--nh-secondary-text);
    background: transparent;
    border: none;
    text-decoration: none;
    white-space: nowrap;
    transition: var(--nh-transition);
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
  }

  .status-tab-btn:hover {
    color: var(--nh-royal-blue);
    background: var(--nh-soft-lavender);
  }

  .status-tab-btn.active {
    background: var(--nh-gradient-primary);
    color: #FFFFFF !important;
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
  }

  .status-tab-btn .tab-count {
    font-size: 0.72rem;
    font-weight: 700;
    padding: 0.15rem 0.5rem;
    border-radius: 20px;
    background: rgba(15, 23, 42, 0.07);
    color: var(--nh-dark-text);
    transition: var(--nh-transition);
  }

  .status-tab-btn.active .tab-count {
    background: rgba(255, 255, 255, 0.25);
    color: #FFFFFF;
  }

  /* Booking Card Styling */
  .booking-card {
    border: 1px solid var(--nh-border);
    border-radius: 16px;
    background: #FFFFFF;
    box-shadow: var(--nh-shadow-subtle);
    transition: var(--nh-transition);
    overflow: hidden;
  }

  .booking-card:hover {
    box-shadow: var(--nh-shadow-card);
    border-color: var(--nh-lavender-border);
  }

  /* Uniform Action Buttons */
  .btn-action-sm {
    padding: 0.45rem 1.1rem;
    font-size: 0.82rem;
    font-weight: 600;
    border-radius: 50px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    transition: var(--nh-transition);
    text-decoration: none;
    white-space: nowrap;
    cursor: pointer;
    line-height: 1.4;
  }

  .btn-action-sm:hover {
    transform: translateY(-2px);
  }

  .btn-action-sm.btn-light-custom {
    background: #F8FAFC;
    border: 1px solid var(--nh-border);
    color: var(--nh-dark-text);
  }

  .btn-action-sm.btn-light-custom:hover {
    background: var(--nh-soft-lavender);
    color: var(--nh-royal-blue);
    border-color: var(--nh-lavender-border);
  }

  .btn-action-sm.btn-warning-custom {
    background: #FFFBEB;
    border: 1px solid #FDE68A;
    color: #B45309;
  }

  .btn-action-sm.btn-warning-custom:hover {
    background: #FEF3C7;
    border-color: #F59E0B;
    color: #92400E;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
  }

  .btn-action-sm.btn-danger-custom,
  .btn-action-sm.btn-outline-danger {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    color: #DC2626;
  }

  .btn-action-sm.btn-danger-custom:hover,
  .btn-action-sm.btn-outline-danger:hover {
    background: #FEE2E2;
    border-color: #EF4444;
    color: #991B1B;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
  }

  .info-badge-box {
    background: var(--nh-bg-light);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    border: 1px solid var(--nh-border);
  }
</style>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- Cancellation Notice Banner -->
    <?php if ($cancelledNotice): ?>
      <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center gap-3" role="alert">
        <div class="p-2 rounded-circle bg-success text-white fs-5 flex-shrink-0" style="width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
          <i class="fas fa-check"></i>
        </div>
        <div>
          <strong class="small d-block text-dark">Booking Request Cancelled</strong>
          <span class="extra-small text-secondary-custom">Your stay request was successfully cancelled. Any paid token deposit refund has been initiated.</span>
        </div>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <!-- Page Header & New Request Button -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">My Bookings & Stay Requests (<?= count($bookings) ?>)</h3>
        <span class="text-secondary-custom small">Track your accommodation applications, move-in timelines, and active leases</span>
      </div>

      <a href="search.php" class="btn btn-nh-primary px-3.5 py-2 shadow-sm">
        <i class="fas fa-plus"></i> New Accommodation Request
      </a>
    </div>

    <!-- 3 Pending Booking Limit Warning Banner -->
    <?php if ($pendingCount >= 3): ?>
      <div class="alert alert-warning border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center gap-3">
        <div class="p-2 rounded-circle bg-warning text-dark fs-5 flex-shrink-0" style="width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
          <i class="fas fa-triangle-exclamation"></i>
        </div>
        <div class="flex-grow-1">
          <strong class="small d-block">Pending Request Limit Reached (3/3 Active Requests)</strong>
          <span class="extra-small text-dark opacity-75">You currently have 3 pending accommodation requests under owner review. You can place additional requests once one is confirmed or cancelled.</span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Status Tabs Navigation Bar -->
    <div class="status-tabs-wrapper">
      <div class="status-tab-bar">
        <a href="bookings.php?status=all" class="status-tab-btn <?= ($filterStatus === 'all') ? 'active' : '' ?>">
          All Bookings <span class="tab-count"><?= count($bookings) ?></span>
        </a>
        <a href="bookings.php?status=Pending" class="status-tab-btn <?= ($filterStatus === 'Pending') ? 'active' : '' ?>">
          <i class="fas fa-clock text-warning"></i> Pending <span class="tab-count"><?= count(array_filter($bookings, fn($b) => $b['status'] === 'Pending')) ?></span>
        </a>
        <a href="bookings.php?status=Approved" class="status-tab-btn <?= ($filterStatus === 'Approved') ? 'active' : '' ?>">
          <i class="fas fa-circle-check text-primary"></i> Approved <span class="tab-count"><?= count(array_filter($bookings, fn($b) => $b['status'] === 'Approved')) ?></span>
        </a>
        <a href="bookings.php?status=Active" class="status-tab-btn <?= ($filterStatus === 'Active') ? 'active' : '' ?>">
          <i class="fas fa-house-circle-check text-success"></i> Active Stays <span class="tab-count"><?= count(array_filter($bookings, fn($b) => $b['status'] === 'Active')) ?></span>
        </a>
        <a href="bookings.php?status=Completed" class="status-tab-btn <?= ($filterStatus === 'Completed') ? 'active' : '' ?>">
          <i class="fas fa-circle-check text-info"></i> Completed <span class="tab-count"><?= count(array_filter($bookings, fn($b) => $b['status'] === 'Completed')) ?></span>
        </a>
        <a href="bookings.php?status=Cancelled" class="status-tab-btn <?= ($filterStatus === 'Cancelled') ? 'active' : '' ?>">
          <i class="fas fa-ban text-danger"></i> Cancelled <span class="tab-count"><?= count(array_filter($bookings, fn($b) => $b['status'] === 'Cancelled')) ?></span>
        </a>
      </div>
    </div>

    <!-- Booking Cards Container -->
    <div class="d-flex flex-column gap-3 mb-4">
      <?php if (empty($filteredBookings)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-3">
          <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-royal-blue" style="width: 76px; height: 76px; align-items: center; justify-content: center; font-size: 2rem;">
            <i class="fas fa-calendar-xmark"></i>
          </div>
          <h5 class="fw-bold mb-1">No Bookings Found</h5>
          <p class="text-secondary-custom small mb-4 mx-auto" style="max-width: 460px;">You currently have no stay requests under "<?= htmlspecialchars($filterStatus) ?>". Explore verified accommodations near your college to book a room.</p>
          <a href="search.php" class="btn btn-nh-primary px-4 py-2 mx-auto">
            <i class="fas fa-magnifying-glass me-1"></i> Search Accommodations
          </a>
        </div>
      <?php else: ?>
        <?php foreach ($filteredBookings as $bk):
          $badgeClass = 'status-' . strtolower($bk['status']);
        ?>
          <div class="booking-card p-4">
            <!-- Top Card Header: Booking ID, Placed Date & Status Badge -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom gap-2">
              <div class="d-flex align-items-center gap-2">
                <span class="fs-5 fw-bold text-royal-blue">Booking #<?= htmlspecialchars($bk['id']) ?></span>
                <span class="extra-small text-muted">· Placed <?= htmlspecialchars($bk['created_at']) ?></span>
              </div>
              <span class="badge-status <?= $badgeClass ?> px-3 py-1.5 fs-6">
                <?php if ($bk['status'] === 'Pending'): ?><i class="fas fa-clock"></i><?php endif; ?>
                <?php if ($bk['status'] === 'Approved'): ?><i class="fas fa-circle-check"></i><?php endif; ?>
                <?php if ($bk['status'] === 'Active'): ?><i class="fas fa-house-circle-check"></i><?php endif; ?>
                <?php if ($bk['status'] === 'Completed'): ?><i class="fas fa-circle-check"></i><?php endif; ?>
                <?php if ($bk['status'] === 'Cancelled'): ?><i class="fas fa-ban"></i><?php endif; ?>
                <?= htmlspecialchars($bk['status']) ?>
              </span>
            </div>

            <!-- Details Body Grid -->
            <div class="row g-3 align-items-center mb-3">
              <!-- Property Info -->
              <div class="col-lg-5 col-md-6">
                <h5 class="fw-bold mb-1">
                  <a href="property-details.php?id=<?= $bk['property_id'] ?>" class="text-dark text-decoration-none hover-primary"><?= htmlspecialchars($bk['property_title']) ?></a>
                </h5>
                <span class="extra-small text-secondary-custom d-block mb-2">
                  <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($bk['location']) ?>
                </span>
                <div class="d-flex flex-wrap gap-2 extra-small">
                  <span class="badge bg-soft-lavender text-royal-blue px-2.5 py-1.5"><i class="fas fa-bed me-1"></i> <?= htmlspecialchars($bk['room_type']) ?></span>
                  <span class="badge bg-light text-dark border px-2.5 py-1.5"><i class="fas fa-user-tie me-1"></i> Host: <?= htmlspecialchars($bk['owner_name']) ?></span>
                </div>
              </div>

              <!-- Move-in & Duration Info -->
              <div class="col-lg-3 col-sm-6">
                <div class="info-badge-box">
                  <span class="extra-small text-secondary-custom d-block mb-0.5">Move-in Date</span>
                  <strong class="small text-dark d-block mb-1"><i class="fas fa-calendar-day text-primary me-1"></i> <?= htmlspecialchars($bk['move_in_date']) ?></strong>
                  <span class="extra-small text-muted d-block"><i class="fas fa-hourglass-half me-1"></i> Duration: <?= htmlspecialchars($bk['duration']) ?></span>
                </div>
              </div>

              <!-- Rent & Deposit Info -->
              <div class="col-lg-4 col-sm-6 text-sm-end">
                <span class="extra-small text-secondary-custom d-block">Monthly Rent / Deposit</span>
                <strong class="text-royal-blue fs-4 fw-bold">₹<?= number_format($bk['rent']) ?></strong><span class="extra-small text-muted"> /mo</span>
                <div class="extra-small text-success fw-semibold mt-1">Deposit: ₹<?= number_format($bk['deposit']) ?></div>
                <div class="extra-small text-muted">Token Paid: ₹<?= number_format($bk['token_fee']) ?> (Balance: ₹<?= number_format($bk['move_in_balance']) ?>)</div>
              </div>
            </div>

            <!-- Action Buttons Footer -->
            <div class="pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div class="extra-small text-secondary-custom d-flex align-items-center gap-1.5">
                <i class="fas fa-shield-halved text-success fs-6"></i>
                <span>Zero Brokerage · Two-Stage Safe Payment Protected</span>
              </div>

              <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
                <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn-action-sm btn-nh-outline">
                  <i class="fas fa-eye"></i> View Details
                </a>

                <a href="messages.php?booking_id=<?= $bk['id'] ?>" class="btn-action-sm btn-light-custom">
                  <i class="fas fa-comment-dots text-primary"></i> Contact Landlord
                </a>

                <?php if ($bk['status'] === 'Pending'): ?>
                  <a href="bookings.php?cancel=<?= $bk['id'] ?>&status=<?= urlencode($filterStatus) ?>" class="btn-action-sm btn-danger-custom" onclick="return confirm('Cancel this booking request? Your token fee will be refunded.');">
                    <i class="fas fa-ban"></i> Cancel Request
                  </a>
                <?php elseif ($bk['status'] === 'Approved'): ?>
                  <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn-action-sm btn-success text-white">
                    <i class="fas fa-check-circle"></i> Confirm & Check-in Pass
                  </a>
                  <a href="bookings.php?cancel=<?= $bk['id'] ?>&status=<?= urlencode($filterStatus) ?>" class="btn-action-sm btn-danger-custom" onclick="return confirm('Decline this approved booking?');">
                    <i class="fas fa-xmark"></i> Decline
                  </a>
                <?php elseif ($bk['status'] === 'Active'): ?>
                  <button class="btn-action-sm btn-nh-primary" onclick="alert('Extend stay request sent to landlord!')">
                    <i class="fas fa-clock-rotate-left"></i> Extend Stay
                  </button>
                <?php elseif ($bk['status'] === 'Completed'): ?>
                  <a href="reviews.php?property_id=<?= $bk['property_id'] ?>" class="btn-action-sm btn-warning-custom">
                    <i class="fas fa-star"></i> Write Review
                  </a>
                  <button class="btn-action-sm btn-light-custom" onclick="alert('Receipt PDF downloaded!')">
                    <i class="fas fa-file-invoice"></i> Receipt
                  </button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>