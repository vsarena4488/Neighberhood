<?php
// dashboard.php - User Dashboard
$pageTitle = 'Dashboard · NeighborNest User Portal';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

// Get user data
$user = $_SESSION['user'] ?? [];
$userName = explode(' ', $user['name'] ?? 'Vishal')[0];
$course = $user['course'] ?? 'Student';
$unreadMessages = function_exists('getUnreadMessagesCount') ? getUnreadMessagesCount() : 0;
$wishlistCount = count($_SESSION['user_wishlist'] ?? []);
$bookingsCount = count($_SESSION['user_bookings'] ?? []);
?>
<style>
  /* Additional dashboard-specific styles */
  .stat-card {
    background: var(--nh-white);
    border: 1px solid var(--nh-border);
    border-radius: var(--nh-radius-lg);
    padding: 1.25rem 1.35rem;
    box-shadow: var(--nh-shadow-subtle);
    transition: var(--nh-transition);
    height: 100%;
    display: flex;
    align-items: center;
    gap: 1rem;
    cursor: pointer;
  }

  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--nh-shadow-card);
    border-color: var(--nh-lavender-border);
  }

  .stat-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: var(--nh-radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
  }

  .stat-card h3 {
    font-size: 1.5rem;
    font-weight: 800;
    margin-bottom: 0;
    line-height: 1.1;
  }

  .stat-card .extra-small {
    font-size: 0.75rem;
    font-weight: 500;
  }

  .transition-all {
    transition: var(--nh-transition);
  }

  .transition-all:hover {
    transform: translateX(4px);
    background: var(--nh-soft-lavender) !important;
  }

  .bg-nh-hero {
    background: linear-gradient(135deg, #EEF2FF 0%, #F8FAFC 100%);
  }

  .text-amber {
    color: var(--nh-amber) !important;
  }

  .text-teal {
    color: var(--nh-teal) !important;
  }

  .badge-status {
    padding: 0.25rem 0.75rem;
    border-radius: var(--nh-radius-pill);
    font-size: 0.7rem;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    letter-spacing: 0.02em;
    white-space: nowrap;
  }

  .status-pending {
    background: #FEF3C7;
    color: #B45309;
  }

  .status-approved {
    background: #EEF2FF;
    color: #4338CA;
  }

  .status-active {
    background: #DCFCE7;
    color: #15803D;
  }

  .status-completed {
    background: #CCFBF1;
    color: #0F766E;
  }

  .status-cancelled {
    background: #FEE2E2;
    color: #B91C1C;
  }

  .btn-nh-primary {
    background: var(--nh-gradient-primary);
    color: #FFFFFF !important;
    border: none;
    padding: 0.55rem 1.35rem;
    border-radius: var(--nh-radius-pill);
    font-weight: 600;
    font-size: 0.85rem;
    box-shadow: 0 4px 14px rgba(79, 70, 229, 0.3);
    transition: var(--nh-transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    min-height: 40px;
  }

  .btn-nh-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 7px 20px rgba(79, 70, 229, 0.45);
    color: #FFFFFF !important;
  }

  .btn-nh-outline {
    background: transparent;
    color: var(--nh-royal-blue) !important;
    border: 1.5px solid var(--nh-bright-indigo);
    padding: 0.5rem 1.25rem;
    border-radius: var(--nh-radius-pill);
    font-weight: 600;
    font-size: 0.85rem;
    transition: var(--nh-transition);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.45rem;
    cursor: pointer;
    text-decoration: none;
    white-space: nowrap;
    min-height: 38px;
  }

  .btn-nh-outline:hover {
    background: var(--nh-soft-lavender);
    transform: translateY(-2px);
    color: var(--nh-royal-blue) !important;
  }

  .btn-nh-outline.btn-sm {
    padding: 0.3rem 1rem;
    font-size: 0.78rem;
    min-height: 32px;
  }

  /* Property Card Overrides */
  .property-card {
    background: var(--nh-white);
    border-radius: var(--nh-radius-lg);
    border: 1px solid var(--nh-border);
    box-shadow: var(--nh-shadow-card);
    overflow: hidden;
    transition: var(--nh-transition);
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
  }

  .property-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--nh-shadow-hover);
    border-color: var(--nh-lavender-border);
  }

  .card-img-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
    background: #e2e8f0;
    flex-shrink: 0;
  }

  .card-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .property-card:hover .card-img-wrapper img {
    transform: scale(1.04);
  }

  /* Table Styling */
  .table-nh th {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #94A3B8;
    border-bottom: 1px solid var(--nh-border);
    padding: 0.8rem 1rem;
  }

  .table-nh td {
    padding: 0.8rem 1rem;
    border-bottom: 1px solid var(--nh-border);
    vertical-align: middle;
  }

  .table-nh tbody tr:hover {
    background: var(--nh-bg-light);
  }

  @media (max-width: 768px) {
    .stat-card {
      padding: 0.9rem;
      gap: 0.65rem;
    }

    .stat-icon-wrapper {
      width: 40px;
      height: 40px;
      font-size: 1.1rem;
    }

    .stat-card h3 {
      font-size: 1.25rem;
    }

    .card-img-wrapper {
      height: 170px;
    }

    .dashboard-header-card {
      padding: 1.25rem !important;
    }

    .dashboard-header-card .display-6 {
      font-size: 1.5rem !important;
    }

    .badge-status {
      font-size: 0.6rem;
      padding: 0.15rem 0.6rem;
    }

    .table-nh {
      font-size: 0.75rem;
    }

    .table-nh th,
    .table-nh td {
      padding: 0.5rem 0.6rem;
    }
  }

  @media (max-width: 576px) {
    .stat-card {
      padding: 0.7rem;
      gap: 0.5rem;
    }

    .stat-icon-wrapper {
      width: 36px;
      height: 36px;
      font-size: 0.9rem;
    }

    .stat-card h3 {
      font-size: 1.1rem;
    }

    .stat-card .extra-small {
      font-size: 0.65rem;
    }

    .card-img-wrapper {
      height: 150px;
    }

    .btn-nh-primary,
    .btn-nh-outline {
      font-size: 0.75rem;
      padding: 0.35rem 0.9rem;
      min-height: 32px;
    }
  }

  .fade-up {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeUp 0.5s ease forwards;
  }

  @keyframes fadeUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .delay-1 {
    animation-delay: 0.05s;
  }

  .delay-2 {
    animation-delay: 0.1s;
  }

  .delay-3 {
    animation-delay: 0.15s;
  }

  .delay-4 {
    animation-delay: 0.2s;
  }

  .delay-5 {
    animation-delay: 0.25s;
  }

  .delay-6 {
    animation-delay: 0.3s;
  }
