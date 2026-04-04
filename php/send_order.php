<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "diplom");

$phone = $_POST['phone'] ?? '';
$userId = $_SESSION['user_id'] ?? null;
$quantities = $_POST['quantities'] ?? [];
$prices = $_POST['prices'] ?? [];
if (!$phone || !$userId) {
    exit("Некорректные данные");
}

// Создаём заказ
$status = "Создан";
$stmt = $mysqli->prepare("INSERT INTO orders (phone, user_id, status) VALUES (?, ?, ?)");
$stmt->bind_param("sis", $phone, $userId, $status);
$stmt->execute();
$order_id = $stmt->insert_id;



foreach ($quantities as $product_id => $quantity) {
    $price = $prices[$product_id] ?? 0;

    $stmt = $mysqli->prepare("INSERT INTO orderitems (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
    $stmt->execute();
}

?>