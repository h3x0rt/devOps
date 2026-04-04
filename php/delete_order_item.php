<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$password = "";
$dbname = "diplom";
$conn = new mysqli($host, $user, $password, $dbname);

$item_id = intval($_GET['item_id'] ?? 0);
$order_id = intval($_GET['order_id'] ?? 0);

if ($item_id > 0) {
    $stmt = $conn->prepare("DELETE FROM orderitems WHERE id = ?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
}

header("Location: ../order_details.php?order_id=$order_id");
exit;