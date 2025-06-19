<?php
include 'mysql/mysqlsorgu.php'; // Veritabanı fonksiyonlarını dahil ediyoruz

// PDO bağlantısını al
$pdo = getPDOConnection();

// İsteği al
$action = isset($_POST['action']) ? $_POST['action'] : '';

if ($action === 'Kayıt Ekle') {
    // Yeni kayıt ekleme işlemi
    $tarih = date('d/m/Y', strtotime($_POST['tarih']));
    $tesis = $_POST['tesis'];
    $kimden = $_POST['kimden'];
    $kime = $_POST['kime'];
    $konu = $_POST['konu'];
    $bilgi = nl2br($_POST['bilgi']);
    $gecerliliktarihi = date('d/m/Y', strtotime($_POST['gecerliliktarihi']));
    $onaydurumu = 'ONAY BEKLENİYOR';

    // Veritabanına ekleme işlemi
    if (insertMemorandum($pdo, $tarih, $tesis, $kimden, $kime, $konu, $bilgi, $gecerliliktarihi, $onaydurumu)) {
        // E-posta gönderme işlemi
        include 'class.phpmailer.php';
        include 'class.smtp.php';

        // E-posta ayarlarını veritabanından çek
        $server = getSMTPServer($pdo);
        $username = getSMTPUsername($pdo);
        $password = getSMTPPassword($pdo);
        $guvenlik = getSMTPSecurity($pdo);
        $port = getSMTPPort($pdo);

        // E-posta gönderme işlemi
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = $server;
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->SMTPSecure = $guvenlik;
        $mail->Port = $port;
        $mail->setFrom($username, '=?UTF-8?Q?Vektra Y=C3=B6netim Portal=C4=B1?=');

        $mail->addAddress('onuryildirim@vektraweb.com.tr', 'Mevlut Sertakar');
        $mail->isHTML(true);
        $mail->Subject = '=?UTF-8?Q?' . quoted_printable_encode('Yeni Eklenen Memorandum Kaydı!') . '?=';

        $table = 'Sisteme yeni memorandum eklendi. Onayınız beklenmektedir. Lütfen yönetim portalı üzerinden onay işlemlerini gerçekleştiriniz.<br><br>
                  Eklenen memorandum bilgileri:<br>
                  <table style="border-collapse: collapse; width: 100%;">
                    <tr>
                        <th style="border: 1px solid black; padding: 8px;">Tarih</th>
                        <th style="border: 1px solid black; padding: 8px;">Tesis</th>
                        <th style="border: 1px solid black; padding: 8px;">Kimden</th>
                        <th style="border: 1px solid black; padding: 8px;">Kime</th>
                        <th style="border: 1px solid black; padding: 8px;">Konu</th>
                        <th style="border: 1px solid black; padding: 8px;">Bilgi</th>
                        <th style="border: 1px solid black; padding: 8px;">Geçerlilik Tarihi</th>
                    </tr>
                    <tr>
                        <td style="border: 1px solid black; padding: 8px;">'.$tarih.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$tesis.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$kimden.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$kime.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$konu.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$bilgi.'</td>
                        <td style="border: 1px solid black; padding: 8px;">'.$gecerliliktarihi.'</td>
                    </tr>
                  </table>
                  <br>
                  <p style="text-align: center;">
                    <img src="https://www.vektraweb.com.tr/assets/img/logo.png" width="150" height="auto" alt="Logo">
                  </p>';

        $mail->Body = $table;

        if ($mail->send()) {
            echo "Kayıt başarıyla eklendi ve e-posta gönderildi.";
        } else {
            echo "Kayıt eklenirken bir hata oluştu. E-posta gönderilemedi: " . $mail->ErrorInfo;
        }
    } else {
        echo "Kayıt eklenirken bir hata oluştu.";
    }
} elseif ($action === 'Güncelle') {
    // Kaydı güncelleme işlemi
    $id = $_POST['employee_id'];
    $tarih = date('d/m/Y', strtotime($_POST['tarih']));
    $tesis = $_POST['tesis'];
    $kimden = $_POST['kimden'];
    $kime = $_POST['kime'];
    $konu = $_POST['konu'];
    $bilgi = nl2br($_POST['bilgi']);
    $gecerliliktarihi = date('d/m/Y', strtotime($_POST['gecerliliktarihi']));
    $onaydurumu = 'ONAY BEKLENİYOR';

    if (updateMemorandum($pdo, $id, $tarih, $tesis, $kimden, $kime, $konu, $bilgi, $gecerliliktarihi, $onaydurumu)) {
        echo "Kayıt başarıyla güncellendi.";
    } else {
        echo "Kayıt güncellenirken bir hata oluştu.";
    }
} elseif ($action === 'Delete') {
    // Kaydı silme işlemi
    $id = $_POST['employee_id'];

    if (deleteMemorandum($pdo, $id)) {
        echo "Kayıt başarıyla silindi.";
    } else {
        echo "Kayıt silinirken bir hata oluştu.";
    }
} elseif ($action === 'Select') {
    // Kaydı seçme işlemi
    $id = $_POST['employee_id'];
    $result = selectMemorandumById($pdo, $id);

    if ($result) {
        echo json_encode($result);
    } else {
        echo "Kayıt seçilirken bir hata oluştu.";
    }
} else {
    echo "Geçersiz işlem.";
}

?>
