<?php
include 'mysql/mysqlsorgu.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// Veritabanı bağlantısını oluştur
$connection = dbConnect();

// POST verilerini al
$atik_turu = $_POST['atik_turu'];
$ay = $_POST['ay'];
$yeni_miktar = $_POST['yeni_miktar'];

// Atık miktarını güncelle
$sonuc = updateAtikMiktari($connection, $atik_turu, $ay, $yeni_miktar);
echo $sonuc;

// Veritabanı bağlantısını kapat
mysqli_close($connection);
?>
