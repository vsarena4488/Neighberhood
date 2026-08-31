<?php
require_once __DIR__ . '/includes/functions.php';

$id = intval($_GET['id'] ?? 101);
$allProperties = getPropertiesData();
$property = null;
foreach ($allProperties as $p) {
    if ($p['id'] === $id) {
        $property = $p;
        break;
    }
}
if (!$property) {
    $property = $allProperties[0]; // fallback
}

$pageTitle = $property['title'] . ' · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$isWishlisted = in_array($property['id'], $_SESSION['user_wishlist'] ?? []);
$isCompared = in_array($property['id'], $_SESSION['user_compare'] ?? []);
$genderLabel = ($property['gender'] === 'male_only') ? 'Boys Only' : (($property['gender'] === 'female_only') ? 'Girls Only' : 'Unisex / Family');
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <!-- Breadcrumb & Top Action Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb extra-small mb-1">
            <li class="breadcrumb-item"><a href="dashboard.php" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="search.php" class="text-decoration-none">Search Places</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($property['area']) ?></li>
          </ol>
        </nav>
        <h3 class="fw-bold mb-1"><?= htmlspecialchars($property['title']) ?></h3>
        <span class="text-secondary-custom small"><i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($property['area']) ?>, <?= htmlspecialchars($property['city']) ?></span>
      </div>

      <!-- Quick Action Buttons -->
      <div class="d-flex align-items-center gap-2">
        <button class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm" onclick="toggleWishlist(<?= $property['id'] ?>, this)">
          <i class="<?= $isWishlisted ? 'fas fa-heart text-danger' : 'far fa-heart' ?> me-1"></i> <?= $isWishlisted ? 'Saved' : 'Wishlist' ?>
        </button>
        <a href="compare.php?add=<?= $property['id'] ?>" class="btn btn-sm btn-light border rounded-pill px-3 shadow-sm">
          <i class="fas fa-scale-balanced me-1 text-primary"></i> <?= $isCompared ? 'In Compare' : 'Compare' ?>
        </a>
        <a href="booking-request.php?property_id=<?= $property['id'] ?>" class="btn btn-sm btn-nh-primary px-4 shadow-sm">
          <i class="fas fa-calendar-check me-1"></i> Request Booking
        </a>
      </div>
    </div>

    <!-- GALLERY & HERO MEDIA -->
    <div class="row g-3 mb-4">
      <div class="col-lg-8">
        <div class="rounded-4 overflow-hidden shadow-sm position-relative" style="height: 380px;">
          <img id="mainGalleryImage" src="<?= htmlspecialchars($property['image']) ?>" alt="<?= htmlspecialchars($property['title']) ?>" class="w-100 h-100 object-fit-cover" />
          <div class="position-absolute top-0 start-0 m-3 d-flex gap-2">
            <?php if ($property['verified']): ?>
              <span class="badge bg-success rounded-pill px-3 py-2"><i class="fas fa-certificate me-1"></i> Verified Property</span>
            <?php endif; ?>
            <span class="badge bg-dark rounded-pill px-3 py-2"><?= htmlspecialchars($genderLabel) ?></span>
          </div>
        </div>
      </div>
      <div class="col-lg-4 d-flex flex-column gap-3">
        <?php foreach (array_slice($property['gallery'], 1, 2) as $img): ?>
          <div class="rounded-4 overflow-hidden shadow-sm flex-grow-1" style="height: 180px; cursor: pointer;" onclick="document.getElementById('mainGalleryImage').src = '<?= htmlspecialchars($img) ?>'">
            <img src="<?= htmlspecialchars($img) ?>" alt="Gallery item" class="w-100 h-100 object-fit-cover" />
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="row g-4">
      <!-- LEFT CONTENT COLUMN -->
      <div class="col-lg-8">
        <!-- Quick Highlights Badges -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <div class="row g-3 text-center">
            <div class="col-4 border-end">
              <span class="extra-small text-secondary-custom d-block">Monthly Starting Rent</span>
              <h4 class="fw-bold text-royal-blue mb-0">₹<?= number_format($property['rent']) ?></h4>
              <span class="fs-xs text-muted">Inclusive of Wi-Fi</span>
            </div>
            <div class="col-4 border-end">
              <span class="extra-small text-secondary-custom d-block">Security Deposit</span>
              <h4 class="fw-bold text-dark mb-0">₹<?= number_format($property['deposit']) ?></h4>
              <span class="fs-xs text-success">100% Refundable</span>
            </div>
            <div class="col-4">
              <span class="extra-small text-secondary-custom d-block">Current Availability</span>
              <h4 class="fw-bold text-success mb-0"><?= htmlspecialchars($property['available_beds']) ?> Beds</h4>
              <span class="fs-xs text-muted">Immediate Move-in</span>
            </div>
          </div>
        </div>

        <!-- Description -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-align-left text-bright-indigo me-2"></i> About This Accommodation</h5>
          <p class="text-secondary-custom small leading-relaxed mb-0"><?= nl2br(htmlspecialchars($property['desc'])) ?></p>
        </div>

        <!-- Room Options & Occupancy Table -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-bed text-bright-indigo me-2"></i> Available Room Options & Pricing</h5>
          <div class="table-responsive">
            <table class="table table-bordered align-middle small mb-0">
              <thead class="table-light">
                <tr>
                  <th>Room Type</th>
                  <th>Occupancy</th>
                  <th>Monthly Rent</th>
                  <th>Deposit</th>
                  <th>Availability</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($property['room_options'] as $room): ?>
                  <tr>
                    <td class="fw-bold text-dark"><?= htmlspecialchars($room['name']) ?></td>
                    <td><span class="badge bg-soft-lavender text-royal-blue"><?= htmlspecialchars($room['occupancy']) ?></span></td>
                    <td class="fw-bold text-royal-blue">₹<?= number_format($room['rent']) ?>/mo</td>
                    <td>₹<?= number_format($room['deposit']) ?></td>
                    <td>
                      <span class="badge <?= ($room['status'] === 'Available') ? 'bg-success' : 'bg-secondary' ?>">
                        <?= htmlspecialchars($room['status']) ?>
                      </span>
                    </td>
                    <td class="text-end">
                      <?php if ($room['status'] === 'Available'): ?>
                        <a href="booking-request.php?property_id=<?= $property['id'] ?>&room=<?= urlencode($room['name']) ?>" class="btn btn-sm btn-nh-primary py-1 px-3">Select</a>
                      <?php else: ?>
                        <button class="btn btn-sm btn-light disabled py-1 px-3" disabled>Sold Out</button>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Amenities & Facilities -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-circle-check text-bright-indigo me-2"></i> Included Amenities & Facilities</h5>
          <div class="row g-2">
            <?php foreach ($property['amenities'] as $am): ?>
              <div class="col-sm-6 col-md-4">
                <div class="p-2.5 bg-soft-lavender rounded-3 border border-primary-subtle d-flex align-items-center gap-2 extra-small text-royal-blue fw-semibold">
                  <i class="fas fa-check-circle text-success fs-6"></i>
                  <span><?= htmlspecialchars($am) ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- House Rules -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-clipboard-list text-bright-indigo me-2"></i> Accommodation Rules & Curfew</h5>
          <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small text-secondary-custom">
            <?php foreach ($property['rules'] as $rule): ?>
              <li class="d-flex align-items-start gap-2">
                <i class="fas fa-shield-halved text-success mt-1"></i>
                <span><?= htmlspecialchars($rule) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <!-- Location & Nearby Distance Markers -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <h5 class="fw-bold mb-3"><i class="fas fa-map-location-dot text-bright-indigo me-2"></i> Location & Key Proximity Markers</h5>
          <div id="propertySingleMap" style="height: 250px; border-radius: 12px; margin-bottom: 1.25rem;"></div>
          <div class="row g-2">
            <?php foreach ($property['nearby'] as $nb): ?>
              <div class="col-md-6">
                <div class="p-2.5 bg-light rounded-3 d-flex align-items-center gap-2 extra-small text-secondary-custom">
                  <i class="fas fa-route text-bright-indigo fs-6"></i>
                  <span><?= htmlspecialchars($nb) ?></span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Student Reviews -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-star text-warning me-2"></i> Tenant & Student Reviews (<?= $property['reviews_count'] ?>)</h5>
            <span class="badge bg-warning text-dark px-3 py-2 fw-bold"><i class="fas fa-star me-1"></i> <?= $property['rating'] ?> / 5.0</span>
          </div>

          <div class="d-flex flex-column gap-3">
            <div class="p-3 bg-light rounded-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="d-flex align-items-center gap-2">
                  <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 11px;">AR</div>
                  <strong class="small text-dark">Ananya Rao (Christ University)</strong>
                </div>
                <span class="extra-small text-muted">2 months ago</span>
              </div>
              <div class="text-warning extra-small mb-1"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i> 5.0</div>
              <p class="extra-small text-secondary-custom mb-0">"The food is home-cooked and hygienic. Wi-Fi speed never drops during online exams. Very safe environment!"</p>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT SIDEBAR BOOKING & OWNER CARD -->
      <div class="col-lg-4">
        <!-- Sticky Booking Summary Box -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4 sticky-top" style="top: 85px; z-index: 100;">
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <div>
              <span class="extra-small text-secondary-custom d-block">Starting from</span>
              <h3 class="fw-bold text-royal-blue mb-0">₹<?= number_format($property['rent']) ?><span class="fs-xs fw-normal text-secondary-custom">/mo</span></h3>
            </div>
            <span class="badge bg-success px-3 py-2 rounded-pill">Zero Brokerage</span>
          </div>

          <!-- Token Booking Fee Notice -->
          <div class="p-3 rounded-3 bg-soft-lavender border border-primary-subtle mb-3">
            <div class="d-flex align-items-center gap-2 mb-1">
              <i class="fas fa-lock text-bright-indigo"></i>
              <strong class="small text-royal-blue">Two-Stage Safe Booking</strong>
            </div>
            <p class="fs-xs text-secondary-custom mb-0">
              Pay just <strong>₹500 token fee</strong> online to lock this room now. Pay your first month's rent & deposit at check-in.
            </p>
          </div>

          <div class="d-grid gap-2 mb-4">
            <a href="booking-request.php?property_id=<?= $property['id'] ?>" class="btn btn-nh-primary py-2.5">
              <i class="fas fa-bolt me-1"></i> Instant Booking Request
            </a>
            <a href="messages.php?property_id=<?= $property['id'] ?>" class="btn btn-nh-outline py-2">
              <i class="fas fa-comment-dots me-1"></i> Chat with Landlord
            </a>
          </div>

          <!-- Verified Owner Card -->
          <div class="border-top pt-3">
            <span class="extra-small text-muted text-uppercase fw-bold mb-2 d-block">Property Host / Owner</span>
            <div class="d-flex align-items-center gap-3 mb-3">
              <img src="<?= htmlspecialchars($property['owner']['avatar']) ?>" alt="<?= htmlspecialchars($property['owner']['name']) ?>" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" />
              <div>
                <h6 class="fw-bold mb-0"><?= htmlspecialchars($property['owner']['name']) ?></h6>
                <span class="extra-small text-success"><i class="fas fa-check-circle me-1"></i> Govt ID Verified Host</span>
                <span class="extra-small text-muted d-block"><?= $property['owner']['properties_listed'] ?> Listed Places · Member since <?= $property['owner']['member_since'] ?></span>
              </div>
            </div>
            <a href="tel:<?= $property['owner']['phone'] ?>" class="btn btn-sm btn-light w-100 border text-secondary-custom">
              <i class="fas fa-phone me-1 text-primary"></i> Call: <?= htmlspecialchars($property['owner']['phone']) ?>
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const lat = <?= $property['lat'] ?>;
    const lng = <?= $property['lng'] ?>;
    
    if (document.getElementById("propertySingleMap")) {
      const pMap = L.map('propertySingleMap').setView([lat, lng], 14);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap'
      }).addTo(pMap);

      L.marker([lat, lng]).addTo(pMap)
        .bindPopup("<strong><?= addslashes($property['title']) ?></strong><br/><?= addslashes($property['area']) ?>")
        .openPopup();
    }
  });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
