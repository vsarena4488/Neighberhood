<?php
require_once __DIR__ . '/includes/functions.php';

$bookingId = $_GET['id'] ?? 'B1024';
$bookings = $_SESSION['user_bookings'] ?? [];
$booking = null;

foreach ($bookings as $b) {
    if ($b['id'] === $bookingId) {
        $booking = $b;
        break;
    }
}
if (!$booking) $booking = $bookings[0]; // fallback

$pageTitle = 'Booking #' . $booking['id'] . ' · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$badgeClass = 'status-' . strtolower($booking['status']);
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb extra-small mb-1">
            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="bookings.php" class="text-decoration-none">My Bookings</a></li>
            <li class="breadcrumb-item active">#<?= htmlspecialchars($booking['id']) ?></li>
          </ol>
        </nav>
        <div class="d-flex align-items-center gap-2">
          <h3 class="fw-bold mb-0">Booking Reference #<?= htmlspecialchars($booking['id']) ?></h3>
          <span class="badge-status <?= $badgeClass ?> px-3 py-1"><?= htmlspecialchars($booking['status']) ?></span>
        </div>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="messages.php?booking_id=<?= $booking['id'] ?>" class="btn btn-sm btn-nh-outline px-3">
          <i class="fas fa-comment-dots me-1"></i> Message Landlord
        </a>
        <button class="btn btn-sm btn-light border px-3" onclick="window.print()">
          <i class="fas fa-print me-1"></i> Print / Receipt
        </button>
      </div>
    </div>

    <!-- BOOKING TIMELINE TRACKER (As specified by PM) -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
      <h5 class="fw-bold mb-3"><i class="fas fa-timeline text-bright-indigo me-2"></i> Stay & Verification Progress Timeline</h5>
      
      <div class="d-flex flex-column flex-md-row justify-content-between position-relative py-2">
        <?php foreach ($booking['timeline'] as $idx => $step): ?>
          <div class="text-center mb-3 mb-md-0 flex-grow-1 position-relative">
            <div class="rounded-circle mx-auto d-flex align-items-center justify-content-center fw-bold mb-2 shadow-sm <?= $step['done'] ? 'bg-primary text-white' : 'bg-light text-muted border' ?>" style="width: 42px; height: 42px; font-size: 1.1rem;">
              <?php if ($step['done']): ?>
                <i class="fas fa-check"></i>
              <?php else: ?>
                <?= $idx + 1 ?>
              <?php endif; ?>
            </div>
            <strong class="d-block small text-dark"><?= htmlspecialchars($step['step']) ?></strong>
            <span class="extra-small <?= !empty($step['current']) ? 'text-primary fw-bold' : 'text-muted' ?>"><?= htmlspecialchars($step['date']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="row g-4">
      <!-- LEFT COLUMN: PROPERTY & STAY DETAILS -->
      <div class="col-lg-8">
        <!-- Property Information Card -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-building text-bright-indigo me-2"></i> Accommodation Information</h5>
          
          <div class="p-3 bg-light rounded-3 border mb-3">
            <h5 class="fw-bold mb-1">
              <a href="property-details.php?id=<?= $booking['property_id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($booking['property_title']) ?></a>
            </h5>
            <span class="extra-small text-secondary-custom d-block mb-2">
              <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($booking['location']) ?>
            </span>
            <div class="d-flex flex-wrap gap-2 extra-small">
              <span class="badge bg-soft-lavender text-royal-blue"><i class="fas fa-bed me-1"></i> <?= htmlspecialchars($booking['room_type']) ?></span>
              <span class="badge bg-white text-dark border">Duration: <?= htmlspecialchars($booking['duration']) ?></span>
              <span class="badge bg-success text-white">Move-in Date: <?= htmlspecialchars($booking['move_in_date']) ?></span>
            </div>
          </div>

          <div class="row g-3 small">
            <div class="col-sm-6">
              <span class="text-secondary-custom d-block extra-small">Primary Tenant Name:</span>
              <strong class="text-dark"><?= htmlspecialchars($user['name'] ?? 'Vishal Patel') ?></strong>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary-custom d-block extra-small">Registered Email:</span>
              <strong class="text-dark"><?= htmlspecialchars($user['email'] ?? 'vishal@example.com') ?></strong>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary-custom d-block extra-small">Contact Phone:</span>
              <strong class="text-dark"><?= htmlspecialchars($user['phone'] ?? '+91 98765 43210') ?></strong>
            </div>
            <div class="col-sm-6">
              <span class="text-secondary-custom d-block extra-small">College Verification:</span>
              <strong class="text-dark"><?= htmlspecialchars($user['college'] ?? 'Christ University') ?></strong>
            </div>
          </div>
        </div>

        <!-- Landlord & Check-in Pass Instructions -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-id-card-clip text-bright-indigo me-2"></i> Move-in & Check-in Pass</h5>
          <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle d-flex align-items-start gap-3">
            <i class="fas fa-door-open fs-3 text-royal-blue mt-1"></i>
            <div>
              <strong class="d-block small text-royal-blue">Physical Move-in Scheduled for <?= htmlspecialchars($booking['move_in_date']) ?></strong>
              <p class="extra-small text-secondary-custom mb-0">
                Please present your digital booking ID <strong>#<?= htmlspecialchars($booking['id']) ?></strong> and a valid government or college ID to property manager <strong><?= htmlspecialchars($booking['owner_name']) ?></strong> upon arrival.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: TWO-STAGE PAYMENT SUMMARY -->
      <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 sticky-top" style="top: 85px; z-index: 100;">
          <h6 class="fw-bold mb-3 pb-2 border-bottom">Payment Ledger & Receipts</h6>
          
          <div class="d-flex justify-content-between small mb-2">
            <span class="text-secondary-custom">Monthly Rent:</span>
            <strong>₹<?= number_format($booking['rent']) ?></strong>
          </div>
          <div class="d-flex justify-content-between small mb-2">
            <span class="text-secondary-custom">Security Deposit:</span>
            <strong>₹<?= number_format($booking['deposit']) ?></strong>
          </div>
          <div class="d-flex justify-content-between small mb-2">
            <span class="text-secondary-custom">Token Booking Fee:</span>
            <span class="badge bg-success">₹<?= number_format($booking['token_fee']) ?> (Paid)</span>
          </div>
          <hr class="my-2">
          <div class="d-flex justify-content-between fw-bold mb-3">
            <span>Balance Due at Check-in:</span>
            <span class="text-royal-blue fs-5">₹<?= number_format($booking['move_in_balance']) ?></span>
          </div>

          <!-- Landlord Contact Box -->
          <div class="p-3 bg-light rounded-3 border mb-3">
            <span class="extra-small text-muted fw-bold d-block mb-1">Host Contact</span>
            <strong class="d-block small text-dark"><?= htmlspecialchars($booking['owner_name']) ?></strong>
            <span class="extra-small text-secondary-custom d-block mb-2"><i class="fas fa-phone me-1 text-primary"></i> <?= htmlspecialchars($booking['owner_phone']) ?></span>
            <div class="d-grid gap-2">
              <a href="messages.php?booking_id=<?= $booking['id'] ?>" class="btn btn-sm btn-nh-primary">
                <i class="fas fa-comment-dots me-1"></i> Chat Now
              </a>
              <a href="tel:<?= $booking['owner_phone'] ?>" class="btn btn-sm btn-light border">
                <i class="fas fa-phone me-1"></i> Call Host
              </a>
            </div>
          </div>

          <?php if ($booking['status'] === 'Pending'): ?>
            <a href="bookings.php?cancel=<?= $booking['id'] ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Cancel this booking request?');">
              <i class="fas fa-ban me-1"></i> Cancel Request
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
