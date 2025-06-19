<?php

include_once("mysql/mysqlsorgu.php"); // Fonksiyonların olduğu dosyayı dahil ediyoruz

// PDO bağlantısını oluştur
$pdo = getPDOConnection();

// Session'ı başlatıyoruz
$firmalaraOzelIsim = "test1"; // Firma A için
session_name($firmalaraOzelIsim);
session_start();

// Oturumdaki kullanıcı bilgilerini alıyoruz
$user = $_SESSION["login_user"];
$id = $user['id'];
$user_name = $user['name'];
$log_date = date('Y-m-d');
$log_time = date('H:i:s');
$action = "Çıkış Yaptı";

// Kullanıcının çıkış yaptığını logluyoruz
logUserAction($pdo, $user_name, $log_date, $log_time, $action);

// Kullanıcı durumunu "Offline" olarak güncelliyoruz
updateUserStatus($pdo, $id, 'Offline');

// Tüm Session'ları boşaltıyoruz
$_SESSION = array();

// Session için tarayıcıya gönderilen Cookie'leri expire ediyoruz
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Tüm sessionları yok ediyoruz (kullanıcı çıkış yaptı)
session_destroy();

// Kullanıcıyı giriş sayfasına yönlendiriyoruz
header("Location: /portal/test1");
exit;
?>
