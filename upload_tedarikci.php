<?php
require_once 'mysql/mysqlsorgu.php'

try {
    $pdo = getPDOConnection();
    // PDO hata modunu etkinleştirme
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}

$id = isset($_POST["id"]) ? htmlspecialchars($_POST["id"]) : '';

// Dosya yükleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["dosya_yolu"])) {
    $targetDirectory = "uploads/tedarikci/"; // Dosyaların yükleneceği dizin
    $targetFile = $targetDirectory . basename($_FILES["dosya_yolu"]["name"]);

    if (move_uploaded_file($_FILES["dosya_yolu"]["tmp_name"], $targetFile)) {
        // Dosya başarıyla yüklendi, veritabanına kaydedebilirsiniz
        // Örnek bir SQL sorgusu
        $sql = "UPDATE tedarikcilistesi 
                SET dosya_yolu = CONCAT(IFNULL(dosya_yolu, ''), ',', :dosya_yolu) 
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dosya_yolu', $targetFile, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            // Veritabanına kayıt başarılı
            echo "Dosya yolu veritabanına kaydedildi.";
        } else {
            // Veritabanına kayıt sırasında bir hata oluştu
            echo "Veritabanına kayıt sırasında bir hata oluştu.";
        }
    } else {
        echo "Dosya yüklenirken bir hata oluştu.";
    }
} else {
    echo "Geçersiz istek.";
}
?>
