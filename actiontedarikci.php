<?php
require_once 'mysql/mysqlsorgu.php';


try {
    // Veritabanına bağlantı oluşturma
    $connection = getPDOConnection();


    if (isset($_POST["action"])) {
        if ($_POST["action"] == "Select") {
            $id = $_POST["employee_id"];

            // Güncellenecek kaydı seçme sorgusu
            $statement = $connection->prepare("SELECT * FROM tedarikcilistesi WHERE id=:id");
            $statement->execute(array(':id' => $id));
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // JSON yanıtı oluşturma
            $response = array(
                'tedarikciadi' => $row['tedarikciadi'],
                'adresi' => $row['adresi'],
                'ilce' => $row['ilce'],
                'il' => $row['il'],
                'yetkiliadi' => $row['yetkiliadi'],
                'mail' => $row['mail'],
                'telefon' => $row['telefon'],
                'urungrubu' => explode(", ", $row['urungrubu'])
            );

            // JSON yanıtını döndürme
            echo json_encode($response);
        } elseif ($_POST["action"] == "Kayıt Ekle") {
            // Yeni kayıt ekleme sorgusu
            $query = "INSERT INTO tedarikcilistesi (tedarikciadi, adresi, ilce, il, yetkiliadi, mail, telefon, urungrubu) 
                      VALUES (:tedarikciadi, :adresi, :ilce, :il, :yetkiliadi, :mail, :telefon, :urungrubu)";

            $statement = $connection->prepare($query);

            $result = $statement->execute(
                array(
                    ':tedarikciadi' => $_POST["tedarikciadi"],
                    ':adresi' => $_POST["adresi"],
                    ':ilce' => $_POST["ilce"],
                    ':il' => $_POST["il"],
                    ':yetkiliadi' => $_POST["yetkiliadi"],
                    ':mail' => $_POST["mail"],
                    ':telefon' => $_POST["telefon"],
                    ':urungrubu' => $_POST["urungrubu"], // JSON verisini burada kullanın
                )
            );

            if (!empty($result)) {
                echo 'Kayıt Eklendi';
            }
        } elseif ($_POST["action"] == "Güncelle") {
            $id = $_POST["employee_id"];

            // Güncellenecek kaydı seçme sorgusu
            $statement = $connection->prepare("SELECT * FROM tedarikcilistesi WHERE id=:id");
            $statement->execute(array(':id' => $id));
            $row = $statement->fetch(PDO::FETCH_ASSOC);

            // JSON verilerini işleme
            $mail_str = "";
            if (isset($_POST['urungrubu'])) {
                $mail = $_POST['urungrubu'];
                if (!is_array($mail)) {
                    $mail = json_decode($mail);
                }
                $mail_str = implode(", ", $mail);
            }

            // Güncelleme sorgusu
            $update_query = "UPDATE tedarikcilistesi 
                SET tedarikciadi = :tedarikciadi, adresi = :adresi, ilce = :ilce, il = :il, yetkiliadi = :yetkiliadi, mail = :mail, telefon = :telefon, urungrubu = :urungrubu WHERE id = :id";
            
            $statement = $connection->prepare($update_query);

            $result = $statement->execute(array(
                ':tedarikciadi' => $_POST["tedarikciadi"],
                ':adresi' => $_POST["adresi"],
                ':ilce' => $_POST["ilce"],
                ':il' => $_POST["il"],
                ':yetkiliadi' => $_POST["yetkiliadi"],
                ':mail' => $_POST["mail"],
                ':telefon' => $_POST["telefon"],
                ':urungrubu' => $mail_str,
                ':id' => $id
            ));

            if (!empty($result)) {
                echo 'Kayıt Güncellendi';
            }
        }
    }
} catch (PDOException $e) {
    // Hata durumunda hata mesajını yakala
    echo "Veritabanı Hatası: " . $e->getMessage();
}
?>
