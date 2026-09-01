<?php
// Owner Panel includes/sidebar.php - Navigation Sidebar
$currentPage = $currentPage ?? basename($_SERVER['PHP_SELF'], '.php');
$unreadMessages = function_exists('getUnreadOwnerMessagesCount') ? getUnreadOwnerMessagesCount() : 0;
$pendingBookings = function_exists('getPendingOwnerBookingsCount') ? getPendingOwnerBookingsCount() : 0;
$unreadNotifications = function_exists('getUnreadOwnerNotificationsCount') ? getUnreadOwnerNotificationsCount() : 0;
$propertiesCount = count($_SESSION['owner_properties'] ?? []);
?>
<aside class="app-sidebar" id="appSidebar">
  <!-- Sidebar Brand Header -->
  <div class="sidebar-brand-box">
    <a href="dashboard.php" class="sidebar-brand-content">
      <div class="sidebar-brand-icon">
        <i class="fas fa-building-user"></i>
      </div>
      <div>
        <div class="sidebar-brand-text">NeighborNest</div>
        <div class="sidebar-brand-sub">Owner Portal</div>
      </div>
    </a>
    <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close Navigation">
      <i class="fas fa-xmark"></i>
    </button>
  </div>

  <div class="sidebar-menu-wrapper">
    <!-- 1. Dashboard -->
    <a href="dashboard.php" class="sidebar-nav-item <?= in_array($currentPage, ['dashboard', 'index']) ? 'active' : '' ?>">
      <i class="fas fa-house-chimney"></i>
      <span>Dashboard</span>
    </a>

    <!-- 2. My Properties -->
    <a href="properties.php" class="sidebar-nav-item <?= in_array($currentPage, ['properties', 'add-property']) ? 'active' : '' ?>">
      <i class="fas fa-city"></i>
      <span>My Properties</span>
      <?php if ($propertiesCount > 0): ?>
        <span class="sidebar-badge sidebar-badge-primary"><?= $propertiesCount ?></span>
      <?php endif; ?>
    </a>

    <!-- 3. Bookings -->
    <a href="bookings.php" class="sidebar-nav-item <?= in_array($currentPage, ['bookings', 'booking-details']) ? 'active' : '' ?>">
      <i class="fas fa-calendar-check"></i>
      <span>Bookings</span>
      <?php if ($pendingBookings > 0): ?>
        <span class="sidebar-badge sidebar-badge-danger"><?= $pendingBookings ?></span>
      <?php endif; ?>
    </a>

    <!-- 4. Messages -->
    <a href="messages.php" class="sidebar-nav-item <?= ($currentPage === 'messages') ? 'active' : '' ?>">
      <i class="fas fa-comment-dots"></i>
      <span>Messages</span>
      <?php if ($unreadMessages > 0): ?>
        <span class="sidebar-badge sidebar-badge-danger"><?= $unreadMessages ?></span>
      <?php endif; ?>
    </a>

    <!-- 5. Reviews -->
    <a href="reviews.php" class="sidebar-nav-item <?= ($currentPage === 'reviews') ? 'active' : '' ?>">
      <i class="fas fa-star"></i>
      <span>Reviews</span>
    </a>

    <!-- 6. Earnings -->
    <a href="earnings.php" class="sidebar-nav-item <?= ($currentPage === 'earnings') ? 'active' : '' ?>">
      <i class="fas fa-wallet"></i>
      <span>Earnings</span>
    </a>

    <!-- 7. Analytics -->
    <a href="analytics.php" class="sidebar-nav-item <?= ($currentPage === 'analytics') ? 'active' : '' ?>">
      <i class="fas fa-chart-line"></i>
      <span>Analytics</span>
    </a>

    <!-- 8. Notifications -->
    <a href="notifications.php" class="sidebar-nav-item <?= ($currentPage === 'notifications') ? 'active' : '' ?>">
      <i class="fas fa-bell"></i>
      <span>Notifications</span>
      <?php if ($unreadNotifications > 0): ?>
        <span class="sidebar-badge sidebar-badge-danger"><?= $unreadNotifications ?></span>
      <?php endif; ?>
    </a>

    <hr style="border-color: var(--nh-border); margin: 0.75rem 0.5rem;">

    <!-- 9. Profile -->
    <a href="profile.php" class="sidebar-nav-item <?= ($currentPage === 'profile') ? 'active' : '' ?>">
      <i class="fas fa-user-gear"></i>
      <span>Profile</span>
    </a>

    <!-- 10. Settings -->
    <a href="settings.php" class="sidebar-nav-item <?= ($currentPage === 'settings') ? 'active' : '' ?>">
      <i class="fas fa-gear"></i>
      <span>Settings</span>
    </a>

    <!-- Logout -->
    <a href="../Guest Panel/login.php" class="sidebar-nav-item" style="margin-top: 0.5rem; color: var(--nh-rose); border-top: 1px solid var(--nh-border); padding-top: 1rem;">
      <i class="fas fa-arrow-right-from-bracket"></i>
      <span>Log Out</span>
    </a>
  </div>
</aside>
