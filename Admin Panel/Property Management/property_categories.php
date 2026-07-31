<?php
// properties/property_categories.php - Property Categories
$breadcrumb = 'Property Management > Property Categories';
$pageTitle = 'Property Categories';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Property Categories</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Include all styles from all_properties.php - compact version */
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

        .category-card {
            background: var(--nn-white);
            border-radius: var(--nn-radius-sm);
            padding: 1.5rem;
            box-shadow: var(--nn-shadow);
            border: 1px solid var(--nn-border);
            transition: var(--nn-transition);
            height: 100%;
            cursor: pointer;
        }

        .category-card:hover {
            box-shadow: var(--nn-shadow-hover);
            transform: translateY(-4px);
        }

        .category-card .icon-wrap {
            width: 56px;
            height: 56px;
            background: var(--nn-lavender);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--nn-primary-light);
            margin-bottom: 0.75rem;
        }

        .category-card h6 {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }

        .category-card .count {
            font-size: 0.8rem;
            color: var(--nn-text-secondary);
        }

        .category-card .sub-types {
            font-size: 0.7rem;
            color: var(--nn-text-muted);
            margin-top: 0.5rem;
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
            .category-card {
                padding: 1rem;
            }
            .category-card .icon-wrap {
                width: 44px;
                height: 44px;
                font-size: 1.2rem;
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
        .delay-7 {
            animation-delay: 0.35s;
        }
        .delay-8 {
            animation-delay: 0.4s;
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
                        <h1>🏷️ Property Categories</h1>
                        <p>Manage property categories and sub-categories for better organization.</p>
                    </div>
                    <a href="#" class="btn-nn-primary"><i class="fas fa-plus-circle me-1"></i> Add Category</a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-3 fade-up delay-1">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">8</div>
                                <div class="stat-label">Main Categories</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-tags"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-2">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">24</div>
                                <div class="stat-label">Sub-Categories</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-tag"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">234</div>
                                <div class="stat-label">Total Properties</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-building"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">12</div>
                                <div class="stat-label">Uncategorized</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-exclamation-triangle" style="color:var(--nn-amber);"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Grid -->
            <div class="row g-3 g-md-4">
                
                <!-- Category 1: PG -->
                <div class="col-6 col-md-4 col-lg-3 fade-up delay-1">
                    <div class="category-card">
                        <div class="icon-wrap"><i class="fas fa-hotel"></i></div>
                        <h6>PG</h6>
                        <div class="count">48 Properties</div>
                        <div class="sub-types">Sub-types: Boys PG, Girls PG, Mixed PG</div>
                        <div class="mt-2 d-flex gap-1">
                            <button class="btn-sm-nn outline">Edit</button>
                            <button class="btn-sm-nn primary">View</button>
                        </div>
                    </div>
                </div>

                <!-- Category 2: Hostel -->
                <div class="col-6 col-md-4 col-lg-3 fade-up delay-2">
                    <div class="category-card">
                        <div class="icon-wrap"><i class="fas fa-bed"></i></div>
                        <h6>Hostel</h6>
                        <div class="count">36 Properties</div>
                        <div class="sub-types">Sub-types: Boys Hostel, Girls Hostel</div>
                        <div class="mt-2 d-flex gap-1">
                            <button class="btn-sm-nn outline">Edit</button>
                            <button class="btn-sm-nn primary">View</button>
                        </div>
                    </div>
                </div>

                <!-- Category 3: Apartments -->
                <div class="col-6 col-md-4 col-lg-3 fade-up delay-3">
                    <div class="category-card">
                        <div class="icon-wrap"><i class="fas fa-building"></i></div>
                        <h6>Apartments</h6>
                        <div class="count">52 Properties</div>
                        <div class="sub-types">Sub-types: Studio, 1BHK, 2BHK, 3BHK+</div>
                        <div class="mt-2 d-flex gap-1">
                            <button class="btn-sm-nn outline">Edit</button>
                            <button class="btn-sm-nn primary">View</button>
                        </div>
                    </div>
                </div>

                <!-- Category 4: Houses -->
                <div class="col-6 col-md-4 col-lg-3 fade-up delay-4">
                    <div class="category-card">
                        <div class="icon-wrap"><i class="fas fa-home"></i></div>
                        <h6>Houses</h6>
                        <div class="count">28 Properties</div>
                        <div class="sub-types">Sub-types: Independent, Duplex, Villa</div>
                        <div class="mt-2 d-flex gap-1">
                            <button class="btn-sm-nn outline">Edit</button>
                            <button class="btn-sm-nn primary">View</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Uncategorized Notice -->
            <div class="mt-4 p-3 bg-white rounded-3 border" style="border-color:var(--nn-border);">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <div>
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        <span class="fw-medium">12 properties are uncategorized</span>
                        <span class="text-muted-custom small ms-2">Please assign categories to improve discoverability.</span>
                    </div>
                    <a href="#" class="btn-sm-nn primary">Review Uncategorized</a>
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

            console.log('NeighborNest · Property Categories loaded.');
        })();
    </script>

</body>

</html>