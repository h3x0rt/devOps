<?php
session_start();

$conn = new mysqli("localhost", "root", "", "diplom");
$table = $_POST['select-table'] ?? '';
$allowed = ['products', 'categories', 'attributes', 'productattributes', 'orderitems'];

if (!in_array($table, $allowed)) {
    die("Недопустимая таблица");
}

if ($table === 'products') {
    $name = $_POST['name'] ?? '';
    $price = floatval($_POST['price'] ?? 0);
    $price_for = $_POST['price_for'] ?? '';
    $category_id = intval($_POST['category_id'] ?? 0);
    $imgPath = '';
    

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $imageSize = getimagesize($_FILES['img']['tmp_name']);
        
        $width = $imageSize[0];
        $height = $imageSize[1];
        $aspect = round($width / $height, 2);

        $validAspects = [round(16/9, 2), round(4/3, 2)];
        if (!in_array($aspect, $validAspects)) {
            $_SESSION['error'] = $price_for . "Ошибка: допустимы только изображения с соотношением сторон 16:9 или 4:3";
            header("Location: ../admin.php");
            exit;
        }
        

        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $imgPath = 'img/' . uniqid('prod_', true) . '.' . $ext;
        move_uploaded_file($_FILES['img']['tmp_name'], "../" . $imgPath);
    }

    if ($name && $price && $category_id && $price_for) {
        
        $stmt = $conn->prepare("INSERT INTO products (name, price, img, category_id, price_for) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisis", $name, $price, $imgPath, $category_id, $price_for);
        $stmt->execute();
    }

} elseif ($table === 'categories') {
    $name = $_POST['name'] ?? '';
    if ($name) {
        $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }

} elseif ($table === 'attributes') {
    $name = $_POST['name'] ?? '';
    if ($name) {
        $stmt = $conn->prepare("INSERT INTO attributes (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        $stmt->execute();
    }
}elseif ($table === 'productattributes') {
    $product_id = intval($_POST['product_id'] ?? 0);
    $attribute_id = intval($_POST['attribute_id'] ?? 0);
    $value = $_POST['value'] ?? '';

    if ($product_id && $attribute_id && $value) {
        $stmt = $conn->prepare("INSERT INTO productattributes (product_id, attribute_id, value) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $product_id, $attribute_id, $value);
        $stmt->execute();
    }
}elseif ($table === 'orderitems') {
    $product_id = intval($_POST['product_id'] ?? 0);
    $order_id = intval($_POST['order_id'] ?? 0);

    $stmt = $conn->prepare("select price from products where ID = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $price = $row['price'] ?? 0;
    $stmt ->close();
    if ($product_id && $order_id && $price) {
        $stmt = $conn->prepare("INSERT INTO orderitems (product_id, order_id, price) VALUES (?, ?, ?)");
        $stmt->bind_param("iid", $product_id, $order_id, $price);
        $stmt->execute();
    }
}
header("Location: ../admin.php");
exit;