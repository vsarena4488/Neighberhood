<?php
// wishlist-toggle.php - Endpoint to toggle properties in wishlist
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_wishlist'])) {
    $_SESSION['user_wishlist'] = [];
}

$propertyId = isset($_POST['property_id']) ? intval($_POST['property_id']) : (isset($_GET['id']) ? intval($_GET['id']) : 0);

if ($propertyId > 0) {
    if (in_array($propertyId, $_SESSION['user_wishlist'])) {
        $_SESSION['user_wishlist'] = array_values(array_diff($_SESSION['user_wishlist'], [$propertyId]));
        echo json_encode(['status' => 'removed', 'property_id' => $propertyId, 'count' => count($_SESSION['user_wishlist'])]);
    } else {
        $_SESSION['user_wishlist'][] = $propertyId;
        echo json_encode(['status' => 'added', 'property_id' => $propertyId, 'count' => count($_SESSION['user_wishlist'])]);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid property ID']);
