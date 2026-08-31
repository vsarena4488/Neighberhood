<?php
require_once __DIR__ . '/includes/functions.php';

// Handle Wishlist Removal
if (isset($_GET['remove'])) {
    $remId = intval($_GET['remove']);
    $_SESSION['user_wishlist'] = array_values(array_diff($_SESSION['user_wishlist'], [$remId]));
}
if (isset($_GET['clear'])) {
    $_SESSION['user_wishlist'] = [];
}

$pageTitle = 'My Wishlist · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$allProperties = getPropertiesData();
$wishlistIds = $_SESSION['user_wishlist'] ?? [];
$wishlistItems = [];

foreach ($wishlistIds as $wid) {
    foreach ($allProperties as $p) {
        if ($p['id'] === $wid) {
            $wishlistItems[] = $p;
            break;
        }
    }
}
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">My Saved Wishlist (<?= count($wishlistItems) ?>)</h3>
        <span class="text-secondary-custom small">Accommodations you have shortlisted to compare and book</span>
      </div>

      <?php if (!empty($wishlistItems)): ?>
        <a href="wishlist.php?clear=1" class="btn btn-sm btn-light border text-danger px-3 shadow-sm" onclick="return confirm('Clear entire wishlist?');">
          <i class="fas fa-trash-can me-1"></i> Clear Wishlist
        </a>
      <?php endif; ?>
    </div>

    <?php if (empty($wishlistItems)): ?>
      <!-- EMPTY STATE SPECIFIED BY PRODUCT MANAGER -->
      <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-4">
        <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-danger" style="width: 76px; height: 76px; align-items: center; justify-content: center; font-size: 2.2rem;">
          <i class="fas fa-heart-crack"></i>
        </div>
        <h4 class="fw-bold mb-1">No Saved Properties Yet</h4>
        <p class="text-secondary-custom small mb-4 max-w-md mx-auto">
          Start exploring accommodations near your college or office and tap the heart icon to save your favorite rooms for easy comparison.
        </p>
        <a href="search.php" class="btn btn-nh-primary px-4 py-2 mx-auto">
          <i class="fas fa-magnifying-glass me-1"></i> Explore Accommodations
        </a>
      </div>
    <?php else: ?>
      <!-- Wishlist Grid -->
      <div class="row g-4">
        <?php foreach ($wishlistItems as $item): 
          $genderLabel = ($item['gender'] === 'male_only') ? 'Boys Only' : (($item['gender'] === 'female_only') ? 'Girls Only' : 'Unisex');
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="property-card">
              <div class="card-img-wrapper">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />
                <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1">
                  <?php if ($item['verified']): ?>
                    <span class="badge bg-success small"><i class="fas fa-check-circle me-1"></i> Verified</span>
                  <?php endif; ?>
                  <span class="badge bg-primary small"><?= htmlspecialchars($item['type']) ?></span>
                </div>
                <a href="wishlist.php?remove=<?= $item['id'] ?>" class="btn btn-sm bg-white text-danger position-absolute top-0 end-0 m-2 rounded-circle shadow-sm border-0" title="Remove from Wishlist">
                  <i class="fas fa-trash-can"></i>
                </a>
              </div>

              <div class="p-3 d-flex flex-column flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="extra-small text-secondary-custom fw-medium text-truncate">
                    <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($item['area']) ?>
                  </span>
                  <span class="badge bg-warning text-dark extra-small flex-shrink-0">
                    <i class="fas fa-star me-1"></i> <?= htmlspecialchars($item['rating']) ?>
                  </span>
                </div>

                <h6 class="fw-bold mb-2 text-truncate" title="<?= htmlspecialchars($item['title']) ?>">
                  <a href="property-details.php?id=<?= $item['id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($item['title']) ?></a>
                </h6>

                <div class="d-flex flex-wrap gap-1 mb-2">
                  <?php foreach (array_slice($item['amenities'], 0, 2) as $am): ?>
                    <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1"><?= htmlspecialchars($am) ?></span>
                  <?php endforeach; ?>
                </div>

                <div class="mt-auto pt-2.5 border-top d-flex align-items-center justify-content-between">
                  <div>
                    <span class="extra-small text-secondary-custom d-block">Monthly Rent</span>
                    <strong class="text-royal-blue fs-5">₹<?= number_format($item['rent']) ?></strong>
                    <span class="extra-small text-secondary-custom">/mo</span>
                  </div>

                  <div class="d-flex align-items-center gap-1.5 ms-auto">
                    <a href="booking-request.php?property_id=<?= $item['id'] ?>" class="btn btn-sm btn-nh-primary px-3">
                      Book Now
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
