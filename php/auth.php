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
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT ID, name, password_hash, role FROM users WHERE name = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();

if (!($stmt->num_rows > 0)) {
    $response['message'] = "Неверный логин или пароль";
    echo json_encode($response);
    exit;
}

$stmt->bind_result($user_id, $name, $password_hash, $role);
$stmt->fetch();

if (!password_verify($password, $password_hash)) {
    echo json_encode(["message" => "Неверный логин или пароль"]);
    exit;
}
$_SESSION['user_id'] = $user_id;
$_SESSION['role'] = $role;
$_SESSION['user_name'] = $name;

$token = bin2hex(random_bytes(32));
setcookie('remember_token', $token, time() + 60 * 60 * 24 * 15, '/'); // 15 дней
$update = $conn->prepare("UPDATE users SET remember_token = ? WHERE ID = ?");
$update->bind_param("si", $token, $user_id);
$update->execute();
$log = $conn->prepare("INSERT INTO userlogs (user_id, action) VALUES (?, 'авторизован пользователь')");
$log->bind_param("i", $user_id);
$log->execute();
echo json_encode([
    "success" => true,
    "username" => $name
]);

?>