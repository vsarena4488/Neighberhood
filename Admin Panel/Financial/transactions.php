<?php
// Financial/transactions.php - Admin Panel Detailed Transactions Ledger
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Financial > Transactions Ledger';
$pageTitle = 'Transactions Ledger';

$query = "SELECT p.*, u.name as user_name, o.name as owner_name, b.property_id, pr.title as property_title
          FROM payments p
          JOIN users u ON p.user_id = u.id
          JOIN users o ON p.owner_id = o.id
          LEFT JOIN bookings b ON p.booking_id = b.id
          LEFT JOIN properties pr ON b.property_id = pr.id
          ORDER BY p.created_at DESC";
$transactions = dbFetchAll($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Transactions Ledger</title>
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
        .table-nn th { background: #F1F5F9; color: var(--nn-text-secondary); font-size: 0.8rem; text-transform: uppercase; }
    </style>
</head>
<body>
    <?php include '../sidebar.php'; ?>
    <div class="main-content">
        <?php include '../top_nevbar.php'; ?>
        
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="heading-font h3 mb-1">📑 Transaction Ledger</h1>
                    <p class="text-secondary small mb-0">Complete historical financial ledger across all accommodation reservations.</p>
                </div>
                <a href="payments.php" class="btn btn-outline-secondary btn-sm px-3 rounded-pill"><i class="fas fa-arrow-left me-1"></i> Back to Payments</a>
            </div>

            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-nn">
                        <thead>
                            <tr>
                                <th class="ps-4">Reference ID</th>
                                <th>Booking</th>
                                <th>Property</th>
                                <th>From (Tenant)</th>
                                <th>To (Host)</th>
                                <th>Category</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $t): ?>
                                <tr>
                                    <td class="ps-4 font-monospace fw-bold text-primary"><?= htmlspecialchars($t['id']) ?></td>
                                    <td><span class="badge bg-light text-dark border"><?= htmlspecialchars($t['booking_id']) ?></span></td>
                                    <td class="fw-semibold text-truncate" style="max-width: 180px;"><?= htmlspecialchars($t['property_title'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($t['user_name']) ?></td>
                                    <td><?= htmlspecialchars($t['owner_name']) ?></td>
                                    <td><?= htmlspecialchars($t['payment_type']) ?></td>
                                    <td><?= htmlspecialchars($t['method']) ?></td>
                                    <td class="fw-bold">₹<?= number_format($t['amount'], 2) ?></td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><?= htmlspecialchars($t['status']) ?></span></td>
                                    <td class="text-end pe-4 text-muted small"><?= date('d M Y, H:i:s', strtotime($t['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
