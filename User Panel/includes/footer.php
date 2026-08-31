<?php
// includes/footer.php - Closing Tags, Mobile Nav, JavaScript
$currentPage = $currentPage ?? basename($_SERVER['PHP_SELF'], '.php');
$unreadMessages = function_exists('getUnreadMessagesCount') ? getUnreadMessagesCount() : 0;
$bookingsCount = count($_SESSION['user_bookings'] ?? []);
?>
    </div><!-- .main-wrapper -->
  </div><!-- .app-layout -->

  <!-- ============================================================
       MOBILE BOTTOM APP NAVIGATION BAR (< 992px)
       ============================================================ -->
  <nav class="mobile-bottom-nav">
    <div class="mobile-bottom-nav-inner">
      <a href="dashboard.php" class="mobile-nav-item <?= in_array($currentPage, ['dashboard', 'index']) ? 'active' : '' ?>">
        <i class="fas fa-house-chimney"></i>
        <span>Home</span>
      </a>

      <a href="search.php" class="mobile-nav-item <?= in_array($currentPage, ['search', 'property-details', 'compare']) ? 'active' : '' ?>">
        <i class="fas fa-magnifying-glass-location"></i>
        <span>Explore</span>
      </a>

      <a href="bookings.php" class="mobile-nav-item <?= in_array($currentPage, ['bookings', 'booking-details', 'booking-request']) ? 'active' : '' ?>">
        <i class="fas fa-calendar-check"></i>
        <span>Bookings</span>
        <?php if ($bookingsCount > 0): ?>
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

      <a href="profile.php" class="mobile-nav-item <?= in_array($currentPage, ['profile', 'settings', 'notifications', 'reviews', 'wishlist']) ? 'active' : '' ?>">
        <i class="fas fa-user-circle"></i>
        <span>Profile</span>
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

  <!-- Custom JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // ============================================
      // MOBILE DRAWER CONTROLLER
      // ============================================
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

      // Close drawer when clicking a navigation link on mobile
      document.querySelectorAll(".sidebar-nav-item").forEach(link => {
        link.addEventListener("click", function() {
          if (window.innerWidth < 992) {
            closeSidebar();
          }
        });
      });

      // Handle window resize
      window.addEventListener("resize", function() {
        if (window.innerWidth >= 992) {
          closeSidebar();
        }
      });

      // ============================================
      // WISHLIST TOGGLE
      // ============================================
      window.toggleWishlist = function(propertyId, btnElement) {
        const icon = btnElement ? btnElement.querySelector("i") : null;
        if (icon) {
          if (icon.classList.contains("fas")) {
            icon.classList.remove("fas", "text-danger");
            icon.classList.add("far");
          } else {
            icon.classList.remove("far");
            icon.classList.add("fas", "text-danger");
          }
        }
        console.log('🔄 Toggled wishlist for property:', propertyId);
      };

      // ============================================
      // STAT CARD CLICK HANDLER
      // ============================================
      document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
          const label = this.querySelector('.extra-small');
          if (label) {
            console.log('📊 Navigating to:', label.textContent.trim());
          }
        });
      });

      console.log('✅ NeighborNest Dashboard initialized.');
    });
  </script>
</body>
</html>
