<?php
require_once 'mysql/mysqlsorgu.php';
include 'class.phpmailer.php';
include 'class.smtp.php';

$baglanti = getPDOConnection();

// SMTP ayarlarını veritabanından al
$smtpAyar = $baglanti->query("SELECT * FROM smtpayar")->fetch(PDO::FETCH_ASSOC);
$server = $smtpAyar['server'];
$username = $smtpAyar['username'];
$password = $smtpAyar['password'];
$guvenlik = $smtpAyar['guvenlik'];
$port = $smtpAyar['port'];

$testmailler = $_POST['testmail'];
$mailAddresses = explode(',', $testmailler);

// E-posta oluşturma
$mail = new PHPMailer();
$mail->isSMTP();
$mail->CharSet = 'UTF-8';
$mail->Host = $server;
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;
$mail->SMTPSecure = $guvenlik;
$mail->Port = $port;
$mail->setFrom($username, '=?UTF-8?Q?' . quoted_printable_encode('Vektra Yönetim Portalı') . '?=');


foreach ($mailAddresses as $mailAddress) {
    $mail->addAddress(trim($mailAddress), $mailAddress);
}

$mail->isHTML(true);
$mail->Subject = '=?UTF-8?B?' . base64_encode('VectraWeb Test Maili!') . '?=';


// Tablo HTML içeriğini oluştur
$table = 'Bu bir test mailidir. Bu maili almışsanız VectraWeb SMTP ayarlarınız doğru şekilde yapılandırılmış demektir.
          <br>
          <p style="text-align: center;">
            <img src="https://www.greengardenhotels.com/portal/assets/images/footerbanner.png" alt="Logo">
          </p>';

$mail->Body = $table;

// E-postayı gönder
if ($mail->send()) {
    header("refresh:2; url=smtpayarlari");
    echo "Mail başarıyla gönderildi. Gelen Kutunuzu kontrol ediniz.";
} else {
    header("refresh:2; url=smtpayarlari");
    echo "Bir sorun oluştu. E-posta gönderilemedi: " . $mail->ErrorInfo;
}
?>
