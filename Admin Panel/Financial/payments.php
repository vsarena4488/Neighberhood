<?php
// Financial/payments.php - Admin Panel Payment Management
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Financial > Payment Management';
$pageTitle = 'Payment Management';

// Fetch Payment Stats from DB
$totalRevenue = dbFetchOne("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = 'Completed'")['total'];
$tokenEscrow = dbFetchOne("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE payment_type = 'Token Deposit' AND status = 'Completed'")['total'];
$pendingPayouts = dbFetchOne("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = 'Pending'")['total'];
$disputesCount = dbFetchOne("SELECT COUNT(*) as cnt FROM disputes WHERE status = 'Open'")['cnt'];

// Filter parameters
$statusFilter = $_GET['status'] ?? '';
$searchQuery = trim($_GET['q'] ?? '');

$query = "SELECT p.*, u.name as user_name, u.email as user_email, o.name as owner_name 
          FROM payments p
          JOIN users u ON p.user_id = u.id
          JOIN users o ON p.owner_id = o.id
          WHERE 1=1";
$params = [];

if ($statusFilter) {
    $query .= " AND p.status = ?";
    $params[] = $statusFilter;
}
if ($searchQuery) {
    $query .= " AND (p.id LIKE ? OR u.name LIKE ? OR o.name LIKE ?)";
    $like = "%$searchQuery%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}
$query .= " ORDER BY p.created_at DESC";
$payments = dbFetchAll($query, $params);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Payment Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        :root {
            --nn-primary: #1E3A5F;
            --nn-primary-light: #4F46E5;
            --nn-gradient: linear-gradient(135deg, #1E3A5F 0%, #4F46E5 100%);
            --nn-lavender: #EEF2FF;
            --nn-success: #10B981;
            --nn-amber: #F59E0B;
            --nn-danger: #EF4444;
            --nn-teal: #0D9488;
            --nn-white: #FFFFFF;
            --nn-bg-light: #F8FAFC;
            --nn-text-primary: #1E293B;
            --nn-text-secondary: #64748B;
            --nn-border: #E2E8F0;
            --nn-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            --nn-radius-sm: 12px;
            --nn-sidebar-width: 260px;
        }
        body { font-family: 'Inter', sans-serif; background: var(--nn-bg-light); color: var(--nn-text-primary); }
        .heading-font { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; }
        .main-content { margin-left: var(--nn-sidebar-width); min-height: 100vh; }
        @media (max-width: 992px) { .main-content { margin-left: 0 !important; } }
        .page-content { padding: 1.5rem 1.5rem 2rem; }
        .stat-card {
            background: #fff; border-radius: var(--nn-radius-sm); padding: 1.25rem;
            border: 1px solid var(--nn-border); box-shadow: var(--nn-shadow);
        }
        .stat-number { font-size: 1.75rem; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--nn-primary); }
        .table-nn th { background: #F1F5F9; color: var(--nn-text-secondary); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; }
    </style>
</head>
<body>
    <?php include '../sidebar.php'; ?>
    <div class="main-content">
        <?php include '../top_nevbar.php'; ?>
        
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="heading-font h3 mb-1">💳 Payment Management</h1>
                    <p class="text-secondary small mb-0">Overview of student token deposits, escrow balance, host payouts, and transaction history.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="transactions.php" class="btn btn-outline-primary btn-sm px-3 rounded-pill"><i class="fas fa-list me-1"></i> Transactions</a>
                    <a href="disputes.php" class="btn btn-outline-danger btn-sm px-3 rounded-pill"><i class="fas fa-exclamation-triangle me-1"></i> Disputes (<?= $disputesCount ?>)</a>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="text-secondary small fw-semibold">Total Platform Volume</div>
                        <div class="stat-number mt-1 text-primary">₹<?= number_format($totalRevenue, 2) ?></div>
                        <span class="badge bg-success-subtle text-success mt-2"><i class="fas fa-check-circle me-1"></i> Verified Escrow</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="text-secondary small fw-semibold">Token Deposits Held</div>
                        <div class="stat-number mt-1 text-success">₹<?= number_format($tokenEscrow, 2) ?></div>
                        <span class="badge bg-info-subtle text-info mt-2">₹500 / Reservation</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="text-secondary small fw-semibold">Pending Host Payouts</div>
                        <div class="stat-number mt-1 text-warning">₹<?= number_format($pendingPayouts, 2) ?></div>
                        <span class="badge bg-warning-subtle text-warning mt-2">Awaiting Release</span>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="text-secondary small fw-semibold">Disputed Amounts</div>
                        <div class="stat-number mt-1 text-danger"><?= $disputesCount ?> Case(s)</div>
                        <span class="badge bg-danger-subtle text-danger mt-2">Resolution Required</span>
                    </div>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="card border-0 rounded-4 shadow-sm bg-white p-3 mb-4">
                <form method="GET" class="row g-2 align-items-center">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control bg-light border-start-0" placeholder="Search by TXN ID, student or owner name..." value="<?= htmlspecialchars($searchQuery) ?>" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select bg-light" onchange="this.form.submit()">
                            <option value="">All Statuses</option>
                            <option value="Completed" <?= $statusFilter === 'Completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="Pending" <?= $statusFilter === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Refunded" <?= $statusFilter === 'Refunded' ? 'selected' : '' ?>>Refunded</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
                    </div>
                    <div class="col-md-2">
                        <a href="payments.php" class="btn btn-outline-secondary w-100">Reset</a>
                    </div>
                </form>
            </div>

            <!-- Payments Table -->
            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-nn">
                        <thead>
                            <tr>
                                <th class="ps-4">TXN ID</th>
                                <th>Booking Ref</th>
                                <th>Student / Payer</th>
                                <th>Property Host</th>
                                <th>Payment Type</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($payments)): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">No payments found matching criteria.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($payments as $p): ?>
                                    <tr>
                                        <td class="ps-4 fw-bold font-monospace text-primary"><?= htmlspecialchars($p['id']) ?></td>
                                        <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($p['booking_id']) ?></span></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($p['user_name']) ?></div>
                                            <div class="extra-small text-muted"><?= htmlspecialchars($p['user_email']) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($p['owner_name']) ?></td>
                                        <td><?= htmlspecialchars($p['payment_type']) ?></td>
                                        <td><span class="badge bg-light text-secondary border"><i class="fas fa-wallet me-1"></i> <?= htmlspecialchars($p['method']) ?></span></td>
                                        <td class="fw-bold text-dark">₹<?= number_format($p['amount'], 2) ?></td>
                                        <td>
                                            <?php if ($p['status'] === 'Completed'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Completed</span>
                                            <?php elseif ($p['status'] === 'Pending'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1"><?= htmlspecialchars($p['status']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4 text-muted small"><?= date('M d, Y H:i', strtotime($p['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
