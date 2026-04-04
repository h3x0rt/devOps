<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$password = "";
$dbname = "diplom";
$conn = new mysqli($host, $user, $password, $dbname);

$table = $_POST['table'] ?? '';
$id = intval($_POST['id'] ?? 0);

$allowedTables = ['products', 'categories', 'cartitems', 'attributes','orders', 'orderitems', 'productattributes', 'services', 'userlogs'];
$response = ['success' => false];

if (in_array($table, $allowedTables) && $id > 0) {
    $primaryKey = "ID";
    $stmt = $conn->prepare("DELETE FROM `$table` WHERE `$primaryKey` = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $response['success'] = true;
    }
}
echo json_encode($response);
?>