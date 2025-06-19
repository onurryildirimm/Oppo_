<?php
require_once 'mysql/mysqlsorgu.php';

$conn = dbConnect();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$column = isset($_POST['column']) ? $_POST['column'] : null;
$editval = isset($_POST['editval']) ? $_POST['editval'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($column === null || $editval === null || $id === null) {
    echo json_encode(['status' => 'error', 'message' => 'Missing parameters']);
    exit;
}

// Önceki satırdaki değeri almak için sorgu oluştur
$sql_previous = "SELECT $column FROM kayitlar WHERE id < $id ORDER BY id DESC LIMIT 1";
$result_previous = $conn->query($sql_previous);

// Önceki değeri kontrol et
$previousValue = null;
if ($result_previous->num_rows > 0) {
    $row_previous = $result_previous->fetch_assoc();
    $previousValue = $row_previous[$column];
}

// Eğer önceki değer varsa ve yeni değer önceki değerden küçükse, hata mesajı döndür
if ($previousValue !== null && $editval < $previousValue) {
    echo json_encode(['status' => 'error', 'message' => 'Yeni değer önceki değerden küçük olamaz!']);
    exit;
}

// Güncelleme veya ekleme işlemi
if ($id == 0) {
    $sql_insert = "INSERT INTO kayitlar ($column) VALUES (?)";
    $stmt_insert = $conn->prepare($sql_insert);
    if ($stmt_insert === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }
    $stmt_insert->bind_param("s", $editval);
    $stmt_insert->execute();
    if ($stmt_insert->affected_rows > 0) {
        $new_id = $conn->insert_id;
        echo json_encode(['status' => 'success', 'id' => $new_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Insert failed']);
    }
    $stmt_insert->close();
} else {
    $sql_update = "UPDATE kayitlar SET $column = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }
    $stmt_update->bind_param("si", $editval, $id);
    $stmt_update->execute();
    if ($stmt_update->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'id' => $id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
    $stmt_update->close();
}

// İşlem başarılıysa ve eklenen değer önceki değerden küçükse, eklenen değeri sil
if ($editval < $previousValue) {
    $sql_delete = "DELETE FROM kayitlar WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    if ($stmt_delete === false) {
        echo json_encode(['status' => 'error', 'message' => 'Error preparing statement: ' . $conn->error]);
        exit;
    }
    $stmt_delete->bind_param("i", $id);
    $stmt_delete->execute();
    if ($stmt_delete->affected_rows > 0) {
        echo json_encode(['status' => 'success', 'message' => 'Daha küçük değer silindi']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Silme işlemi başarısız']);
    }
    $stmt_delete->close();
}

$conn->close();
?>
