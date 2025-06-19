<?php
require_once 'mysql/mysqlsorgu.php';


$connection = getPDOConnection(); // Create Object of PDO class by connecting to Mysql database

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM cihazlistesi ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO cihazlistesi (cihaz) 
   VALUES (:cihaz)
  ");
  $result = $statement->execute(
   array(
    ':cihaz'             => $_POST["cihaz"]
    
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
   "SELECT * FROM cihazlistesi 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["cihaz"]              = $row["cihaz"];
   
  }
  echo json_encode($output);
 }
 
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE cihazlistesi 
   SET cihaz = :cihaz WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':cihaz'             => $_POST["cihaz"],   

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
   "DELETE FROM cihazlistesi WHERE id = :id"
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
