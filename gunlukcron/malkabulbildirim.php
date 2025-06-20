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

// Bugüne ait verileri seç
$statement = $connection->prepare("SELECT * FROM malkabul WHERE tarih = CURDATE() ORDER BY id DESC");
$statement->execute();
$result = $statement->fetchAll();

// Veri sayısını kontrol et
$dataCount = count($result);

// Eğer veri varsa mail gönder
if ($dataCount > 0) {
    // Tablo içeriği oluşturma
function createTableContent($data) {
    $output = '<table style="border-collapse: collapse; border: 1px solid black; width: 100%;">';
    $output .= '<thead>';
    $output .= '<tr>
                    <th style="border: 1px solid black; width: 10%;">Tarih</th>
                    <th style="border: 1px solid black; width: 10%;">Ürün</th>
                    <th style="border: 1px solid black; width: 15%;">Tedarikçi</th>
                    <th style="border: 1px solid black; width: 10%;">Marka</th>
                    <th style="border: 1px solid black; width: 10%;">Parti No</th>
                    <th style="border: 1px solid black; width: 10%;">Kabul Durumu</th>
                    <th style="border: 1px solid black; width: 15%;">Açıklama</th>
                    <th style="border: 1px solid black; width: 10%;">Kabul Yapan</th>
                </tr>';
    $output .= '</thead>';
    $output .= '<tbody>';
    foreach ($data as $row) {
        $output .= '<tr>';
        $output .= '<td style="border: 1px solid black; width: 10%;">'.date('d.m.Y', strtotime($row["tarih"])).'</td>';
        $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['urun'] . '</td>';
        $output .= '<td style="border: 1px solid black; width: 15%;">' . $row['tedarikci'] . '</td>';
        $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['marka'] . '</td>';
        $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['partino'] . '</td>';
        $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['kabuldurumu'] . '</td>';
        $output .= '<td style="border: 1px solid black; width: 15%;">' . $row['aciklama'] . '</td>';
        $output .= '<td style="border: 1px solid black; width: 10%;">' . $row['kabulyapan'] . '</td>';
        $output .= '</tr>';
    }
    $output .= '</tbody>';
    $output .= '</table>';
    return $output;
}

    // Tablo içeriğini oluştur
    $tableContent = createTableContent($result);
    $subject = 'Bugünün Şartlı Kabul - Red Verileri';
    $subject_encoded = '=?UTF-8?B?' . base64_encode($subject) . '?=';

  // E-posta ayarları
// E-posta oluşturma
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Host = $server;  // E-posta sağlayıcınıza göre ayarlayın
    $mail->SMTPAuth = true;
    $mail->Username = $username;  // E-posta hesabınıza göre ayarlayın
    $mail->Password = $password;  // E-posta hesabınıza göre ayarlayın
    $mail->SMTPSecure = $guvenlik;
    $mail->Port = $port;
    $mail->setFrom($username, '=?UTF-8?Q?Vektra Y=C3=B6netim Portal=C4=B1?=');
    $mail->addAddress('mevlut@alyahotels.com', 'Mevlut Sertakar');
    $mail->addAddress('quality.laguna@alyahotels.com', 'Emel Mutludag');
    $mail->addAddress('satinalma.laguna@alyahotels.com', 'Mahmut Kocyigit');
    $mail->isHTML(true);
    // E-posta konusunu belirle
    $mail->Subject = $subject_encoded;
// E-posta içeriği

$mail->Body = "Sayın Yetkili,<br><br>Aşağıdaki tabloda şartlı kabul veya red olan veriler yer almaktadır:<br><br>$tableContent";

    // Gönder
    $mail->send();
    echo 'E-posta gönderildi!';
} else {
    echo 'Bugüne ait veri bulunamadığından dolayı e-posta gönderimi yapılmadı.';
}
?>
