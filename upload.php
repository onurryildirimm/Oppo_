<?php include_once ("inc/config.php");
require_once 'mysql/mysqlsorgu.php';
session_start();
$db = new Db();
/**
 * Veritabanımıza bağlanmaya çalışıyoruz.
 * Bağlanamazsak, hata mesajını ekrana yazdırıyoruz
 */
if (!$db->connect()) {
    die("Hata: Veritabanına bağlanırken bir hata oluştu." . $db->error());
}

/**
 * login_user oturum değişkeninden bilgileri alıyoruz ve
 * $user değişkenine kaydediyoruz.
 *
 * Eğer kullanıcımız oturum açmış ise, $user dolu olacak.
 * Eğer kullanıcımız daha önce oturum açmamış ise, $user boş olacak.
 *
 */
$user = $_SESSION['login_user'];
$departman = $user['departman'];
$id = $user['id'];
	try{//hata varmı diye kontrol mekanizması.

		$baglanti=getPDOConnection();

	    $sonuc = $baglanti->exec("UPDATE user SET status='Online' WHERE id='$id' ");
	}catch (PDOException $h) {

		$hata=$h->getMessage();
	}

if (!$user) {
    header("location: login");
    exit;
    }
    


try {
    $pdo = getPDOConnection();
    // PDO hata modunu etkinleştirme
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
}

// Dosya yükleme işlemi
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["profile_image"])) {
    $targetDirectory = "uploads/"; // Profil fotoğraflarının yükleneceği dizin
    $targetFile = $targetDirectory . basename($_FILES["profile_image"]["name"]);

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
        // Dosya başarıyla yüklendi, veritabanına kaydedebilirsiniz
        // Örnek bir SQL sorgusu
        $sql = "UPDATE user SET profile_image = :profile_image WHERE id = :user_id";

        // SQL sorgusunu hazırla ve çalıştır
        // $pdo değişkeniyle veritabanına bağlanmış olduğunuzu varsayalım
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':profile_image', $targetFile, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            // Veritabanına kayıt başarılı
            echo "Profil fotoğrafı veritabanına kaydedildi.";
        } else {
            // Veritabanına kayıt sırasında bir hata oluştu
            echo "Veritabanına kayıt sırasında bir hata oluştu.";
        }
    } else {
        echo "Dosya yüklenirken bir hata oluştu.";
    }
} else {
    echo "Geçersiz istek.";
}
?>






