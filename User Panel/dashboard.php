<?php
$pageTitle = 'Dashboard · NeighborNest User Portal';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <!-- Welcome Header Banner -->
    <div class="card border-0 rounded-4 p-4 p-md-5 mb-4 shadow-sm" style="background: var(--nh-gradient-hero); border: 1px solid var(--nh-lavender-border) !important;">
      <div class="row align-items-center gy-4">
        <div class="col-lg-7">
          <span class="badge bg-soft-lavender text-royal-blue border border-primary-subtle rounded-pill px-3 py-2 mb-2 font-weight-bold">
            <i class="fas fa-graduation-cap me-1 text-bright-indigo"></i> <?= htmlspecialchars($user['course'] ?? 'Student') ?>
          </span>
          <h2 class="display-6 fw-bold mb-2">Welcome back, <?= htmlspecialchars(explode(' ', $user['name'] ?? 'Vishal')[0]) ?>! 👋</h2>
          <p class="text-secondary-custom mb-4 small leading-relaxed">
            Find and manage your verified student PGs, hostels, and rental accommodations across Bangalore and top Indian cities with zero brokerage.
          </p>

          <!-- Dashboard Global Search Bar -->
          <form action="search.php" method="GET" class="d-flex flex-column flex-sm-row gap-2 bg-white p-2 rounded-4 shadow-sm border">
            <div class="input-group border-0">
              <span class="input-group-text bg-transparent border-0 text-bright-indigo ps-3"><i class="fas fa-location-dot"></i></span>
              <input type="text" name="q" class="form-control border-0 shadow-none ps-1" placeholder="Search by city, area, college (e.g. Koramangala, Christ Univ)..." />
            </div>
            <button type="submit" class="btn btn-nh-primary px-4 py-2 flex-shrink-0">
              <i class="fas fa-search me-1"></i> Search Places
            </button>
          </form>
        </div>

        <div class="col-lg-5 text-center text-lg-end d-none d-lg-block">
          <img src="https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?auto=format&fit=crop&w=500&q=80" alt="Accommodation" class="rounded-4 shadow img-fluid" style="max-height: 200px; object-fit: cover; width: 85%;" />
        </div>
      </div>
    </div>

    <!-- 4 Statistics Cards -->
    <div class="row g-3 g-md-4 mb-4">
      <div class="col-6 col-lg-3">
        <a href="wishlist.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #FEF3C7; color: #D97706;">
              <i class="fas fa-heart"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark"><?= count($_SESSION['user_wishlist'] ?? []) ?></h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Saved Wishlist</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a href="bookings.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #EEF2FF; color: #4F46E5;">
              <i class="fas fa-calendar-check"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark"><?= count($_SESSION['user_bookings'] ?? []) ?></h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Total Bookings</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a href="bookings.php?status=Active" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #DCFCE7; color: #16A34A;">
              <i class="fas fa-house-user"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark">1</h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Active Stays</span>
            </div>
          </div>
        </a>
      </div>

      <div class="col-6 col-lg-3">
        <a href="messages.php" class="text-decoration-none">
          <div class="stat-card">
            <div class="stat-icon-wrapper" style="background: #FEE2E2; color: #EF4444;">
              <i class="fas fa-comment-dots"></i>
            </div>
            <div>
              <h3 class="fw-bold mb-0 text-dark"><?= getUnreadMessagesCount() ?></h3>
              <span class="extra-small text-secondary-custom font-weight-medium">Unread Messages</span>
            </div>
          </div>
        </a>
      </div>
    </div>

    <!-- RECOMMENDED PROPERTIES SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h5 class="fw-bold mb-0">Recommended for You</h5>
        <span class="extra-small text-secondary-custom">Handpicked student accommodations near Christ University</span>
      </div>
      <a href="search.php" class="btn btn-sm btn-nh-outline px-3">View All Listings →</a>
    </div>

    <div class="row g-4 mb-5">
      <?php 
      $properties = getPropertiesData();
      foreach (array_slice($properties, 0, 3) as $item): 
        $genderLabel = ($item['gender'] === 'male_only') ? 'Boys Only' : (($item['gender'] === 'female_only') ? 'Girls Only' : 'Unisex');
        $isWishlisted = in_array($item['id'], $_SESSION['user_wishlist'] ?? []);
      ?>
        <div class="col-md-6 col-lg-4">
          <div class="property-card">
            <div class="card-img-wrapper">
              <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy" />
              <div class="position-absolute top-0 start-0 m-2 d-flex flex-column gap-1">
                <?php if ($item['verified']): ?>
                  <span class="badge bg-success small"><i class="fas fa-check-circle me-1"></i> Verified</span>
                <?php endif; ?>
                <span class="badge bg-primary small"><?= htmlspecialchars($item['type']) ?></span>
                <span class="badge bg-dark small"><?= htmlspecialchars($genderLabel) ?></span>
              </div>
              <button class="btn btn-sm bg-white text-dark position-absolute top-0 end-0 m-2 rounded-circle shadow-sm border-0" onclick="toggleWishlist(<?= $item['id'] ?>, this)" title="Save to Wishlist">
                <i class="<?= $isWishlisted ? 'fas fa-heart text-danger' : 'far fa-heart' ?>"></i>
              </button>
            </div>

            <div class="p-3 d-flex flex-column flex-grow-1">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <span class="extra-small text-secondary-custom fw-medium text-truncate">
                  <i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($item['area']) ?>
                </span>
                <span class="badge bg-warning text-dark extra-small flex-shrink-0">
                  <i class="fas fa-star me-1"></i> <?= htmlspecialchars($item['rating']) ?>
                </span>
              </div>

              <h6 class="fw-bold mb-2 text-truncate" title="<?= htmlspecialchars($item['title']) ?>">
                <a href="property-details.php?id=<?= $item['id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($item['title']) ?></a>
              </h6>

              <div class="d-flex flex-wrap gap-1 mb-2">
                <?php foreach (array_slice($item['amenities'], 0, 2) as $am): ?>
                  <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1"><i class="fas fa-check me-1 text-success"></i><?= htmlspecialchars($am) ?></span>
                <?php endforeach; ?>
                <?php if (count($item['amenities']) > 2): ?>
                  <span class="badge bg-soft-lavender text-royal-blue extra-small px-2 py-1">+<?= count($item['amenities']) - 2 ?> more</span>
                <?php endif; ?>
              </div>

              <div class="extra-small text-secondary-custom mb-3 text-truncate">
                <i class="fas fa-route me-1 text-bright-indigo"></i> <?= htmlspecialchars($item['nearby'][0] ?? 'Prime location') ?>
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

    <div class="row g-4">
      <!-- RECENT BOOKINGS TABLE -->
      <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm bg-white h-100">
          <div class="p-3.5 px-4 border-bottom d-flex justify-content-between align-items-center">
            <div>
              <h5 class="fw-bold mb-0">My Recent Bookings</h5>
              <span class="extra-small text-secondary-custom">Track your accommodation request status</span>
            </div>
            <a href="bookings.php" class="extra-small text-primary text-decoration-none fw-semibold">View All Bookings →</a>
          </div>

          <div class="p-0 table-responsive">
            <table class="table align-middle mb-0 small">
              <thead class="table-light">
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
                foreach (array_slice($bookings, 0, 3) as $bk): 
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
              <h5 class="fw-bold mb-0">Recent Messages</h5>
              <span class="extra-small text-secondary-custom">Direct chat with verified landlords</span>
            </div>
            <a href="messages.php" class="extra-small text-primary text-decoration-none fw-semibold">Open Chat →</a>
          </div>

          <div class="p-3 d-flex flex-column gap-2">
            <?php 
            $chats = $_SESSION['user_chats'] ?? [];
            foreach (array_slice($chats, 0, 3) as $chat): 
            ?>
              <a href="messages.php?chat=<?= $chat['id'] ?>" class="p-2.5 rounded-3 border bg-light text-decoration-none text-dark d-flex align-items-start gap-2.5 transition-all">
                <img src="<?= htmlspecialchars($chat['owner_avatar']) ?>" alt="<?= htmlspecialchars($chat['owner_name']) ?>" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; flex-shrink: 0;" />
                <div class="flex-grow-1 overflow-hidden">
                  <div class="d-flex justify-content-between align-items-center mb-0.5">
                    <strong class="small text-dark text-truncate"><?= htmlspecialchars($chat['owner_name']) ?></strong>
                    <span class="fs-xs text-muted"><?= htmlspecialchars($chat['last_time']) ?></span>
                  </div>
                  <span class="extra-small text-primary d-block fw-semibold mb-1"><?= htmlspecialchars($chat['property_title']) ?></span>
                  <p class="extra-small text-secondary-custom mb-0 text-truncate"><?= htmlspecialchars($chat['last_message']) ?></p>
                </div>
                <?php if ($chat['unread'] > 0): ?>
                  <span class="badge bg-danger rounded-pill extra-small"><?= $chat['unread'] ?></span>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
