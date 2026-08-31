<?php
require_once __DIR__ . '/includes/functions.php';

$propertyId = intval($_GET['property_id'] ?? 101);
$allProperties = getPropertiesData();
$property = null;
foreach ($allProperties as $p) {
    if ($p['id'] === $propertyId) {
        $property = $p;
        break;
    }
}
if (!$property) $property = $allProperties[0];

$selectedRoom = $_GET['room'] ?? $property['room_options'][0]['name'];

// Handle POST Booking Submission (Step 6 -> Step 7)
$bookingCreated = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newId = 'B' . rand(1030, 1999);
    $selectedRoomName = $_POST['room_name'] ?? $selectedRoom;
    $moveInDate = $_POST['move_in_date'] ?? 'Sep 01, 2026';
    $duration = $_POST['duration'] ?? '3 Months';
    $paymentMethod = $_POST['payment_method'] ?? 'UPI';

    $newBooking = [
        'id' => $newId,
        'property_id' => $property['id'],
        'property_title' => $property['title'],
        'property_type' => $property['type'],
        'location' => $property['area'] . ', ' . $property['city'],
        'room_type' => $selectedRoomName,
        'owner_name' => $property['owner']['name'],
        'owner_phone' => $property['owner']['phone'],
        'move_in_date' => $moveInDate,
        'duration' => $duration,
        'rent' => $property['rent'],
        'deposit' => $property['deposit'],
        'token_fee' => 500,
        'token_status' => 'Paid (' . $paymentMethod . ')',
        'move_in_balance' => ($property['rent'] + $property['deposit'] - 500),
        'status' => 'Pending',
        'created_at' => 'Just now',
        'timeline' => [
            ['step' => 'Booking Requested', 'date' => date('M d, Y'), 'done' => true],
            ['step' => 'Owner Reviewing', 'date' => 'In Progress', 'done' => true, 'current' => true],
            ['step' => 'Booking Approved', 'date' => 'Pending', 'done' => false],
            ['step' => 'Physical Move-in & Check-in', 'date' => $moveInDate, 'done' => false],
            ['step' => 'Completed', 'date' => 'Pending', 'done' => false]
        ]
    ];

    array_unshift($_SESSION['user_bookings'], $newBooking);
    $bookingCreated = $newBooking;
}

