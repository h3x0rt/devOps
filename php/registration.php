<?php
header('Content-Type: application/json');
session_start();

// Подключение к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "diplom";
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Получение данных из формы
$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';
$password_verify = $_POST['password_verify'] ?? '';

// Проверка, существует ли пользователь
$stmt = $conn->prepare("SELECT ID FROM users WHERE name = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();

if(!(ctype_graph($login))){
    $response['message'] = "В логине не должно быть пробелов.";
    echo json_encode($response);
    exit;
}
if(strlen($login) > 16){
    $response['message'] = "Максимальная длина имени 16 символов.";
    echo json_encode($response);
    exit;
}
if ($stmt->num_rows > 0) {
    $response['message'] = "Имя пользователя уже занято.";
    echo json_encode($response);
    exit;
}
if(strlen($password) < 8){
    $response['message'] = "Длина пароля должна составлять минимум 8 символов.";
    echo json_encode($response);
    exit;
}
if($password != $password_verify){
    $response['message'] = "Подтверждение пароля неверно.";
    echo json_encode($response);
    exit;
} else {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (name, password_hash) VALUES (?, ?)");
    $stmt->bind_param("ss", $login, $passwordHash);
    $stmt->execute();

    $stmt = $conn->prepare("SELECT ID FROM users WHERE name = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    $_SESSION['user_id'] = $user_id;

    $log = $conn->prepare("INSERT INTO userlogs (user_id, action) VALUES (?, 'зарегистрирован новый пользователь')");
    $log->bind_param("i", $user_id);
    $log->execute();

    $response['success'] = true;
    $response['message'] = "Регистрация успешна!";
    echo json_encode($response);
    exit;
}
?>