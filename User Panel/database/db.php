<?php
// User Panel/database/db.php - Database connection & query helper for User Panel
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class UserDatabase {
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
                self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
            } catch (PDOException $e) {
                try {
                    $tempPdo = new PDO($dsn, $user, $pass, $options);
                    $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $options);
                    
                    $schemaFile = __DIR__ . '/schema.sql';
                    if (file_exists($schemaFile)) {
                        $sql = file_get_contents($schemaFile);
                        self::$pdo->exec($sql);
                    }
                } catch (Exception $ex) {
                    die("Database connection error: " . htmlspecialchars($ex->getMessage()));
                }
            }
        }
        return self::$pdo;
    }
}

// Global functions
function getDB() {
    return UserDatabase::getConnection();
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

function getLoggedInUserId() {
    if (isset($_SESSION['user']['id'])) {
        return (int)$_SESSION['user']['id'];
    }
    if (isset($_SESSION['user_id'])) {
        return (int)$_SESSION['user_id'];
    }
    // Default fallback to student Vishal Patel (id 2)
    return 2;
}
