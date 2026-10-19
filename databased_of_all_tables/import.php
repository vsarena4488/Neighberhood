<?php
// databased_of_all_tables/import.php - Database Inspector & 1-Click Restore Utility
$host = '127.0.0.1';
$db   = 'neighborhood_db';
$user = 'root';
$pass = '';

$message = '';
$status = 'info';

// Handle 1-Click Import / Restore
if (isset($_POST['action']) && $_POST['action'] === 'restore') {
    try {
        $tempPdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        
        $sqlFile = __DIR__ . '/neighborhood_db.sql';
        if (!file_exists($sqlFile)) {
            throw new Exception("neighborhood_db.sql file not found in " . __DIR__);
        }
        
        $sqlContent = file_get_contents($sqlFile);
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        $pdo->exec($sqlContent);
        
        $message = "Database `neighborhood_db` has been successfully restored from neighborhood_db.sql!";
        $status = "success";
    } catch (Exception $e) {
        $message = "Error during restore: " . $e->getMessage();
        $status = "danger";
    }
}

// Inspect current database status
$dbConnected = false;
$tablesInfo = [];
$totalRows = 0;
$connError = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    $dbConnected = true;

    $stmt = $pdo->query("SHOW TABLES");
    $rawTables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    foreach ($rawTables as $t) {
        $count = $pdo->query("SELECT COUNT(*) FROM `$t`")->fetchColumn();
        $totalRows += (int)$count;
        $tablesInfo[] = [
            'name' => $t,
            'rows' => (int)$count
        ];
    }
} catch (Exception $e) {
    $connError = $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NeighborHood · Database Manager & Diagnostics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        .card { border-radius: 12px; border: 1px solid #e2e8f0; }
        .badge-status { font-size: 0.85rem; padding: 6px 12px; border-radius: 20px; }
    </style>
</head>
<body class="py-5">
<div class="container" style="max-width: 900px;">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="fas fa-database text-primary me-2"></i>NeighborHood Database Diagnostics</h2>
            <p class="text-muted mb-0">Inspect MySQL status, tables, and restore backup database easily.</p>
        </div>
        <a href="../Guest Panel/index.php" class="btn btn-outline-secondary">
            <i class="fas fa-home me-1"></i> Home
        </a>
    </div>

    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $status ?> alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas <?= $status === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle' ?> me-2"></i>
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Connection Status Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1">MySQL Connection Status</h5>
                    <div class="text-muted small">
                        Host: <code><?= htmlspecialchars($host) ?></code> | Database: <code><?= htmlspecialchars($db) ?></code> | User: <code><?= htmlspecialchars($user) ?></code>
                    </div>
                </div>
                <div>
                    <?php if ($dbConnected): ?>
                        <span class="badge bg-success-subtle text-success border border-success badge-status">
                            <i class="fas fa-circle-check me-1"></i> Connected & Online
                        </span>
                    <?php else: ?>
                        <span class="badge bg-danger-subtle text-danger border border-danger badge-status">
                            <i class="fas fa-circle-xmark me-1"></i> Connection Failed
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!$dbConnected): ?>
                <div class="alert alert-danger mt-3 mb-0">
                    <strong>Error:</strong> <?= htmlspecialchars($connError) ?>
                    <p class="mb-0 mt-1 small">Please make sure MySQL is started in your XAMPP Control Panel.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tables Overview -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0">
                <i class="fas fa-table-list text-primary me-2"></i>Tables in <code>neighborhood_db</code> (<?= count($tablesInfo) ?> tables, <?= $totalRows ?> total rows)
            </h5>
            <form method="POST" onsubmit="return confirm('Restore database from neighborhood_db.sql? This will refresh all tables.');" class="d-inline">
                <input type="hidden" name="action" value="restore">
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fas fa-rotate me-1"></i> Re-import / Restore SQL Dump
                </button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Table Name</th>
                            <th>Total Rows</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tablesInfo)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    No tables found in database. Click "Re-import / Restore SQL Dump" above to load all tables.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tablesInfo as $idx => $t): ?>
                                <tr>
                                    <td class="ps-4 text-muted"><?= $idx + 1 ?></td>
                                    <td class="fw-bold"><code><?= htmlspecialchars($t['name']) ?></code></td>
                                    <td><span class="badge bg-secondary"><?= $t['rows'] ?> records</span></td>
                                    <td>
                                        <span class="text-success small"><i class="fas fa-check me-1"></i>Active</span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Access Credentials -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0"><i class="fas fa-key text-warning me-2"></i>Demo Accounts for Testing</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <span class="badge bg-danger mb-2">Admin Panel</span>
                        <div class="small"><strong>Email:</strong> admin@neighborhood.com</div>
                        <div class="small"><strong>Password:</strong> admin123</div>
                        <a href="../Admin Panel/index.php" class="btn btn-sm btn-outline-danger mt-2 w-100">Open Admin Panel</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <span class="badge bg-success mb-2">Owner Panel</span>
                        <div class="small"><strong>Email:</strong> rajesh.sharma@neighborhood.com</div>
                        <div class="small"><strong>Password:</strong> password123</div>
                        <a href="../Owner Panel/dashboard.php" class="btn btn-sm btn-outline-success mt-2 w-100">Open Owner Panel</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded-3 bg-light">
                        <span class="badge bg-primary mb-2">User / Student Panel</span>
                        <div class="small"><strong>Email:</strong> vishal.patel@example.com</div>
                        <div class="small"><strong>Password:</strong> password123</div>
                        <a href="../User Panel/dashboard.php" class="btn btn-sm btn-outline-primary mt-2 w-100">Open User Panel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
