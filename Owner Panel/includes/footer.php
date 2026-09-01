<?php
// Owner Panel includes/footer.php - Footer, Mobile Nav & Scripts
$currentPage = $currentPage ?? basename($_SERVER['PHP_SELF'], '.php');
$unreadMessages = function_exists('getUnreadOwnerMessagesCount') ? getUnreadOwnerMessagesCount() : 0;
$pendingBookings = function_exists('getPendingOwnerBookingsCount') ? getPendingOwnerBookingsCount() : 0;
?>

    <!-- ============================================================
         GLOBAL IN-PAGE FOOTER (DESKTOP & MOBILE)
         ============================================================ -->
    <footer class="app-page-footer mt-auto py-4 px-4 bg-white border-top">
      <div class="container-fluid p-0">
        <div class="row align-items-center gy-3">
          <div class="col-md-6 text-center text-md-start">
            <div class="d-flex align-items-center justify-content-center justify-content-md-start gap-2 mb-1">
              <span class="badge bg-soft-lavender text-royal-blue fw-bold px-2 py-1">
                <i class="fas fa-shield-check text-bright-indigo me-1"></i> Verified Property Host Portal
              </span>
              <span class="extra-small text-secondary-custom">• Zero Brokerage Direct Connection</span>
            </div>
            <p class="extra-small text-secondary-custom mb-0">
              © <?= date('Y') ?> <strong>NeighborNest</strong>. Property Owner & Host Console. All rights reserved.
            </p>
          </div>

          <div class="col-md-6 text-center text-md-end">
            <div class="d-flex flex-wrap justify-content-center justify-content-md-end gap-3 extra-small">
              <a href="properties.php" class="text-secondary-custom text-decoration-none hover-primary">My Listings</a>
              <a href="bookings.php" class="text-secondary-custom text-decoration-none hover-primary">Bookings</a>
              <a href="earnings.php" class="text-secondary-custom text-decoration-none hover-primary">Financials</a>
              <a href="settings.php" class="text-secondary-custom text-decoration-none hover-primary">Privacy & Terms</a>
            </div>
          </div>
        </div>
      </div>
    </footer>

    </div><!-- .main-wrapper -->
  </div><!-- .app-layout -->

  <!-- ============================================================
       MOBILE BOTTOM APP NAVIGATION BAR (< 992px)
       ============================================================ -->
  <nav class="mobile-bottom-nav">
    <div class="mobile-bottom-nav-inner">
      <a href="dashboard.php" class="mobile-nav-item <?= in_array($currentPage, ['dashboard', 'index']) ? 'active' : '' ?>">
        <i class="fas fa-house-chimney"></i>
        <span>Dashboard</span>
      </a>

      <a href="properties.php" class="mobile-nav-item <?= in_array($currentPage, ['properties', 'add-property']) ? 'active' : '' ?>">
        <i class="fas fa-city"></i>
        <span>Properties</span>
      </a>

      <a href="bookings.php" class="mobile-nav-item <?= in_array($currentPage, ['bookings', 'booking-details']) ? 'active' : '' ?>">
        <i class="fas fa-calendar-check"></i>
        <span>Bookings</span>
        <?php if ($pendingBookings > 0): ?>
          <span class="mobile-nav-badge"></span>
        <?php endif; ?>
      </a>

      <a href="messages.php" class="mobile-nav-item <?= ($currentPage === 'messages') ? 'active' : '' ?>">
        <i class="fas fa-comment-dots"></i>
        <span>Chats</span>
        <?php if ($unreadMessages > 0): ?>
          <span class="mobile-nav-badge"></span>
        <?php endif; ?>
      </a>

      <a href="profile.php" class="mobile-nav-item <?= in_array($currentPage, ['profile', 'settings', 'notifications', 'reviews', 'earnings', 'analytics']) ? 'active' : '' ?>">
        <i class="fas fa-user-circle"></i>
        <span>Account</span>
      </a>
    </div>
  </nav>

  <!-- ============================================================
       SCRIPTS
       ============================================================ -->
  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Leaflet JS for Maps -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <!-- Custom Mobile Drawer Controller JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const toggleBtn = document.getElementById("sidebarToggleBtn");
      const closeBtn = document.getElementById("sidebarCloseBtn");
      const sidebar = document.getElementById("appSidebar");
      const overlay = document.getElementById("sidebarOverlay");

      function openSidebar() {
        if (sidebar && overlay) {
          sidebar.classList.add("show");
          overlay.classList.add("show");
          document.body.style.overflow = "hidden";
        }
      }

      function closeSidebar() {
        if (sidebar && overlay) {
          sidebar.classList.remove("show");
          overlay.classList.remove("show");
          document.body.style.overflow = "";
        }
      }

      if (toggleBtn) toggleBtn.addEventListener("click", openSidebar);
      if (closeBtn) closeBtn.addEventListener("click", closeSidebar);
      if (overlay) overlay.addEventListener("click", closeSidebar);

      document.querySelectorAll(".sidebar-nav-item").forEach(link => {
        link.addEventListener("click", function() {
          if (window.innerWidth < 992) {
            closeSidebar();
          }
        });
      });

      window.addEventListener("resize", function() {
        if (window.innerWidth >= 992) {
          closeSidebar();
        }
      });

      console.log('✅ NeighborNest Owner Portal Initialized.');
    });
  </script>
</body>
</html>
