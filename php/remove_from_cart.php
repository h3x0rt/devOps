<?php
session_start();
header('Content-Type: application/json');

$mysqli = new mysqli("localhost", "root", "", "diplom");

$userId = $_SESSION['user_id'] ?? null;
$productId = intval($_POST['product'] ?? 0);

if ($userId > 0 && $productId > 0) {
    $stmt = $mysqli->prepare("DELETE FROM cartitems WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $userId, $productId);
    $stmt->execute();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Некорректные данные']);
    exit;
}
