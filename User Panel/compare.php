<?php
require_once __DIR__ . '/includes/functions.php';

// Handle Add/Remove in Compare List
if (isset($_GET['add'])) {
    $addId = intval($_GET['add']);
    if (!in_array($addId, $_SESSION['user_compare'])) {
        if (count($_SESSION['user_compare']) < 3) {
            $_SESSION['user_compare'][] = $addId;
        }
    }
}
if (isset($_GET['remove'])) {
    $remId = intval($_GET['remove']);
    $_SESSION['user_compare'] = array_values(array_diff($_SESSION['user_compare'], [$remId]));
}
if (isset($_GET['clear'])) {
    $_SESSION['user_compare'] = [];
}

$pageTitle = 'Compare Accommodations · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$allProperties = getPropertiesData();
$compareIds = $_SESSION['user_compare'] ?? [];
$comparedItems = [];

foreach ($compareIds as $cid) {
    foreach ($allProperties as $p) {
        if ($p['id'] === $cid) {
            $comparedItems[] = $p;
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
        <h3 class="fw-bold mb-1">Accommodation Comparison Matrix</h3>
        <span class="text-secondary-custom small">Compare side-by-side rent, deposits, amenities, food inclusions, and college distance (Max 3)</span>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="search.php" class="btn btn-sm btn-nh-outline px-3">
          <i class="fas fa-plus me-1"></i> Add More Places
        </a>
        <?php if (!empty($comparedItems)): ?>
          <a href="compare.php?clear=1" class="btn btn-sm btn-light border text-danger px-3">
            <i class="fas fa-trash-can me-1"></i> Clear All
          </a>
        <?php endif; ?>
      </div>
    </div>

    <?php if (empty($comparedItems)): ?>
      <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-4">
        <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-royal-blue" style="width: 70px; height: 70px; align-items: center; justify-content: center; font-size: 1.8rem;">
          <i class="fas fa-scale-balanced"></i>
        </div>
        <h4 class="fw-bold mb-1">No Accommodations in Compare List</h4>
        <p class="text-secondary-custom small mb-4 max-w-md mx-auto">Select 2 or 3 student PGs or flats to compare prices, distance to campus, and amenities side-by-side.</p>
        <a href="search.php" class="btn btn-nh-primary px-4 py-2 mx-auto">Explore Places to Compare</a>
      </div>
    <?php else: ?>
      <!-- Comparison Table Card -->
      <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden p-0 mb-4">
        <div class="table-responsive">
          <table class="table table-bordered align-middle text-center mb-0">
            <thead class="table-light">
              <tr>
                <th style="width: 22%; text-align: left; padding-left: 1.5rem;" class="text-secondary-custom">
                  Feature / Criteria
                  <div class="fs-xs fw-normal text-muted"><?= count($comparedItems) ?> of 3 selected</div>
                </th>
                <?php foreach ($comparedItems as $c): ?>
                  <th style="width: <?= round(78 / count($comparedItems)) ?>%; min-width: 220px;" class="p-3">
                    <div class="rounded-3 overflow-hidden mb-2 position-relative" style="height: 130px;">
                      <img src="<?= htmlspecialchars($c['image']) ?>" alt="<?= htmlspecialchars($c['title']) ?>" class="w-100 h-100 object-fit-cover" />
                      <span class="badge bg-primary position-absolute top-0 start-0 m-2 small"><?= htmlspecialchars($c['type']) ?></span>
                    </div>
                    <h6 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($c['title']) ?></h6>
                    <a href="compare.php?remove=<?= $c['id'] ?>" class="extra-small text-danger text-decoration-none fw-semibold">
                      <i class="fas fa-times-circle me-1"></i> Remove
                    </a>
                  </th>
                <?php endforeach; ?>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Monthly Rent</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="fw-bold text-royal-blue fs-5">₹<?= number_format($c['rent']) ?><span class="fs-xs fw-normal text-muted">/mo</span></td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Security Deposit</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="fw-semibold text-dark">₹<?= number_format($c['deposit']) ?></td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Location & Area</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td><i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($c['area']) ?>, <?= htmlspecialchars($c['city']) ?></td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Gender Rule</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="text-capitalize fw-medium"><?= str_replace('_', ' ', $c['gender']) ?></td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Rating & Reviews</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td><span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i> <?= $c['rating'] ?></span> (<?= $c['reviews_count'] ?> reviews)</td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Availability</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="text-success fw-bold"><?= htmlspecialchars($c['available_beds']) ?> Beds Available</td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Nearby Proximity</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="extra-small text-secondary-custom"><?= htmlspecialchars($c['nearby'][0] ?? 'Prime connectivity') ?></td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Key Amenities</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="extra-small text-start">
                    <div class="d-flex flex-wrap gap-1 justify-content-center">
                      <?php foreach (array_slice($c['amenities'], 0, 4) as $am): ?>
                        <span class="badge bg-soft-lavender text-royal-blue extra-small"><?= htmlspecialchars($am) ?></span>
                      <?php endforeach; ?>
                    </div>
                  </td>
                <?php endforeach; ?>
              </tr>
              <tr>
                <td class="fw-bold text-start ps-4 text-dark bg-light">Action</td>
                <?php foreach ($comparedItems as $c): ?>
                  <td class="p-3">
                    <div class="d-flex flex-column gap-2">
                      <a href="booking-request.php?property_id=<?= $c['id'] ?>" class="btn btn-sm btn-nh-primary py-1.5">Book Now (₹500 Token)</a>
                      <a href="property-details.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-nh-outline py-1">View Details</a>
                    </div>
                  </td>
                <?php endforeach; ?>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    <?php endif; ?>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
