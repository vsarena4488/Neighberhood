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

$filteredProperties = array_filter($properties, function($p) use ($filterStatus) {
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

      <a href="add-property.php" class="btn btn-nh-primary px-3.5 py-2 shadow-sm">
        <i class="fas fa-plus me-1"></i> Add New Accommodation Listing
      </a>
    </div>

    <!-- Status Tabs Navigation Bar -->
    <div class="d-flex flex-wrap gap-2 mb-4 p-1.5 bg-white rounded-pill border shadow-sm" style="width: fit-content;">
      <a href="properties.php?status=all" class="btn btn-sm <?= ($filterStatus === 'all') ? 'btn-primary' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        All Listed (<?= count($properties) ?>)
      </a>
      <a href="properties.php?status=Active" class="btn btn-sm <?= ($filterStatus === 'Active') ? 'btn-success text-white' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Active (<?= count(array_filter($properties, fn($p) => $p['status'] === 'Active')) ?>)
      </a>
      <a href="properties.php?status=Pending Verification" class="btn btn-sm <?= ($filterStatus === 'Pending Verification') ? 'btn-warning text-dark' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
        Pending Verification (<?= count(array_filter($properties, fn($p) => $p['status'] === 'Pending Verification')) ?>)
      </a>
      <a href="properties.php?status=Draft" class="btn btn-sm <?= ($filterStatus === 'Draft') ? 'btn-secondary' : 'btn-light' ?> rounded-pill px-3 fw-semibold">
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
          $badgeClass = 'status-' . strtolower(str_replace(' ', '-', $item['status']));
        ?>
          <div class="col-md-6 col-lg-4">
            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden h-100 d-flex flex-column">
              <!-- Property Image Header -->
              <div class="position-relative" style="height: 190px; background: #E2E8F0;">
                <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" class="w-100 h-100" style="object-fit: cover;" />
                
                <!-- Status Badges Top Left -->
                <div class="position-absolute top-0 start-0 m-3 d-flex flex-column gap-1">
                  <span class="badge-status <?= $badgeClass ?> shadow-sm">
                    <?= htmlspecialchars($item['status']) ?>
                  </span>
                  <?php if (!empty($item['verified'])): ?>
                    <span class="badge bg-success text-white extra-small px-2 py-1 rounded-pill">
                      <i class="fas fa-check-circle me-1"></i> Verified Property
                    </span>
                  <?php endif; ?>
                </div>

                <!-- Rating Tag Top Right -->
                <div class="position-absolute top-0 end-0 m-3">
                  <span class="badge bg-white text-dark shadow-sm px-2.5 py-1.5 fw-bold extra-small rounded-pill">
                    <i class="fas fa-star text-warning me-1"></i> <?= $item['rating'] ?> (<?= $item['reviews_count'] ?>)
                  </span>
                </div>
              </div>

              <!-- Property Body Info -->
              <div class="card-body p-4 d-flex flex-column flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <span class="extra-small text-secondary-custom fw-semibold"><i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($item['area']) ?></span>
                  <span class="badge bg-soft-lavender text-royal-blue extra-small"><?= htmlspecialchars($item['type']) ?></span>
                </div>

                <h5 class="fw-bold text-dark mb-2 text-truncate">
                  <?= htmlspecialchars($item['title']) ?>
                </h5>

                <div class="d-flex flex-wrap gap-2 extra-small mb-3">
                  <span class="badge bg-light text-dark border"><i class="fas fa-bed text-primary me-1"></i> Available Beds: <strong><?= $item['available_beds'] ?>/<?= $item['total_rooms'] ?></strong></span>
                  <span class="badge bg-light text-dark border"><i class="fas fa-eye text-info me-1"></i> Views: <strong><?= number_format($item['views']) ?></strong></span>
                </div>

                <!-- Price Footer & Actions -->
                <div class="pt-3 border-top mt-auto d-flex align-items-center justify-content-between gap-2">
                  <div>
                    <span class="extra-small text-muted d-block">Monthly Rent</span>
                    <strong class="text-royal-blue fs-5">₹<?= number_format($item['rent']) ?></strong><span class="extra-small text-muted">/mo</span>
                  </div>

                  <div class="d-flex gap-1.5">
                    <button class="btn btn-sm btn-light border px-2.5" title="Edit Listing Details" onclick="alert('Editing listing #<?= $item['id'] ?> simulated.')">
                      <i class="fas fa-pen text-secondary"></i>
                    </button>
                    <a href="properties.php?delete=<?= $item['id'] ?>" class="btn btn-sm btn-outline-danger px-2.5" title="Delete Property" onclick="return confirm('Delete this listing permanently?');">
                      <i class="fas fa-trash-can"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
