<?php
// Community/reviews.php - Admin Panel Reviews Moderation
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Community > Reviews Management';
$pageTitle = 'Reviews Management';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reviewId = (int)($_POST['review_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    
    if ($reviewId > 0 && $action === 'delete') {
        dbExecute("DELETE FROM reviews WHERE id = ?", [$reviewId]);
        logActivity("Review Deleted", "Admin removed review #$reviewId");
        $message = "Review #$reviewId removed successfully.";
    }
}

$ratingFilter = $_GET['rating'] ?? '';
$sql = "SELECT r.*, p.title as property_title, u.name as user_name, u.avatar as user_avatar, u.email as user_email
        FROM reviews r
        JOIN properties p ON r.property_id = p.id
        JOIN users u ON r.user_id = u.id
        WHERE 1=1";
$params = [];
if ($ratingFilter) {
    $sql .= " AND r.rating = ?";
    $params[] = $ratingFilter;
}
$sql .= " ORDER BY r.created_at DESC";
$reviews = dbFetchAll($sql, $params);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Reviews Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        :root {
            --nn-primary: #1E3A5F;
            --nn-primary-light: #4F46E5;
            --nn-bg-light: #F8FAFC;
            --nn-text-primary: #1E293B;
            --nn-text-secondary: #64748B;
            --nn-border: #E2E8F0;
            --nn-sidebar-width: 260px;
        }
        body { font-family: 'Inter', sans-serif; background: var(--nn-bg-light); color: var(--nn-text-primary); }
        .heading-font { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
        .main-content { margin-left: var(--nn-sidebar-width); min-height: 100vh; }
        @media (max-width: 992px) { .main-content { margin-left: 0 !important; } }
        .page-content { padding: 1.5rem 1.5rem 2rem; }
    </style>
</head>
<body>
    <?php include '../sidebar.php'; ?>
    <div class="main-content">
        <?php include '../top_nevbar.php'; ?>
        
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="heading-font h3 mb-1">⭐ Reviews & Rating Moderation</h1>
                    <p class="text-secondary small mb-0">Oversee all tenant stay reviews, owner responses, and feedback integrity.</p>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4">
                    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Rating Filters -->
            <div class="d-flex gap-2 mb-4">
                <a href="reviews.php" class="btn btn-sm <?= empty($ratingFilter) ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">All Stars</a>
                <a href="reviews.php?rating=5" class="btn btn-sm <?= $ratingFilter === '5' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">5 Stars ⭐</a>
                <a href="reviews.php?rating=4" class="btn btn-sm <?= $ratingFilter === '4' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">4 Stars ⭐</a>
                <a href="reviews.php?rating=3" class="btn btn-sm <?= $ratingFilter === '3' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">3 Stars & Below</a>
            </div>

            <!-- Reviews Grid -->
            <div class="row g-3">
                <?php foreach ($reviews as $rev): ?>
                    <div class="col-md-6">
                        <div class="card border-0 rounded-4 shadow-sm bg-white p-3 h-100">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?= htmlspecialchars($rev['user_avatar']) ?>" alt="User" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold small"><?= htmlspecialchars($rev['user_name']) ?></div>
                                        <div class="extra-small text-muted"><?= htmlspecialchars($rev['user_email']) ?></div>
                                    </div>
                                </div>
                                <div class="text-warning small">
                                    <?= str_repeat('<i class="fas fa-star"></i> ', $rev['rating']) ?>
                                </div>
                            </div>
                            <div class="mb-2">
                                <span class="badge bg-light text-dark border extra-small"><i class="fas fa-building me-1 text-primary"></i> <?= htmlspecialchars($rev['property_title']) ?></span>
                            </div>
                            <p class="text-secondary small mb-3 flex-grow-1">"<?= htmlspecialchars($rev['comment']) ?>"</p>
                            <?php if ($rev['owner_reply']): ?>
                                <div class="p-2 rounded-3 bg-light border-start border-4 border-primary extra-small text-muted mb-2">
                                    <strong class="text-dark d-block">Owner Reply:</strong>
                                    <?= htmlspecialchars($rev['owner_reply']) ?>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top extra-small text-muted">
                                <span><?= date('M d, Y', strtotime($rev['created_at'])) ?></span>
                                <form method="POST" onsubmit="return confirm('Remove this review?');">
                                    <input type="hidden" name="review_id" value="<?= $rev['id'] ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2 rounded-pill"><i class="fas fa-trash me-1"></i> Remove</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
