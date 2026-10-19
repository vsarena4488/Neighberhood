<?php
// Analytics/analytics.php - Admin Panel Analytics Hub
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Analytics > System Overview';
$pageTitle = 'Platform Analytics';

// Fetch Live Metrics
$totalUsers = dbFetchOne("SELECT COUNT(*) as cnt FROM users WHERE role = 'user'")['cnt'];
$totalOwners = dbFetchOne("SELECT COUNT(*) as cnt FROM users WHERE role = 'owner'")['cnt'];
$totalProps = dbFetchOne("SELECT COUNT(*) as cnt FROM properties")['cnt'];
$approvedProps = dbFetchOne("SELECT COUNT(*) as cnt FROM properties WHERE status = 'approved'")['cnt'];
$totalBookings = dbFetchOne("SELECT COUNT(*) as cnt FROM bookings")['cnt'];
$totalRev = dbFetchOne("SELECT COALESCE(SUM(amount), 0) as total FROM payments WHERE status = 'Completed'")['total'];

// City breakdown
$cityCounts = dbFetchAll("SELECT city, COUNT(*) as count FROM properties GROUP BY city");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · Platform Analytics</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --nn-primary: #1E3A5F;
            --nn-primary-light: #4F46E5;
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
        .stat-card { background: #fff; border-radius: var(--nn-radius-sm); padding: 1.25rem; border: 1px solid var(--nn-border); box-shadow: var(--nn-shadow); }
        .stat-number { font-size: 1.75rem; font-weight: 800; font-family: 'Plus Jakarta Sans', sans-serif; color: var(--nn-primary); }
    </style>
</head>
<body>
    <?php include '../sidebar.php'; ?>
    <div class="main-content">
        <?php include '../top_nevbar.php'; ?>
        
        <div class="page-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="heading-font h3 mb-1">📈 Platform Analytics & Insights</h1>
                    <p class="text-secondary small mb-0">High-level growth, student booking traction, city density, and financial volume.</p>
                </div>
                <a href="reports.php" class="btn btn-primary btn-sm px-3 rounded-pill"><i class="fas fa-download me-1"></i> Export Reports</a>
            </div>

            <!-- Stats Overview -->
            <div class="row g-3 mb-4">
                <div class="col-6 col-md-2">
                    <div class="stat-card">
                        <div class="text-secondary small">Total Students</div>
                        <div class="stat-number mt-1"><?= $totalUsers ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stat-card">
                        <div class="text-secondary small">Property Hosts</div>
                        <div class="stat-number mt-1 text-primary"><?= $totalOwners ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <div class="stat-card">
                        <div class="text-secondary small">Live Listings</div>
                        <div class="stat-number mt-1 text-success"><?= $approvedProps ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="text-secondary small">Reservations</div>
                        <div class="stat-number mt-1 text-warning"><?= $totalBookings ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="stat-card">
                        <div class="text-secondary small">Processed GMV</div>
                        <div class="stat-number mt-1 text-info">₹<?= number_format($totalRev) ?></div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-chart-line text-primary me-2"></i> Monthly Booking Growth & Volume</h6>
                        <canvas id="growthChart" height="130"></canvas>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card border-0 rounded-4 shadow-sm bg-white p-4">
                        <h6 class="fw-bold mb-3"><i class="fas fa-pie-chart text-success me-2"></i> Accommodation Distribution by City</h6>
                        <canvas id="cityChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const ctxGrowth = document.getElementById('growthChart').getContext('2d');
        new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: ['May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                datasets: [{
                    label: 'Reservations',
                    data: [12, 19, 28, 45, 62, 85],
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const ctxCity = document.getElementById('cityChart').getContext('2d');
        new Chart(ctxCity, {
            type: 'doughnut',
            data: {
                labels: [<?php foreach($cityCounts as $c) echo "'" . addslashes($c['city']) . "',"; ?>],
                datasets: [{
                    data: [<?php foreach($cityCounts as $c) echo $c['count'] . ","; ?>],
                    backgroundColor: ['#4F46E5', '#10B981', '#F59E0B', '#0D9488', '#EF4444']
                }]
            },
            options: { responsive: true }
        });
    </script>
</body>
</html>
