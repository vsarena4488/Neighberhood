<?php
// Financial/disputes.php - Admin Panel Disputes Center
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Financial > Disputes & Resolutions';
$pageTitle = 'Disputes & Resolutions';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $disputeId = (int)($_POST['dispute_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    
    if ($disputeId > 0 && in_array($action, ['Resolve', 'Refund', 'Dismiss'])) {
        $newStatus = ($action === 'Dismiss') ? 'Dismissed' : (($action === 'Refund') ? 'Refunded' : 'Resolved');
        dbExecute("UPDATE disputes SET status = ? WHERE id = ?", [$newStatus, $disputeId]);
        logActivity("Dispute Updated", "Dispute #$disputeId marked as $newStatus");
        $message = "Dispute #$disputeId has been marked as $newStatus.";
    }
}

$disputes = dbFetchAll("SELECT d.*, u.name as user_name, u.email as user_email, o.name as owner_name, o.phone as owner_phone, b.property_id
                        FROM disputes d
                        JOIN users u ON d.user_id = u.id
                        JOIN users o ON d.owner_id = o.id
                        LEFT JOIN bookings b ON d.booking_id = b.id
                        ORDER BY d.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Dispute Resolutions</title>
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
                    <h1 class="heading-font h3 mb-1">⚖️ Dispute Resolution Center</h1>
                    <p class="text-secondary small mb-0">Review claims, security deposit conflicts, and mediation between students and property owners.</p>
                </div>
                <a href="payments.php" class="btn btn-outline-secondary btn-sm px-3 rounded-pill"><i class="fas fa-arrow-left me-1"></i> Payments</a>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Dispute ID</th>
                                <th>Booking Ref</th>
                                <th>Complainant (Tenant)</th>
                                <th>Host (Owner)</th>
                                <th>Disputed Amount</th>
                                <th>Reason / Claim</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Mediation Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($disputes)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No open disputes registered.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($disputes as $d): ?>
                                    <tr>
                                        <td class="ps-4 font-monospace fw-bold text-danger">#DSP-<?= $d['id'] ?></td>
                                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($d['booking_id']) ?></span></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($d['user_name']) ?></div>
                                            <div class="extra-small text-muted"><?= htmlspecialchars($d['user_email']) ?></div>
                                        </td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($d['owner_name']) ?></div>
                                            <div class="extra-small text-muted"><?= htmlspecialchars($d['owner_phone']) ?></div>
                                        </td>
                                        <td class="fw-bold text-danger">₹<?= number_format($d['amount'], 2) ?></td>
                                        <td><small class="text-secondary"><?= htmlspecialchars($d['reason']) ?></small></td>
                                        <td>
                                            <?php if ($d['status'] === 'Open'): ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Open</span>
                                            <?php elseif ($d['status'] === 'Resolved'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Resolved</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1"><?= htmlspecialchars($d['status']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <?php if ($d['status'] === 'Open'): ?>
                                                <form method="POST" class="d-inline-flex gap-1">
                                                    <input type="hidden" name="dispute_id" value="<?= $d['id'] ?>">
                                                    <button type="submit" name="action" value="Resolve" class="btn btn-sm btn-outline-success px-2 py-1" title="Mediate & Mark Resolved"><i class="fas fa-check"></i></button>
                                                    <button type="submit" name="action" value="Refund" class="btn btn-sm btn-outline-primary px-2 py-1" title="Approve Refund to Student"><i class="fas fa-undo"></i></button>
                                                    <button type="submit" name="action" value="Dismiss" class="btn btn-sm btn-outline-secondary px-2 py-1" title="Dismiss Dispute"><i class="fas fa-times"></i></button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-muted small"><i class="fas fa-lock me-1"></i> Closed</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
