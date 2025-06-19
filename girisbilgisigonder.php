<?php
include 'class.phpmailer.php';
include 'class.smtp.php';
include 'mysql/mysqlsorgu.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// PDO bağlantısını oluştur
$pdo = getPDOConnection();

// SMTP ayarlarını veritabanından çek
$smtpSettings = getSMTPSettings($pdo);

// POST verilerini al
$usernamemail = $_POST['username'];
$name = $_POST['name'];
$surname = $_POST['surname'];

// E-posta oluşturma
$mail = new PHPMailer();
$mail->isSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = $smtpSettings['server'];  // E-posta sağlayıcınıza göre ayarlayın
$mail->SMTPAuth = true;
$mail->Username = $smtpSettings['username'];  // E-posta hesabınıza göre ayarlayın
$mail->Password = $smtpSettings['password'];  // E-posta hesabınıza göre ayarlayın
$mail->SMTPSecure = $smtpSettings['guvenlik'];
$mail->Port = $smtpSettings['port'];
$mail->setFrom($smtpSettings['username'], '=?UTF-8?Q?Vektra Y=C3=B6netim Portal=C4=B1?=');
$mail->addAddress($usernamemail,  $name . ' ' . $surname);  // Alıcı bilgilerini ayarlayın
$mail->isHTML(true);
$mail->Subject = '=?UTF-8?Q?' . quoted_printable_encode('VectraWeb Yönetim Portalı Kullanıcı Kaydı') . '?=';

// Tablo HTML içeriğini oluştur
$table = 'Merhaba ' . $name . ' ' . $surname . ',<br><br>
         Yönetim Portalına giriş için kullanıcınız oluşturulmuştur.<br><br>
         Giriş Linki: <a href="https://www.vektraweb.com.tr/portal/lagunabeachalya">Giriş</a> <br><br>
         Kullanıcı Adınız: ' . $usernamemail . '<br><br>
         Şifrenizi sistem yetkilinizden talep ediniz. <br><br>
          <p style="text-align: center;">
            <img src="https://www.vektraweb.com.tr/maillogo.png" alt="Logo" >
          </p>';

// E-posta içeriği
$mail->Body = $table;

// E-postayı gönder
if ($mail->send()) {
    header("refresh:2; url=kullaniciayarlari");
    echo "Giriş Bilgilendirme Maili Başarıyla Gönderildi.";
} else {
    header("refresh:2; url=kullaniciekle");
    echo "Bir sorun oluştu. E-posta gönderilemedi: " . $mail->ErrorInfo;
}

?>
