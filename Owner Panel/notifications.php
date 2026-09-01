<?php
// Owner Panel notifications.php - Alert Notification Center
$pageTitle = 'Notification Center · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

// Handle Mark All Read / Clear
if (isset($_GET['action'])) {
    if ($_GET['action'] === 'read_all') {
        foreach ($_SESSION['owner_notifications'] as &$n) {
            $n['unread'] = false;
        }
    } elseif ($_GET['action'] === 'clear') {
        $_SESSION['owner_notifications'] = [];
    }
    header('Location: notifications.php');
    exit;
}

$pageTitle = 'Notifications · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$notifs = $_SESSION['owner_notifications'] ?? [];
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    
    <!-- Header Title & Bulk Actions -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Notification Center</h3>
        <span class="text-secondary-custom small">Real-time alerts for booking requests, tenant messages, payouts, and reviews</span>
      </div>

      <div class="d-flex gap-2">
        <a href="notifications.php?action=read_all" class="btn btn-sm btn-light border px-3">
          <i class="fas fa-check-double me-1 text-primary"></i> Mark All as Read
        </a>
        <a href="notifications.php?action=clear" class="btn btn-sm btn-outline-danger px-3" onclick="return confirm('Clear all notifications?');">
          <i class="fas fa-trash-can me-1"></i> Clear All
        </a>
      </div>
    </div>

    <!-- NOTIFICATIONS LIST -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
      <?php if (empty($notifs)): ?>
        <div class="text-center py-5">
          <div class="p-3 bg-soft-lavender rounded-circle d-inline-flex mb-3 text-royal-blue" style="width: 64px; height: 64px; align-items: center; justify-content: center; font-size: 1.75rem;">
            <i class="fas fa-bell-slash"></i>
          </div>
          <h5 class="fw-bold mb-1">No Notifications</h5>
          <p class="text-secondary-custom small mb-0">You're all caught up! No unread system notifications.</p>
        </div>
      <?php else: ?>
        <div class="d-flex flex-column gap-3">
          <?php foreach ($notifs as $nf): ?>
            <a href="<?= htmlspecialchars($nf['link']) ?>" class="d-flex align-items-start gap-3 p-3 rounded-4 border text-decoration-none transition-all <?= !empty($nf['unread']) ? 'bg-soft-lavender border-primary-subtle' : 'bg-white border-light' ?>">
              <div class="p-2.5 rounded-circle bg-<?= $nf['color'] ?>-subtle text-<?= $nf['color'] ?> flex-shrink-0" style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
                <i class="fas <?= htmlspecialchars($nf['icon']) ?>"></i>
              </div>

              <div class="flex-grow-1 overflow-hidden">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <strong class="small text-dark fw-bold text-truncate"><?= htmlspecialchars($nf['title']) ?></strong>
                  <span class="fs-xs text-muted ms-2 flex-shrink-0"><?= htmlspecialchars($nf['time']) ?></span>
                </div>
                <p class="extra-small text-secondary-custom mb-0"><?= htmlspecialchars($nf['desc']) ?></p>
              </div>

              <?php if (!empty($nf['unread'])): ?>
                <span class="badge bg-primary rounded-circle p-1 me-1" style="width: 8px; height: 8px;"></span>
              <?php endif; ?>
            </a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
