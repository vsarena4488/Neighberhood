    </div><!-- .main-wrapper -->
  </div><!-- .app-layout -->

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Leaflet JS for Maps -->
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <script>
    // Responsive Sidebar Drawer Toggle
    document.addEventListener("DOMContentLoaded", function() {
      const toggleBtn = document.getElementById("sidebarToggleBtn");
      const sidebar = document.getElementById("appSidebar");

      if (toggleBtn && sidebar) {
        toggleBtn.addEventListener("click", function(e) {
          e.stopPropagation();
          sidebar.classList.toggle("show");
        });

        // Close when clicking outside on mobile
        document.addEventListener("click", function(e) {
          if (window.innerWidth < 992 && sidebar.classList.contains("show")) {
            if (!sidebar.contains(e.target) && e.target !== toggleBtn) {
              sidebar.classList.remove("show");
            }
          }
        });
      }
    });

    // Wishlist Toggle Helper Function
    function toggleWishlist(propertyId, btnElement) {
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
    }
  </script>
</body>

</html>
