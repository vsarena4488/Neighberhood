<?php
// Owner Panel analytics.php - Performance Analytics & Insights
$pageTitle = 'Property Analytics · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

$properties = $_SESSION['owner_properties'] ?? [];

$pageTitle = 'Property Analytics · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    
    <!-- Header Title & Date Selector -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Property Performance & Analytics</h3>
        <span class="text-secondary-custom small">Detailed metrics on views, wishlist bookmarks, inquiries, conversion rates, and occupancy</span>
      </div>

      <div class="d-flex align-items-center gap-2">
        <select class="form-select form-select-sm rounded-pill px-3 py-1.5 extra-small border shadow-sm" style="width: auto;">
          <option value="month" selected>This Month (Aug 2026)</option>
          <option value="quarter">This Quarter (Q3 2026)</option>
          <option value="year">Full Year 2026</option>
        </select>
      </div>
    </div>

    <!-- 6 ANALYTICS METRIC CARDS -->
    <div class="row g-3 mb-4">
      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card p-3">
          <div>
            <span class="extra-small text-muted d-block">Page Views</span>
            <h4 class="fw-bold mb-0 text-dark">2,860</h4>
            <span class="fs-xs text-success"><i class="fas fa-arrow-up"></i> +14%</span>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card p-3">
          <div>
            <span class="extra-small text-muted d-block">Wishlist Count</span>
            <h4 class="fw-bold mb-0 text-dark">171</h4>
            <span class="fs-xs text-success"><i class="fas fa-arrow-up"></i> +8%</span>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card p-3">
          <div>
            <span class="extra-small text-muted d-block">Total Inquiries</span>
            <h4 class="fw-bold mb-0 text-dark">84</h4>
            <span class="fs-xs text-success"><i class="fas fa-arrow-up"></i> +22%</span>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card p-3">
          <div>
            <span class="extra-small text-muted d-block">Booking Requests</span>
            <h4 class="fw-bold mb-0 text-dark">18</h4>
            <span class="fs-xs text-success"><i class="fas fa-arrow-up"></i> +5%</span>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card p-3">
          <div>
            <span class="extra-small text-muted d-block">Conversion Rate</span>
            <h4 class="fw-bold mb-0 text-dark">6.3%</h4>
            <span class="fs-xs text-success"><i class="fas fa-arrow-up"></i> +1.2%</span>
          </div>
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="stat-card p-3">
          <div>
            <span class="extra-small text-muted d-block">Occupancy Rate</span>
            <h4 class="fw-bold mb-0 text-dark">88%</h4>
            <span class="fs-xs text-success"><i class="fas fa-circle-check"></i> High</span>
          </div>
        </div>
      </div>
    </div>

    <!-- PROPERTY COMPARISON PERFORMANCE TABLE -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
      <h5 class="fw-bold mb-3"><i class="fas fa-chart-column text-bright-indigo me-2"></i> Property Performance Comparison Matrix</h5>
      
      <div class="table-responsive">
        <table class="table table-hover align-middle extra-small mb-0">
          <thead class="table-light">
            <tr>
              <th>Property Name</th>
              <th>Type</th>
              <th>Total Views</th>
              <th>Wishlist Saves</th>
              <th>Available Beds</th>
              <th>Occupancy</th>
              <th class="text-end">Monthly Revenue</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($properties as $prop): ?>
              <tr>
                <td><strong class="text-dark d-block"><?= htmlspecialchars($prop['title']) ?></strong><span class="text-muted fs-xs"><?= htmlspecialchars($prop['area']) ?></span></td>
                <td><span class="badge bg-soft-lavender text-royal-blue"><?= htmlspecialchars($prop['type']) ?></span></td>
                <td><strong class="text-dark"><?= number_format($prop['views']) ?></strong></td>
                <td><span class="text-danger fw-semibold"><i class="fas fa-heart me-1"></i> <?= $prop['wishlist_count'] ?></span></td>
                <td><span class="badge bg-light text-dark border"><?= $prop['available_beds'] ?> / <?= $prop['total_rooms'] ?> Beds</span></td>
                <td>
                  <div class="d-flex align-items-center gap-2" style="width: 120px;">
                    <div class="progress flex-grow-1" style="height: 6px;"><div class="progress-bar bg-success" style="width: 85%;"></div></div>
                    <span class="fw-bold text-dark">85%</span>
                  </div>
                </td>
                <td class="text-end"><strong class="text-success fs-6">₹<?= number_format($prop['rent'] * 6) ?></strong></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
