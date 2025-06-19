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
               
                'fiyat' => $row['fiyat'],
                'urunhizmetkalitesi' => $row['urunhizmetkalitesi'],
                'odemevadesi' => $row['odemevadesi'],
                'calismayetenegi' => $row['calismayetenegi'],
                'referanslar' => $row['referanslar'],
                'firmabelgedurumu' => $row['firmabelgedurumu'],
                'maliguc' => $row['maliguc'],
                'risk' => $row['risk'],
                'cevreseldegerleme' => $row['cevreseldegerleme'],
                'statu' => $row['statu'],
                'aciklama' => $row['aciklama']
            );

            // JSON yanıtını döndürme
            echo json_encode($response);
        } elseif ($_POST["action"] == "Kayıt Ekle") {
            // Yeni kayıt ekleme sorgusu
            $query = "INSERT INTO tedarikcilistesi (tedarikciadi, urungrubu, fiyat, urunhizmetkalitesi, odemevadesi, calismayetenegi, calismayetenegi, referanslar, firmabelgedurumu, maliguc, risk, cevreseldegerleme, statu, aciklama) 
                      VALUES (:tedarikciadi, :urungrubu, :fiyat, :urunhizmetkalitesi, :odemevadesi, :calismayetenegi, :referanslar, :firmabelgedurumu, :maliguc, :risk, :cevreseldegerleme, :statu, :aciklama)";

            $statement = $connection->prepare($query);

            $result = $statement->execute(
                array(
                    ':tedarikciadi' => $_POST["tedarikciadi"],
                    
                    ':fiyat' => $_POST["fiyat"],
                    ':urunhizmetkalitesi' => $_POST["urunhizmetkalitesi"],
                    ':odemevadesi' => $_POST["odemevadesi"],
                    ':calismayetenegi' => $_POST["calismayetenegi"],
                    ':referanslar' => $_POST["referanslar"],
                    ':firmabelgedurumu' => $_POST["firmabelgedurumu"],
                    ':maliguc' => $_POST["maliguc"],
                    ':risk' => $_POST["risk"],
                    ':cevreseldegerleme' => $_POST["cevreseldegerleme"],
                    ':statu' => $_POST["statu"],
                    ':aciklama' => $_POST["aciklama"],
                   
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
            if (isset($_POST['firmabelgedurumu'])) {
                $mail = $_POST['firmabelgedurumu'];
                if (!is_array($mail)) {
                    $mail = json_decode($mail);
                }
                $mail_str = implode(", ", $mail);
            }

            // Güncelleme sorgusu
            $update_query = "UPDATE tedarikcilistesi 
                SET tedarikciadi = :tedarikciadi, fiyat = :fiyat, urunhizmetkalitesi = :urunhizmetkalitesi, odemevadesi = :odemevadesi, calismayetenegi = :calismayetenegi, referanslar = :referanslar, firmabelgedurumu = :firmabelgedurumu, maliguc = :maliguc, risk = :risk, cevreseldegerleme = :cevreseldegerleme, statu = :statu, aciklama = :aciklama WHERE id = :id";
            
            $statement = $connection->prepare($update_query);

            $result = $statement->execute(array(
                ':tedarikciadi' => $_POST["tedarikciadi"],
                    
                    ':fiyat' => $_POST["fiyat"],
                    ':urunhizmetkalitesi' => $_POST["urunhizmetkalitesi"],
                    ':odemevadesi' => $_POST["odemevadesi"],
                    ':calismayetenegi' => $_POST["calismayetenegi"],
                    ':referanslar' => $_POST["referanslar"],
                    ':firmabelgedurumu' => $_POST["firmabelgedurumu"],
                    ':maliguc' => $_POST["maliguc"],
                    ':risk' => $_POST["risk"],
                    ':cevreseldegerleme' => $_POST["cevreseldegerleme"],
                    ':statu' => $_POST["statu"],
                    ':aciklama' => $_POST["aciklama"],
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
