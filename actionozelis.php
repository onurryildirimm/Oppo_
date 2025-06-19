<?php
require_once "mysql/mysqlsorgu.php";
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM ozelisler ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO ozelisler (tarih, konu, detay, durum, sorumludepartman, yapilanis, bitistarihi, tamamlanmatarihi, kullanici) 
   VALUES (:tarih, :konu, :detay, :durum, :sorumludepartman, :yapilanis, :bitistarihi, :tamamlanmatarihi, :kullanici)
  ");
  $result = $statement->execute(
   array(
    ':tarih'            => $_POST["tarih"],
    ':konu'           => $_POST["konu"],
    ':detay'   => $_POST["detay"],
    ':durum'      => $_POST["durum"],
    ':sorumludepartman' => $_POST["sorumludepartman"],
    ':yapilanis'     => $_POST["yapilanis"],
    ':bitistarihi' => $_POST["bitistarihi"],
    ':tamamlanmatarihi' => $_POST["tamamlanmatarihi"],
    ':kullanici'    => $_POST["kullanici"]
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
   "SELECT * FROM ozelisler 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["tarih"]             = htmlspecialchars($row["tarih"]);
   $output["konu"]            = htmlspecialchars($row["konu"]);
   $output["detay"]    = htmlspecialchars($row["detay"]);
   $output["durum"]       = htmlspecialchars($row["durum"]);
   $output["sorumludepartman"]  = htmlspecialchars($row["sorumludepartman"]);
   $output["yapilanis"]      = htmlspecialchars($row["yapilanis"]);
   $output["bitistarihi"]  = htmlspecialchars($row["bitistarihi"]);
   $output["tamamlanmatarihi"]  = htmlspecialchars($row["tamamlanmatarihi"]);
   $output["kullanici"]     = htmlspecialchars($row["kullanici"]);
   
   
  }
  echo json_encode($output);
 }
 
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE ozelisler 
   SET tarih = :tarih, konu = :konu, detay = :detay, durum = :durum, sorumludepartman = :sorumludepartman, yapilanis = :yapilanis, bitistarihi = :bitistarihi, tamamlanmatarihi = :tamamlanmatarihi, kullanici = :kullanici WHERE id = :id
   "
  );
  $result = $statement->execute(
   array(
    ':tarih'            => $_POST["tarih"],
    ':konu'           => $_POST["konu"],
    ':detay'   => $_POST["detay"],
    ':durum'      => $_POST["durum"],
    ':sorumludepartman' => $_POST["sorumludepartman"],
    ':yapilanis'     => $_POST["yapilanis"],
    ':bitistarihi' => $_POST["bitistarihi"],
    ':tamamlanmatarihi' => $_POST["tamamlanmatarihi"],
    ':kullanici'    => $_POST["kullanici"],
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
   "DELETE FROM ozelisler WHERE id = :id"
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
