<?php
// Settings/settings.php - Admin Panel System Settings
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'System > Platform Settings';
$pageTitle = 'Platform Settings';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = "Settings updated successfully.";
    logActivity("Settings Updated", "Admin updated platform parameters");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Platform Settings</title>
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
                    <h1 class="heading-font h3 mb-1">⚙️ Platform & Security Settings</h1>
                    <p class="text-secondary small mb-0">Configure token deposit rules, commission margins, notification gateways, and system maintenance.</p>
                </div>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4">
                    <i class="fas fa-check-circle me-2"></i> <?= htmlspecialchars($message) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                        <h5 class="fw-bold mb-4">General Platform Configurations</h5>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Platform Brand Name</label>
                                <input type="text" class="form-control" name="platform_name" value="NeighborNest" required>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Standard Booking Token Deposit (₹)</label>
                                    <input type="number" class="form-control" name="token_deposit" value="500" required>
                                    <small class="text-muted extra-small">Escrow fee charged to students upon application</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Platform Commission Fee (%)</label>
                                    <input type="number" class="form-control" name="commission_fee" value="2.5" step="0.1" required>
                                    <small class="text-muted extra-small">Charged per successful monthly transaction</small>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Support Helpline Contact</label>
                                    <input type="text" class="form-control" name="support_phone" value="+91 99000 11223">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-semibold">Official Support Email</label>
                                    <input type="email" class="form-control" name="support_email" value="support@neighbornest.com">
                                </div>
                            </div>
                            <hr class="my-4">
                            <h6 class="fw-bold mb-3">Listing Verification Policy</h6>
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input" type="checkbox" id="requireKyc" checked>
                                <label class="form-check-label small" for="requireKyc">Require manual admin verification before publishing new listings</label>
                            </div>
                            <div class="form-check form-switch mb-4">
                                <input class="form-check-input" type="checkbox" id="requireStudentId" checked>
                                <label class="form-check-label small" for="requireStudentId">Require valid Student ID card upload for student discount tags</label>
                            </div>
                            <button type="submit" class="btn btn-primary rounded-pill px-4"><i class="fas fa-save me-1"></i> Save Changes</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 rounded-4 shadow-sm bg-white p-4 mb-4">
                        <h6 class="fw-bold mb-3 text-danger"><i class="fas fa-shield-halved me-1"></i> System Maintenance</h6>
                        <p class="extra-small text-muted mb-3">Enabling maintenance mode will restrict access for regular students and property hosts.</p>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="maintMode">
                            <label class="form-check-label small" for="maintMode">Enable Maintenance Mode</label>
                        </div>
                    </div>

                    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-database me-1 text-primary"></i> Database Status</h6>
                        <div class="extra-small text-muted mb-1">Host: <code>127.0.0.1:3306</code></div>
                        <div class="extra-small text-muted mb-1">Database: <code>neighborhood_db</code></div>
                        <div class="extra-small text-muted mb-3">Charset: <code>utf8mb4</code></div>
                        <span class="badge bg-success-subtle text-success border border-success-subtle w-100 py-2"><i class="fas fa-check-circle me-1"></i> Connected & Synchronized</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
