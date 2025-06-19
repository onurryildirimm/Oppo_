<?php
require_once "mysql/mysqlsorgu.php";

// Veritabanı bağlantısını oluşturun
$conn = dbConnect();

// Bağlantıyı kontrol edin
if ($conn->connect_error) {
    die("Veritabanı bağlantısında hata: " . $conn->connect_error);
}

// POST verilerini al
$atik_turu = $_POST['atik_turu'];
$ay = $_POST['ay'];
$yeni_miktar = $_POST['yeni_miktar'];

// Atık miktarını güncelle
$stmt = $conn->prepare("UPDATE atikler SET miktar = ? WHERE tur = ? AND ay = ?");
$stmt->bind_param("sss", $yeni_miktar, $atik_turu, $ay);

if ($stmt->execute()) {
    echo "Atık miktarı güncellendi";
} else {
    echo "Hata oluştu: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
