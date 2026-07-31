<?php
// properties/index.php - Property Management Overview
$breadcrumb = 'Property Management';
$pageTitle = 'Property Management';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Property Management</title>

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

        .stat-card {
            background: var(--nn-white);
            border-radius: var(--nn-radius-sm);
            padding: 1.2rem 1.2rem 1rem;
            box-shadow: var(--nn-shadow);
            border: 1px solid var(--nn-border);
            transition: var(--nn-transition);
            height: 100%;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .stat-card:hover {
            box-shadow: var(--nn-shadow-hover);
            transform: translateY(-4px);
        }

        .stat-card .stat-number {
            font-size: 2rem;
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
            font-size: 1.8rem;
            color: var(--nn-primary-light);
            opacity: 0.5;
        }

        .stat-card .stat-link {
            font-size: 0.7rem;
            color: var(--nn-primary-light);
            text-decoration: none;
            font-weight: 600;
        }

        .stat-card .stat-link:hover {
            text-decoration: underline;
        }

        .quick-access-card {
            background: var(--nn-white);
            border-radius: var(--nn-radius-sm);
            padding: 1.5rem;
            box-shadow: var(--nn-shadow);
            border: 1px solid var(--nn-border);
            transition: var(--nn-transition);
            text-decoration: none;
            color: var(--nn-text-primary);
            display: block;
            height: 100%;
            text-align: center;
        }

        .quick-access-card:hover {
            box-shadow: var(--nn-shadow-hover);
            transform: translateY(-4px);
        }

        .quick-access-card .icon-wrap {
            width: 56px;
            height: 56px;
            background: var(--nn-lavender);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.5rem;
            color: var(--nn-primary-light);
        }

        .quick-access-card h6 {
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.2rem;
        }

        .quick-access-card .count {
            font-size: 0.75rem;
            color: var(--nn-text-secondary);
        }

        .quick-access-card .count.danger {
            color: var(--nn-danger);
        }

        .quick-access-card .count.success {
            color: var(--nn-success);
        }

        .quick-access-card .count.amber {
            color: var(--nn-amber);
        }

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

        .status-badge.approved {
            background: #D1FAE5;
            color: #059669;
        }

        .status-badge.rejected {
            background: #FEE2E2;
            color: #DC2626;
        }

        .status-badge.reported {
            background: #FCE4EC;
            color: #DC2626;
        }

        .status-badge.active {
            background: #DBEAFE;
            color: #2563EB;
        }

        .status-badge.inactive {
            background: #E5E7EB;
            color: #6B7280;
        }

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

        .property-image-thumb {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid var(--nn-border);
        }

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
            .quick-access-card {
                padding: 1rem;
            }
            .quick-access-card .icon-wrap {
                width: 44px;
                height: 44px;
                font-size: 1.2rem;
            }
        }

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
        .delay-5 {
            animation-delay: 0.25s;
        }
        .delay-6 {
            animation-delay: 0.3s;
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
                        <h1>🏢 Property Management</h1>
                        <p>Manage all property listings across the platform including approval, moderation, and categorization.</p>
                    </div>
                    <a href="#" class="btn-nn-primary"><i class="fas fa-plus-circle me-1"></i> Add New Property</a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-3 fade-up delay-1">
                    <a href="all_properties.php" class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">234</div>
                                <div class="stat-label">Total Properties</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-building"></i></div>
                        </div>
                        <div class="mt-2">
                            <span class="stat-link">View All →</span>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 fade-up delay-2">
                    <a href="pending_approval.php" class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number" style="color:var(--nn-amber);">12</div>
                                <div class="stat-label">Pending Approval</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-clock" style="color:var(--nn-amber);"></i></div>
                        </div>
                        <div class="mt-2">
                            <span class="stat-link">Review Now →</span>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 fade-up delay-3">
                    <a href="reported_properties.php" class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number" style="color:var(--nn-danger);">5</div>
                                <div class="stat-label">Reported Properties</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-flag" style="color:var(--nn-danger);"></i></div>
                        </div>
                        <div class="mt-2">
                            <span class="stat-link text-danger">Urgent Review →</span>
                        </div>
                    </a>
                </div>
                <div class="col-6 col-md-3 fade-up delay-4">
                    <a href="property_categories.php" class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">8</div>
                                <div class="stat-label">Categories</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-tags"></i></div>
                        </div>
                        <div class="mt-2">
                            <span class="stat-link">Manage →</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Quick Access Grid -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-1">
                    <a href="all_properties.php" class="quick-access-card">
                        <div class="icon-wrap"><i class="fas fa-list"></i></div>
                        <h6>All Properties</h6>
                        <span class="count">234 total</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-2">
                    <a href="pending_approval.php" class="quick-access-card">
                        <div class="icon-wrap" style="background:#FEF3C7;color:#D97706;"><i class="fas fa-clock"></i></div>
                        <h6>Pending Approval</h6>
                        <span class="count amber">12 waiting</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-3">
                    <a href="approved_properties.php" class="quick-access-card">
                        <div class="icon-wrap" style="background:#D1FAE5;color:#059669;"><i class="fas fa-check-circle"></i></div>
                        <h6>Approved</h6>
                        <span class="count success">198 approved</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-4">
                    <a href="rejected_properties.php" class="quick-access-card">
                        <div class="icon-wrap" style="background:#FEE2E2;color:#DC2626;"><i class="fas fa-times-circle"></i></div>
                        <h6>Rejected</h6>
                        <span class="count danger">24 rejected</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-5">
                    <a href="reported_properties.php" class="quick-access-card">
                        <div class="icon-wrap" style="background:#FCE4EC;color:#DC2626;"><i class="fas fa-flag"></i></div>
                        <h6>Reported</h6>
                        <span class="count danger">5 flagged</span>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-2 fade-up delay-6">
                    <a href="property_categories.php" class="quick-access-card">
                        <div class="icon-wrap"><i class="fas fa-tags"></i></div>
                        <h6>Categories</h6>
                        <span class="count">8 types</span>
                    </a>
                </div>
            </div>

            <!-- Recent Properties Table -->
            <div class="fade-up delay-3">
                <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                    <h5 class="fw-bold mb-0">📋 Recent Properties</h5>
                    <a href="all_properties.php" class="text-primary text-decoration-none small fw-semibold">View All <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-nn mb-0">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Owner</th>
                                <th>Type</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=100&h=100&fit=crop" alt="Property" class="property-image-thumb" />
                                        <div>
                                            <span class="fw-medium">Sunrise PG</span><br />
                                            <span class="text-muted-custom small">Manhattan, NYC</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Rajesh Sharma</td>
                                <td><span class="badge bg-secondary">PG</span></td>
                                <td><span class="fw-bold">$8,000/mo</span></td>
                                <td><span class="status-badge pending">Pending</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline me-1">View</button>
                                    <button class="btn-sm-nn success me-1">Approve</button>
                                    <button class="btn-sm-nn danger">Reject</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=100&h=100&fit=crop" alt="Property" class="property-image-thumb" />
                                        <div>
                                            <span class="fw-medium">Green Nest Hostel</span><br />
                                            <span class="text-muted-custom small">Brooklyn, NYC</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Priya Sharma</td>
                                <td><span class="badge bg-secondary">Hostel</span></td>
                                <td><span class="fw-bold">$6,500/mo</span></td>
                                <td><span class="status-badge approved">Approved</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline me-1">View</button>
                                    <button class="btn-sm-nn primary me-1">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?w=100&h=100&fit=crop" alt="Property" class="property-image-thumb" />
                                        <div>
                                            <span class="fw-medium">Lake View Apartments</span><br />
                                            <span class="text-muted-custom small">Queens, NYC</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Amit Verma</td>
                                <td><span class="badge bg-secondary">Apartment</span></td>
                                <td><span class="fw-bold">$7,200/mo</span></td>
                                <td><span class="status-badge rejected">Rejected</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline me-1">View</button>
                                    <button class="btn-sm-nn primary me-1">Edit</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=100&h=100&fit=crop" alt="Property" class="property-image-thumb" />
                                        <div>
                                            <span class="fw-medium">Sky PG</span><br />
                                            <span class="text-muted-custom small">Manhattan, NYC</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Sara Khan</td>
                                <td><span class="badge bg-secondary">PG</span></td>
                                <td><span class="fw-bold">$9,000/mo</span></td>
                                <td><span class="status-badge reported">Reported</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline me-1">View</button>
                                    <button class="btn-sm-nn primary me-1">Review</button>
                                    <button class="btn-sm-nn danger">Remove</button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=100&h=100&fit=crop" alt="Property" class="property-image-thumb" />
                                        <div>
                                            <span class="fw-medium">Park Place Residences</span><br />
                                            <span class="text-muted-custom small">Queens, NYC</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Vikram Singh</td>
                                <td><span class="badge bg-secondary">Apartment</span></td>
                                <td><span class="fw-bold">$10,500/mo</span></td>
                                <td><span class="status-badge approved">Approved</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline me-1">View</button>
                                    <button class="btn-sm-nn primary me-1">Edit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

            console.log('NeighborNest · Property Management loaded.');
        })();
    </script>

</body>

</html>