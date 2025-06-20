<?php
// Veritabanı bağlantısı
$dbhost = 'localhost';
$dbname = 'xxxx';
$dbuser = 'xxxx';
$dbpass = 'xxxxx';

try {
    $db = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantısı sağlanamadı: " . $e->getMessage());
}

// İsteği al
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'Kayıt Ekle') {
    // Yeni kayıt ekleme işlemi
    $yediotuz = $_POST['yediotuz'];
    $onsaat = $_POST['onsaat'];
    $onotuz = $_POST['onotuz'];
    $onbir = $_POST['onbir'];
    $oniki = $_POST['oniki'];
    $ondortotuz = $_POST['ondortotuz'];
    $onbes = $_POST['onbes'];
    $onalti = $_POST['onalti'];
    $onaltiotuz = $_POST['onaltiotuz'];
    $yirmibir = $_POST['yirmibir'];

    // Veritabanına ekleme sorgusu
    $query = "INSERT INTO animasyon (yediotuz, onsaat, onotuz, onbir, oniki, ondortotuz, onbes, onalti, onaltiotuz, yirmibir)
              VALUES (:yediotuz, :onsaat, :onotuz, :onbir, :oniki, :ondortotuz, :onbes, :onalti, :onaltiotuz, :yirmibir)";
    $stmt = $db->prepare($query);

    // Parametreleri bağla
    $stmt->bindParam(':yediotuz', $yediotuz);
    $stmt->bindParam(':onsaat', $onsaat);
    $stmt->bindParam(':onotuz', $onotuz);
    $stmt->bindParam(':onbir', $onbir);
    $stmt->bindParam(':oniki', $oniki);
    $stmt->bindParam(':ondortotuz', $ondortotuz);
    $stmt->bindParam(':onbes', $onbes);
    $stmt->bindParam(':onalti', $onalti);
    $stmt->bindParam(':onaltiotuz', $onaltiotuz);
    $stmt->bindParam(':yirmibir', $yirmibir);
    // Sorguyu çalıştır
    
} elseif ($action === 'Güncelle') {
    // Kaydı güncelleme işlemi
    $id = $_POST['employee_id'];
    $gunler = $_POST['gunler'];
    $yediotuz = $_POST['yediotuz'];
    $onsaat = $_POST['onsaat'];
    $onotuz = $_POST['onotuz'];
    $onbir = $_POST['onbir'];
    $oniki = $_POST['oniki'];
    $ondortotuz = $_POST['ondortotuz'];
    $onbes = $_POST['onbes'];
    $onalti = $_POST['onalti'];
    $onaltiotuz = $_POST['onaltiotuz'];
    $yirmibir = $_POST['yirmibir'];
    // Veritabanında güncelleme sorgusu
    $query = "UPDATE animasyon SET gunler = :gunler, yediotuz = :yediotuz, onsaat = :onsaat, onotuz = :onotuz, onbir = :onbir, oniki = :oniki, ondortotuz = :ondortotuz, onbes = :onbes, onalti = :onalti, onaltiotuz = :onaltiotuz, yirmibir = :yirmibir WHERE id = :id";
    $stmt = $db->prepare($query);

    // Parametreleri bağla
    $stmt->bindParam(':gunler', $gunler);
    $stmt->bindParam(':yediotuz', $yediotuz);
    $stmt->bindParam(':onsaat', $onsaat);
    $stmt->bindParam(':onotuz', $onotuz);
    $stmt->bindParam(':onbir', $onbir);
    $stmt->bindParam(':oniki', $oniki);
    $stmt->bindParam(':ondortotuz', $ondortotuz);
    $stmt->bindParam(':onbes', $onbes);
    $stmt->bindParam(':onalti', $onalti);
    $stmt->bindParam(':onaltiotuz', $onaltiotuz);
    $stmt->bindParam(':yirmibir', $yirmibir);
    $stmt->bindParam(':id', $id);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        echo "Kayıt başarıyla güncellendi.";
    } else {
        echo "Kayıt güncellenirken bir hata oluştu.";
    }
} elseif ($action === 'Delete') {
    // Kaydı silme işlemi
    $id = $_POST['employee_id'];

    // Veritabanından silme sorgusu
    $query = "DELETE FROM animasyon WHERE id = :id";
    $stmt = $db->prepare($query);

    // Parametreyi bağla
    $stmt->bindParam(':id', $id);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        echo "Kayıt başarıyla silindi.";
    } else {
        echo "Kayıt silinirken bir hata oluştu.";
    }
} elseif ($action === 'Select') {
    // Kaydı seçme işlemi
    $id = $_POST['employee_id'];

    // Veritabanından kaydı seçme sorgusu
    $query = "SELECT * FROM animasyon WHERE id = :id";
    $stmt = $db->prepare($query);

    // Parametreyi bağla
    $stmt->bindParam(':id', $id);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        echo "Kayıt seçilirken bir hata oluştu.";
    }
} else {
    echo "Geçersiz işlem.";
}

?>




