<?php


//Database connection by using PHP PDO
$username = 'homeandf_onur';
$password = '354472Onur';
$connection = new PDO( 'mysql:host=localhost;dbname=homeandf_lagunabeachalya', $username, $password ); // Create Object of PDO class by connecting to Mysql database

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM yillikbakimi ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO yillikbakim (cihaz_adi, bakim_tarih, bakim_yapan) 
   VALUES (:cihaz_adi, :bakim_tarih, :bakim_yapan)
  ");
  $result = $statement->execute(
   array(
    ':cihaz_adi'             => $_POST["cihaz_adi"],
    ':bakim_tarih'             => $_POST["bakim_tarih"],
    ':bakim_yapan'             => $_POST["bakim_yapan"]
    
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
   "SELECT * FROM yillikbakim 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["cihaz_adi"]              = $row["cihaz_adi"];
   $output["bakim_tarih"]            = $row["bakim_tarih"];
   $output["bakim_yapan"]            = $row["bakim_yapan"];
   
  }
  echo json_encode($output);
 }
 
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE yillikbakim 
   SET bakim_tarih = :bakim_tarih, bakim_yapan = :bakim_yapan WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':bakim_tarih'             => $_POST["bakim_tarih"],   
    ':bakim_yapan'             => $_POST["bakim_yapan"],   
    ':id'                => $_POST["employee_id"]
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
   "DELETE FROM yillikbakim WHERE id = :id"
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
