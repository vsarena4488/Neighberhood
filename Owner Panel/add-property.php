<?php
// Owner Panel add-property.php - 7-Step Multi-Step Add Property Wizard
$pageTitle = 'Add New Property · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

$successMessage = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newId = rand(110, 999);
    $title = trim($_POST['title'] ?? 'New Executive Accommodation');
    $type = $_POST['type'] ?? 'PG';
    $area = $_POST['area'] ?? 'Koramangala 4th Block';
    $city = $_POST['city'] ?? 'Bangalore';
    $rent = intval($_POST['rent'] ?? 10000);
    $deposit = intval($_POST['deposit'] ?? 18000);
    $gender = $_POST['gender'] ?? 'male_only';
    $status = isset($_POST['save_draft']) ? 'Draft' : 'Pending Verification';

    $newProperty = [
        'id' => $newId,
        'title' => $title,
        'type' => $type,
        'city' => $city,
        'area' => $area,
        'rent' => $rent,
        'deposit' => $deposit,
        'gender' => $gender,
        'status' => $status,
        'rating' => 0.0,
        'reviews_count' => 0,
        'views' => 1,
        'wishlist_count' => 0,
        'available_beds' => 2,
        'total_rooms' => 6,
        'verified' => false,
        'image' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80',
        'gallery' => ['https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=800&q=80'],
        'amenities' => $_POST['amenities'] ?? ['High-Speed Wi-Fi', 'Daily Housekeeping', 'Geyser'],
        'rules' => ['Gate Curfew: 10:30 PM'],
        'room_options' => [
            ['name' => 'Standard Single Occupancy', 'occupancy' => 'Single', 'rent' => $rent, 'deposit' => $deposit, 'available' => 2, 'total' => 6]
        ]
    ];

    array_unshift($_SESSION['owner_properties'], $newProperty);
    header('Location: properties.php?added=1');
    exit;
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb extra-small mb-1">
            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="properties.php" class="text-decoration-none">My Properties</a></li>
            <li class="breadcrumb-item active">Add Property Listing</li>
          </ol>
        </nav>
        <h3 class="fw-bold mb-1">Add New Accommodation Listing</h3>
        <span class="text-secondary-custom small">Complete the quick 7-step wizard to list your PG, hostel, or rental flat</span>
      </div>
    </div>

    <!-- 7-STEP PROGRESS BAR INDICATOR -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-3.5 mb-4">
      <div class="d-flex justify-content-between align-items-center gap-2 extra-small text-muted fw-bold">
        <span id="stepTab1" class="text-primary"><i class="fas fa-1 me-1"></i> Basic Info</span>
        <span id="stepTab2"><i class="fas fa-2 me-1"></i> Location</span>
        <span id="stepTab3"><i class="fas fa-3 me-1"></i> Rooms & Rent</span>
        <span id="stepTab4"><i class="fas fa-4 me-1"></i> Amenities</span>
        <span id="stepTab5"><i class="fas fa-5 me-1"></i> House Rules</span>
        <span id="stepTab6"><i class="fas fa-6 me-1"></i> Photos</span>
        <span id="stepTab7"><i class="fas fa-7 me-1"></i> Preview & Submit</span>
      </div>
      <div class="progress mt-2" style="height: 6px;">
        <div class="progress-bar bg-primary" id="wizardProgressBar" style="width: 14%;"></div>
      </div>
    </div>

    <!-- WIZARD FORM CONTAINER -->
    <form action="add-property.php" method="POST" id="addPropertyForm">
      
      <!-- STEP 1: BASIC INFORMATION -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel" id="stepPanel1">
        <h5 class="fw-bold mb-3"><i class="fas fa-circle-info text-bright-indigo me-2"></i> Step 1: Basic Information</h5>
        <div class="row g-3">
          <div class="col-md-8">
            <label class="form-label small fw-bold text-secondary mb-1">Property Listing Title *</label>
            <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. St. Mark's Luxury Executive PG for Men" required />
          </div>
          <div class="col-md-4">
            <label class="form-label small fw-bold text-secondary mb-1">Accommodation Type *</label>
            <select name="type" class="form-select rounded-3" required>
              <option value="PG" selected>PG (Paying Guest)</option>
              <option value="Hostel">Student Hostel</option>
              <option value="Apartment">Independent Apartment / Flat</option>
              <option value="Room">Private Single Room</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Gender Restriction *</label>
            <select name="gender" class="form-select rounded-3" required>
              <option value="male_only" selected>Boys / Gents Only</option>
              <option value="female_only">Girls / Women Only</option>
              <option value="unisex">Unisex / All Genders Welcome</option>
            </select>
          </div>
        </div>
      </div>

      <!-- STEP 2: LOCATION DETAILS -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel d-none" id="stepPanel2">
        <h5 class="fw-bold mb-3"><i class="fas fa-location-dot text-bright-indigo me-2"></i> Step 2: Location & Address</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">City Hub *</label>
            <input type="text" name="city" class="form-control rounded-3" value="Bangalore" required />
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Neighborhood Area / Sector *</label>
            <input type="text" name="area" class="form-control rounded-3" placeholder="e.g. Koramangala 4th Block" required />
          </div>
          <div class="col-12">
            <label class="form-label small fw-bold text-secondary mb-1">Landmark Distance (Nearby College or Tech Park)</label>
            <input type="text" name="landmark" class="form-control rounded-3" placeholder="e.g. 0.8 km to Christ University, Forum Mall" />
          </div>
        </div>
      </div>

      <!-- STEP 3: ROOMS & PRICING -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel d-none" id="stepPanel3">
        <h5 class="fw-bold mb-3"><i class="fas fa-bed text-bright-indigo me-2"></i> Step 3: Room Options & Rent Pricing</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Monthly Rent Amount (₹) *</label>
            <input type="number" name="rent" class="form-control rounded-3" value="9500" required />
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Refundable Security Deposit (₹) *</label>
            <input type="number" name="deposit" class="form-control rounded-3" value="15000" required />
          </div>
          <div class="col-md-6">
            <label class="form-label small fw-bold text-secondary mb-1">Fixed Token Reservation Fee (₹)</label>
            <input type="text" class="form-control rounded-3 bg-light" value="₹500 (Standard Platform Token)" readonly />
          </div>
        </div>
      </div>

      <!-- STEP 4: AMENITIES GRID -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel d-none" id="stepPanel4">
        <h5 class="fw-bold mb-3"><i class="fas fa-list-check text-bright-indigo me-2"></i> Step 4: Included Amenities</h5>
        <div class="row g-3">
          <?php 
          $allAmenities = ['High-Speed Wi-Fi', '3-Time Meals', 'AC', 'Daily Housekeeping', 'Laundry', 'CCTV Security', 'Power Backup', 'Geyser', 'Study Table', 'RO Drinking Water', 'Biometric Entry', 'Gaming Lounge'];
          foreach ($allAmenities as $am): ?>
            <div class="col-6 col-md-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="amenities[]" value="<?= htmlspecialchars($am) ?>" id="am_<?= md5($am) ?>" checked />
                <label class="form-check-label extra-small text-dark fw-semibold" for="am_<?= md5($am) ?>">
                  <?= htmlspecialchars($am) ?>
                </label>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- STEP 5: HOUSE RULES -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel d-none" id="stepPanel5">
        <h5 class="fw-bold mb-3"><i class="fas fa-shield-halved text-bright-indigo me-2"></i> Step 5: House Rules & Guidelines</h5>
        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary mb-1">Curfew & Gate Timings</label>
          <input type="text" name="rules[]" class="form-control rounded-3" value="Gate Curfew: 10:30 PM (Digital intimation required for late returns)" />
        </div>
        <div class="mb-3">
          <label class="form-label small fw-bold text-secondary mb-1">Visitor Policy</label>
          <input type="text" name="rules[]" class="form-control rounded-3" value="Visitors allowed in common lounge until 8:00 PM" />
        </div>
      </div>

      <!-- STEP 6: PHOTO GALLERY -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel d-none" id="stepPanel6">
        <h5 class="fw-bold mb-3"><i class="fas fa-images text-bright-indigo me-2"></i> Step 6: Property Gallery Photos</h5>
        <div class="p-4 border border-2 border-dashed rounded-4 text-center bg-light">
          <i class="fas fa-cloud-arrow-up fs-2 text-primary mb-2"></i>
          <h6 class="fw-bold mb-1">Drag and drop high quality property photos here</h6>
          <span class="extra-small text-muted d-block mb-3">Upload exterior, room interior, washroom, and dining hall photos (JPG, PNG)</span>
          <input type="file" class="form-control max-w-sm mx-auto rounded-3" multiple />
        </div>
      </div>

      <!-- STEP 7: PREVIEW & SUBMIT -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 wizard-step-panel d-none" id="stepPanel7">
        <h5 class="fw-bold mb-3"><i class="fas fa-check-circle text-success me-2"></i> Step 7: Final Preview & Submit</h5>
        <p class="small text-secondary-custom mb-3">Please review your accommodation listing details before submitting for verified host publication.</p>
        <div class="p-3 bg-soft-lavender rounded-3 border border-primary-subtle extra-small text-royal-blue">
          <i class="fas fa-shield-check me-1"></i> Your listing will be reviewed by NeighborNest verification team within 24 hours.
        </div>
      </div>

      <!-- NAVIGATION & SAVE DRAFT CONTROLS -->
      <div class="d-flex justify-content-between align-items-center gap-2">
        <button type="button" class="btn btn-light border px-4" id="prevBtn" onclick="navigateStep(-1)" disabled>
          <i class="fas fa-arrow-left me-1"></i> Previous
        </button>

        <div class="d-flex gap-2">
          <button type="submit" name="save_draft" value="1" class="btn btn-light border px-3 text-secondary">
            <i class="fas fa-floppy-disk me-1"></i> Save Draft
          </button>
          <button type="button" class="btn btn-nh-primary px-4" id="nextBtn" onclick="navigateStep(1)">
            Next Step <i class="fas fa-arrow-right ms-1"></i>
          </button>
          <button type="submit" name="submit_final" value="1" class="btn btn-success text-white px-4 d-none" id="submitBtn">
            <i class="fas fa-check-circle me-1"></i> Submit Property Listing
          </button>
        </div>
      </div>

    </form>
  </main>

