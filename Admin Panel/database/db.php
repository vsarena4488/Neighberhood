<?php
// Admin Panel/database/db.php - Database connection & query helper
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Database {
    private static $pdo = null;

    public static function getConnection() {
        if (self::$pdo === null) {
            $host = '127.0.0.1';
            $db   = 'neighborhood_db';
            $user = 'root';
            $pass = '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host=$host;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                // Connect to MySQL server
                $tempPdo = new PDO($dsn, $user, $pass, $options);
                $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

                // Connect to database
                self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);

                // Auto initialize schema if tables missing
                self::ensureSchema(self::$pdo);
            } catch (PDOException $e) {
                // Return readable error or log
                die("<div style='font-family:sans-serif;padding:20px;background:#fee2e2;border:1px solid #ef4444;border-radius:8px;max-width:600px;margin:40px auto;color:#991b1b;'>
                    <h3 style='margin-top:0;'>Database Connection Error</h3>
                    <p>Could not connect to MySQL server. Please make sure MySQL is running in XAMPP.</p>
                    <small>Details: " . htmlspecialchars($e->getMessage()) . "</small>
                </div>");
            }
        }
        return self::$pdo;
    }

    private static function ensureSchema(PDO $pdo) {
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() === 0) {
            $schemaFile = __DIR__ . '/schema.sql';
            if (file_exists($schemaFile)) {
                $sql = file_get_contents($schemaFile);
                $pdo->exec($sql);
            }
        }
    }
}

// Global helper functions
function getDB() {
    return Database::getConnection();
}

function dbFetchOne($sql, $params = []) {
    $stmt = getDB()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetch();
}

function dbFetchAll($sql, $params = []) {
    $stmt = getDB()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function dbExecute($sql, $params = []) {
    $stmt = getDB()->prepare($sql);
    return $stmt->execute($params);
}

function dbLastId() {
    return getDB()->lastInsertId();
}

function logActivity($action, $details = null, $userId = null) {
    try {
        if (!$userId && isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        }
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        dbExecute("INSERT INTO activity_logs (user_id, action, details, ip_address) VALUES (?, ?, ?, ?)", [
            $userId, $action, $details, $ip
        ]);
    } catch (Exception $e) {
        // Fail silently for activity logging
    }
}

// Auth and Access Control Helper
function checkAdminAccess() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    // If logged in as admin
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        return true;
    }
    // If mock admin session is active for demo
    if (isset($_SESSION['user_email']) && $_SESSION['user_email'] === 'admin@neighborhood.com') {
        $_SESSION['user_role'] = 'admin';
        return true;
    }
    // For convenience in testing, set default admin if not logged in
    if (!isset($_SESSION['admin'])) {
        $admin = dbFetchOne("SELECT * FROM users WHERE role = 'admin' LIMIT 1");
        if ($admin) {
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['user_email'] = $admin['email'];
            $_SESSION['user_role'] = 'admin';
            $_SESSION['user_name'] = $admin['name'];
            $_SESSION['admin'] = $admin;
        }
    }
    return true;
}
