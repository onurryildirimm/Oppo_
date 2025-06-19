<?php
require_once 'mysql/mysqlsorgu.php';
try {
    $pdo = getPDOConnection();
    // PDO hata modunu etkinleştirme
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}

$cihazAdi = isset($_POST["cihaz_adi"]) ? htmlspecialchars($_POST["cihaz_adi"]) : '';

// Dosya yükleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["dosya_yolu"])) {
    $targetDirectory = "uploads/"; // Dosyaların yükleneceği dizin
    $targetFile = $targetDirectory . basename($_FILES["dosya_yolu"]["name"]);

    if (move_uploaded_file($_FILES["dosya_yolu"]["tmp_name"], $targetFile)) {
        // Dosya başarıyla yüklendi, veritabanına kaydedebilirsiniz
        // Örnek bir SQL sorgusu
        $sql = "UPDATE yillikbakim 
                SET dosya_yolu = CONCAT(IFNULL(dosya_yolu, ''), ',', :dosya_yolu) 
                WHERE cihaz_adi = :cihaz_adi";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':dosya_yolu', $targetFile, PDO::PARAM_STR);
        $stmt->bindParam(':cihaz_adi', $cihazAdi, PDO::PARAM_STR);

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
