<?php
require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM malkabul ORDER BY id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO malkabul (tarih, saat, urun, tedarikci, marka, partino, skt, urunsicaklik, aracsicaklik, aractemizlik, ambalajtemizlik, kabuldurumu, aciklama, kabulyapan) 
   VALUES (:tarih, :saat, :urun, :tedarikci, :marka, :partino, :skt, :urunsicaklik, :aracsicaklik, :aractemizlik, :ambalajtemizlik, :kabuldurumu, :aciklama, :kabulyapan)
  ");
  $result = $statement->execute(
   array(
    ':tarih'             => $_POST["tarih"],
    ':saat'             => $_POST["saat"],
    ':urun'             => $_POST["urun"],
    ':tedarikci'   => $_POST["tedarikci"],
    ':marka'   => $_POST["marka"],
    ':partino'            => $_POST["partino"],
    ':skt'            => $_POST["skt"],
    ':urunsicaklik'            => $_POST["urunsicaklik"],
    ':aracsicaklik'            => $_POST["aracsicaklik"],
    ':aractemizlik'            => $_POST["aractemizlik"],
    ':ambalajtemizlik'            => $_POST["ambalajtemizlik"],
    ':kabuldurumu'            => $_POST["kabuldurumu"],
    ':aciklama'            => $_POST["aciklama"],
    ':kabulyapan'            => $_POST["kabulyapan"],
    
    
   )
  );
   if ($_POST["kabuldurumu"] == "KABUL") {
        // Mevcut kabul sayısını alın
        $query = "SELECT SUM(CASE WHEN kabuldurumu = 'KABUL' THEN 1 ELSE 0 END) AS kabul_adet FROM malkabul WHERE tedarikci = :tedarikciAdi";
        $statement = $connection->prepare($query);
        $statement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
        $statement->execute();
        $kabulAdet1 = $statement->fetch(PDO::FETCH_ASSOC)['kabul_adet'];
        $kabulAdet1 = $kabulAdet1 !== null ? $kabulAdet1 : 0;
         if (empty($kabulAdet1) ) {
        $kabulAdet1 = 0;
    }
        // Kabul sayısını güncelleyin
        $updateQuery = "UPDATE tedarikcilistesi SET kabulsayisi = :kabulAdet WHERE tedarikciadi = :tedarikciAdi";
        $updateStatement = $connection->prepare($updateQuery);
        $updateStatement->bindValue(':kabulAdet', $kabulAdet1, PDO::PARAM_INT);
        $updateStatement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
        $updateStatement->execute();
    }
    elseif ($_POST["kabuldurumu"] == "ŞARTLI KABUL") {
        // Mevcut kabul sayısını alın
        $query = "SELECT SUM(CASE WHEN kabuldurumu = 'ŞARTLI KABUL' THEN 1 ELSE 0 END) AS kabul_adet FROM malkabul WHERE tedarikci = :tedarikciAdi";
        $statement = $connection->prepare($query);
        $statement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
        $statement->execute();
        $kabulAdet2 = $statement->fetch(PDO::FETCH_ASSOC)['kabul_adet'];
        $kabulAdet2 = $kabulAdet2 !== null ? $kabulAdet2 : 0;
         if (empty($kabulAdet2)) {
        $kabulAdet2 = 0;
    }
        // Kabul sayısını güncelleyin
        $updateQuery = "UPDATE tedarikcilistesi SET sartlikabulsayisi = :kabulAdet WHERE tedarikciadi = :tedarikciAdi";
        $updateStatement = $connection->prepare($updateQuery);
        $updateStatement->bindValue(':kabulAdet', $kabulAdet2, PDO::PARAM_INT);
        $updateStatement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
        $updateStatement->execute();
    }
    elseif ($_POST["kabuldurumu"] == "RED") {
        // Mevcut kabul sayısını alın
        $query = "SELECT SUM(CASE WHEN kabuldurumu = 'RED' THEN 1 ELSE 0 END) AS kabul_adet FROM malkabul WHERE tedarikci = :tedarikciAdi";
        $statement = $connection->prepare($query);
        $statement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
        $statement->execute();
        $kabulAdet3 = $statement->fetch(PDO::FETCH_ASSOC)['kabul_adet'];
        $kabulAdet3 = $kabulAdet3 !== null ? $kabulAdet3 : 0;
         if (empty($kabulAdet3)) {
        $kabulAdet3 = 0;
    }
        // Kabul sayısını güncelleyin
        $updateQuery = "UPDATE tedarikcilistesi SET redsayisi = :kabulAdet WHERE tedarikciadi = :tedarikciAdi";
        $updateStatement = $connection->prepare($updateQuery);
        $updateStatement->bindValue(':kabulAdet', $kabulAdet3, PDO::PARAM_INT);
        $updateStatement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
        $updateStatement->execute();
    }

    if (!empty($result)) {
        echo 'Data İşlendi';
    }
}
  //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select" )
 {
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM malkabul 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["tarih"]                = htmlspecialchars($row["tarih"]);
   $output["saat"]                = htmlspecialchars($row["saat"]);
   $output["urun"]                 = htmlspecialchars($row["urun"]);
   $output["tedarikci"]            = htmlspecialchars($row["tedarikci"]);
   $output["marka"]            = htmlspecialchars($row["marka"]);
   $output["partino"]            = htmlspecialchars($row["partino"]);
   $output["skt"]                  = htmlspecialchars($row["skt"]);
   $output["urunsicaklik"]         = htmlspecialchars($row["urunsicaklik"]);
   $output["aracsicaklik"]         = htmlspecialchars($row["aracsicaklik"]);
   $output["aractemizlik"]         = htmlspecialchars($row["aractemizlik"]);
   $output["ambalajtemizlik"]      = htmlspecialchars($row["ambalajtemizlik"]);
   $output["kabuldurumu"]      = htmlspecialchars($row["kabuldurumu"]);
   $output["aciklama"]             = htmlspecialchars($row["aciklama"]);
   $output["kabulyapan"]           = htmlspecialchars($row["kabulyapan"]);
   
  }
  echo json_encode($output);
 }
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE malkabul 
   SET tarih = :tarih, urun = :urun, tedarikci = :tedarikci, marka = :marka, partino = :partino, skt = :skt, urunsicaklik = :urunsicaklik, aracsicaklik = :aracsicaklik, aractemizlik = :aractemizlik, ambalajtemizlik = :ambalajtemizlik, kabuldurumu = :kabuldurumu, aciklama = :aciklama, kabulyapan = :kabulyapan WHERE id = :id");
  $result = $statement->execute(
   array(
    ':tarih'             => $_POST["tarih"],
    ':urun'              => $_POST["urun"],
    ':tedarikci'         => $_POST["tedarikci"],
    ':marka'             => $_POST["marka"],
    ':partino'           => $_POST["partino"],
    ':skt'               => $_POST["skt"],
    ':urunsicaklik'      => $_POST["urunsicaklik"],
    ':aracsicaklik'      => $_POST["aracsicaklik"],
    ':aractemizlik'      => $_POST["aractemizlik"],
    ':ambalajtemizlik'   => $_POST["ambalajtemizlik"],
    ':aciklama'          => $_POST["aciklama"],
    ':kabuldurumu'          => $_POST["kabuldurumu"],
    ':kabulyapan'        => $_POST["kabulyapan"],
    ':id'                => $_POST["employee_id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Updated';
  }
 }
if($_POST["action"] == "Güncelle")
 {
    // Mevcut kabul sayısını alın
    $query = "SELECT SUM(CASE WHEN kabuldurumu = 'KABUL' THEN 1 ELSE 0 END) AS kabul_adet FROM malkabul WHERE tedarikci = :tedarikciAdi";
    $statement = $connection->prepare($query);
    $statement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
    $statement->execute();
    $kabulAdet1 = $statement->fetch(PDO::FETCH_ASSOC)['kabul_adet'];
    $kabulAdet1 = $kabulAdet1 !== null ? $kabulAdet1 : 0;

    // Kabul sayısını güncelleyin
    $updateQuery = "UPDATE tedarikcilistesi SET kabulsayisi = :kabulAdet WHERE tedarikciadi = :tedarikciAdi";
    $updateStatement = $connection->prepare($updateQuery);
    $updateStatement->bindValue(':kabulAdet', $kabulAdet1, PDO::PARAM_INT);
    $updateStatement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
    $updateStatement->execute();
}
if($_POST["action"] == "Güncelle")
 {
    // Mevcut kabul sayısını alın
    $query = "SELECT SUM(CASE WHEN kabuldurumu = 'ŞARTLI KABUL' THEN 1 ELSE 0 END) AS kabul_adet FROM malkabul WHERE tedarikci = :tedarikciAdi";
    $statement = $connection->prepare($query);
    $statement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
    $statement->execute();
    $kabulAdet1 = $statement->fetch(PDO::FETCH_ASSOC)['kabul_adet'];
    $kabulAdet1 = $kabulAdet1 !== null ? $kabulAdet1 : 0;

    // Kabul sayısını güncelleyin
    $updateQuery = "UPDATE tedarikcilistesi SET sartlikabulsayisi = :kabulAdet WHERE tedarikciadi = :tedarikciAdi";
    $updateStatement = $connection->prepare($updateQuery);
    $updateStatement->bindValue(':kabulAdet', $kabulAdet1, PDO::PARAM_INT);
    $updateStatement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
    $updateStatement->execute();
}
if($_POST["action"] == "Güncelle")
 {
    // Mevcut kabul sayısını alın
    $query = "SELECT SUM(CASE WHEN kabuldurumu = 'RED' THEN 1 ELSE 0 END) AS kabul_adet FROM malkabul WHERE tedarikci = :tedarikciAdi";
    $statement = $connection->prepare($query);
    $statement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
    $statement->execute();
    $kabulAdet1 = $statement->fetch(PDO::FETCH_ASSOC)['kabul_adet'];
    $kabulAdet1 = $kabulAdet1 !== null ? $kabulAdet1 : 0;

    // Kabul sayısını güncelleyin
    $updateQuery = "UPDATE tedarikcilistesi SET redsayisi = :kabulAdet WHERE tedarikciadi = :tedarikciAdi";
    $updateStatement = $connection->prepare($updateQuery);
    $updateStatement->bindValue(':kabulAdet', $kabulAdet1, PDO::PARAM_INT);
    $updateStatement->bindParam(':tedarikciAdi', $_POST["tedarikci"], PDO::PARAM_STR);
    $updateStatement->execute();
}


 if($_POST["action"] == "Delete")
 {
  $statement = $connection->prepare(
   "DELETE FROM malkabul WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':id' => $_POST["employee_id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Deleted';
  }
 }
}

?>
