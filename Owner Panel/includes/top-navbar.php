<?php
// Owner Panel includes/top-navbar.php - Top Navigation Bar
$owner = $_SESSION['owner'] ?? [];
$unreadNotifications = function_exists('getUnreadOwnerNotificationsCount') ? getUnreadOwnerNotificationsCount() : 0;
?>
<header class="app-topbar">
  <!-- Mobile Drawer Toggle Button -->
  <div class="d-flex align-items-center gap-2">
    <button class="btn btn-sm btn-light border d-lg-none p-2" id="sidebarToggleBtn" aria-label="Open Navigation">
      <i class="fas fa-bars fs-6"></i>
    </button>
    
    <!-- Topbar Search Bar -->
    <div class="topbar-search-box">
      <i class="fas fa-magnifying-glass"></i>
      <input type="text" placeholder="Search properties, tenant bookings, TXN ID..." />
    </div>
  </div>

  <!-- Topbar Action Links & Profile -->
  <div class="d-flex align-items-center gap-2.5">
    <!-- Quick Add Property Action CTA -->
    <a href="add-property.php" class="btn btn-sm btn-nh-primary px-3 shadow-sm d-none d-sm-inline-flex">
      <i class="fas fa-plus me-1"></i> Add New Property
    </a>

    <!-- Notification Bell Link -->
    <a href="notifications.php" class="topbar-action-btn" title="Owner Notifications">
      <i class="fas fa-bell"></i>
      <?php if ($unreadNotifications > 0): ?>
        <span class="topbar-dot-badge"></span>
      <?php endif; ?>
    </a>

    <!-- Messages Link -->
    <a href="messages.php" class="topbar-action-btn" title="Tenant Messages">
      <i class="fas fa-comment-dots"></i>
      <?php if (function_exists('getUnreadOwnerMessagesCount') && getUnreadOwnerMessagesCount() > 0): ?>
        <span class="topbar-dot-badge"></span>
      <?php endif; ?>
    </a>

    <!-- Profile Link dropdown button -->
    <a href="profile.php" class="d-flex align-items-center gap-2 text-decoration-none ms-1">
      <img src="<?= htmlspecialchars($owner['avatar']) ?>" alt="<?= htmlspecialchars($owner['name']) ?>" class="topbar-user-avatar" />
      <div class="d-none d-xl-block text-start lh-1">
        <strong class="d-block extra-small text-dark fw-bold"><?= htmlspecialchars($owner['name']) ?></strong>
        <span class="fs-xs text-success fw-semibold"><i class="fas fa-shield-check"></i> Verified Host</span>
      </div>
    </a>
  </div>
</header>
