<?php
require_once __DIR__ . '/functions.php';

$user = $_SESSION['user'] ?? [];
$unreadNotifications = function_exists('getUnreadNotificationsCount') ? getUnreadNotificationsCount() : 0;
$unreadMessages = function_exists('getUnreadMessagesCount') ? getUnreadMessagesCount() : 0;
$notificationsList = $_SESSION['user_notifications'] ?? [];
?>

<!-- TOP NAVBAR (70px) -->
<header class="app-topbar">
  <div class="d-flex align-items-center gap-3">
    <!-- Hamburger for Mobile / Tablet -->
    <button class="btn btn-light d-lg-none p-2 rounded-3 border" type="button" id="sidebarToggleBtn" aria-label="Toggle Navigation">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Global Quick Search Bar -->
    <form action="search.php" method="GET" class="topbar-search-box d-none d-sm-block">
      <i class="fas fa-magnifying-glass"></i>
      <input type="text" name="q" placeholder="Search by city, area, college, landmark..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
    </form>
  </div>

  <!-- Right Actions -->
  <div class="d-flex align-items-center gap-2.5">
    <!-- Notifications Dropdown -->
    <div class="dropdown">
      <button class="topbar-action-btn" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notifications">
        <i class="far fa-bell fs-5"></i>
        <?php if ($unreadNotifications > 0): ?>
          <span class="topbar-dot-badge"></span>
        <?php endif; ?>
      </button>

      <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-0 mt-2" style="width: 320px; max-width: 90vw;" aria-labelledby="notifDropdown">
        <li class="p-3 border-bottom d-flex justify-content-between align-items-center">
          <h6 class="fw-bold mb-0">Notifications</h6>
          <a href="notifications.php" class="extra-small text-primary text-decoration-none fw-semibold">View All (<?= count($notificationsList) ?>)</a>
        </li>
        <div style="max-height: 280px; overflow-y: auto;">
          <?php foreach (array_slice($notificationsList, 0, 3) as $notif): ?>
            <li>
              <a class="dropdown-item p-3 border-bottom d-flex gap-2.5 align-items-start <?= $notif['unread'] ? 'bg-soft-lavender' : '' ?>" href="<?= $notif['link'] ?>">
                <div class="p-2 rounded-circle bg-white text-<?= $notif['color'] ?> shadow-sm" style="flex-shrink: 0;">
                  <i class="fas <?= $notif['icon'] ?>"></i>
                </div>
                <div>
                  <strong class="d-block small text-dark"><?= htmlspecialchars($notif['title']) ?></strong>
                  <p class="extra-small text-secondary-custom mb-1 text-truncate" style="max-width: 210px;"><?= htmlspecialchars($notif['desc']) ?></p>
                  <span class="fs-xs text-muted"><?= htmlspecialchars($notif['time']) ?></span>
                </div>
              </a>
            </li>
          <?php endforeach; ?>
        </div>
        <li class="p-2 text-center bg-light rounded-bottom-4">
          <a href="notifications.php" class="extra-small text-secondary fw-semibold text-decoration-none">Open Notification Center</a>
        </li>
      </ul>
    </div>

    <!-- Messages Link -->
    <a href="messages.php" class="topbar-action-btn" title="Messages">
      <i class="far fa-comment-dots fs-5"></i>
      <?php if ($unreadMessages > 0): ?>
        <span class="topbar-dot-badge"></span>
      <?php endif; ?>
    </a>

    <!-- Compare Pill Shortcut (If items selected) -->
    <?php $compareCount = count($_SESSION['user_compare'] ?? []); ?>
    <?php if ($compareCount > 0): ?>
      <a href="compare.php" class="btn btn-sm btn-nh-outline px-3 d-none d-md-inline-flex" title="Compare Selected Accommodations">
        <i class="fas fa-scale-balanced me-1"></i> Compare (<?= $compareCount ?>)
      </a>
    <?php endif; ?>

    <!-- User Profile Menu Dropdown -->
    <div class="dropdown ms-1">
      <button class="btn btn-light d-flex align-items-center gap-2 p-1.5 pe-3 rounded-pill border bg-white shadow-sm" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?= htmlspecialchars($user['avatar'] ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=200&q=80') ?>" alt="<?= htmlspecialchars($user['name'] ?? 'User') ?>" class="topbar-user-avatar" />
        <div class="text-start d-none d-sm-block">
          <span class="d-block small fw-bold text-dark lh-1"><?= htmlspecialchars($user['name'] ?? 'Vishal Patel') ?></span>
          <span class="fs-xs text-secondary-custom">Student / Tenant</span>
        </div>
        <i class="fas fa-chevron-down fs-xs text-muted ms-1"></i>
      </button>

      <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 p-2 mt-2" style="min-width: 220px;" aria-labelledby="userMenuDropdown">
        <li class="p-2 border-bottom mb-1">
          <strong class="d-block small text-dark"><?= htmlspecialchars($user['name'] ?? 'Vishal Patel') ?></strong>
          <span class="extra-small text-muted text-truncate d-block"><?= htmlspecialchars($user['email'] ?? 'vishal.patel@example.com') ?></span>
        </li>
        <li><a class="dropdown-item rounded-3 small py-2" href="profile.php"><i class="fas fa-user me-2 text-primary"></i> My Profile</a></li>
        <li><a class="dropdown-item rounded-3 small py-2" href="bookings.php"><i class="fas fa-calendar-check me-2 text-primary"></i> My Bookings</a></li>
        <li><a class="dropdown-item rounded-3 small py-2" href="wishlist.php"><i class="fas fa-heart me-2 text-danger"></i> Wishlist</a></li>
        <li><a class="dropdown-item rounded-3 small py-2" href="settings.php"><i class="fas fa-gear me-2 text-secondary"></i> Settings</a></li>
        <li><hr class="dropdown-divider my-1"></li>
        <li><a class="dropdown-item rounded-3 small py-2 text-danger" href="../Guest Panel/login.php"><i class="fas fa-arrow-right-from-bracket me-2"></i> Log Out</a></li>
      </ul>
    </div>
  </div>
</header>
