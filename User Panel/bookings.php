<?php
require_once __DIR__ . '/includes/functions.php';

// Handle Cancel Booking Action
if (isset($_GET['cancel'])) {
    $cancelId = trim($_GET['cancel']);
    foreach ($_SESSION['user_bookings'] as &$b) {
        if ($b['id'] === $cancelId && in_array($b['status'], ['Pending', 'Approved'])) {
            $b['status'] = 'Cancelled';
            break;
        }
    }
}

$pageTitle = 'My Bookings · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$filterStatus = $_GET['status'] ?? 'all';
$bookings = $_SESSION['user_bookings'] ?? [];

$filteredBookings = array_filter($bookings, function($b) use ($filterStatus) {
    if ($filterStatus === 'all') return true;
    return (strcasecmp($b['status'], $filterStatus) === 0);
});

$pendingCount = getActivePendingBookingsCount();
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">My Bookings & Stay Requests (<?= count($bookings) ?>)</h3>
        <span class="text-secondary-custom small">Track your accommodation applications, move-in timelines, and active leases</span>
      </div>

      <a href="search.php" class="btn btn-sm btn-nh-primary px-3 shadow-sm">
        <i class="fas fa-plus me-1"></i> New Accommodation Request
      </a>
    </div>

    <!-- 3 Pending Booking Limit Warning Banner (as specified by PM) -->
    <?php if ($pendingCount >= 3): ?>
      <div class="alert alert-warning border-0 rounded-4 shadow-sm p-3 mb-4 d-flex align-items-center gap-3">
        <div class="p-2 rounded-circle bg-warning text-dark fs-5" style="flex-shrink: 0;"><i class="fas fa-triangle-exclamation"></i></div>
        <div class="flex-grow-1">
          <strong class="small d-block">Pending Request Limit Reached (3/3 Active Requests)</strong>
          <span class="extra-small text-dark opacity-75">You currently have 3 pending accommodation requests under owner review. You can place additional requests once one is confirmed or cancelled.</span>
        </div>
      </div>
    <?php endif; ?>

    <!-- Status Tabs -->
    <div class="d-flex flex-wrap gap-2 mb-4 p-1.5 bg-white rounded-pill border shadow-sm" style="width: fit-content;">
      <a href="bookings.php?status=all" class="btn btn-sm <?= ($filterStatus === 'all') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        All Bookings (<?= count($bookings) ?>)
      </a>
      <a href="bookings.php?status=Pending" class="btn btn-sm <?= ($filterStatus === 'Pending') ? 'btn-warning text-dark' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Pending (<?= count(array_filter($bookings, fn($b)=>$b['status']==='Pending')) ?>)
      </a>
      <a href="bookings.php?status=Approved" class="btn btn-sm <?= ($filterStatus === 'Approved') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Approved (<?= count(array_filter($bookings, fn($b)=>$b['status']==='Approved')) ?>)
      </a>
      <a href="bookings.php?status=Active" class="btn btn-sm <?= ($filterStatus === 'Active') ? 'btn-success text-white' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Active Stays (<?= count(array_filter($bookings, fn($b)=>$b['status']==='Active')) ?>)
      </a>
      <a href="bookings.php?status=Completed" class="btn btn-sm <?= ($filterStatus === 'Completed') ? 'btn-teal text-white' : 'btn-light' ?> rounded-pill px-3 fw-semibold" style="<?= ($filterStatus === 'Completed') ? 'background: #0D9488;' : '' ?>">
        Completed (<?= count(array_filter($bookings, fn($b)=>$b['status']==='Completed')) ?>)
      </a>
      <a href="bookings.php?status=Cancelled" class="btn btn-sm <?= ($filterStatus === 'Cancelled') ? 'btn-danger' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Cancelled (<?= count(array_filter($bookings, fn($b)=>$b['status']==='Cancelled')) ?>)
      </a>
    </div>

    <!-- Booking Cards Container -->
    <div class="d-flex flex-column gap-3 mb-4">
      <?php if (empty($filteredBookings)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-3">
          <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-royal-blue" style="width: 70px; height: 70px; align-items: center; justify-content: center; font-size: 1.8rem;">
            <i class="fas fa-calendar-xmark"></i>
          </div>
          <h5 class="fw-bold mb-1">No Bookings Found in This Status</h5>
          <p class="text-secondary-custom small mb-4 max-w-md mx-auto">You have no stay requests under "<?= htmlspecialchars($filterStatus) ?>". Start exploring verified accommodations to book a bed.</p>
          <a href="search.php" class="btn btn-nh-primary px-4 py-2 mx-auto">Search Accommodations</a>
        </div>
      <?php else: ?>
        <?php foreach ($filteredBookings as $bk): 
          $badgeClass = 'status-' . strtolower($bk['status']);
        ?>
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
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

            <div class="row g-3 align-items-center mb-3">
              <div class="col-md-6">
                <h5 class="fw-bold mb-1">
                  <a href="property-details.php?id=<?= $bk['property_id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($bk['property_title']) ?></a>
                </h5>
                <span class="extra-small text-secondary-custom d-block mb-2">
                  <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($bk['location']) ?>
                </span>
                <div class="d-flex flex-wrap gap-2 extra-small">
                  <span class="badge bg-soft-lavender text-royal-blue"><i class="fas fa-bed me-1"></i> <?= htmlspecialchars($bk['room_type']) ?></span>
                  <span class="badge bg-light text-dark border"><i class="fas fa-user-tie me-1"></i> Host: <?= htmlspecialchars($bk['owner_name']) ?></span>
                </div>
              </div>

              <div class="col-sm-6 col-md-3">
                <span class="extra-small text-secondary-custom d-block">Move-in Date</span>
                <strong class="small text-dark d-block"><?= htmlspecialchars($bk['move_in_date']) ?></strong>
                <span class="extra-small text-muted">Duration: <?= htmlspecialchars($bk['duration']) ?></span>
              </div>

              <div class="col-sm-6 col-md-3 text-md-end">
                <span class="extra-small text-secondary-custom d-block">Monthly Rent / Deposit</span>
                <strong class="text-royal-blue fs-5">₹<?= number_format($bk['rent']) ?></strong><span class="extra-small text-muted">/mo</span>
                <span class="extra-small text-success d-block fw-semibold">Deposit: ₹<?= number_format($bk['deposit']) ?></span>
                <span class="fs-xs text-muted">Token Paid: ₹<?= number_format($bk['token_fee']) ?> (Balance: ₹<?= number_format($bk['move_in_balance']) ?>)</span>
              </div>
            </div>

            <!-- CONTEXTUAL ACTION BUTTONS BY STATUS (As defined in PM Spec) -->
            <div class="pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-2">
              <div class="extra-small text-secondary-custom">
                <i class="fas fa-shield-halved text-success me-1"></i> Zero Brokerage · Two-Stage Safe Payment Protected
              </div>

              <div class="d-flex flex-wrap gap-2 ms-auto">
                <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn btn-sm btn-nh-outline px-3">
                  <i class="fas fa-eye me-1"></i> View Booking
                </a>
                
                <a href="messages.php?booking_id=<?= $bk['id'] ?>" class="btn btn-sm btn-light border px-3">
                  <i class="fas fa-comment-dots me-1 text-primary"></i> Contact Landlord
                </a>

                <?php if ($bk['status'] === 'Pending'): ?>
                  <a href="bookings.php?cancel=<?= $bk['id'] ?>" class="btn btn-sm btn-outline-danger px-3" onclick="return confirm('Cancel this booking request? Your token fee will be refunded.');">
                    <i class="fas fa-ban me-1"></i> Cancel Request
                  </a>
                <?php elseif ($bk['status'] === 'Approved'): ?>
                  <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn btn-sm btn-success px-3">
                    <i class="fas fa-check me-1"></i> Confirm & Check-in Pass
                  </a>
                  <a href="bookings.php?cancel=<?= $bk['id'] ?>" class="btn btn-sm btn-outline-danger px-2" onclick="return confirm('Decline this approved booking?');">
                    Cancel
                  </a>
                <?php elseif ($bk['status'] === 'Active'): ?>
                  <button class="btn btn-sm btn-nh-primary px-3" onclick="alert('Extend stay request sent to landlord!')">
                    <i class="fas fa-clock-rotate-left me-1"></i> Extend Stay
                  </button>
                <?php elseif ($bk['status'] === 'Completed'): ?>
                  <a href="reviews.php?property_id=<?= $bk['property_id'] ?>" class="btn btn-sm btn-warning text-dark px-3">
                    <i class="fas fa-star me-1"></i> Write Review
                  </a>
                  <button class="btn btn-sm btn-light border px-3" onclick="alert('Receipt PDF downloaded!')">
                    <i class="fas fa-file-invoice me-1"></i> Receipt
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