$pageTitle = 'Request Booking · ' . $property['title'];
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="mb-4">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb extra-small mb-1">
          <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Home</a></li>
          <li class="breadcrumb-item"><a href="property-details.php?id=<?= $property['id'] ?>" class="text-decoration-none"><?= htmlspecialchars($property['title']) ?></a></li>
          <li class="breadcrumb-item active">Booking Wizard</li>
        </ol>
      </nav>
      <h3 class="fw-bold mb-1">Accommodation Booking Request</h3>
      <span class="text-secondary-custom small">Complete the quick 7-step request to secure your bed with verified owner approval</span>
    </div>

    <?php if ($bookingCreated): ?>
      <!-- STEP 7: BOOKING CONFIRMATION SCREEN -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 p-md-5 text-center my-3 max-w-xl mx-auto">
        <div class="p-3.5 bg-success text-white rounded-circle d-inline-flex mx-auto mb-3 shadow" style="width: 72px; height: 72px; align-items: center; justify-content: center; font-size: 2.2rem;">
          <i class="fas fa-circle-check"></i>
        </div>
        <h3 class="fw-bold mb-1 text-dark">Booking Request Submitted!</h3>
        <p class="text-secondary-custom small mb-4">
          Your booking reference <strong class="text-royal-blue">#<?= $bookingCreated['id'] ?></strong> has been sent to host <strong><?= htmlspecialchars($bookingCreated['owner_name']) ?></strong>.
        </p>

        <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle text-start small mb-4">
          <div class="d-flex justify-content-between mb-1">
            <span class="text-secondary-custom">Property:</span>
            <strong><?= htmlspecialchars($bookingCreated['property_title']) ?></strong>
          </div>
          <div class="d-flex justify-content-between mb-1">
            <span class="text-secondary-custom">Room Type:</span>
            <strong><?= htmlspecialchars($bookingCreated['room_type']) ?></strong>
          </div>
          <div class="d-flex justify-content-between mb-1">
            <span class="text-secondary-custom">Move-in Date:</span>
            <strong><?= htmlspecialchars($bookingCreated['move_in_date']) ?></strong>
          </div>
          <div class="d-flex justify-content-between mb-1">
            <span class="text-secondary-custom">Token Fee Paid:</span>
            <strong class="text-success">₹500 (<?= htmlspecialchars($bookingCreated['token_status']) ?>)</strong>
          </div>
          <hr class="my-2">
          <div class="d-flex justify-content-between">
            <span class="text-secondary-custom">Move-in Balance (Due at check-in):</span>
            <strong class="text-royal-blue">₹<?= number_format($bookingCreated['move_in_balance']) ?></strong>
          </div>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-center">
          <a href="booking-details.php?id=<?= $bookingCreated['id'] ?>" class="btn btn-nh-primary px-4">
            <i class="fas fa-receipt me-1"></i> View Booking Tracker
          </a>
          <a href="bookings.php" class="btn btn-nh-outline px-4">
            <i class="fas fa-list me-1"></i> All Bookings
          </a>
          <a href="messages.php" class="btn btn-light border px-3">
            <i class="fas fa-comment-dots me-1 text-primary"></i> Chat with Landlord
          </a>
        </div>
      </div>
    <?php else: ?>
      <!-- 7-STEP INTERACTIVE BOOKING WIZARD -->
      <div class="row g-4">
        <div class="col-lg-8">
          <form action="booking-request.php?property_id=<?= $property['id'] ?>" method="POST" id="bookingWizardForm">
            <!-- Step Navigation Tabs / Indicator (Responsive Scrollable) -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-2.5 p-md-3 mb-4 overflow-x-auto">
              <div class="d-flex justify-content-between align-items-center extra-small font-weight-bold text-center" style="min-width: 480px;">
                <div class="flex-grow-1 text-royal-blue"><i class="fas fa-circle-check text-success me-1"></i> 1. Property</div>
                <div class="text-muted">➔</div>
                <div class="flex-grow-1 text-royal-blue"><i class="fas fa-bed me-1"></i> 2. Room</div>
                <div class="text-muted">➔</div>
                <div class="flex-grow-1 text-royal-blue"><i class="fas fa-calendar me-1"></i> 3. Dates</div>
                <div class="text-muted">➔</div>
                <div class="flex-grow-1 text-royal-blue"><i class="fas fa-user me-1"></i> 4. Details</div>
                <div class="text-muted">➔</div>
                <div class="flex-grow-1 text-royal-blue"><i class="fas fa-credit-card me-1"></i> 5. Token Fee</div>
              </div>
            </div>

            <!-- STEP 1: Property Confirmation -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
              <h5 class="fw-bold mb-3"><i class="fas fa-building text-bright-indigo me-2"></i> Step 1: Selected Property</h5>
              <div class="d-flex align-items-center gap-3 p-3 bg-light rounded-3 border">
                <img src="<?= htmlspecialchars($property['image']) ?>" alt="<?= htmlspecialchars($property['title']) ?>" class="rounded-3" style="width: 70px; height: 70px; object-fit: cover;" />
                <div>
                  <h6 class="fw-bold mb-1"><?= htmlspecialchars($property['title']) ?></h6>
                  <span class="extra-small text-secondary-custom d-block"><i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($property['area']) ?>, <?= htmlspecialchars($property['city']) ?></span>
                  <span class="badge bg-success extra-small mt-1">Verified Host: <?= htmlspecialchars($property['owner']['name']) ?></span>
                </div>
              </div>
            </div>

            <!-- STEP 2: Room Selection -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
              <h5 class="fw-bold mb-3"><i class="fas fa-bed text-bright-indigo me-2"></i> Step 2: Choose Room & Bed Occupancy</h5>
              <div class="row g-3">
                <?php foreach ($property['room_options'] as $idx => $room): ?>
                  <div class="col-sm-6">
                    <label class="card p-3 rounded-3 border h-100 cursor-pointer <?= ($room['name'] === $selectedRoom) ? 'border-primary bg-soft-lavender' : '' ?>" style="cursor: pointer;">
                      <div class="d-flex align-items-start gap-2">
                        <input type="radio" name="room_name" value="<?= htmlspecialchars($room['name']) ?>" class="mt-1" <?= ($room['name'] === $selectedRoom) ? 'checked' : '' ?> <?= ($room['status'] !== 'Available') ? 'disabled' : '' ?> />
                        <div class="flex-grow-1">
                          <strong class="d-block small"><?= htmlspecialchars($room['name']) ?></strong>
                          <span class="extra-small text-muted d-block mb-2">Occupancy: <?= htmlspecialchars($room['occupancy']) ?></span>
                          <div class="d-flex justify-content-between align-items-baseline">
                            <strong class="text-royal-blue">₹<?= number_format($room['rent']) ?>/mo</strong>
                            <span class="badge <?= ($room['status'] === 'Available') ? 'bg-success' : 'bg-secondary' ?> extra-small"><?= $room['status'] ?></span>
                          </div>
                        </div>
                      </div>
                    </label>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- STEP 3: Dates & Stay Duration -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
              <h5 class="fw-bold mb-3"><i class="fas fa-calendar-alt text-bright-indigo me-2"></i> Step 3: Move-in Date & Duration</h5>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">Expected Move-in Date *</label>
                  <input type="date" name="move_in_date" class="form-control rounded-3" value="2026-09-01" required />
                </div>
                <div class="col-md-6">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">Initial Stay Duration *</label>
                  <select name="duration" class="form-select rounded-3">
                    <option value="3 Months" selected>3 Months (Standard Semester)</option>
                    <option value="6 Months">6 Months (Half Year)</option>
                    <option value="11 Months">11 Months (Full Academic Year)</option>
                    <option value="1 Month">1 Month (Trial Stay)</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- STEP 4: Personal Information -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
              <h5 class="fw-bold mb-3"><i class="fas fa-user-check text-bright-indigo me-2"></i> Step 4: Tenant Details</h5>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">Full Name</label>
                  <input type="text" class="form-control rounded-3" value="<?= htmlspecialchars($user['name'] ?? 'Vishal Patel') ?>" readonly />
                </div>
                <div class="col-md-6">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">Email Address</label>
                  <input type="email" class="form-control rounded-3" value="<?= htmlspecialchars($user['email'] ?? 'vishal@example.com') ?>" readonly />
                </div>
                <div class="col-md-6">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">Phone Number</label>
                  <input type="text" class="form-control rounded-3" value="<?= htmlspecialchars($user['phone'] ?? '+91 98765 43210') ?>" readonly />
                </div>
                <div class="col-md-6">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">College / Organization</label>
                  <input type="text" class="form-control rounded-3" value="<?= htmlspecialchars($user['college'] ?? 'Christ University') ?>" readonly />
                </div>
                <div class="col-12">
                  <label class="form-label extra-small fw-bold text-secondary mb-1">Special Requests or Notes for Landlord (Optional)</label>
                  <textarea name="notes" class="form-control rounded-3" rows="2" placeholder="e.g. Vegetarian food preference, study table requirement..."></textarea>
                </div>
              </div>
            </div>

            <!-- STEP 5 & 6: Token Fee Payment (Two-Stage Model) -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
              <h5 class="fw-bold mb-2"><i class="fas fa-credit-card text-bright-indigo me-2"></i> Step 5 & 6: Pay Token Booking Fee</h5>
              <p class="text-secondary-custom extra-small mb-3">
                To guarantee your reservation and protect against scams, pay a small <strong>₹500 token fee</strong> online now. The balance rent & deposit is payable upon physical check-in.
              </p>

              <div class="row g-2 mb-3">
                <div class="col-6 col-md-3">
                  <label class="card p-2.5 rounded-3 border text-center cursor-pointer bg-soft-lavender border-primary">
                    <input type="radio" name="payment_method" value="UPI (GPay / PhonePe)" checked class="d-none" />
                    <i class="fas fa-mobile-screen-button text-bright-indigo fs-5 mb-1 d-block"></i>
                    <span class="extra-small fw-bold">UPI / GPay</span>
                  </label>
                </div>
                <div class="col-6 col-md-3">
                  <label class="card p-2.5 rounded-3 border text-center cursor-pointer">
                    <input type="radio" name="payment_method" value="Credit/Debit Card" class="d-none" />
                    <i class="fas fa-credit-card text-secondary fs-5 mb-1 d-block"></i>
                    <span class="extra-small fw-bold">Debit / Card</span>
                  </label>
                </div>
                <div class="col-6 col-md-3">
                  <label class="card p-2.5 rounded-3 border text-center cursor-pointer">
                    <input type="radio" name="payment_method" value="Net Banking" class="d-none" />
                    <i class="fas fa-building-columns text-secondary fs-5 mb-1 d-block"></i>
                    <span class="extra-small fw-bold">Net Banking</span>
                  </label>
                </div>
                <div class="col-6 col-md-3">
                  <label class="card p-2.5 rounded-3 border text-center cursor-pointer">
                    <input type="radio" name="payment_method" value="PayTM Wallet" class="d-none" />
                    <i class="fas fa-wallet text-secondary fs-5 mb-1 d-block"></i>
                    <span class="extra-small fw-bold">Wallets</span>
                  </label>
                </div>
              </div>

              <div class="form-check small mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" required checked>
                <label class="form-check-label extra-small text-secondary-custom" for="termsCheck">
                  I agree to the NeighborNest Booking Terms, House Rules, and 100% Refundable Token Policy if rejected by owner.
                </label>
              </div>

              <button type="submit" class="btn btn-nh-primary w-100 py-3 fs-6">
                <i class="fas fa-lock me-1"></i> Pay ₹500 Token Fee & Submit Booking Request
              </button>
            </div>
          </form>
        </div>

        <!-- RIGHT SIDEBAR SUMMARY -->
        <div class="col-lg-4">
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4 sticky-top" style="top: 85px; z-index: 100;">
            <h6 class="fw-bold mb-3 pb-2 border-bottom">Booking Price Breakdown</h6>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-secondary-custom">Monthly Room Rent:</span>
              <strong class="text-dark">₹<?= number_format($property['rent']) ?></strong>
            </div>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-secondary-custom">Security Deposit:</span>
              <strong class="text-dark">₹<?= number_format($property['deposit']) ?></strong>
            </div>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-secondary-custom">Wi-Fi & Maintenance:</span>
              <strong class="text-success">FREE (Included)</strong>
            </div>
            <div class="d-flex justify-content-between small mb-2">
              <span class="text-secondary-custom">Brokerage Fee:</span>
              <strong class="text-success">₹0 (Zero Brokerage)</strong>
            </div>
            <hr class="my-2">
            <div class="p-2.5 rounded-3 bg-soft-lavender border border-primary-subtle mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <strong class="small text-royal-blue">Payable Online Now (Token):</strong>
                <h5 class="fw-bold text-royal-blue mb-0">₹500</h5>
              </div>
              <span class="fs-xs text-muted">Locks bed availability immediately</span>
            </div>

            <div class="d-flex justify-content-between extra-small text-muted mb-4">
              <span>Balance at Move-in Check-in:</span>
              <strong>₹<?= number_format($property['rent'] + $property['deposit'] - 500) ?></strong>
            </div>

            <div class="p-3 bg-light rounded-3 border extra-small text-secondary-custom">
              <i class="fas fa-shield-halved text-success me-1"></i>
              <strong>100% Moneyback Guarantee:</strong> If the property host declines your application, your ₹500 token fee is automatically refunded back to your source account within 24 hours.
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
