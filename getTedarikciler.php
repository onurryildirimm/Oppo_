<?php
include 'mysql/mysqlsorgu.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// PDO bağlantısını al
$pdo = getPDOConnection();

// Seçilen grup değerini alın
$secilenGrup = $_POST["secilenGrup"];

// Tedarikçileri almak için fonksiyonu çağırın
$tedarikciler = getTedarikcilerByGrup($pdo, $secilenGrup);

// JSON formatında tedarikçileri döndürün
echo json_encode($tedarikciler);
?>
