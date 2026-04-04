<?php
session_start();
header('Content-type: application/json');
if (isset($_SESSION['user_id'])) {
    echo json_encode(['authenticated' => true, 'user_id' => $_SESSION['user_id']]);
    exit();
}

?>