<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// PHPMailer kütüphanesini dahil edin
include 'class.phpmailer.php';
include 'class.smtp.php';

// Veritabanı bağlantısı
require_once '../mysql/mysqlsorgu.php';
$connection = getPDOConnection();

// Mail bilgileri çek
$server = $connection->query("SELECT server FROM smtpayar")->fetchColumn();
$username = $connection->query("SELECT username FROM smtpayar")->fetchColumn();
$password = $connection->query("SELECT password FROM smtpayar")->fetchColumn();
$guvenlik = $connection->query("SELECT guvenlik FROM smtpayar")->fetchColumn();
$port = $connection->query("SELECT port FROM smtpayar")->fetchColumn();

// Eğitime 3 gün kala olan verileri seç
$statement = $connection->prepare("SELECT * FROM egitim WHERE DATEDIFF(planlanan, CURDATE()) = 3 ORDER BY id DESC");
$statement->execute();
$result = $statement->fetchAll();

// Veri sayısını kontrol et
$dataCount = count($result);

// Eğer veri varsa mail gönder
if ($dataCount > 0) {
    // Alıcı adresleri çek
    $recipients = array_column($result, 'username');

    // Tablo içeriği oluşturma
    function createTableContent($data)
    {
        $output = '<table style="border-collapse: collapse; border: 1px solid black; width: 100%;">';
        $output .= '<thead>';
        $output .= '<tr>
                    <th style="border: 1px solid black; width: 10%;">Konu</th>
                    <th style="border: 1px solid black; width: 10%;">Eğitim Veren</th>
                    <th style="border: 1px solid black; width: 15%;">Süre</th>
                    <th style="border: 1px solid black; width: 10%;">Eğitimi Alacaklar</th>
                    <th style="border: 1px solid black; width: 10%;">Planlanan Tarih</th>
                </tr>';
        $output .= '</thead>';
        $output .= '<tbody>';
        foreach ($data as $row) {
            $output .= '<tr>';
            $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['konu'] . '</td>';
            $output .= '<td style="border: 1px solid black; width: 15%;">' . $row['veren'] . '</td>';
            $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['sure'] . '</td>';
            $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['gruplar'] . '</td>';
            $output .= '<td style="border: 1px solid black; width: 10%;">' . date('d.m.Y', strtotime($row["planlanan"])) . '</td>';
            $output .= '</tr>';
        }
        $output .= '</tbody>';
        $output .= '</table>';
        return $output;
    }

    // Tablo içeriğini oluştur
    $tableContent = createTableContent($result);
    $subject = 'Yaklaşan Eğitim Hatırlatması';
    $subject_encoded = '=?UTF-8?B?' . base64_encode($subject) . '?=';

    // E-posta ayarları
    // E-posta oluşturma
    $mail = new PHPMailer();
    //$mail->SMTPDebug = 2; // Tüm hata ayıklama seviyelerini etkinleştirir


    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    
    $mail->Host = $server;  // E-posta sağlayıcınıza göre ayarlayın
    $mail->SMTPAuth = true;
    $mail->Username = $username;  // E-posta hesabınıza göre ayarlayın
    $mail->Password = $password;  // E-posta hesabınıza göre ayarlayın
    $mail->SMTPSecure = $guvenlik;
    $mail->Port = $port;
    $mail->setFrom($username, '=?UTF-8?Q?Vektra Y=C3=B6netim Portal=C4=B1?=');

    $recipients = explode(',', $result[0]['username']);

// Her bir e-posta adresini ekleyin
foreach ($recipients as $recipient) {
    $mail->addAddress(trim($recipient));
}

    $mail->isHTML(true);
    // E-posta konusunu belirle
    $mail->Subject = $subject_encoded;
    // E-posta içeriği
    $mail->Body = "Sayın Yetkili,<br><br>Aşağıdaki tabloda 3 gün içinde başlayacak eğitimler yer almaktadır:<br><br>$tableContent";

    // Gönder
    $mail->send();
    echo 'E-posta gönderildi!';
} else {
    echo 'Yaklaşan eğitim bulunamadığından dolayı e-posta gönderimi yapılmadı.';
}

?>
