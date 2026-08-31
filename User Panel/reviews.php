<?php
require_once __DIR__ . '/includes/functions.php';

$allProperties = getPropertiesData();
$reviews = &$_SESSION['user_reviews'];

// Handle New Review Submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propId = intval($_POST['property_id'] ?? 101);
    $rating = intval($_POST['rating'] ?? 5);
    $comment = trim($_POST['comment'] ?? '');

    $targetProp = null;
    foreach ($allProperties as $p) {
        if ($p['id'] === $propId) {
            $targetProp = $p;
            break;
        }
    }

    if (!empty($comment) && $targetProp) {
        $reviews[] = [
            'id' => 'rev_' . (count($reviews) + 1),
            'property_id' => $targetProp['id'],
            'property_title' => $targetProp['title'],
            'location' => $targetProp['area'] . ', ' . $targetProp['city'],
            'rating' => $rating,
            'stay_period' => 'Recent Stay (2026)',
            'comment' => $comment,
            'posted_at' => 'Just now',
            'photos' => [$targetProp['image']]
        ];
        $message = 'Your accommodation review has been posted successfully!';
    }
}

$pageTitle = 'My Reviews · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">My Accommodation Reviews (<?= count($reviews) ?>)</h3>
        <span class="text-secondary-custom small">Share your authentic stay experiences to help fellow students and tenants find good homes</span>
      </div>

      <button type="button" class="btn btn-sm btn-nh-primary px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#writeReviewModal">
        <i class="fas fa-pen-to-square me-1"></i> Write a Review
      </button>
    </div>

    <?php if (!empty($message)): ?>
      <div class="alert alert-success alert-dismissible fade show rounded-4 border-0 shadow-sm mb-4 small" role="alert">
        <i class="fas fa-circle-check me-2"></i> <?= htmlspecialchars($message) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- Reviews List -->
    <div class="d-flex flex-column gap-3 mb-4">
      <?php if (empty($reviews)): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-5 text-center my-3">
          <div class="p-4 bg-soft-lavender rounded-circle d-inline-flex mx-auto mb-3 text-warning" style="width: 70px; height: 70px; align-items: center; justify-content: center; font-size: 1.8rem;">
            <i class="fas fa-star"></i>
          </div>
          <h5 class="fw-bold mb-1">No Reviews Written Yet</h5>
          <p class="text-secondary-custom small mb-4 max-w-md mx-auto">Have you completed a stay at any student PG or hostel? Share your rating on food hygiene, internet speed, and security.</p>
          <button type="button" class="btn btn-nh-primary px-4 py-2 mx-auto" data-bs-toggle="modal" data-bs-target="#writeReviewModal">
            Write Your First Review
          </button>
        </div>
      <?php else: ?>
        <?php foreach ($reviews as $rev): ?>
          <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom gap-2">
              <div>
                <h5 class="fw-bold mb-1">
                  <a href="property-details.php?id=<?= $rev['property_id'] ?>" class="text-dark text-decoration-none"><?= htmlspecialchars($rev['property_title']) ?></a>
                </h5>
                <span class="extra-small text-secondary-custom"><i class="fas fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($rev['location']) ?> · Stay: <?= htmlspecialchars($rev['stay_period']) ?></span>
              </div>

              <div class="d-flex align-items-center gap-2">
                <span class="badge bg-warning text-dark px-3 py-1.5 fw-bold fs-6">
                  <i class="fas fa-star me-1"></i> <?= $rev['rating'] ?>.0
                </span>
              </div>
            </div>

            <p class="small text-secondary-custom leading-relaxed mb-3">
              "<?= htmlspecialchars($rev['comment']) ?>"
            </p>

            <?php if (!empty($rev['photos'])): ?>
              <div class="d-flex gap-2 mb-3">
                <?php foreach ($rev['photos'] as $pImg): ?>
                  <img src="<?= htmlspecialchars($pImg) ?>" alt="Review photo" class="rounded-3" style="width: 70px; height: 70px; object-fit: cover;" />
                <?php endforeach; ?>
              </div>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center extra-small text-muted pt-2 border-top">
              <span>Posted on <?= htmlspecialchars($rev['posted_at']) ?></span>
              <div>
                <button class="btn btn-link btn-sm text-secondary-custom text-decoration-none p-0 me-3" onclick="alert('Review edit window simulated.')"><i class="fas fa-pen me-1"></i> Edit</button>
                <button class="btn btn-link btn-sm text-danger text-decoration-none p-0" onclick="alert('Review deleted.')"><i class="fas fa-trash-can me-1"></i> Delete</button>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

    <!-- WRITE REVIEW MODAL (PM Spec) -->
    <div class="modal fade" id="writeReviewModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg p-4">
          <div class="modal-header border-0 pb-0 px-0">
            <h5 class="modal-title fw-bold"><i class="fas fa-star text-warning me-2"></i> Write Accommodation Review</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form action="reviews.php" method="POST" class="mt-3">
            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary mb-1">Select Stay / Accommodation *</label>
              <select name="property_id" class="form-select rounded-3" required>
                <?php foreach ($allProperties as $p): ?>
                  <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['title']) ?> (<?= htmlspecialchars($p['area']) ?>)</option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary mb-1">Star Rating (1 to 5 Stars) *</label>
              <select name="rating" class="form-select rounded-3" required>
                <option value="5">★★★★★ 5.0 - Excellent Experience</option>
                <option value="4">★★★★☆ 4.0 - Good Stay</option>
                <option value="3">★★★☆☆ 3.0 - Average</option>
                <option value="2">★★☆☆☆ 2.0 - Below Average</option>
                <option value="1">★☆☆☆☆ 1.0 - Poor</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold text-secondary mb-1">Your Detailed Review & Feedback *</label>
              <textarea name="comment" class="form-control rounded-3" rows="4" placeholder="Tell other students about room hygiene, food taste, Wi-Fi reliability, and owner responsiveness..." required></textarea>
            </div>

            <div class="mb-4">
              <label class="form-label small fw-bold text-secondary mb-1">Add Photos (Optional)</label>
              <input type="file" class="form-control rounded-3" accept="image/*" />
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-nh-primary py-2">
                <i class="fas fa-paper-plane me-1"></i> Submit Verified Review
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
