<?php
// Community/complaints.php - Admin Panel Complaints Tracker
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Community > Tenant Complaints';
$pageTitle = 'Tenant Complaints';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaintId = (int)($_POST['complaint_id'] ?? 0);
    $status = $_POST['status'] ?? '';
    
    if ($complaintId > 0 && in_array($status, ['Investigating', 'Resolved', 'Dismissed'])) {
        dbExecute("UPDATE complaints SET status = ? WHERE id = ?", [$status, $complaintId]);
        logActivity("Complaint Updated", "Complaint #$complaintId marked as $status");
        $message = "Complaint #$complaintId updated to $status.";
    }
}

$complaints = dbFetchAll("SELECT c.*, u.name as user_name, u.email as user_email, u.phone as user_phone, p.title as property_title
                          FROM complaints c
                          JOIN users u ON c.user_id = u.id
                          LEFT JOIN properties p ON c.property_id = p.id
                          ORDER BY c.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Tenant Complaints</title>
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
                    <h1 class="heading-font h3 mb-1">📢 Community & Tenant Complaints</h1>
                    <p class="text-secondary small mb-0">Track and escalate accommodation grievances, amenities issues, and safety reports.</p>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4">
                    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Ticket ID</th>
                                <th>Student</th>
                                <th>Property</th>
                                <th>Subject</th>
                                <th>Details</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($complaints)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No complaints submitted.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($complaints as $c): ?>
                                    <tr>
                                        <td class="ps-4 font-monospace fw-bold text-danger">#CMP-<?= $c['id'] ?></td>
                                        <td>
                                            <div class="fw-semibold"><?= htmlspecialchars($c['user_name']) ?></div>
                                            <div class="extra-small text-muted"><?= htmlspecialchars($c['user_phone']) ?></div>
                                        </td>
                                        <td><?= htmlspecialchars($c['property_title'] ?? 'General') ?></td>
                                        <td class="fw-semibold text-dark"><?= htmlspecialchars($c['title']) ?></td>
                                        <td><small class="text-secondary"><?= htmlspecialchars($c['description']) ?></small></td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1"><?= htmlspecialchars($c['priority']) ?></span>
                                        </td>
                                        <td>
                                            <?php if ($c['status'] === 'Resolved'): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Resolved</span>
                                            <?php elseif ($c['status'] === 'Investigating'): ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">Investigating</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">Open</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end pe-4">
                                            <form method="POST" class="d-inline-flex gap-1">
                                                <input type="hidden" name="complaint_id" value="<?= $c['id'] ?>">
                                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                                    <option value="Open" <?= $c['status'] === 'Open' ? 'selected' : '' ?>>Open</option>
                                                    <option value="Investigating" <?= $c['status'] === 'Investigating' ? 'selected' : '' ?>>Investigate</option>
                                                    <option value="Resolved" <?= $c['status'] === 'Resolved' ? 'selected' : '' ?>>Resolve</option>
                                                    <option value="Dismissed" <?= $c['status'] === 'Dismissed' ? 'selected' : '' ?>>Dismiss</option>
                                                </select>
                                            </form>
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
