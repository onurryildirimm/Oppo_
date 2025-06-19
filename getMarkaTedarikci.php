<?php
include 'mysql/mysqlsorgu.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// Veritabanı bağlantısını oluştur
$connection = dbConnect();

// AJAX isteğinden gelen seçilen ürün değerini alın
$selectedUrun = $_POST['urun'];

// Markaları ve tedarikçileri almak için fonksiyonları çağırın
$markaOptions = getMarkalar($connection, $selectedUrun);
$tedarikciOptions = getTedarikciler($connection, $selectedUrun);

// JSON yanıtı oluşturun
$response = array(
    'markaOptions' => $markaOptions,
    'tedarikciOptions' => $tedarikciOptions
);

// JSON formatında yanıtı gönderin
echo json_encode($response);

// Veritabanı bağlantısını kapat
mysqli_close($connection);
?>
