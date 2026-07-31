<?php
// bookings/completed.php - Completed Bookings
$breadcrumb = 'Booking Management > Completed';
$pageTitle = 'Completed Bookings';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Completed Bookings</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Include all styles from cancelled.php - compact version */
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
            color: var(--nn-teal);
            line-height: 1.1;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--nn-text-secondary);
            font-weight: 500;
        }

        .stat-card .stat-icon {
            font-size: 1.6rem;
            color: var(--nn-teal);
            opacity: 0.6;
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

        .status-badge.completed {
            background: #CCFBF1;
            color: #0D9488;
        }

        .btn-sm-nn {
            padding: 0.2rem 0.8rem;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 40px;
            border: none;
            transition: var(--nn-transition);
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

        .rating-stars {
            color: #F59E0B;
            font-size: 0.8rem;
            letter-spacing: 2px;
        }

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
                        <h1>✅ Completed Bookings</h1>
                        <p>View all successfully completed bookings with student reviews.</p>
                    </div>
                    <span class="badge bg-teal" style="font-size:0.8rem;padding:0.4rem 1rem;background:var(--nn-teal);color:#fff;">269 Completed</span>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-3 g-md-4 mb-4">
                <div class="col-6 col-md-3 fade-up delay-1">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">269</div>
                                <div class="stat-label">Total Completed</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-check-double"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-2">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">45</div>
                                <div class="stat-label">This Month</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-calendar-alt" style="color:var(--nn-primary-light);"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-3">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">4.6</div>
                                <div class="stat-label">Avg. Rating</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-star" style="color:#F59E0B;"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3 fade-up delay-4">
                    <div class="stat-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="stat-number">92%</div>
                                <div class="stat-label">Satisfaction Rate</div>
                            </div>
                            <div class="stat-icon"><i class="fas fa-smile" style="color:var(--nn-success);"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section fade-up delay-1">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold text-secondary-custom">Search</label>
                        <input type="text" class="form-control" placeholder="Search by student or property..." />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold text-secondary-custom">Rating</label>
                        <select class="form-select">
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars ★★★★★</option>
                            <option value="4">4 Stars ★★★★</option>
                            <option value="3">3 Stars ★★★</option>
                            <option value="2">2 Stars ★★</option>
                            <option value="1">1 Star ★</option>
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

            <!-- Completed Bookings Table -->
            <div class="fade-up delay-2">
                <div class="table-responsive">
                    <table class="table table-nn mb-0">
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Student</th>
                                <th>Property</th>
                                <th>Stay Period</th>
                                <th>Amount</th>
                                <th>Rating</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="fw-medium">#B1022</span></td>
                                <td>Amit Singh</td>
                                <td>Lake View</td>
                                <td>Jun 20 - Jul 20, 2024</td>
                                <td>$7,200</td>
                                <td><span class="rating-stars">★★★★★</span> 5.0</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-medium">#B1014</span></td>
                                <td>Priya Shah</td>
                                <td>Green Nest</td>
                                <td>Jun 10 - Jul 10, 2024</td>
                                <td>$6,500</td>
                                <td><span class="rating-stars">★★★★☆</span> 4.5</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-medium">#B1011</span></td>
                                <td>Ravi Kumar</td>
                                <td>Sunrise PG</td>
                                <td>Jun 5 - Jul 5, 2024</td>
                                <td>$8,000</td>
                                <td><span class="rating-stars">★★★★★</span> 4.8</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-medium">#B1007</span></td>
                                <td>Sara Khan</td>
                                <td>Sky PG</td>
                                <td>May 28 - Jun 28, 2024</td>
                                <td>$9,000</td>
                                <td><span class="rating-stars">★★★☆☆</span> 3.5</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline">View</button>
                                </td>
                            </tr>
                            <tr>
                                <td><span class="fw-medium">#B1003</span></td>
                                <td>Vikram Reddy</td>
                                <td>Park Place</td>
                                <td>May 20 - Jun 20, 2024</td>
                                <td>$10,500</td>
                                <td><span class="rating-stars">★★★★★</span> 4.9</td>
                                <td><span class="status-badge completed">Completed</span></td>
                                <td class="text-end">
                                    <button class="btn-sm-nn outline">View</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex flex-wrap justify-content-between align-items-center mt-3">
                    <span class="small text-secondary-custom">Showing 1-5 of 269 completed bookings</span>
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-custom mb-0">
                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">4</a></li>
                            <li class="page-item"><a class="page-link" href="#">5</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
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

            console.log('NeighborNest · Completed Bookings loaded.');
        })();
    </script>

</body>

</html>