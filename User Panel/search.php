<?php
// search.php - Accommodation Search & Discovery
$pageTitle = 'Find Accommodation - NeighborNest';
require_once __DIR__ . '/includes/functions.php';

// Initialize wishlist in session if not set
if (!isset($_SESSION['user_wishlist'])) {
  $_SESSION['user_wishlist'] = [];
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

// Get all properties from master dataset
$allProperties = getPropertiesData();

// Get filter values from URL
$searchQuery = trim($_GET['q'] ?? '');
$selectedCity = $_GET['city'] ?? 'Bangalore';
$selectedType = $_GET['type'] ?? 'all';
$selectedGender = $_GET['gender'] ?? 'all';
$maxBudget = isset($_GET['budget']) ? intval($_GET['budget']) : 35000;
$verifiedOnly = isset($_GET['verified']) && ($_GET['verified'] == '1' || $_GET['verified'] == 'true');
$sortBy = $_GET['sort'] ?? 'featured';

// Filter properties
$filteredProperties = array_filter($allProperties, function ($p) use ($searchQuery, $selectedCity, $selectedType, $selectedGender, $maxBudget, $verifiedOnly) {
  // City filter
  if ($selectedCity !== 'all' && strcasecmp($p['city'], $selectedCity) !== 0) return false;

  // Type filter
  if ($selectedType !== 'all' && $p['type'] !== $selectedType) return false;

  // Gender filter
  if ($selectedGender !== 'all' && $p['gender'] !== $selectedGender && $p['gender'] !== 'unisex') return false;

  // Budget filter
  if ($p['rent'] > $maxBudget) return false;

  // Verified only filter
  if ($verifiedOnly && empty($p['verified'])) return false;

  // Search query filter
  if (!empty($searchQuery)) {
    $q = strtolower($searchQuery);
    $matches = (stripos($p['title'], $q) !== false) ||
      (stripos($p['area'], $q) !== false) ||
      (stripos($p['type'], $q) !== false) ||
      (stripos($p['city'], $q) !== false);
    if (!$matches) return false;
  }

  return true;
});

// Sort logic
if ($sortBy === 'price_asc') {
  usort($filteredProperties, fn($a, $b) => $a['rent'] <=> $b['rent']);
} elseif ($sortBy === 'price_desc') {
  usort($filteredProperties, fn($a, $b) => $b['rent'] <=> $a['rent']);
} elseif ($sortBy === 'rating_desc') {
  usort($filteredProperties, fn($a, $b) => $b['rating'] <=> $a['rating']);
}
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <!-- Header Title & Stats -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Find Student Accommodations</h3>
        <span class="text-secondary-custom small">Search and discover verified PGs, hostels, and flats near your campus with zero brokerage</span>
      </div>

      <!-- View Switcher & Mobile Filter Button -->
      <div class="d-flex align-items-center gap-2 flex-wrap justify-content-start justify-content-md-end">
        <button class="btn btn-sm btn-nh-outline d-lg-none px-3" type="button" data-bs-toggle="collapse" data-bs-target="#mobileFilterCollapse" aria-expanded="false">
          <i class="fas fa-sliders me-1"></i> Filters
        </button>

        <div class="btn-group btn-group-sm bg-white p-1 rounded-pill border shadow-sm" role="group">
          <button type="button" class="btn btn-sm btn-outline-primary active rounded-pill px-2 px-sm-3" id="viewBtnGrid" onclick="switchView('grid')">
            <i class="fas fa-th-large me-1"></i> Grid
          </button>
          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 px-sm-3" id="viewBtnList" onclick="switchView('list')">
            <i class="fas fa-list me-1"></i> List
          </button>
          <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 px-sm-3" id="viewBtnMap" onclick="switchView('map')">
            <i class="fas fa-map-marked-alt me-1"></i> Map
          </button>
        </div>
      </div>
    </div>

    <!-- MOBILE COLLAPSIBLE FILTER PANEL -->
    <div class="collapse d-lg-none mb-4" id="mobileFilterCollapse">
      <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
        <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
          <h6 class="fw-bold mb-0"><i class="fas fa-sliders text-bright-indigo me-1"></i> Search Filters</h6>
          <a href="search.php" class="extra-small text-danger text-decoration-none fw-semibold">Reset</a>
        </div>
        <form action="search.php" method="GET">
          <?php if (!empty($searchQuery)): ?>
            <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>" />
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label extra-small fw-bold text-secondary mb-1">City Hub</label>
            <select name="city" class="form-select form-select-sm rounded-3">
              <option value="Bangalore" <?= ($selectedCity === 'Bangalore') ? 'selected' : '' ?>>Bangalore</option>
              <option value="Mumbai" <?= ($selectedCity === 'Mumbai') ? 'selected' : '' ?>>Mumbai</option>
              <option value="Delhi" <?= ($selectedCity === 'Delhi') ? 'selected' : '' ?>>Delhi / NCR</option>
              <option value="Pune" <?= ($selectedCity === 'Pune') ? 'selected' : '' ?>>Pune</option>
              <option value="Hyderabad" <?= ($selectedCity === 'Hyderabad') ? 'selected' : '' ?>>Hyderabad</option>
              <option value="Chennai" <?= ($selectedCity === 'Chennai') ? 'selected' : '' ?>>Chennai</option>
              <option value="all" <?= ($selectedCity === 'all') ? 'selected' : '' ?>>All Cities</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label extra-small fw-bold text-secondary mb-1">Accommodation Type</label>
            <select name="type" class="form-select form-select-sm rounded-3">
              <option value="all" <?= ($selectedType === 'all') ? 'selected' : '' ?>>All Types</option>
              <option value="PG" <?= ($selectedType === 'PG') ? 'selected' : '' ?>>Paying Guest (PG)</option>
              <option value="Hostel" <?= ($selectedType === 'Hostel') ? 'selected' : '' ?>>Student Hostel</option>
              <option value="Room" <?= ($selectedType === 'Room') ? 'selected' : '' ?>>Private Room</option>
              <option value="Apartment" <?= ($selectedType === 'Apartment') ? 'selected' : '' ?>>Flat / Apartment</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label extra-small fw-bold text-secondary mb-1">Gender Rule</label>
            <select name="gender" class="form-select form-select-sm rounded-3">
              <option value="all" <?= ($selectedGender === 'all') ? 'selected' : '' ?>>All Rules</option>
              <option value="male_only" <?= ($selectedGender === 'male_only') ? 'selected' : '' ?>>Boys Only</option>
              <option value="female_only" <?= ($selectedGender === 'female_only') ? 'selected' : '' ?>>Girls Only</option>
              <option value="unisex" <?= ($selectedGender === 'unisex') ? 'selected' : '' ?>>Unisex / Co-Living</option>
            </select>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
              <label class="form-label extra-small fw-bold text-secondary mb-0">Max Budget:</label>
              <span class="fw-bold text-royal-blue small">Ã¢â€šÂ¹<?= number_format($maxBudget) ?></span>
            </div>
            <input type="range" name="budget" min="5000" max="40000" step="1000" value="<?= $maxBudget ?>" class="form-range" />
          </div>
          <div class="form-check form-switch mb-3">
            <input class="form-check-input" type="checkbox" name="verified" value="1" id="mobileVerifiedSwitch" <?= $verifiedOnly ? 'checked' : '' ?>>
            <label class="form-check-label small fw-bold text-success" for="mobileVerifiedSwitch">
              <i class="fas fa-shield-halved me-1"></i> Verified Only
            </label>
          </div>
          <button type="submit" class="btn btn-nh-primary w-100 py-2">Apply Filters</button>
        </form>
      </div>
    </div>

    <div class="row g-4">
      <!-- LEFT FILTER PANEL (Desktop Sticky) -->
      <div class="col-lg-3 d-none d-lg-block">
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4 sticky-top" style="top: 85px; z-index: 100;">
          <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
            <h6 class="fw-bold mb-0"><i class="fas fa-sliders text-bright-indigo me-1"></i> Filters</h6>
            <a href="search.php" class="extra-small text-danger text-decoration-none fw-semibold">Reset All</a>
          </div>

          <form action="search.php" method="GET">
            <?php if (!empty($searchQuery)): ?>
              <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>" />
            <?php endif; ?>

            <!-- City Selection -->
            <div class="mb-3">
              <label class="form-label extra-small fw-bold text-secondary mb-1">City Hub</label>
              <select name="city" class="form-select form-select-sm rounded-3">
                <option value="Bangalore" <?= ($selectedCity === 'Bangalore') ? 'selected' : '' ?>>Bangalore</option>
                <option value="Mumbai" <?= ($selectedCity === 'Mumbai') ? 'selected' : '' ?>>Mumbai</option>
                <option value="Delhi" <?= ($selectedCity === 'Delhi') ? 'selected' : '' ?>>Delhi / NCR</option>
                <option value="Pune" <?= ($selectedCity === 'Pune') ? 'selected' : '' ?>>Pune</option>
                <option value="Hyderabad" <?= ($selectedCity === 'Hyderabad') ? 'selected' : '' ?>>Hyderabad</option>
                <option value="Chennai" <?= ($selectedCity === 'Chennai') ? 'selected' : '' ?>>Chennai</option>
                <option value="all" <?= ($selectedCity === 'all') ? 'selected' : '' ?>>All Cities</option>
              </select>
            </div>

            <!-- Property Type -->
            <div class="mb-3">
              <label class="form-label extra-small fw-bold text-secondary mb-1">Accommodation Type</label>
              <select name="type" class="form-select form-select-sm rounded-3">
                <option value="all" <?= ($selectedType === 'all') ? 'selected' : '' ?>>All Types</option>
                <option value="PG" <?= ($selectedType === 'PG') ? 'selected' : '' ?>>Paying Guest (PG)</option>
                <option value="Hostel" <?= ($selectedType === 'Hostel') ? 'selected' : '' ?>>Student Hostel</option>
                <option value="Room" <?= ($selectedType === 'Room') ? 'selected' : '' ?>>Private Room</option>
                <option value="Apartment" <?= ($selectedType === 'Apartment') ? 'selected' : '' ?>>Flat / Apartment</option>
              </select>
            </div>

            <!-- Gender Filter -->
            <div class="mb-3">
              <label class="form-label extra-small fw-bold text-secondary mb-1">Gender Rule</label>
              <select name="gender" class="form-select form-select-sm rounded-3">
                <option value="all" <?= ($selectedGender === 'all') ? 'selected' : '' ?>>All Rules</option>
                <option value="male_only" <?= ($selectedGender === 'male_only') ? 'selected' : '' ?>>Boys / Men Only</option>
                <option value="female_only" <?= ($selectedGender === 'female_only') ? 'selected' : '' ?>>Girls / Women Only</option>
                <option value="unisex" <?= ($selectedGender === 'unisex') ? 'selected' : '' ?>>Unisex / Co-Living</option>
              </select>
            </div>

            <!-- Budget Slider -->
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label class="form-label extra-small fw-bold text-secondary mb-0">Max Budget:</label>
                <span class="fw-bold text-royal-blue small" id="budgetLabel">Rs.<?= number_format($maxBudget) ?></span>
              </div>
              <input type="range" name="budget" min="5000" max="40000" step="1000" value="<?= $maxBudget ?>" class="form-range" oninput="document.getElementById('budgetLabel').innerText = 'Rs.' + parseInt(this.value).toLocaleString();" />
            </div>

            <!-- Verified Only Toggle -->
            <div class="form-check form-switch mb-4">
              <input class="form-check-input" type="checkbox" name="verified" value="1" id="verifiedSwitch" <?= $verifiedOnly ? 'checked' : '' ?>>
              <label class="form-check-label small fw-bold text-success" for="verifiedSwitch">
                <i class="fas fa-shield-halved me-1"></i> Verified Only
              </label>
            </div>

            <button type="submit" class="btn btn-nh-primary w-100 py-2">Apply Filters</button>
          </form>
        </div>
      </div>

      <!-- RIGHT RESULTS AREA -->
      <div class="col-lg-9">
        <!-- Results Bar & Sorting -->
        <div class="card border-0 rounded-4 shadow-sm bg-white p-3 mb-4">
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <span class="small fw-semibold text-dark">
              Showing <strong class="text-royal-blue"><?= count($filteredProperties) ?></strong> accommodations available
            </span>

            <div class="d-flex align-items-center gap-2 flex-wrap justify-content-start justify-content-md-end">
              <span class="extra-small text-secondary-custom d-none d-sm-inline flex-shrink-0">Sort by:</span>
              <form action="search.php" method="GET" id="sortForm" class="d-inline-block">
                <?php if (!empty($searchQuery)): ?>
                  <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>" />
                <?php endif; ?>
                <input type="hidden" name="city" value="<?= htmlspecialchars($selectedCity) ?>" />
                <input type="hidden" name="type" value="<?= htmlspecialchars($selectedType) ?>" />
                <input type="hidden" name="gender" value="<?= htmlspecialchars($selectedGender) ?>" />
                <input type="hidden" name="budget" value="<?= htmlspecialchars($maxBudget) ?>" />
                <?php if ($verifiedOnly): ?>
                  <input type="hidden" name="verified" value="1" />
                <?php endif; ?>
                <select name="sort" class="form-select form-select-sm rounded-pill px-3" onchange="this.form.submit()">
                  <option value="featured" <?= ($sortBy === 'featured') ? 'selected' : '' ?>>Featured First</option>
                  <option value="price_asc" <?= ($sortBy === 'price_asc') ? 'selected' : '' ?>>Lowest Rent First</option>
                  <option value="price_desc" <?= ($sortBy === 'price_desc') ? 'selected' : '' ?>>Highest Rent First</option>
                  <option value="rating_desc" <?= ($sortBy === 'rating_desc') ? 'selected' : '' ?>>Highest Rated First</option>
                </select>
              </form>
            </div>
          </div>
        </div>

        <!-- MAP CONTAINER (Hidden by default) -->
        <div id="searchMapContainer" class="card border-0 rounded-4 shadow-sm bg-white p-3 mb-4 d-none">
          <div id="searchLeafletMap" style="height: 420px; width: 100%; border-radius: 12px;"></div>
        </div>

        <!-- GRID VIEW CONTAINER -->
        <div id="searchGridContainer" class="row g-3 g-md-4 mb-4">
          <?php if (empty($filteredProperties)): ?>
            <div class="col-12 text-center py-5">
              <div class="card border-0 rounded-4 bg-soft-lavender p-5" style="max-width: 540px; margin: 0 auto;">
                <i class="fas fa-magnifying-glass-location text-bright-indigo display-4 mb-3"></i>
                <h5 class="fw-bold mb-1">No Matching Places Found</h5>
                <p class="text-secondary-custom small mb-4">Try widening your budget range, resetting gender preferences, or searching for all types.</p>
                <a href="search.php" class="btn btn-nh-primary btn-sm px-4" style="margin: 0 auto;">Reset Filters</a>
              </div>
            </div>
          <?php else: ?>
            <?php foreach ($filteredProperties as $item):
              $genderLabel = ($item['gender'] === 'male_only') ? 'Boys Only' : (($item['gender'] === 'female_only') ? 'Girls Only' : 'Unisex');
              $isWishlisted = in_array($item['id'], $_SESSION['user_wishlist'] ?? []);
            ?>
              <div class="col-sm-6 col-lg-4">
                <div class="property-card">
                  <div class="card-img-wrapper">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />
                    <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1">
                      <?php if (!empty($item['verified'])): ?>
                        <span class="badge bg-success small"><i class="fas fa-check-circle me-1"></i> Verified</span>
                      <?php endif; ?>
                      <span class="badge bg-primary small"><?= htmlspecialchars($item['type']) ?></span>
                      <span class="badge bg-dark small"><?= htmlspecialchars($genderLabel) ?></span>
                    </div>
                    <button class="btn btn-sm bg-white text-dark position-absolute top-0 end-0 m-2 rounded-circle shadow-sm border-0" onclick="toggleWishlist(<?= $item['id'] ?>, this)">
                      <i class="<?= $isWishlisted ? 'fas fa-heart text-danger' : 'far fa-heart' ?>"></i>
                    </button>
                  </div>

                  <div class="p-3 d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="extra-small text-secondary-custom fw-medium text-truncate" style="max-width: 60%;">
                        <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($item['area']) ?>
                      </span>
                      <span class="badge bg-warning text-dark extra-small flex-shrink-0">
                        <i class="fas fa-star me-1"></i> <?= htmlspecialchars($item['rating']) ?> (<?= $item['reviews_count'] ?? 0 ?>)
                      </span>
                    </div>

                    <h6 class="fw-bold mb-2 text-truncate" title="<?= htmlspecialchars($item['title']) ?>">
                      <a href="property-details.php?id=<?= $item['id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($item['title']) ?></a>
                    </h6>

                    <div class="d-flex flex-wrap gap-1 mb-2">
                      <?php foreach (array_slice($item['amenities'] ?? [], 0, 2) as $am): ?>
                        <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1"><i class="fas fa-check me-1 text-success"></i><?= htmlspecialchars($am) ?></span>
                      <?php endforeach; ?>
                      <?php if (count($item['amenities'] ?? []) > 2): ?>
                        <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1">+<?= count($item['amenities']) - 2 ?> more</span>
                      <?php endif; ?>
                    </div>

                    <div class="extra-small text-secondary-custom mb-3 text-truncate">
                      <i class="fas fa-route me-1 text-bright-indigo"></i> <?= htmlspecialchars($item['nearby'][0] ?? 'Close to transit') ?>
                    </div>

                    <div class="mt-auto pt-2 border-top d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                      <div>
                        <span class="extra-small text-secondary-custom d-block" style="line-height: 1;">Monthly Rent</span>
                        <strong class="text-royal-blue fs-5">Rs.<?= number_format($item['rent']) ?></strong>
                        <span class="extra-small text-secondary-custom">/mo</span>
                      </div>

                      <div class="d-flex align-items-center gap-2 ms-sm-auto">
                        <a href="compare.php?add=<?= $item['id'] ?>" class="btn btn-sm btn-light border p-2" title="Compare">
                          <i class="fas fa-scale-balanced text-secondary-custom"></i>
                        </a>
                        <a href="property-details.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-nh-primary px-3">
                          View Details
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- LIST VIEW CONTAINER (Hidden by default) -->
        <div id="searchListContainer" class="d-flex flex-column gap-3 mb-4 d-none">
          <?php foreach ($filteredProperties as $item):
            $genderLabel = ($item['gender'] === 'male_only') ? 'Boys Only' : (($item['gender'] === 'female_only') ? 'Girls Only' : 'Unisex');
            $isWishlisted = in_array($item['id'], $_SESSION['user_wishlist'] ?? []);
          ?>
            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden p-3 p-md-3">
              <div class="row g-3 align-items-stretch">
                <div class="col-md-4">
                  <div class="rounded-3 overflow-hidden position-relative h-100" style="min-height: 180px;">
                    <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-100 h-100" style="object-fit: cover;" />
                    <span class="badge bg-primary position-absolute top-0 start-0 m-2 small"><?= htmlspecialchars($item['type']) ?></span>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                    <span class="badge bg-warning text-dark extra-small"><i class="fas fa-star me-1"></i> <?= $item['rating'] ?></span>
                    <?php if (!empty($item['verified'])): ?><span class="badge bg-success extra-small">Verified</span><?php endif; ?>
                    <span class="extra-small text-secondary-custom"><i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($item['area']) ?></span>
                  </div>
                  <h5 class="fw-bold mb-2"><a href="property-details.php?id=<?= $item['id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($item['title']) ?></a></h5>
                  <p class="extra-small text-secondary-custom mb-2"><?= htmlspecialchars(substr($item['desc'] ?? '', 0, 110)) ?>...</p>
                  <div class="d-flex flex-wrap gap-1">
                    <?php foreach (array_slice($item['amenities'] ?? [], 0, 3) as $am): ?>
                      <span class="badge bg-soft-lavender text-royal-blue extra-small"><?= htmlspecialchars($am) ?></span>
                    <?php endforeach; ?>
                  </div>
                </div>
                <div class="col-md-3 text-md-end d-flex flex-column justify-content-between align-items-stretch align-items-md-end gap-2 border-start-md ps-md-3">
                  <span class="extra-small text-secondary-custom d-block">Starting from</span>
                  <h4 class="fw-bold text-royal-blue mb-1">Rs.<?= number_format($item['rent']) ?><span class="fs-xs fw-normal text-secondary-custom">/mo</span></h4>
                  <span class="extra-small text-muted d-block mb-3">Deposit: Rs.<?= number_format($item['deposit']) ?></span>
                  <div class="d-flex flex-column gap-2 w-100">
                    <a href="property-details.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-nh-primary w-100">View Details</a>
                    <a href="booking-request.php?property_id=<?= $item['id'] ?>" class="btn btn-sm btn-nh-outline w-100">Book Now</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <nav class="d-flex justify-content-center mt-4">
          <ul class="pagination pagination-sm">
            <li class="page-item disabled"><a class="page-link rounded-start-pill px-3" href="#">Previous</a></li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link rounded-end-pill px-3" href="#">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </main>

  <script>
    // Make properties data available to JavaScript
    var propertiesJson = <?= json_encode(array_values($filteredProperties)) ?>;
    var searchLeafletMap = null;
    var mapInitialized = false;

    /**
     * Switch between Grid, List, and Map views
     */
    function switchView(mode) {
      var gridView = document.getElementById("searchGridContainer");
      var listView = document.getElementById("searchListContainer");
      var mapView = document.getElementById("searchMapContainer");

      var btnGrid = document.getElementById("viewBtnGrid");
      var btnList = document.getElementById("viewBtnList");
      var btnMap = document.getElementById("viewBtnMap");

      // Reset all buttons
      if (btnGrid) btnGrid.classList.remove("active");
      if (btnList) btnList.classList.remove("active");
      if (btnMap) btnMap.classList.remove("active");

      // Hide all views
      if (gridView) gridView.classList.add("d-none");
      if (listView) listView.classList.add("d-none");
      if (mapView) mapView.classList.add("d-none");

      // Show selected view
      if (mode === 'grid') {
        if (gridView) gridView.classList.remove("d-none");
        if (btnGrid) btnGrid.classList.add("active");
      } else if (mode === 'list') {
        if (listView) listView.classList.remove("d-none");
        if (btnList) btnList.classList.add("active");
      } else if (mode === 'map') {
        if (mapView) mapView.classList.remove("d-none");
        if (btnMap) btnMap.classList.add("active");
        initSearchMap();
      }
    }

    /**
     * Initialize Leaflet Map
     */
    function initSearchMap() {
      if (mapInitialized) {
        setTimeout(function() {
          if (searchLeafletMap) {
            searchLeafletMap.invalidateSize();
          }
        }, 200);
        return;
      }

      if (typeof L === 'undefined') {
        console.warn('Leaflet library not loaded.');
        return;
      }

      try {
        searchLeafletMap = L.map('searchLeafletMap').setView([12.9716, 77.5946], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 18,
          attribution: 'Ã‚Â© OpenStreetMap contributors'
        }).addTo(searchLeafletMap);

        var bounds = [];
        var hasMarkers = false;

        propertiesJson.forEach(function(p) {
          if (p.lat && p.lng) {
            var marker = L.marker([p.lat, p.lng]).addTo(searchLeafletMap);
            marker.bindPopup(
              '<div style="font-family: sans-serif; min-width: 150px;">' +
              '<strong style="color: #4338CA;">' + p.title + '</strong><br/>' +
              '<strong>Ã¢â€šÂ¹' + p.rent.toLocaleString() + '/mo</strong> (' + p.type + ')<br/>' +
              '<small class="text-muted">' + p.area + '</small><br/>' +
              '<a href="property-details.php?id=' + p.id + '" style="display:inline-block; margin-top:6px; background:#4F46E5; color:#fff; padding:3px 8px; border-radius:12px; font-size:11px; text-decoration:none;">View Details</a>' +
              '</div>'
            );
            bounds.push([p.lat, p.lng]);
            hasMarkers = true;
          }
        });

        if (hasMarkers && bounds.length > 0) {
          searchLeafletMap.fitBounds(bounds, {
            padding: [50, 50]
          });
        }

        mapInitialized = true;
      } catch (e) {
        console.error('Error initializing map:', e);
      }
    }
  </script>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>