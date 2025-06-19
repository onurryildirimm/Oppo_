<?php
include 'mysql/mysqlsorgu.php'; // Veritabanı fonksiyonlarını dahil ediyoruz

// POST yöntemiyle gelen "id" parametresini alın
$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($id !== null) {
    try {
        // PDO bağlantısını alın
        $pdo = getPDOConnection();
        
        // Memorandum kaydının onay durumunu güncelleme
        if (updateMemorandumStatus($pdo, $id, 'ONAYLANDI')) {
            // İşlem başarılı olduğunda geri dönüş mesajı
            echo "Kayıt başarıyla onaylandı.";
        } else {
            echo "Kayıt onaylanırken bir hata oluştu.";
        }
    } catch (PDOException $e) {
        // İşlem sırasında bir hata oluştuğunda hata mesajını döndürme
        echo "Hata: " . $e->getMessage();
    }
} else {
    echo "Geçersiz ID.";
}

// Yönlendirme işlemi
header("Location: memorandumonayla");
exit;
?>
