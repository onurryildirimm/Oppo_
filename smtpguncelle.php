<?php
require_once 'mysql/mysqlsorgu.php';

$server =   $_POST['server'];
$username = $_POST['username'];
$password = $_POST['password'];
$guvenlik = $_POST['guvenlik'];
$port =     $_POST['port'];

// Veritabanı bağlantısı için PDO kullanımı
$baglanti = getPDOConnection();

// Veritabanında mevcut veriyi kontrol et
$kontrolSorgusu = $baglanti->query("SELECT COUNT(*) FROM smtpayar");
$veriMevcut = ($kontrolSorgusu->fetchColumn() > 0);

if ($veriMevcut) {
    // Veri varsa güncelleme sorgusu için hazırlanmış ifadeler kullan
    $sonuc = $baglanti->prepare("UPDATE smtpayar SET server=:server, username=:username, password=:password, guvenlik=:guvenlik, port=:port");
} else {
    // Veri yoksa ekleme sorgusu için hazırlanmış ifade kullan
    $sonuc = $baglanti->prepare("INSERT INTO smtpayar (server, username, password, guvenlik, port) VALUES (:server, :username, :password, :guvenlik, :port)");
}

// Parametreleri bağla ve sorguyu çalıştır
$sonuc->bindParam(':server', $server);
$sonuc->bindParam(':username', $username);
$sonuc->bindParam(':password', $password);
$sonuc->bindParam(':guvenlik', $guvenlik);
$sonuc->bindParam(':port', $port);
$sonuc->execute();

// Yönlendirme için tam URL kullanma
header("Location: smtpayarlari");
exit;

?>

