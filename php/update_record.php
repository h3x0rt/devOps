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
$id = intval($_POST['id']);
$table = $_POST['table'];
unset($_POST['id'], $_POST['table']);

$columns = [];
$values = [];
$types = '';

foreach ($_POST as $key => $value) {
    $columns[] = "`$key`=?";
    $values[] = $value;
    $types .= 's';
}

$values[] = $id;
$types .= 'i';

$sql = "UPDATE `$table` SET " . implode(',', $columns) . " WHERE ID=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$values);
$stmt->execute();
?>