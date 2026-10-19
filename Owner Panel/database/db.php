<?php
// Owner Panel/database/db.php - Database connection & query helper for Owner Panel
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class OwnerDatabase {
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
                // If db doesn't exist, connect and create
                $tempPdo = new PDO($dsn, $user, $pass, $options);
                $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
                
                // Ensure schema is imported if tables don't exist
                $stmt = self::$pdo->query("SHOW TABLES LIKE 'users'");
                if ($stmt->rowCount() === 0) {
                    $schemaFile = __DIR__ . '/schema.sql';
                    if (file_exists($schemaFile)) {
                        $sql = file_get_contents($schemaFile);
                        self::$pdo->exec($sql);
                    }
                }
            } catch (Exception $ex) {
                die("<div style='font-family:sans-serif;padding:20px;background:#fee2e2;border:1px solid #ef4444;border-radius:8px;max-width:600px;margin:40px auto;color:#991b1b;'>
                    <h3 style='margin-top:0;'>Database Connection Error</h3>
                    <p>Could not connect to MySQL server. Please make sure MySQL is running in XAMPP.</p>
                    <small>Details: " . htmlspecialchars($ex->getMessage()) . "</small>
                </div>");
            }
        }
        return self::$pdo;
    }
}

// Global functions wrapped in function_exists guards
if (!function_exists('getDB')) {
    function getDB() {
        return OwnerDatabase::getConnection();
    }
}

if (!function_exists('dbFetchOne')) {
    function dbFetchOne($sql, $params = []) {
        $stmt = getDB()->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetch();
        return $res ?: [];
    }
}

if (!function_exists('dbFetchAll')) {
    function dbFetchAll($sql, $params = []) {
        $stmt = getDB()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}

if (!function_exists('dbExecute')) {
    function dbExecute($sql, $params = []) {
        $stmt = getDB()->prepare($sql);
        return $stmt->execute($params);
    }
}

if (!function_exists('dbLastId')) {
    function dbLastId() {
        return getDB()->lastInsertId();
    }
}

if (!function_exists('logActivity')) {
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
}

if (!function_exists('getLoggedInOwnerId')) {
    function getLoggedInOwnerId() {
        if (isset($_SESSION['owner']['id'])) {
            return (int)$_SESSION['owner']['id'];
        }
        if (isset($_SESSION['user_id'])) {
            return (int)$_SESSION['user_id'];
        }
        // Default fallback to demo owner Rajesh Sharma (id 3)
        return 3;
    }
}

