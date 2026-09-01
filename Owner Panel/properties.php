<?php
// Owner Panel properties.php - My Properties Management
$pageTitle = 'My Properties · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

// Handle property deletion / status toggle
if (isset($_GET['delete'])) {
  $delId = intval($_GET['delete']);
  $_SESSION['owner_properties'] = array_values(array_filter($_SESSION['owner_properties'], fn($p) => $p['id'] !== $delId));
  header('Location: properties.php?deleted=1');
  exit;
}

$pageTitle = 'My Listed Properties · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$filterStatus = $_GET['status'] ?? 'all';
$properties = $_SESSION['owner_properties'] ?? [];

$filteredProperties = array_filter($properties, function ($p) use ($filterStatus) {
  if ($filterStatus === 'all') return true;
  return (strcasecmp($p['status'], $filterStatus) === 0);
});
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- Page Header & Action CTA -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">My Listed Properties (<?= count($properties) ?>)</h3>
        <span class="text-secondary-custom small">Manage your accommodations, occupancy rates, pricing, and verification status</span>
      </div>

      <a href="add-property.php" class="btn btn-nh-primary px-4 py-2 shadow-sm">
        <i class="fas fa-plus me-1"></i> Add New Property Listing
      </a>
    </div>



    <!-- Status Tabs Navigation Bar -->
    <div class="d-flex flex-wrap gap-2 mb-4 p-2 bg-white rounded-pill border shadow-sm w-100 overflow-x-auto">
      <a href="properties.php?status=all" class="btn btn-sm <?= ($filterStatus === 'all') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 py-1.5 fw-semibold text-nowrap">
        All Listed (<?= count($properties) ?>)
      </a>
      <a href="properties.php?status=Active" class="btn btn-sm <?= ($filterStatus === 'Active') ? 'btn-success text-white' : 'btn-light' ?> rounded-pill px-3 py-1.5 fw-semibold text-nowrap">
        Active (<?= count(array_filter($properties, fn($p) => $p['status'] === 'Active')) ?>)
      </a>
      <a href="properties.php?status=Pending Verification" class="btn btn-sm <?= ($filterStatus === 'Pending Verification') ? 'btn-warning text-dark' : 'btn-light' ?> rounded-pill px-3 py-1.5 fw-semibold text-nowrap">
        Pending Verification (<?= count(array_filter($properties, fn($p) => $p['status'] === 'Pending Verification')) ?>)
      </a>
      <a href="properties.php?status=Draft" class="btn btn-sm <?= ($filterStatus === 'Draft') ? 'btn-secondary' : 'btn-light' ?> rounded-pill px-3 py-1.5 fw-semibold text-nowrap">
        Drafts (<?= count(array_filter($properties, fn($p) => $p['status'] === 'Draft')) ?>)
      </a>
    </div>

    <!-- Properties Grid -->
    <div class="row g-4">
      <?php if (empty($filteredProperties)): ?>
        <div class="col-12">
          <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-3">
            <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-royal-blue" style="width: 76px; height: 76px; align-items: center; justify-content: center; font-size: 2rem;">
              <i class="fas fa-city"></i>
            </div>
            <h5 class="fw-bold mb-1">No Properties Found</h5>
            <p class="text-secondary-custom small mb-4 mx-auto" style="max-width: 460px;">You currently have no listed properties under "<?= htmlspecialchars($filterStatus) ?>". Create a new accommodation listing to reach thousands of student tenants.</p>
            <a href="add-property.php" class="btn btn-nh-primary px-4 py-2 mx-auto">
              <i class="fas fa-plus me-1"></i> Add Property Listing
            </a>
          </div>
        </div>
      <?php else: ?>
        <?php foreach ($filteredProperties as $item):
          $statusLower = strtolower($item['status']);
          $statusClass = ($statusLower === 'active') ? 'active' : (($statusLower === 'draft') ? 'inactive' : 'pending');
          $occupiedCount = max(0, $item['total_rooms'] - $item['available_beds']);
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="property-card">

              <!-- Image Wrapper -->
              <div class="card-image-wrapper">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />

                <!-- Badges -->
                <div class="card-badges">
                  <?php if (!empty($item['verified'])): ?>
                    <span class="badge-tag badge-verified">
                      <i class="fas fa-check-circle"></i> Verified
                    </span>
                  <?php endif; ?>
                  <span class="badge-tag badge-type"><?= htmlspecialchars($item['type']) ?></span>
                  <span class="badge-tag badge-status <?= $statusClass ?>">
                    <i class="fas fa-circle me-1" style="font-size: 8px;"></i> <?= htmlspecialchars($item['status']) ?>
                  </span>
                </div>
              </div>

              <!-- Card Body -->
              <div class="card-body">

                <!-- Location & Rating -->
                <div class="card-top-row">
                  <span class="card-location">
                    <i class="fas fa-location-dot"></i> <?= htmlspecialchars($item['area']) ?>
                  </span>
                  <span class="card-rating">
                    <i class="fas fa-star"></i> <?= $item['rating'] ?> <span class="rating-count">(<?= $item['reviews_count'] ?>)</span>
                  </span>
                </div>

                <!-- Title -->
                <h3 class="card-title" title="<?= htmlspecialchars($item['title']) ?>">
                  <a href="javascript:void(0)" onclick="alert('Viewing property #<?= $item['id'] ?> details')"><?= htmlspecialchars($item['title']) ?></a>
                </h3>

                <!-- Metrics: Rooms, Occupancy, Availability -->
                <div class="card-metrics">
                  <span class="metric-item">
                    <i class="fas fa-bed"></i>
                    <strong><?= $item['total_rooms'] ?></strong> Rooms
                  </span>
                  <span class="metric-item">
                    <i class="fas fa-users"></i>
                    <strong><?= $occupiedCount ?></strong> Occupied
                  </span>
                  <span class="metric-item">
                    <i class="fas fa-door-open"></i>
                    <strong><?= $item['available_beds'] ?></strong> Available
                  </span>
                </div>

                <!-- Rent & Highlighted Deposit (87% Occupancy Removed as requested) -->
                <div class="card-pricing">
                  <div class="price-block">
                    <span class="price-label">Monthly Rent</span>
                    <span class="price-amount">
                      ₹<?= number_format($item['rent']) ?> <span class="price-period">/month</span>
                    </span>
                  </div>

                  <!-- Highlighted Deposit Tag -->
                  <div class="price-deposit-highlight" title="Security Deposit Amount">
                    <i class="fas fa-shield-halved text-primary"></i> Deposit: ₹<?= number_format($item['deposit']) ?>
                  </div>
                </div>

                <!-- Action Buttons (Owner Specific) -->
                <div class="card-actions">
                  <a href="javascript:void(0)" class="btn-action btn-view" onclick="alert('Viewing listing #<?= $item['id'] ?>')">
                    <i class="fas fa-eye"></i> View
                  </a>
                  <a href="javascript:void(0)" class="btn-action btn-edit" onclick="alert('Editing listing #<?= $item['id'] ?>')">
                    <i class="fas fa-pen"></i> Edit
                  </a>
                  <a href="javascript:void(0)" class="btn-action btn-manage" onclick="alert('Managing rooms for listing #<?= $item['id'] ?>')">
                    <i class="fas fa-door-open"></i> Rooms
                  </a>
                  <a href="properties.php?delete=<?= $item['id'] ?>" class="btn-action btn-delete" title="Delete Property Listing" onclick="return confirm('Delete this property permanently?');">
                    <i class="fas fa-trash-alt"></i>
                  </a>
                </div>

              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>