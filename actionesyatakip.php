<?php
require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM esyatakip ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO esyatakip (cinsi, miktar, marka, serino, cikisnedeni, ilgilidepartman, takipsorumlusu, tedarikcifirma, durumu,  cikistarihi, beklenengelistarihi, gelistarihi) 
   VALUES (:cinsi, :miktar, :marka, :serino, :cikisnedeni, :ilgilidepartman, :takipsorumlusu, :tedarikcifirma, :durumu, :cikistarihi, :beklenengelistarihi, :gelistarihi)
  ");
  $result = $statement->execute(
   array(
    ':cinsi'            => $_POST["cinsi"],
    ':miktar'           => $_POST["miktar"],
    ':marka'            => $_POST["marka"],
    ':serino'           => $_POST["serino"],
    ':cikisnedeni'      => $_POST["cikisnedeni"],
    ':ilgilidepartman'  => $_POST["ilgilidepartman"],
    ':takipsorumlusu'   => $_POST["takipsorumlusu"],
    ':tedarikcifirma'   => $_POST["tedarikcifirma"],
    ':durumu'           => $_POST["durumu"],
    ':cikistarihi'      => $_POST["cikistarihi"],
    ':beklenengelistarihi'    => $_POST["beklenengelistarihi"],
    ':gelistarihi'      => $_POST["gelistarihi"]
    
   )
  );
  if(!empty($result))
  {
   echo 'Data İşlendi';
  }

}
 


 //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select" )
 {
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM esyatakip 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["cinsi"]             = htmlspecialchars($row["cinsi"]);
   $output["miktar"]            = htmlspecialchars($row["miktar"]);
   $output["marka"]    = htmlspecialchars($row["marka"]);
   $output["serino"]       = htmlspecialchars($row["serino"]);
   $output["cikisnedeni"]  = htmlspecialchars($row["cikisnedeni"]);
   $output["ilgilidepartman"]      = htmlspecialchars($row["ilgilidepartman"]);
   $output["takipsorumlusu"]  = htmlspecialchars($row["takipsorumlusu"]);
   $output["tedarikcifirma"]     = htmlspecialchars($row["tedarikcifirma"]);
   $output["durumu"]            = htmlspecialchars($row["durumu"]);
   $output["cikistarihi"]     = htmlspecialchars($row["cikistarihi"]);
   $output["beklenengelistarihi"]     = htmlspecialchars($row["beklenengelistarihi"]);
   $output["gelistarihi"]     = htmlspecialchars($row["gelistarihi"]);
   
  }
  echo json_encode($output);
 }
 
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE esyatakip 
   SET cinsi = :cinsi, miktar = :miktar, marka = :marka, serino = :serino, cikisnedeni = :cikisnedeni, ilgilidepartman = :ilgilidepartman, takipsorumlusu = :takipsorumlusu, tedarikcifirma = :tedarikcifirma, durumu = :durumu, cikistarihi = :cikistarihi, beklenengelistarihi = :beklenengelistarihi, gelistarihi = :gelistarihi   
   WHERE id = :id
   "
  );
  $result = $statement->execute(
   array(
    ':cinsi'            => $_POST["cinsi"],
    ':miktar'           => $_POST["miktar"],
    ':marka'            => $_POST["marka"],
    ':serino'           => $_POST["serino"],
    ':cikisnedeni'      => $_POST["cikisnedeni"],
    ':ilgilidepartman'  => $_POST["ilgilidepartman"],
    ':takipsorumlusu'   => $_POST["takipsorumlusu"],
    ':tedarikcifirma'   => $_POST["tedarikcifirma"],
    ':durumu'           => $_POST["durumu"],
    ':cikistarihi'      => $_POST["cikistarihi"],
    ':beklenengelistarihi'    => $_POST["beklenengelistarihi"],
    ':gelistarihi'      => $_POST["gelistarihi"],
    ':id'   => $_POST["employee_id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Updated';
  }
 }
 


 if($_POST["action"] == "Delete")
 {
  $statement = $connection->prepare(
   "DELETE FROM isler WHERE id = :id"
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