<script>
  let currentStep = 1;
  const totalSteps = 7;

  function navigateStep(direction) {
    const activePanel = document.getElementById('stepPanel' + currentStep);
    if (activePanel) activePanel.classList.add('d-none');

    const activeTab = document.getElementById('stepTab' + currentStep);
    if (activeTab) activeTab.classList.remove('text-primary', 'fw-bold');

    currentStep += direction;
    if (currentStep < 1) currentStep = 1;
    if (currentStep > totalSteps) currentStep = totalSteps;

    const nextPanel = document.getElementById('stepPanel' + currentStep);
    if (nextPanel) nextPanel.classList.remove('d-none');

    const nextTab = document.getElementById('stepTab' + currentStep);
    if (nextTab) nextTab.classList.add('text-primary', 'fw-bold');

    const progressBar = document.getElementById('wizardProgressBar');
    if (progressBar) progressBar.style.width = ((currentStep / totalSteps) * 100) + '%';

    document.getElementById('prevBtn').disabled = (currentStep === 1);
    
    if (currentStep === totalSteps) {
      document.getElementById('nextBtn').classList.add('d-none');
      document.getElementById('submitBtn').classList.remove('d-none');
    } else {
      document.getElementById('nextBtn').classList.remove('d-none');
      document.getElementById('submitBtn').classList.add('d-none');
    }
  }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
