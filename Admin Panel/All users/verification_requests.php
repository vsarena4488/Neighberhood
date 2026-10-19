<?php
// users/owner_verification.php - Owner & Student Verification Requests
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'User Management > Verification Requests';
$pageTitle = 'Verification Requests';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetUserId = (int)($_POST['target_user_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    
    if ($targetUserId > 0) {
        if ($action === 'verify') {
            dbExecute("UPDATE users SET is_verified = 1 WHERE id = ?", [$targetUserId]);
            logActivity('User Verified', "Admin approved identity verification for user #$targetUserId");
            $message = "User #$targetUserId verified successfully!";
        } elseif ($action === 'reject') {
            dbExecute("UPDATE users SET is_verified = 0, status = 'pending' WHERE id = ?", [$targetUserId]);
            logActivity('User Rejected', "Admin rejected verification for user #$targetUserId");
            $message = "User #$targetUserId verification rejected.";
        }
    }
}

$requests = dbFetchAll("SELECT u.*, (SELECT COUNT(*) FROM properties WHERE owner_id = u.id) as prop_count
                        FROM users u
                        WHERE u.role IN ('owner', 'user')
                        ORDER BY u.is_verified ASC, u.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Owner Verification</title>

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
            --nn-text-muted: #94A3B8;
            --nn-border: #E2E8F0;
            --nn-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
            --nn-shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.08);
            --nn-radius-sm: 12px;
            --nn-transition: 0.25s ease;
            --nn-sidebar-width: 260px;
            --nn-navbar-height: 64px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--nn-bg-light);
            color: var(--nn-text-primary);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        .heading-font {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .text-secondary-custom {
            color: var(--nn-text-secondary);
        }
        .text-muted-custom {
            color: var(--nn-text-muted);
        }

        .main-content {
            margin-left: var(--nn-sidebar-width);
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        .main-content.expanded {
            margin-left: 72px;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0 !important;
            }
            .main-content.expanded {
                margin-left: 0 !important;
            }
        }

        .page-content {
            padding: 1.5rem 1.5rem 2rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 0.1rem;
        }

        .page-header p {
            color: var(--nn-text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        /* Stats Cards */
        .stat-card {
            background: var(--nn-white);
            border-radius: var(--nn-radius-sm);
            padding: 1.2rem 1.2rem 1rem;
            box-shadow: var(--nn-shadow);
            border: 1px solid var(--nn-border);
            transition: var(--nn-transition);
            height: 100%;
        }

        .stat-card:hover {
            box-shadow: var(--nn-shadow-hover);
            transform: translateY(-2px);
        }

        .stat-card .stat-number {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--nn-primary);
            line-height: 1.1;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--nn-text-secondary);
            font-weight: 500;
        }

        .stat-card .stat-icon {
            font-size: 1.6rem;
            color: var(--nn-primary-light);
            opacity: 0.6;
        }

        /* Table */
        .table-nn {
            background: var(--nn-white);
            border-radius: var(--nn-radius-sm);
            overflow: hidden;
            box-shadow: var(--nn-shadow);
            border: 1px solid var(--nn-border);
        }

        .table-nn thead th {
            background: var(--nn-bg-light);
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--nn-text-muted);
            border-bottom: 1px solid var(--nn-border);
            padding: 0.7rem 1rem;
        }

        .table-nn tbody td {
            font-size: 0.85rem;
            padding: 0.7rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--nn-border);
        }

        .table-nn tbody tr:hover {
            background: var(--nn-bg-light);
        }

        /* Status Badges */
        .status-badge {
            font-size: 0.65rem;
            font-weight: 600;
            padding: 0.15rem 0.7rem;
            border-radius: 40px;
            display: inline-block;
            white-space: nowrap;
        }

        .status-badge.pending {
            background: #FEF3C7;
            color: #D97706;
        }

        .status-badge.verified {
            background: #D1FAE5;
            color: #059669;
        }

        .status-badge.rejected {
            background: #FEE2E2;
            color: #DC2626;
        }

        .status-badge.reviewing {
            background: #DBEAFE;
            color: #2563EB;
        }

        .status-badge.document-missing {
            background: #FCE4EC;
            color: #DC2626;
        }

        /* Buttons */
        .btn-sm-nn {
            padding: 0.2rem 0.8rem;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 40px;
            border: none;
            transition: var(--nn-transition);
        }

        .btn-sm-nn.primary {
            background: var(--nn-primary-light);
            color: #fff;
        }
        .btn-sm-nn.primary:hover {
            background: #4338CA;
        }

        .btn-sm-nn.success {
            background: var(--nn-success);
            color: #fff;
        }
        .btn-sm-nn.success:hover {
            background: #059669;
        }

        .btn-sm-nn.danger {
            background: var(--nn-danger);
            color: #fff;
        }
        .btn-sm-nn.danger:hover {
            background: #DC2626;
        }

        .btn-sm-nn.outline {
            background: transparent;
            color: var(--nn-text-secondary);
            border: 1px solid var(--nn-border);
        }
        .btn-sm-nn.outline:hover {
            background: var(--nn-bg-light);
        }

        .btn-nn-primary {
            background: var(--nn-gradient);
            color: #fff;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--nn-transition);
            box-shadow: 0 8px 24px rgba(79, 70, 229, 0.25);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-nn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 40px rgba(79, 70, 229, 0.35);
            color: #fff;
        }

        .btn-nn-outline {
            background: transparent;
            border: 1.5px solid var(--nn-primary-light);
            color: var(--nn-primary-light);
            padding: 0.5rem 1.5rem;
            border-radius: 60px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--nn-transition);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-nn-outline:hover {
            background: var(--nn-primary-light);
            color: #fff;
            transform: translateY(-3px);
        }

        /* Filter Section */
        .filter-section {
            background: var(--nn-white);
            border-radius: var(--nn-radius-sm);
            padding: 1rem 1.2rem;
            box-shadow: var(--nn-shadow);
            border: 1px solid var(--nn-border);
            margin-bottom: 1.5rem;
        }

        .filter-section .form-control,
        .filter-section .form-select {
            font-size: 0.85rem;
            border-radius: 8px;
            border-color: var(--nn-border);
        }

        .filter-section .form-control:focus,
        .filter-section .form-select:focus {
            border-color: var(--nn-primary-light);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.08);
        }

        /* Document Preview */
        .document-preview {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .document-preview .doc-icon {
            width: 32px;
            height: 32px;
            background: var(--nn-lavender);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            color: var(--nn-primary-light);
            cursor: pointer;
            transition: var(--nn-transition);
        }

        .document-preview .doc-icon:hover {
            background: var(--nn-primary-light);
            color: #fff;
        }

        .document-preview .doc-icon.missing {
            background: #FEE2E2;
            color: var(--nn-danger);
        }

        /* Document Status Badge inside table */
        .doc-status {
            font-size: 0.6rem;
            font-weight: 600;
            padding: 0.1rem 0.5rem;
            border-radius: 40px;
            display: inline-block;
        }

        .doc-status.uploaded {
            background: #D1FAE5;
            color: #059669;
        }

        .doc-status.missing {
            background: #FEE2E2;
            color: #DC2626;
        }

        .doc-status.pending {
            background: #FEF3C7;
            color: #D97706;
        }

        /* Pagination */
        .pagination-custom .page-link {
            color: var(--nn-text-secondary);
            border-color: var(--nn-border);
            font-size: 0.8rem;
        }

        .pagination-custom .page-item.active .page-link {
            background: var(--nn-primary-light);
            border-color: var(--nn-primary-light);
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-content {
                padding: 1rem;
            }
            .page-header h1 {
                font-size: 1.3rem;
            }
            .stat-card .stat-number {
                font-size: 1.4rem;
            }
            .table-nn {
                font-size: 0.75rem;
            }
            .table-nn thead th,
            .table-nn tbody td {
                padding: 0.4rem 0.6rem;
            }
        }

        @media (max-width: 576px) {
            .stat-card {
                padding: 0.8rem;
            }
            .stat-card .stat-number {
                font-size: 1.2rem;
            }
        }

        /* Animations */
        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.5s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .delay-1 {
            animation-delay: 0.05s;
        }
        .delay-2 {
            animation-delay: 0.1s;
        }
        .delay-3 {
            animation-delay: 0.15s;
        }
        .delay-4 {
            animation-delay: 0.2s;
        }

        /* Owner badge */
        .owner-badge {
            background: #EEF2FF;
            color: #4F46E5;
            padding: 0.15rem 0.6rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
            display: inline-block;
        }

        .property-count-badge {
            background: var(--nn-bg-light);
            color: var(--nn-text-secondary);
            padding: 0.1rem 0.6rem;
            border-radius: 40px;
            font-size: 0.65rem;
            font-weight: 600;
            display: inline-block;
        }
    </style>
</head>

<body>

    <?php include '../sidebar.php'; ?>

    <div class="main-content" id="mainContent">

        <?php include '../top_nevbar.php'; ?>

        <div class="page-content">

            <!-- Page Header -->
            <div class="page-header fade-up">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        <h1>🔐 Owner Verification</h1>
                        <p>Review and verify property owner identity, business, and property ownership documents.</p>
                    </div>
                    <div>
                        <span class="badge bg-primary me-2" style="font-size:0.8rem;padding:0.4rem 1rem;">12 Pending</span>
                        <span class="badge bg-success" style="font-size:0.8rem;padding:0.4rem 1rem;">34 Verified Today</span>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-3 fade-up delay-1">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">12</div>
                                <div class="stat-label">Pending Verification</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-clock" style="color:var(--nn-amber);"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-2">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">6</div>
                                <div class="stat-label">Under Review</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-search" style="color:var(--nn-primary-light);"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">34</div>
                                <div class="stat-label">Verified (Today)</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-check-circle" style="color:var(--nn-success);"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">5</div>
                                <div class="stat-label">Rejected</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-times-circle" style="color:var(--nn-danger);"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section fade-up delay-1">
                <div class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-secondary-custom">Search</label>
                        <input type="text" class="form-control" placeholder="Search by name, email, or business..." />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-secondary-custom">Verification Status</label>
                        <select class="form-select">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="reviewing">Under Review</option>
                            <option value="verified">Verified</option>
                            <option value="rejected">Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold text-secondary-custom">Document Status</label>
                        <select class="form-select">
                            <option value="">All</option>
                            <option value="all-uploaded">All Uploaded</option>
                            <option value="partial">Partial Upload</option>
                            <option value="missing">Missing Docs</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-secondary-custom">Date Range</label>
                        <div class="d-flex gap-2">
                            <input type="date" class="form-control" />
                            <input type="date" class="form-control" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button class="btn-nn-primary w-100"><i class="fas fa-search me-1"></i> Filter</button>
                    </div>
                </div>
            </div>

            <!-- Owner Verification Table -->
            <div class="fade-up delay-2">
                <div class="table-responsive">
                    <table class="table table-nn mb-0">
                        <thead>
                            <tr>
                                <th>Owner</th>
                                <th>Business Name</th>
                                <th>Properties</th>
                                <th>Documents</th>
                                <th>Submitted</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($requests)): ?>
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No verification requests found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $u): ?>
                                    <tr>
                                        <td>
                                            <span class="fw-medium"><?= htmlspecialchars($u['name']) ?></span><br />
                                            <span class="text-muted-custom small"><?= htmlspecialchars($u['email']) ?> (<?= htmlspecialchars($u['phone'] ?? '') ?>)</span>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($u['company_name'] ?: ($u['college'] ?: ($u['role'] === 'owner' ? 'Individual Host' : 'Student'))) ?>
                                            <span class="badge bg-light text-secondary border ms-1"><?= ucfirst($u['role']) ?></span>
                                        </td>
                                        <td><span class="property-count-badge"><?= $u['prop_count'] ?> Properties</span></td>
                                        <td>
                                            <div class="document-preview">
                                                <span class="doc-icon" title="Government ID"><i class="fas fa-id-card"></i></span>
                                                <span class="doc-icon" title="Academic / Business Proof"><i class="fas fa-file-alt"></i></span>
                                                <span class="doc-icon <?= $u['is_verified'] ? '' : 'missing' ?>" title="Verification Status"><i class="fas fa-check-circle"></i></span>
                                            </div>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($u['created_at'])) ?></td>
                                        <td>
                                            <?php if ($u['is_verified']): ?>
                                                <span class="status-badge verified">Verified</span>
                                            <?php else: ?>
                                                <span class="status-badge pending">Pending</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <?php if (!$u['is_verified']): ?>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="target_user_id" value="<?= $u['id'] ?>">
                                                    <button type="submit" name="action" value="verify" class="btn-sm-nn success me-1 border-0">Verify</button>
                                                    <button type="submit" name="action" value="reject" class="btn-sm-nn danger border-0">Reject</button>
                                                </form>
                                            <?php else: ?>
                                                <span class="text-success small fw-semibold"><i class="fas fa-shield-check"></i> Approved</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                    <span class="small text-secondary-custom">Showing 1-6 of 42 owner verification requests</span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-custom mb-0">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>

                <!-- Document Legend -->
                <div class="mt-3 p-3 bg-white rounded-3 border d-flex flex-wrap align-items-center gap-3" style="border-color:var(--nn-border);">
                    <span class="small fw-semibold text-secondary-custom">Document Status:</span>
                    <span class="d-flex align-items-center gap-1"><span class="doc-icon" style="width:20px;height:20px;font-size:0.6rem;background:var(--nn-lavender);border-radius:4px;display:inline-flex;align-items:center;justify-content:center;"><i class="fas fa-check" style="color:var(--nn-success);"></i></span> <span class="small">Uploaded</span></span>
                    <span class="d-flex align-items-center gap-1"><span class="doc-icon" style="width:20px;height:20px;font-size:0.6rem;background:#FEE2E2;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;"><i class="fas fa-times" style="color:var(--nn-danger);"></i></span> <span class="small">Missing</span></span>
                    <span class="d-flex align-items-center gap-1"><span class="doc-icon" style="width:20px;height:20px;font-size:0.6rem;background:#FEF3C7;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;"><i class="fas fa-clock" style="color:var(--nn-amber);"></i></span> <span class="small">Pending</span></span>
                    <span class="text-muted-custom small ms-2">Hover over document icons to see details</span>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

    <script>
        (function() {
            'use strict';

            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const toggleBtn = document.getElementById('toggleSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            let isCollapsed = false;
            let isMobile = window.innerWidth < 992;

            function handleSidebarToggle() {
                if (isMobile) {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                } else {
                    isCollapsed = !isCollapsed;
                    sidebar.classList.toggle('collapsed', isCollapsed);
                    mainContent.classList.toggle('expanded', isCollapsed);
                }
            }

            if (toggleBtn) {
                toggleBtn.addEventListener('click', handleSidebarToggle);
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                });
            }

            document.querySelectorAll('.sidebar-nav .nav-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (isMobile) {
                        sidebar.classList.remove('open');
                        overlay.classList.remove('active');
                    }
                    document.querySelectorAll('.sidebar-nav .nav-item').forEach(el => el.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            function handleResize() {
                const nowMobile = window.innerWidth < 992;
                if (nowMobile !== isMobile) {
                    isMobile = nowMobile;
                    if (isMobile) {
                        sidebar.classList.remove('collapsed');
                        mainContent.classList.remove('expanded');
                        sidebar.classList.remove('open');
                        if (overlay) overlay.classList.remove('active');
                    } else {
                        sidebar.classList.remove('open');
                        if (overlay) overlay.classList.remove('active');
                        if (isCollapsed) {
                            sidebar.classList.add('collapsed');
                            mainContent.classList.add('expanded');
                        }
                    }
                }
            }

            window.addEventListener('resize', handleResize);

            console.log('NeighborNest · Owner Verification loaded.');
        })();
    </script>

</body>

</html>