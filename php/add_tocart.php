<?php
session_start();
header('Content-Type: application/json');
$host = "localhost";
$user = "root";
$password = "";
$dbname = "diplom";
$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Ошибка подключения к БД']);
    exit;
}
$product_id = intval($_POST['product_id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 6);


if ($product_id <= 0 ) {
    echo json_encode(['success' => false, 'message' => 'Неверные данные']);
    exit;
}



// Проверим, есть ли уже такой товар в корзине
$query = "SELECT ID, quantity FROM cartitems WHERE user_id = ? AND product_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $_SESSION['user_id'], $product_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    $new_quantity = $row['quantity'] + $quantity;
    $update = $conn->prepare("UPDATE cartitems SET quantity = ? WHERE ID = ?");
    $update->bind_param("ii", $new_quantity, $row['ID']);
    $update->execute();
} else {
    $insert = $conn->prepare("INSERT INTO cartitems (user_id, product_id, quantity) VALUES (?, ?, ?)");
    $insert->bind_param("iii", $_SESSION['user_id'], $product_id, $quantity);
    $insert->execute();
}

echo json_encode(['success' => true]);
?>