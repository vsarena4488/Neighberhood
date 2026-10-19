<?php
// wishlist-toggle.php - Endpoint to toggle properties in wishlist with database sync
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/database/db.php';

header('Content-Type: application/json');

$userId = function_exists('getLoggedInUserId') ? getLoggedInUserId() : ($_SESSION['user_id'] ?? ($_SESSION['user']['id'] ?? 2));
$propertyId = isset($_POST['property_id']) ? intval($_POST['property_id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);

if ($propertyId > 0 && $userId > 0) {
    try {
        // Check if property is currently wishlisted in the database
        $existing = dbFetchOne("SELECT id FROM wishlists WHERE user_id = ? AND property_id = ? LIMIT 1", [$userId, $propertyId]);

        if ($existing) {
            // Remove from database
            dbExecute("DELETE FROM wishlists WHERE user_id = ? AND property_id = ?", [$userId, $propertyId]);
            $status = 'removed';
        } else {
            // Insert into database
            dbExecute("INSERT IGNORE INTO wishlists (user_id, property_id) VALUES (?, ?)", [$userId, $propertyId]);
            $status = 'added';
        }

        // Reload wishlist from database for this user
        $updatedList = loadUserWishlistFromDb($userId);

        echo json_encode([
            'status' => $status,
            'property_id' => $propertyId,
            'count' => count($updatedList),
            'is_wishlisted' => ($status === 'added')
        ]);
        exit;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        exit;
    }
}

echo json_encode(['status' => 'error', 'message' => 'Invalid property ID or user session']);
