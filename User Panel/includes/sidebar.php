<?php
// includes/sidebar.php - Desktop Sidebar Navigation
$currentPage = $currentPage ?? basename($_SERVER['PHP_SELF'], '.php');
$user = $_SESSION['user'] ?? [];
$unreadMessages = function_exists('getUnreadMessagesCount') ? getUnreadMessagesCount() : 0;
$wishlistCount = count($_SESSION['user_wishlist'] ?? []);
$bookingsCount = count($_SESSION['user_bookings'] ?? []);
$notificationsCount = function_exists('getUnreadNotificationsCount') ? getUnreadNotificationsCount() : 0;
?>
<aside class="app-sidebar" id="appSidebar">
    <!-- Sidebar Close Button (Mobile) -->
    <div class="sidebar-brand-box">
        <a href="dashboard.php" class="sidebar-brand-content">
            <div class="sidebar-brand-icon">
                <i class="fas fa-home"></i>
            </div>
            <div>
                <div class="sidebar-brand-text">NeighborNest</div>
                <div class="sidebar-brand-sub">Student Portal</div>
            </div>
        </a>
        <button class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Close Navigation">
            <i class="fas fa-xmark"></i>
        </button>
    </div>

    <div class="sidebar-menu-wrapper">
        <!-- Dashboard -->
        <a href="dashboard.php" class="sidebar-nav-item <?= in_array($currentPage, ['dashboard', 'index']) ? 'active' : '' ?>">
            <i class="fas fa-house-chimney"></i>
            <span>Dashboard</span>
        </a>

        <!-- Find Accommodation -->
        <a href="search.php" class="sidebar-nav-item <?= in_array($currentPage, ['search', 'property-details', 'compare']) ? 'active' : '' ?>">
            <i class="fas fa-magnifying-glass-location"></i>
            <span>Find Accommodation</span>
        </a>

        <!-- Wishlist -->
        <a href="wishlist.php" class="sidebar-nav-item <?= ($currentPage === 'wishlist') ? 'active' : '' ?>">
            <i class="fas fa-heart"></i>
            <span>Wishlist</span>
            <?php if ($wishlistCount > 0): ?>
                <span class="sidebar-badge sidebar-badge-primary"><?= $wishlistCount ?></span>
            <?php endif; ?>
        </a>

        <!-- My Bookings -->
        <a href="bookings.php" class="sidebar-nav-item <?= in_array($currentPage, ['bookings', 'booking-details', 'booking-request']) ? 'active' : '' ?>">
            <i class="fas fa-calendar-check"></i>
            <span>My Bookings</span>
            <?php if ($bookingsCount > 0): ?>
                <span class="sidebar-badge sidebar-badge-primary"><?= $bookingsCount ?></span>
            <?php endif; ?>
        </a>

        <!-- Messages -->
        <a href="messages.php" class="sidebar-nav-item <?= ($currentPage === 'messages') ? 'active' : '' ?>">
            <i class="fas fa-comment-dots"></i>
            <span>Messages</span>
            <?php if ($unreadMessages > 0): ?>
                <span class="sidebar-badge sidebar-badge-danger"><?= $unreadMessages ?></span>
            <?php endif; ?>
        </a>

        <!-- My Reviews -->
        <a href="reviews.php" class="sidebar-nav-item <?= ($currentPage === 'reviews') ? 'active' : '' ?>">
            <i class="fas fa-star"></i>
            <span>My Reviews</span>
        </a>

        <!-- Notifications -->
        <a href="notifications.php" class="sidebar-nav-item <?= ($currentPage === 'notifications') ? 'active' : '' ?>">
            <i class="fas fa-bell"></i>
            <span>Notifications</span>
            <?php if ($notificationsCount > 0): ?>
                <span class="sidebar-badge sidebar-badge-danger"><?= $notificationsCount ?></span>
            <?php endif; ?>
        </a>

        <hr style="border-color: var(--nh-border); margin: 0.75rem 0.5rem;">

        <!-- Profile -->
        <a href="profile.php" class="sidebar-nav-item <?= ($currentPage === 'profile') ? 'active' : '' ?>">
            <i class="fas fa-user"></i>
            <span>Profile</span>
        </a>

        <!-- Settings -->
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