</style>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">

    <!-- ============================================================
         WELCOME HEADER BANNER
         ============================================================ -->
    <div class="card border-0 rounded-4 p-4 p-md-5 mb-4 shadow-sm fade-up delay-1"
      style="background: linear-gradient(135deg, #EEF2FF 0%, #F8FAFC 100%); border: 1px solid var(--nh-lavender-border) !important;">

      <div class="row align-items-center gy-4">
        <div class="col-lg-7">
          <span class="badge bg-soft-lavender text-royal-blue border border-primary-subtle rounded-pill px-3 py-2 mb-2 font-weight-bold">
            <i class="fas fa-graduation-cap me-1 text-bright-indigo"></i>
            <?= htmlspecialchars($course) ?>
          </span>
          <h2 class="display-6 fw-bold mb-2">
            Welcome back, <?= htmlspecialchars($userName) ?>! 👋
          </h2>
          <p class="text-secondary-custom mb-4 small leading-relaxed">
            Find and manage your verified student PGs, hostels, and rental accommodations across Bangalore and top Indian cities with zero brokerage.
          </p>

          <!-- Dashboard Global Search Bar -->
          <form action="search.php" method="GET" class="d-flex flex-column flex-sm-row gap-2 bg-white p-2 rounded-4 shadow-sm border">
            <div class="input-group border-0">
              <span class="input-group-text bg-transparent border-0 text-bright-indigo ps-3">
                <i class="fas fa-location-dot"></i>
              </span>
              <input type="text" name="q" class="form-control border-0 shadow-none ps-1"
                placeholder="Search by city, area, college (e.g. Koramangala, Christ Univ)..."
                value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" />
            </div>
            <button type="submit" class="btn btn-nh-primary px-4 py-2 flex-shrink-0">
              <i class="fas fa-search me-1"></i> Search Places
            </button>
          </form>
        </div>

        <div class="col-lg-5 text-center text-lg-end d-none d-lg-block">
          <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=500&q=80"
            alt="Accommodation" class="rounded-4 shadow img-fluid"
            style="max-height: 200px; object-fit: cover; width: 85%;" />
        </div>
      </div>
    </div>

    <!-- ============================================================
         4 STATISTICS CARDS
         ============================================================ -->
    <div class="row g-3 g-md-4 mb-4">
      <!-- Wishlist -->
      <div class="col-6 col-lg-3 fade-up delay-2">
        <a href="wishlist.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #FEF3C7; color: #D97706;">
              <i class="fas fa-heart"></i>
            </div>
            <div>
              <h3><?= $wishlistCount ?></h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Saved Wishlist</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Total Bookings -->
      <div class="col-6 col-lg-3 fade-up delay-3">
        <a href="bookings.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #EEF2FF; color: #4F46E5;">
              <i class="fas fa-calendar-check"></i>
            </div>
            <div>
              <h3><?= $bookingsCount ?></h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Total Bookings</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Active Stays -->
      <div class="col-6 col-lg-3 fade-up delay-4">
        <a href="bookings.php?status=Active" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #DCFCE7; color: #16A34A;">
              <i class="fas fa-house-user"></i>
            </div>
            <div>
              <h3>
                <?php
                $active = 0;
                foreach ($_SESSION['user_bookings'] ?? [] as $b) {
                  if ($b['status'] === 'Active') $active++;
                }
                echo $active;
                ?>
              </h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Active Stays</span>
            </div>
          </div>
        </a>
      </div>

      <!-- Unread Messages -->
      <div class="col-6 col-lg-3 fade-up delay-5">
        <a href="messages.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #FEE2E2; color: #EF4444;">
              <i class="fas fa-comment-dots"></i>
            </div>
            <div>
              <h3><?= $unreadMessages ?></h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Unread Messages</span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- ============================================================
         RECOMMENDED PROPERTIES SECTION
         ============================================================ -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 fade-up delay-3">
      <div>
        <h5 class="fw-bold mb-0">🏠 Recommended for You</h5>
        <span class="extra-small text-secondary-custom">Handpicked student accommodations near <?= htmlspecialchars($user['college'] ?? 'your college') ?></span>
      </div>
      <a href="search.php" class="btn btn-sm btn-nh-outline px-3">View All Listings →</a>
    </div>

    <div class="row g-4 mb-5 fade-up delay-4">
      <?php
      $properties = getPropertiesData();
      $recommended = array_slice($properties, 0, 3);
      foreach ($recommended as $item):
        $genderLabel = ($item['gender'] === 'male_only') ? 'Boys Only' : (($item['gender'] === 'female_only') ? 'Girls Only' : 'Unisex');
        $isWishlisted = in_array($item['id'], $_SESSION['user_wishlist'] ?? []);
      ?>
        <div class="col-md-6 col-lg-4">
          <div class="property-card">
            <div class="card-img-wrapper">
              <img src="<?= htmlspecialchars($item['image']) ?>"
                alt="<?= htmlspecialchars($item['title']) ?>"
                loading="lazy" />
              <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1">
                <?php if ($item['verified']): ?>
                  <span class="badge bg-success small"><i class="fas fa-check-circle me-1"></i> Verified</span>
                <?php endif; ?>
                <span class="badge bg-primary small"><?= htmlspecialchars($item['type']) ?></span>
                <span class="badge bg-dark small"><?= htmlspecialchars($genderLabel) ?></span>
              </div>
              <button class="btn btn-sm bg-white text-dark position-absolute top-0 end-0 m-2 rounded-circle shadow-sm border-0"
                onclick="toggleWishlist(<?= $item['id'] ?>, this)"
                title="Save to Wishlist">
                <i class="<?= $isWishlisted ? 'fas fa-heart text-danger' : 'far fa-heart' ?>"></i>
              </button>
            </div>

            <div class="p-3 d-flex flex-column flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="extra-small text-secondary-custom fw-medium text-truncate">
                  <i class="fas fa-location-dot text-danger me-1"></i>
                  <?= htmlspecialchars($item['area']) ?>
                </span>
                <span class="badge bg-warning text-dark extra-small flex-shrink-0">
                  <i class="fas fa-star me-1"></i> <?= htmlspecialchars($item['rating']) ?>
                </span>
              </div>

              <h6 class="fw-bold mb-2 text-truncate" title="<?= htmlspecialchars($item['title']) ?>">
                <a href="property-details.php?id=<?= $item['id'] ?>" class="text-dark text-decoration-none">
                  <?= htmlspecialchars($item['title']) ?>
                </a>
              </h6>

              <div class="d-flex flex-wrap gap-1 mb-2">
                <?php foreach (array_slice($item['amenities'], 0, 2) as $am): ?>
                  <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1">
                    <i class="fas fa-check me-1 text-success"></i><?= htmlspecialchars($am) ?>
                  </span>
                <?php endforeach; ?>
                <?php if (count($item['amenities']) > 2): ?>
                  <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1">
                    +<?= count($item['amenities']) - 2 ?> more
                  </span>
                <?php endif; ?>
              </div>

              <div class="extra-small text-secondary-custom mb-3 text-truncate">
                <i class="fas fa-route me-1 text-bright-indigo"></i>
                <?= htmlspecialchars($item['nearby'][0] ?? 'Prime location') ?>
              </div>

              <div class="mt-auto pt-2.5 border-top d-flex align-items-center justify-content-between">
                <div>
                  <span class="extra-small text-secondary-custom d-block" style="line-height: 1;">Monthly Rent</span>
                  <strong class="text-royal-blue fs-5">₹<?= number_format($item['rent']) ?></strong>
                  <span class="extra-small text-secondary-custom">/mo</span>
                </div>

                <div class="d-flex align-items-center gap-1.5 ms-auto">
                  <a href="compare.php?add=<?= $item['id'] ?>" class="btn btn-sm btn-light border p-2" title="Compare this property">
                    <i class="fas fa-scale-balanced text-secondary-custom"></i>
                  </a>
                  <a href="property-details.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-nh-primary px-3">
                    View Details
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- ============================================================
         RECENT BOOKINGS & MESSAGES ROW
         ============================================================ -->
    <div class="row g-4 fade-up delay-5">

      <!-- RECENT BOOKINGS TABLE -->
      <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">
          <div class="p-3.5 px-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold mb-0">📋 My Recent Bookings</h5>
              <span class="extra-small text-secondary-custom">Track your accommodation request status</span>
            </div>
            <a href="bookings.php" class="extra-small text-primary text-decoration-none fw-semibold">
              View All Bookings <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>

          <div class="p-0 table-responsive">
            <table class="table table-nh align-middle mb-0 small">
              <thead>
                <tr>
                  <th class="ps-4">Booking ID</th>
                  <th>Property</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th class="text-end pe-4">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $bookings = $_SESSION['user_bookings'] ?? [];
                $recentBookings = array_slice($bookings, 0, 3);
                if (!empty($recentBookings)):
                  foreach ($recentBookings as $bk):
                    $badgeClass = 'status-' . strtolower($bk['status']);
                ?>
                    <tr>
                      <td class="ps-4 fw-bold text-royal-blue">#<?= htmlspecialchars($bk['id']) ?></td>
                      <td>
                        <div class="fw-semibold text-dark"><?= htmlspecialchars($bk['property_title']) ?></div>
                        <span class="extra-small text-muted"><?= htmlspecialchars($bk['room_type']) ?></span>
                      </td>
                      <td><span class="text-secondary-custom"><?= htmlspecialchars($bk['location']) ?></span></td>
                      <td>
                        <span class="badge-status <?= $badgeClass ?>">
                          <?php if ($bk['status'] === 'Pending'): ?><i class="fas fa-clock"></i><?php endif; ?>
                          <?php if ($bk['status'] === 'Active'): ?><i class="fas fa-circle-check"></i><?php endif; ?>
                          <?php if ($bk['status'] === 'Completed'): ?><i class="fas fa-check-double"></i><?php endif; ?>
                          <?= htmlspecialchars($bk['status']) ?>
                        </span>
                      </td>
                      <td class="text-end pe-4">
                        <a href="booking-details.php?id=<?= $bk['id'] ?>" class="btn btn-sm btn-nh-outline py-1 px-3">
                          View Details
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center py-4 text-secondary-custom">
                      <i class="fas fa-calendar-xmark fa-2x d-block mb-2 text-muted"></i>
                      No bookings yet. Start exploring!
                      <br>
                      <a href="search.php" class="btn btn-sm btn-nh-primary mt-2">Find Accommodation</a>
                    </td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- RECENT MESSAGES SNIPPET -->
      <div class="col-lg-4">
        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">
          <div class="p-3.5 px-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold mb-0">💬 Recent Messages</h5>
              <span class="extra-small text-secondary-custom">Direct chat with verified landlords</span>
            </div>
            <a href="messages.php" class="extra-small text-primary text-decoration-none fw-semibold">
              Open Chat <i class="fas fa-arrow-right ms-1"></i>
            </a>
          </div>

          <div class="p-3 d-flex flex-column gap-2">
            <?php
            $chats = $_SESSION['user_chats'] ?? [];
            $recentChats = array_slice($chats, 0, 3);
            if (!empty($recentChats)):
              foreach ($recentChats as $chat):
            ?>
                <a href="messages.php?chat=<?= $chat['id'] ?>"
                  class="p-2.5 rounded-3 border bg-light text-decoration-none text-dark d-flex align-items-start gap-2.5 transition-all">
                  <img src="<?= htmlspecialchars($chat['owner_avatar']) ?>"
                    alt="<?= htmlspecialchars($chat['owner_name']) ?>"
                    class="rounded-circle"
                    style="width: 40px; height: 40px; object-fit: cover; flex-shrink: 0;" />
                  <div class="flex-grow-1 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center mb-0.5">
                      <strong class="small text-dark text-truncate"><?= htmlspecialchars($chat['owner_name']) ?></strong>
                      <span class="fs-xs text-muted"><?= htmlspecialchars($chat['last_time']) ?></span>
                    </div>
                    <span class="extra-small text-primary d-block fw-semibold mb-1">
                      <?= htmlspecialchars($chat['property_title']) ?>
                    </span>
                    <p class="extra-small text-secondary-custom mb-0 text-truncate">
                      <?= htmlspecialchars($chat['last_message']) ?>
                    </p>
                  </div>
                  <?php if ($chat['unread'] > 0): ?>
                    <span class="badge bg-danger rounded-pill extra-small"><?= $chat['unread'] ?></span>
                  <?php endif; ?>
                </a>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="text-center text-secondary-custom py-4">
                <i class="fas fa-comment-slash fa-2x d-block mb-2 text-muted"></i>
                <span>No messages yet.</span>
                <br>
                <span class="extra-small">Start a conversation with property owners!</span>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>