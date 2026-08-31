<?php
require_once __DIR__ . '/includes/functions.php';

// Handle Mark All Read / Clear
if (isset($_GET['mark_read'])) {
    foreach ($_SESSION['user_notifications'] as &$n) {
        $n['unread'] = false;
    }
}
if (isset($_GET['clear_all'])) {
    $_SESSION['user_notifications'] = [];
}

$pageTitle = 'Notifications · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$notifications = $_SESSION['user_notifications'] ?? [];
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Notification Center (<?= count($notifications) ?>)</h3>
        <span class="text-secondary-custom small">Stay updated on your booking progress, landlord messages, and payment receipts</span>
      </div>

      <div class="d-flex align-items-center gap-2">
        <a href="notifications.php?mark_read=1" class="btn btn-sm btn-nh-outline px-3">
          <i class="fas fa-check-double me-1"></i> Mark All as Read
        </a>
        <a href="notifications.php?clear_all=1" class="btn btn-sm btn-light border text-danger px-3" onclick="return confirm('Clear all notifications?');">
          <i class="fas fa-trash-can me-1"></i> Clear All
        </a>
      </div>
    </div>

    <!-- Notification Cards List -->
    <div class="d-flex flex-column gap-3 mb-4">
      <?php if (empty($notifications)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-3">
          <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-royal-blue" style="width: 70px; height: 70px; align-items: center; justify-content: center; font-size: 1.8rem;">
            <i class="fas fa-bell-slash"></i>
          </div>
          <h5 class="fw-bold mb-1">No Notifications Right Now</h5>
          <p class="text-secondary-custom small mb-0">You are all caught up! Updates regarding booking approvals and messages will appear here.</p>
        </div>
      <?php else: ?>
        <?php foreach ($notifications as $notif): ?>
          <div class="card border-0 rounded-4 shadow-sm p-3.5 <?= $notif['unread'] ? 'bg-soft-lavender border-start border-primary border-4' : 'bg-white' ?>">
            <div class="d-flex align-items-start gap-3">
              <div class="p-3 rounded-circle bg-white text-<?= $notif['color'] ?> shadow-sm" style="font-size: 1.25rem; flex-shrink: 0;">
                <i class="fas <?= $notif['icon'] ?>"></i>
              </div>

              <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <h6 class="fw-bold mb-0 text-dark"><?= htmlspecialchars($notif['title']) ?></h6>
                  <span class="extra-small text-muted"><?= htmlspecialchars($notif['time']) ?></span>
                </div>
                <p class="small text-secondary-custom mb-3"><?= htmlspecialchars($notif['desc']) ?></p>

                <div class="d-flex gap-2">
                  <a href="<?= $notif['link'] ?>" class="btn btn-sm btn-nh-primary py-1 px-3">
                    View Update
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
