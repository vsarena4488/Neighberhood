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
              <!-- Image Wrapper -->
              <div class="card-image-wrapper">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />

                <!-- Badges - Top Left -->
                <div class="card-badges">
                  <?php if (!empty($item['verified'])): ?>
                    <span class="badge-tag badge-verified">
                      <i class="fas fa-check-circle"></i> Verified
                    </span>
                  <?php endif; ?>
                  <span class="badge-tag badge-type"><?= htmlspecialchars($item['type']) ?></span>
                  <span class="badge-tag badge-gender"><?= htmlspecialchars($genderLabel) ?></span>
                </div>

                <!-- Remove from Wishlist Button - Top Right -->
                <a href="wishlist.php?remove=<?= $item['id'] ?>" class="btn-wishlist text-danger" title="Remove from Wishlist" aria-label="Remove from Wishlist">
                  <i class="fas fa-trash-can"></i>
                </a>
              </div>

              <!-- Card Body -->
              <div class="card-body">
                <!-- Location & Rating -->
                <div class="card-top-row">
                  <span class="card-location">
                    <i class="fas fa-location-dot"></i> <?= htmlspecialchars($item['area']) ?>
                  </span>
                  <span class="card-rating">
                    <i class="fas fa-star"></i> <?= htmlspecialchars($item['rating']) ?> <span class="rating-count">(<?= $item['reviews_count'] ?? 0 ?>)</span>
                  </span>
                </div>

                <!-- Title -->
                <h3 class="card-title">
                  <a href="property-details.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['title']) ?></a>
                </h3>

                <!-- Amenities -->
                <div class="card-amenities">
                  <?php foreach (array_slice($item['amenities'] ?? [], 0, 2) as $am): ?>
                    <span class="amenity-pill"><i class="fas fa-check"></i> <?= htmlspecialchars($am) ?></span>
                  <?php endforeach; ?>
                  <?php if (count($item['amenities'] ?? []) > 2): ?>
                    <span class="amenity-pill more">+<?= count($item['amenities']) - 2 ?> more</span>
                  <?php endif; ?>
                </div>

                <!-- Nearby -->
                <div class="card-nearby">
                  <i class="fas fa-route"></i> <?= htmlspecialchars($item['nearby'][0] ?? 'Prime location') ?>
                </div>

                <!-- Footer: Price + Actions -->
                <div class="card-footer-row">
                  <div class="card-price">
                    <span class="price-label">Monthly Rent</span>
                    <span class="price-amount">
                      ₹<?= number_format($item['rent']) ?> <span class="price-period">/month</span>
                    </span>
                    <span class="price-deposit">Deposit: ₹<?= number_format($item['deposit'] ?? ($item['rent'] * 2)) ?></span>
                  </div>

                  <div class="card-actions">
                    <a href="compare.php?add=<?= $item['id'] ?>" class="btn-compare" title="Compare Property">
                      <i class="fas fa-scale-balanced"></i>
                    </a>
                    <a href="property-details.php?id=<?= $item['id'] ?>" class="btn-view-details">
                      View Details <i class="fas fa-arrow-right"></i>
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