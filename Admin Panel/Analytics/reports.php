<?php
// Analytics/reports.php - Admin Panel System Reports
require_once __DIR__ . '/../database/db.php';
checkAdminAccess();

$breadcrumb = 'Analytics > System Reports';
$pageTitle = 'System Reports';

// Reports export summary
$reports = [
    ['id' => 'REP-01', 'title' => 'Monthly Financial & Revenue Statement', 'type' => 'Financial', 'period' => 'Current Quarter', 'status' => 'Ready'],
    ['id' => 'REP-02', 'title' => 'City-wise Bed Occupancy Rate & Availability', 'type' => 'Operations', 'period' => 'September 2026', 'status' => 'Ready'],
    ['id' => 'REP-03', 'title' => 'Host Verification & Document Compliance Audit', 'type' => 'Compliance', 'period' => 'August 2026', 'status' => 'Ready'],
    ['id' => 'REP-04', 'title' => 'Student Booking Applications & Conversion Funnel', 'type' => 'Marketing', 'period' => 'YTD 2026', 'status' => 'Ready'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>NeighborNest · System Reports</title>
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
                    <h1 class="heading-font h3 mb-1">📑 System Reports & Audits</h1>
                    <p class="text-secondary small mb-0">Generate and download official PDF/CSV audit reports for transactions, occupancy, and compliance.</p>
                </div>
                <button class="btn btn-primary btn-sm px-3 rounded-pill" onclick="window.print()"><i class="fas fa-print me-1"></i> Print Summary</button>
            </div>

            <div class="card border-0 rounded-4 shadow-sm bg-white overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Report Code</th>
                                <th>Report Title</th>
                                <th>Category</th>
                                <th>Billing / Audit Period</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Download</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reports as $r): ?>
                                <tr>
                                    <td class="ps-4 font-monospace fw-bold text-primary"><?= $r['id'] ?></td>
                                    <td class="fw-semibold text-dark"><?= $r['title'] ?></td>
                                    <td><span class="badge bg-light text-secondary border"><?= $r['type'] ?></span></td>
                                    <td><?= $r['period'] ?></td>
                                    <td><span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><?= $r['status'] ?></span></td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3" onclick="alert('Exporting <?= $r['id'] ?> CSV dataset...')"><i class="fas fa-file-csv me-1"></i> Export CSV</button>
                                    </td>
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
