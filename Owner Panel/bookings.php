<?php
// Owner Panel bookings.php - Bookings Management & Occupancy Calendar
$pageTitle = 'Bookings & Stay Requests · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

// Handle Accept / Reject actions
$noticeMessage = '';
if (isset($_GET['accept'])) {
    $acceptId = trim($_GET['accept']);
    foreach ($_SESSION['owner_bookings'] as &$b) {
        if ($b['id'] === $acceptId && $b['status'] === 'Pending') {
            $b['status'] = 'Approved';
            break;
        }
    }
    header('Location: bookings.php?approved=1');
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
    header('Location: bookings.php?rejected=1');
    exit;
}

$pageTitle = 'Bookings Management · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$filterStatus = $_GET['status'] ?? 'all';
$bookings = $_SESSION['owner_bookings'] ?? [];

$filteredBookings = array_filter($bookings, function($b) use ($filterStatus) {
    if ($filterStatus === 'all') return true;
    return (strcasecmp($b['status'], $filterStatus) === 0);
});
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- Page Header Title -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Bookings & Stay Requests (<?= count($bookings) ?>)</h3>
        <span class="text-secondary-custom small">Review tenant applications, approve check-in passes, and manage active leases</span>
      </div>
    </div>

    <!-- OCCUPANCY CALENDAR QUICK VIEW WIDGET -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
      <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
        <h5 class="fw-bold mb-0"><i class="fas fa-calendar-days text-bright-indigo me-2"></i> Weekly Occupancy Calendar</h5>
        <div class="d-flex align-items-center gap-2 extra-small">
          <span class="d-inline-flex align-items-center gap-1"><i class="fas fa-circle text-success fs-xs"></i> 80%+ Booked</span>
          <span class="d-inline-flex align-items-center gap-1"><i class="fas fa-circle text-warning fs-xs"></i> Partial Beds</span>
          <span class="d-inline-flex align-items-center gap-1"><i class="fas fa-circle text-danger fs-xs"></i> Fully Booked</span>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered text-center extra-small align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th style="width: 140px;" class="text-start">Listed Property</th>
              <th>Mon (Sep 1)</th>
              <th>Tue (Sep 2)</th>
              <th>Wed (Sep 3)</th>
              <th>Thu (Sep 4)</th>
              <th>Fri (Sep 5)</th>
              <th>Sat (Sep 6)</th>
              <th>Sun (Sep 7)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-start fw-bold">St. Mark's Executive PG</td>
              <td><span class="badge bg-success-subtle text-success border border-success-subtle w-100 py-1.5">2 Available</span></td>
              <td><span class="badge bg-success-subtle text-success border border-success-subtle w-100 py-1.5">2 Available</span></td>
              <td><span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle w-100 py-1.5">1 Available</span></td>
              <td><span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle w-100 py-1.5">1 Available</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Beds</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Beds</span></td>
              <td><span class="badge bg-success-subtle text-success border border-success-subtle w-100 py-1.5">2 Available</span></td>
            </tr>
            <tr>
              <td class="text-start fw-bold">Koramangala Studio Flat</td>
              <td><span class="badge bg-success-subtle text-success border border-success-subtle w-100 py-1.5">1 Available</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Flat</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Flat</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Flat</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Flat</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Flat</span></td>
              <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle w-100 py-1.5">0 Flat</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Status Filter Pill Bar -->
    <div class="d-flex flex-wrap gap-2 mb-4 p-1.5 bg-white rounded-pill border shadow-sm" style="width: fit-content;">
      <a href="bookings.php?status=all" class="btn btn-sm <?= ($filterStatus === 'all') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        All Requests (<?= count($bookings) ?>)
      </a>
      <a href="bookings.php?status=Pending" class="btn btn-sm <?= ($filterStatus === 'Pending') ? 'btn-warning text-dark' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Pending (<?= count(array_filter($bookings, fn($b) => $b['status'] === 'Pending')) ?>)
      </a>
      <a href="bookings.php?status=Approved" class="btn btn-sm <?= ($filterStatus === 'Approved') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Approved (<?= count(array_filter($bookings, fn($b) => $b['status'] === 'Approved')) ?>)
      </a>
      <a href="bookings.php?status=Active" class="btn btn-sm <?= ($filterStatus === 'Active') ? 'btn-success text-white' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Active Leases (<?= count(array_filter($bookings, fn($b) => $b['status'] === 'Active')) ?>)
      </a>
      <a href="bookings.php?status=Completed" class="btn btn-sm <?= ($filterStatus === 'Completed') ? 'btn-teal text-white' : 'btn-light' ?> rounded-pill px-3 fw-semibold" style="<?= ($filterStatus === 'Completed') ? 'background:#0D9488;' : '' ?>">
        Completed (<?= count(array_filter($bookings, fn($b) => $b['status'] === 'Completed')) ?>)
      </a>
      <a href="bookings.php?status=Cancelled" class="btn btn-sm <?= ($filterStatus === 'Cancelled') ? 'btn-danger' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Cancelled (<?= count(array_filter($bookings, fn($b) => $b['status'] === 'Cancelled')) ?>)
      </a>
    </div>

    <!-- Booking List Cards -->
    <div class="d-flex flex-column gap-3.5 mb-4">
      <?php if (empty($filteredBookings)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-3">
          <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-royal-blue" style="width: 76px; height: 76px; align-items: center; justify-content: center; font-size: 2rem;">
            <i class="fas fa-calendar-xmark"></i>
          </div>
          <h5 class="fw-bold mb-1">No Booking Requests Found</h5>
          <p class="text-secondary-custom small mb-0">No tenant applications under status "<?= htmlspecialchars($filterStatus) ?>".</p>
        </div>
      <?php else: ?>
        <?php foreach ($filteredBookings as $bk): 
          $badgeClass = 'status-' . strtolower($bk['status']);
        ?>
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
            <!-- Header Row: ID, Placed date, Status badge -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-3 border-bottom gap-2">
              <div class="d-flex align-items-center gap-2">
                <span class="fs-5 fw-bold text-royal-blue">Booking #<?= htmlspecialchars($bk['id']) ?></span>
                <span class="extra-small text-muted">· Received <?= htmlspecialchars($bk['created_at']) ?></span>
              </div>
              <span class="badge-status <?= $badgeClass ?> px-3 py-1.5 fs-6">
                <?= htmlspecialchars($bk['status']) ?>
              </span>
            </div>

            <!-- Body Grid: Student info, Property & Room, Rent & Balance -->
            <div class="row g-3 align-items-center mb-3">
              <!-- Student Info -->
              <div class="col-lg-5 col-md-6">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <img src="<?= htmlspecialchars($bk['tenant']['avatar']) ?>" alt="<?= htmlspecialchars($bk['tenant']['name']) ?>" class="rounded-circle shadow-sm" style="width: 44px; height: 44px; object-fit: cover;" />
                  <div>
                    <h5 class="fw-bold text-dark mb-0.5"><?= htmlspecialchars($bk['tenant']['name']) ?></h5>
                    <span class="extra-small text-secondary-custom d-block"><i class="fas fa-graduation-cap text-primary me-1"></i> <?= htmlspecialchars($bk['tenant']['college']) ?></span>
                  </div>
                </div>
                <div class="extra-small text-muted">
                  ID: <strong class="text-dark"><?= htmlspecialchars($bk['tenant']['student_id']) ?></strong> · Course: <span class="text-dark"><?= htmlspecialchars($bk['tenant']['course']) ?></span>
                </div>
              </div>

              <!-- Property & Dates -->
              <div class="col-lg-4 col-sm-6">
                <div class="p-3 bg-light rounded-3 border">
                  <strong class="d-block small text-dark mb-0.5"><?= htmlspecialchars($bk['property_title']) ?></strong>
                  <span class="extra-small text-primary fw-semibold d-block mb-1"><i class="fas fa-bed me-1"></i> <?= htmlspecialchars($bk['room_type']) ?></span>
                  <div class="extra-small text-muted">
                    Move-in: <strong class="text-dark"><?= htmlspecialchars($bk['move_in_date']) ?></strong> (<?= htmlspecialchars($bk['duration']) ?>)
                  </div>
                </div>
              </div>

              <!-- Rent & Deposit stats -->
              <div class="col-lg-3 col-sm-6 text-sm-end">
                <span class="extra-small text-secondary-custom d-block">Rent & Deposit</span>
                <strong class="text-royal-blue fs-4 fw-bold">₹<?= number_format($bk['rent']) ?></strong><span class="extra-small text-muted"> /mo</span>
                <div class="extra-small text-success fw-semibold mt-1">Token Deposit: ₹<?= number_format($bk['token_fee']) ?> (Paid)</div>
                <div class="extra-small text-muted">Move-in Balance: ₹<?= number_format($bk['move_in_balance']) ?></div>
              </div>
            </div>

            <!-- Contextual Actions Bar -->
            <div class="pt-3 border-top d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div class="extra-small text-secondary-custom">
                <i class="fas fa-shield-check text-success me-1"></i> Zero Brokerage Verified Application
              </div>

              <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
                <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn-action-sm btn-nh-outline">
                  <i class="fas fa-eye"></i> View Application Details
                </a>
                
                <a href="messages.php?chat=chat_1" class="btn-action-sm btn-light-custom">
                  <i class="fas fa-comment-dots text-primary"></i> Chat with Student
                </a>

                <?php if ($bk['status'] === 'Pending'): ?>
                  <a href="bookings.php?accept=<?= $bk['id'] ?>" class="btn-action-sm btn-success text-white">
                    <i class="fas fa-check-circle"></i> Accept Request
                  </a>
                  <a href="bookings.php?reject=<?= $bk['id'] ?>" class="btn-action-sm btn-danger-custom" onclick="return confirm('Reject this booking application?');">
                    <i class="fas fa-xmark"></i> Reject
                  </a>
                <?php endif; ?>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
