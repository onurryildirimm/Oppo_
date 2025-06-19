<?php
require_once "mysql/mysqlsorgu.php";
// Veritabanına bağlan
$connection = dbConnect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['user_id'];
    $menuItems = $_POST['menu_items']; // Seçilen menü öğeleri

    // Önce mevcut yetkileri temizleyelim
    $deleteQuery = "DELETE FROM user_permissions WHERE user_id = ?";
    $stmt = $connection->prepare($deleteQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();

    // Seçilen menü öğelerine yeni yetkiler ekleyelim
    $insertQuery = "INSERT INTO user_permissions (user_id, menu_item_id, is_visible) VALUES (?, ?, 1)";
    $stmt = $connection->prepare($insertQuery);
    
    foreach ($menuItems as $menuItemId) {
        $stmt->bind_param("ii", $userId, $menuItemId);
        $stmt->execute();
    }

    echo "Kullanıcıya menü yetkileri başarıyla verildi!";
}

header('Location: menuyetkiayari');
exit();
?>
