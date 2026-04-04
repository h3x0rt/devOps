<?php
header('Content-Type: application/json');
session_start();
$servername = "localhost"; // или IP-адрес сервера
$username = "root"; // имя пользователя (по умолчанию в XAMPP - root)
$password = ""; // пароль (по умолчанию в XAMPP - пустой)
$dbname = "diplom"; // название БД из PHPMyAdmin

// Создаем соединение
$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["message" => "Ошибка подключения к базе данных"]));
}

$item_id = intval($_POST['item_id'] ?? 0);
$order_id = intval($_POST['order_id'] ?? 0);
$quantity = intval($_POST['quantity'] ?? 1);
$price = floatval($_POST['price'] ?? 0);

if ($item_id > 0 && $quantity > 0 && $price >= 0) {
    $stmt = $conn->prepare("UPDATE orderitems SET quantity = ?, price = ? WHERE id = ?");
    $stmt->bind_param("idi", $quantity, $price, $item_id);
    $stmt->execute();
}

header("Location: ../order_details.php?order_id=$order_id");
exit;
?>