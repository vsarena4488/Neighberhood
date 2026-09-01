<?php
// Owner Panel booking-details.php - Booking Application Details & Verification Inspection
$pageTitle = 'Booking Application Details · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

$bookingId = $_GET['id'] ?? 'B1024';
$bookings = $_SESSION['owner_bookings'] ?? [];
$booking = null;
foreach ($bookings as $b) {
    if ($b['id'] === $bookingId) {
        $booking = $b;
        break;
    }
}
if (!$booking) $booking = $bookings[0];

$pageTitle = 'Booking Request #' . $booking['id'] . ' · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    
    <!-- Page Header & Breadcrumb -->
    <div class="mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb extra-small mb-1">
          <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="bookings.php" class="text-decoration-none">Bookings</a></li>
          <li class="breadcrumb-item active">#<?= htmlspecialchars($booking['id']) ?></li>
        </ol>
      </nav>
      <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
          <h3 class="fw-bold mb-0">Booking Application #<?= htmlspecialchars($booking['id']) ?></h3>
          <span class="extra-small text-secondary-custom">Submitted <?= htmlspecialchars($booking['created_at']) ?></span>
        </div>
        <span class="badge-status status-<?= strtolower($booking['status']) ?> px-3 py-1.5 fs-6">
          <?= htmlspecialchars($booking['status']) ?>
        </span>
      </div>
    </div>

    <!-- MAIN TWO-COLUMN DETAILS GRID -->
    <div class="row g-4 mb-4">
      
      <!-- LEFT COLUMN: TENANT VERIFICATION & BOOKING TIMELINE -->
      <div class="col-lg-8">
        
        <!-- STUDENT TENANT VERIFIED PROFILE CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-user-graduate text-bright-indigo me-2"></i> Student Tenant Verified Profile</h5>
          
          <div class="d-flex flex-wrap align-items-center gap-3 p-3 bg-soft-lavender rounded-4 border border-primary-subtle mb-3">
            <img src="<?= htmlspecialchars($booking['tenant']['avatar']) ?>" alt="<?= htmlspecialchars($booking['tenant']['name']) ?>" class="rounded-circle shadow-sm" style="width: 64px; height: 64px; object-fit: cover;" />
            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2 mb-1">
                <h5 class="fw-bold text-dark mb-0"><?= htmlspecialchars($booking['tenant']['name']) ?></h5>
                <span class="badge bg-success text-white extra-small"><i class="fas fa-shield-check me-1"></i> Student Verified</span>
              </div>
              <span class="extra-small text-royal-blue fw-semibold d-block mb-1"><i class="fas fa-university me-1"></i> <?= htmlspecialchars($booking['tenant']['college']) ?></span>
              <span class="fs-xs text-secondary-custom">Course: <strong><?= htmlspecialchars($booking['tenant']['course']) ?></strong> · Student ID: <strong class="text-dark"><?= htmlspecialchars($booking['tenant']['student_id']) ?></strong></span>
            </div>
          </div>

          <div class="row g-3 extra-small">
            <div class="col-md-6">
              <span class="text-secondary-custom d-block mb-0.5">Email Address</span>
              <strong class="text-dark d-block"><i class="fas fa-envelope text-primary me-1"></i> <?= htmlspecialchars($booking['tenant']['email']) ?></strong>
            </div>
            <div class="col-md-6">
              <span class="text-secondary-custom d-block mb-0.5">Contact Phone</span>
              <strong class="text-dark d-block"><i class="fas fa-phone text-success me-1"></i> <?= htmlspecialchars($booking['tenant']['phone']) ?></strong>
            </div>
          </div>
        </div>

        <!-- APPLICATION TIMELINE LIFECYCLE -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-timeline text-bright-indigo me-2"></i> Application Status Timeline</h5>
          
          <div class="d-flex flex-column gap-3">
            <?php foreach ($booking['timeline'] as $t): ?>
              <div class="d-flex align-items-center gap-3">
                <div class="p-2 rounded-circle <?= $t['done'] ? 'bg-success text-white' : 'bg-light text-muted border' ?>" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.85rem;">
                  <i class="fas <?= $t['done'] ? 'fa-check' : 'fa-clock' ?>"></i>
                </div>
                <div class="flex-grow-1">
                  <strong class="small d-block text-dark"><?= htmlspecialchars($t['step']) ?></strong>
                  <span class="fs-xs text-muted"><?= htmlspecialchars($t['date']) ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>

      <!-- RIGHT COLUMN: FINANCIAL BREAKDOWN & DECISION ACTIONS -->
      <div class="col-lg-4">
        
        <!-- FINANCIAL SUMMARY CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-receipt text-bright-indigo me-2"></i> Financial & Rent Summary</h5>
          
          <div class="d-flex flex-column gap-2 extra-small pb-3 border-bottom mb-3">
            <div class="d-flex justify-content-between">
              <span class="text-secondary-custom">Monthly Rent:</span>
              <strong class="text-dark">₹<?= number_format($booking['rent']) ?> /mo</strong>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-secondary-custom">Security Deposit:</span>
              <strong class="text-dark">₹<?= number_format($booking['deposit']) ?></strong>
            </div>
            <div class="d-flex justify-content-between text-success fw-bold">
              <span>Token Deposit Fee (Paid):</span>
              <span>₹<?= number_format($booking['token_fee']) ?></span>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="small text-secondary-custom">Move-in Balance Due:</span>
            <strong class="text-royal-blue fs-5 fw-bold">₹<?= number_format($booking['move_in_balance']) ?></strong>
          </div>

          <div class="p-2.5 bg-light rounded-3 text-center extra-small text-muted mb-3">
            <i class="fas fa-lock text-success me-1"></i> Protected under Two-Stage Escrow Protocol
          </div>
        </div>

        <!-- OWNER DECISION ACTION CARD -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-gavel text-warning me-2"></i> Owner Decision</h5>
          
          <?php if ($booking['status'] === 'Pending'): ?>
            <div class="d-flex flex-column gap-2">
              <a href="bookings.php?accept=<?= $booking['id'] ?>" class="btn btn-success text-white py-2.5 rounded-pill fw-bold small text-center">
                <i class="fas fa-check-circle me-1"></i> Accept & Approve Booking
              </a>
              <button class="btn btn-outline-primary py-2.5 rounded-pill fw-bold small" onclick="alert('Counter-offer dialog opened.')">
                <i class="fas fa-handshake me-1"></i> Propose Counter Offer
              </button>
              <a href="bookings.php?reject=<?= $booking['id'] ?>" class="btn btn-outline-danger py-2.5 rounded-pill fw-bold small text-center" onclick="return confirm('Reject this booking application?');">
                <i class="fas fa-xmark me-1"></i> Reject Application
              </a>
            </div>
          <?php else: ?>
            <div class="p-3 bg-soft-lavender rounded-3 text-center text-royal-blue extra-small fw-bold">
              Application status is currently <?= htmlspecialchars($booking['status']) ?>.
            </div>
          <?php endif; ?>

          <a href="messages.php?chat=chat_1" class="btn btn-nh-outline w-100 mt-3 py-2 text-center">
            <i class="fas fa-comment-dots me-1"></i> Chat with <?= htmlspecialchars($booking['tenant']['name']) ?>
          </a>
        </div>

      </div>

    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
