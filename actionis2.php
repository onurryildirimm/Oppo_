<?php
require_once "mysql/mysqlsorgu.php";
$connection = getPDOConnection();

if (isset($_POST["action"])) // Check value of $_POST["action"] variable value is set or not
{
    // For Load All Data
    if ($_POST["action"] == "Load") {
        $statement = $connection->prepare("SELECT * FROM isler ORDER BY id DESC LIMIT 500");
        $statement->execute();
        $result = $statement->fetchAll();
    }

    // This code is for Create new Records
    if ($_POST["action"] == "Kayıt Ekle") {
        $statement = $connection->prepare("
            INSERT INTO isler (tarih, gundem, gundemegetiren, alinankarar, sorumludepartman, termintarihi, kontrolsorumlusu, sonucaciklama, durumu, kapanistarihi) 
            VALUES (:tarih, :gundem, :gundemegetiren, :alinankarar, :sorumludepartman, :termintarihi, :kontrolsorumlusu, :sonucaciklama, :durumu, :kapanistarihi)
        ");
        $result = $statement->execute(
            array(
                ':tarih' => $_POST["tarih"],
                ':gundem' => $_POST["gundem"],
                ':gundemegetiren' => $_POST["gundemegetiren"],
                ':alinankarar' => $_POST["alinankarar"],
                ':sorumludepartman' => !empty($_POST["sorumludepartman"]) ? implode(',', $_POST["sorumludepartman"]) : '',
                ':termintarihi' => $_POST["termintarihi"],
                ':kontrolsorumlusu' => $_POST["kontrolsorumlusu"],
                ':sonucaciklama' => $_POST["sonucaciklama"],
                ':durumu' => $_POST["durumu"],
                ':kapanistarihi' => $_POST["kapanistarihi"]
            )
        );
        if (!empty($result)) {
            echo 'Data İşlendi';
        }

        $konu = "EĞİTİM PLANLAMASI";
        $query2 = "INSERT INTO operasyontakip (tarih, konu, icerik, departman) 
                    VALUES (:tarih, :konu, :icerik, :departman)";

        $statement2 = $connection->prepare($query2);

        $result2 = $statement2->execute(
            array(
                ':tarih' => $_POST["termintarihi"],
                ':konu' => $_POST["gundem"],
                ':icerik' => $_POST["alinankarar"],
                ':departman' => implode(',', $_POST["sorumludepartman"]) // Checkbox'ların değerlerini virgülle birleştirerek sakla
            )
        );
    }

    // This Code is for fetch single customer data for display on Modal
    if ($_POST["action"] == "Select") {
        $output = array();
        $statement = $connection->prepare(
            "SELECT * FROM isler 
            WHERE id = '" . $_POST["employee_id"] . "' 
            LIMIT 1"
        );
        $statement->execute();
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            $output["tarih"] = htmlspecialchars($row["tarih"]);
            $output["gundem"] = htmlspecialchars($row["gundem"]);
            $output["gundemegetiren"] = htmlspecialchars($row["gundemegetiren"]);
            $output["alinankarar"] = htmlspecialchars($row["alinankarar"]);
            $output["sorumludepartman"] = explode(',', htmlspecialchars($row["sorumludepartman"])); // Veritabanından alınan string'i diziye çevir
            $output["termintarihi"] = htmlspecialchars($row["termintarihi"]);
            $output["kontrolsorumlusu"] = htmlspecialchars($row["kontrolsorumlusu"]);
            $output["sonucaciklama"] = htmlspecialchars($row["sonucaciklama"]);
            $output["durumu"] = htmlspecialchars($row["durumu"]);
            $output["kapanistarihi"] = htmlspecialchars($row["kapanistarihi"]);
        }
        echo json_encode($output);
    }

    if ($_POST["action"] == "Güncelle") {
        $statement = $connection->prepare("
            UPDATE isler 
            SET tarih = :tarih, gundem = :gundem, gundemegetiren = :gundemegetiren, alinankarar = :alinankarar, sorumludepartman = :sorumludepartman, termintarihi = :termintarihi, kontrolsorumlusu = :kontrolsorumlusu, sonucaciklama = :sonucaciklama, durumu = :durumu, kapanistarihi = :kapanistarihi   
            WHERE id = :id
        ");
        $result = $statement->execute(
            array(
                ':tarih' => $_POST["tarih"],
                ':gundem' => $_POST["gundem"],
                ':gundemegetiren' => $_POST["gundemegetiren"],
                ':alinankarar' => $_POST["alinankarar"],
                ':sorumludepartman' => implode(',', $_POST["sorumludepartman"]), // Checkbox'ların değerlerini virgülle birleştirerek sakla
                ':termintarihi' => $_POST["termintarihi"],
                ':kontrolsorumlusu' => $_POST["kontrolsorumlusu"],
                ':sonucaciklama' => $_POST["sonucaciklama"],
                ':durumu' => $_POST["durumu"],
                ':kapanistarihi' => $_POST["kapanistarihi"],
                ':id' => $_POST["employee_id"]
            )
        );
        if (!empty($result)) {
            echo 'Data Updated';
        }
    }

    if ($_POST["action"] == "Delete") {
        $statement = $connection->prepare(
            "DELETE FROM isler WHERE id = :id"
        );
        $result = $statement->execute(
            array(
                ':id' => $_POST["employee_id"]
            )
        );
        if (!empty($result)) {
            echo 'Data Deleted';
        }
    }
}
?>
