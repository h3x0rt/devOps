<?php
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$password = "";
$dbname = "diplom";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка подключения к базе данных']);
    exit;
}

$table = $_POST['table'] ?? '';
$id = intval($_POST['id'] ?? 0);

$allowedTables = ['products', 'categories', 'orders', 'orderitems', 'cartitems', 'attributes', 'productattributes', 'userlogs'];
if (!in_array($table, $allowedTables) || $id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Недопустимая таблица или ID']);
    exit;
}

// Предположим, что первичный ключ всегда "ID"
$record = [];
$stmt = $conn->prepare("SELECT * FROM `$table` WHERE ID = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();
}

// Получаем внешние ключи таблицы
$fk_query = $conn->prepare("
    SELECT COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
    FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME = ?
      AND REFERENCED_TABLE_NAME IS NOT NULL
");
$fk_query->bind_param("s", $table);
$fk_query->execute();
$fk_result = $fk_query->get_result();

$foreignKeys = [];
while ($row = $fk_result->fetch_assoc()) {
    $foreignKeys[$row['COLUMN_NAME']] = [
        'table' => $row['REFERENCED_TABLE_NAME'],
        'column' => $row['REFERENCED_COLUMN_NAME']
    ];
}

// Загружаем данные для выпадающих списков
$dropdownData = [];

foreach ($foreignKeys as $column => $ref) {
    $refTable = $ref['table'];
    $refColumn = $ref['column'];

    $columnsResult = $conn->query("SHOW COLUMNS FROM `$refTable`");
    $columns = [];
    while ($col = $columnsResult->fetch_assoc()) {
        $columns[] = $col['Field'];
    }

    $labelField = null;
    foreach (['name', 'title', $refColumn] as $try) {
        if (in_array($try, $columns)) {
            $labelField = $try;
            break;
        }
    }

    if ($labelField) {
        $sql = "SELECT `$refColumn` AS id, `$labelField` AS label FROM `$refTable`";
        $res = $conn->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $dropdownData[$column][] = $row;
            }
        }
    }
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $dropdownData[$column][] = $row;
        }
    }
}

// Возвращаем JSON
echo json_encode([
    'record' => $record,
    'dropdowns' => $dropdownData
]);
?>