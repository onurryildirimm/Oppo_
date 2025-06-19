<?php
include 'mysql/mysqlsorgu.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// PDO bağlantısını oluştur
$pdo = getPDOConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = intval($_POST['day']);
    $month = $_POST['month'];
    $field = $_POST['field'];
    $value = floatval(str_replace(',', '.', $_POST['value']));

    // Konaklama verisini güncelleme
    $response = updateKonaklamaData($pdo, $day, $month, $field, $value);
    echo $response;
}
?>
