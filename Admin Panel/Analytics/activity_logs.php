<?php
// Analytics/activity_logs.php - Admin Panel System Activity Logs
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Analytics > Activity Logs';
$pageTitle = 'Activity Logs';

$logs = dbFetchAll("SELECT a.*, u.name as user_name, u.email as user_email, u.role as user_role
                    FROM activity_logs a
                    LEFT JOIN users u ON a.user_id = u.id
                    ORDER BY a.created_at DESC LIMIT 50");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Activity Logs</title>
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
                    <h1 class="heading-font h3 mb-1">📜 Platform Activity & Audit Logs</h1>
                    <p class="text-secondary small mb-0">Immutable system action logs tracking admin actions, registrations, property approvals, and payouts.</p>
                </div>
            </div>

            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Log ID</th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Action Performed</th>
                                <th>Event Details</th>
                                <th>IP Address</th>
                                <th class="text-end pe-4">Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($logs as $l): ?>
                                <tr>
                                    <td class="ps-4 font-monospace small text-muted">#LOG-<?= $l['id'] ?></td>
                                    <td>
                                        <div class="fw-semibold small"><?= htmlspecialchars($l['user_name'] ?? 'System / Anonymous') ?></div>
                                        <div class="extra-small text-muted"><?= htmlspecialchars($l['user_email'] ?? '-') ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border"><?= htmlspecialchars($l['user_role'] ?? 'guest') ?></span>
                                    </td>
                                    <td class="fw-bold small text-primary"><?= htmlspecialchars($l['action']) ?></td>
                                    <td><small class="text-secondary"><?= htmlspecialchars($l['details']) ?></small></td>
                                    <td><code class="text-dark extra-small"><?= htmlspecialchars($l['ip_address']) ?></code></td>
                                    <td class="text-end pe-4 text-muted small"><?= date('M d, Y H:i:s', strtotime($l['created_at'])) ?></td>
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
