<?php


require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM urunekle ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO urunekle (urun, grup, ambalajmiktari, birim, marka, firma) 
   VALUES (:urun, :grup, :ambalajmiktari, :birim, :marka, :firma)
  ");
  $result = $statement->execute(
   array(
    ':urun'             => $_POST["urun"],
    ':grup'             => $_POST["grup"],
    ':ambalajmiktari'   => $_POST["ambalajmiktari"],
    ':birim'            => $_POST["birim"],
    ':marka'            => $_POST["marka"],
    ':firma'            => $_POST["firma"]
    
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
   "SELECT * FROM urunekle 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["urun"]              = htmlspecialchars($row["urun"]);
   $output["grup"]              = htmlspecialchars($row["grup"]);
   $output["ambalajmiktari"]    = htmlspecialchars($row["ambalajmiktari"]);
   $output["birim"]             = htmlspecialchars($row["birim"]);
   $output["marka"]             = htmlspecialchars($row["marka"]);
   $output["firma"]             = htmlspecialchars($row["firma"]);
   
  }
  echo json_encode($output);
 }
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE urunekle 
   SET urun = :urun, grup = :grup, ambalajmiktari = :ambalajmiktari, birim = :birim, marka = :marka, firma = :firma WHERE id = :id");
  $result = $statement->execute(
   array(
    ':urun'             => $_POST["urun"],
    ':grup'             => $_POST["grup"],
    ':ambalajmiktari'   => $_POST["ambalajmiktari"],
    ':birim'            => $_POST["birim"],
    ':marka'            => $_POST["marka"],
    ':firma'            => $_POST["firma"],
    ':id'               => $_POST["employee_id"]
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
   "DELETE FROM urunekle WHERE id = :id"
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
