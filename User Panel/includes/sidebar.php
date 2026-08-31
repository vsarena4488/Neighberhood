<?php
require_once __DIR__ . '/functions.php';

if (!isset($currentPage)) {
    $currentPage = basename($_SERVER['PHP_SELF'], '.php');
}

$unreadMessages = function_exists('getUnreadMessagesCount') ? getUnreadMessagesCount() : 0;
$unreadNotifications = function_exists('getUnreadNotificationsCount') ? getUnreadNotificationsCount() : 0;
$wishlistCount = count($_SESSION['user_wishlist'] ?? []);
$bookingsCount = count($_SESSION['user_bookings'] ?? []);
?>

<!-- SIDEBAR NAVIGATION (260px) -->
<aside class="app-sidebar" id="appSidebar">
  <!-- Brand Header -->
  <a href="dashboard.php" class="sidebar-brand-box">
    <div class="sidebar-brand-icon"><i class="fas fa-home"></i></div>
    <div>
      <div class="sidebar-brand-text">NeighborNest</div>
      <div class="sidebar-brand-sub">Student & User Portal</div>
    </div>
  </a>

  <!-- Navigation Items -->
  <div class="sidebar-menu-wrapper">
    <div class="sidebar-heading">Main Navigation</div>

    <a href="dashboard.php" class="sidebar-nav-item <?= in_array($currentPage, ['dashboard', 'index']) ? 'active' : '' ?>">
      <i class="fas fa-house-chimney"></i>
      <span>Dashboard</span>
    </a>

    <a href="search.php" class="sidebar-nav-item <?= in_array($currentPage, ['search', 'property-details', 'compare', 'booking-request']) ? 'active' : '' ?>">
      <i class="fas fa-magnifying-glass-location"></i>
      <span>Find Accommodation</span>
    </a>

    <a href="wishlist.php" class="sidebar-nav-item <?= ($currentPage === 'wishlist') ? 'active' : '' ?>">
      <i class="fas fa-heart"></i>
      <span>Wishlist</span>
      <span class="sidebar-badge sidebar-badge-primary"><?= $wishlistCount ?></span>
    </a>

    <a href="bookings.php" class="sidebar-nav-item <?= in_array($currentPage, ['bookings', 'booking-details']) ? 'active' : '' ?>">
      <i class="fas fa-calendar-check"></i>
      <span>My Bookings</span>
      <span class="sidebar-badge sidebar-badge-primary"><?= $bookingsCount ?></span>
    </a>

    <a href="messages.php" class="sidebar-nav-item <?= ($currentPage === 'messages') ? 'active' : '' ?>">
      <i class="fas fa-comment-dots"></i>
      <span>Messages</span>
      <?php if ($unreadMessages > 0): ?>
        <span class="sidebar-badge sidebar-badge-danger"><?= $unreadMessages ?> ●</span>
      <?php endif; ?>
    </a>

    <a href="reviews.php" class="sidebar-nav-item <?= ($currentPage === 'reviews') ? 'active' : '' ?>">
      <i class="fas fa-star"></i>
      <span>My Reviews</span>
    </a>

    <a href="notifications.php" class="sidebar-nav-item <?= ($currentPage === 'notifications') ? 'active' : '' ?>">
      <i class="fas fa-bell"></i>
      <span>Notifications</span>
      <?php if ($unreadNotifications > 0): ?>
        <span class="sidebar-badge sidebar-badge-danger"><?= $unreadNotifications ?> ●</span>
      <?php endif; ?>
    </a>

    <div class="sidebar-heading mt-3">Account & Preferences</div>

    <a href="profile.php" class="sidebar-nav-item <?= ($currentPage === 'profile') ? 'active' : '' ?>">
      <i class="fas fa-user-circle"></i>
      <span>My Profile</span>
    </a>

    <a href="settings.php" class="sidebar-nav-item <?= ($currentPage === 'settings') ? 'active' : '' ?>">
      <i class="fas fa-gear"></i>
      <span>Settings</span>
    </a>

    <hr class="my-3 opacity-25" />

    <a href="../Guest Panel/login.php" class="sidebar-nav-item text-danger">
      <i class="fas fa-arrow-right-from-bracket text-danger"></i>
      <span>Log Out</span>
    </a>
  </div>
</aside>
