<?php
// Owner Panel reviews.php - Reputation Management & Owner Review Replies
$pageTitle = 'Property Reviews & Reputation · NeighborNest Owner Console';
require_once __DIR__ . '/includes/functions.php';

// Handle owner reply POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_id'])) {
    $revId = $_POST['review_id'];
    $replyText = trim($_POST['reply_text'] ?? '');
    foreach ($_SESSION['owner_reviews'] as &$r) {
        if ($r['id'] === $revId) {
            $r['owner_reply'] = $replyText;
            break;
        }
    }
    header('Location: reviews.php?replied=1');
    exit;
}

$pageTitle = 'Reviews & Ratings · NeighborNest';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/sidebar.php';

$reviews = $_SESSION['owner_reviews'] ?? [];
?>

<div class="main-wrapper">
  <?php require_once __DIR__ . '/includes/top-navbar.php'; ?>

  <main class="page-content">
    
    <!-- Page Header Title -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
      <div>
        <h3 class="fw-bold mb-1">Reviews & Ratings Management</h3>
        <span class="text-secondary-custom small">Monitor tenant feedback, overall star ratings, and reply to stay reviews</span>
      </div>
    </div>

    <!-- OVERALL RATING METRIC & STAR DISTRIBUTION BANNER -->
    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
      <div class="row align-items-center gy-4">
        <div class="col-md-4 text-center border-end-md">
          <h1 class="display-3 fw-bold text-dark mb-0">4.9</h1>
          <div class="text-warning fs-5 mb-1">
            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
          </div>
          <span class="extra-small text-secondary-custom d-block fw-semibold">Based on 30 Verified Tenant Reviews</span>
        </div>

        <div class="col-md-8">
          <h6 class="fw-bold mb-2">Rating Distribution</h6>
          <div class="d-flex flex-column gap-1.5 extra-small">
            <div class="d-flex align-items-center gap-2">
              <span style="width: 50px;">5 Stars</span>
              <div class="progress flex-grow-1" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 85%;"></div></div>
              <span class="text-muted fw-bold">85%</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span style="width: 50px;">4 Stars</span>
              <div class="progress flex-grow-1" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 12%;"></div></div>
              <span class="text-muted fw-bold">12%</span>
            </div>
            <div class="d-flex align-items-center gap-2">
              <span style="width: 50px;">3 Stars</span>
              <div class="progress flex-grow-1" style="height: 8px;"><div class="progress-bar bg-warning" style="width: 3%;"></div></div>
              <span class="text-muted fw-bold">3%</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- REVIEWS LIST -->
    <div class="d-flex flex-column gap-3.5">
      <?php foreach ($reviews as $rev): ?>
        <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
          <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 pb-2 border-bottom gap-2">
            <div class="d-flex align-items-center gap-3">
              <img src="<?= htmlspecialchars($rev['user_avatar']) ?>" alt="<?= htmlspecialchars($rev['user_name']) ?>" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover;" />
              <div>
                <strong class="d-block text-dark fw-bold mb-0.5"><?= htmlspecialchars($rev['user_name']) ?></strong>
                <span class="extra-small text-muted"><i class="fas fa-building text-primary me-1"></i> <?= htmlspecialchars($rev['property_title']) ?></span>
              </div>
            </div>

            <div class="text-end">
              <div class="text-warning extra-small mb-1">
                <?php for($i=0; $i<$rev['rating']; $i++): ?><i class="fas fa-star"></i><?php endfor; ?>
              </div>
              <span class="fs-xs text-muted"><?= htmlspecialchars($rev['posted_at']) ?></span>
            </div>
          </div>

          <p class="extra-small text-dark mb-3" style="line-height: 1.6;">
            "<?= htmlspecialchars($rev['comment']) ?>"
          </p>

          <!-- OFFICIAL OWNER REPLY DISPLAY -->
          <?php if (!empty($rev['owner_reply'])): ?>
            <div class="p-3 bg-soft-lavender rounded-3 border-start border-primary border-4 mb-2 extra-small">
              <strong class="text-royal-blue d-block mb-1"><i class="fas fa-reply me-1"></i> Host Response from Rajesh Sharma:</strong>
              <p class="mb-0 text-dark"><?= htmlspecialchars($rev['owner_reply']) ?></p>
            </div>
          <?php else: ?>
            <button class="btn btn-sm btn-nh-outline align-self-start" data-bs-toggle="modal" data-bs-target="#replyModal_<?= $rev['id'] ?>">
              <i class="fas fa-reply me-1"></i> Post Owner Reply
            </button>
          <?php endif; ?>
        </div>

        <!-- OWNER REPLY MODAL -->
        <div class="modal fade" id="replyModal_<?= $rev['id'] ?>" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 rounded-4 shadow">
              <div class="modal-header border-bottom px-4 py-3">
                <h5 class="modal-title fw-bold fs-6"><i class="fas fa-reply text-bright-indigo me-2"></i> Reply to <?= htmlspecialchars($rev['user_name']) ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <form action="reviews.php" method="POST">
                <input type="hidden" name="review_id" value="<?= $rev['id'] ?>" />
                <div class="modal-body p-4">
                  <label class="form-label small fw-bold text-secondary mb-1">Your Response Message</label>
                  <textarea name="reply_text" class="form-control rounded-3" rows="4" placeholder="Thank the student tenant or address their feedback professionally..." required></textarea>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light">
                  <button type="button" class="btn btn-light border px-3" data-bs-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-nh-primary px-4"><i class="fas fa-paper-plane me-1"></i> Post Public Reply</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
