<?php


require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM anketsayi ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO anketsayi (ay, anketsayi) 
   VALUES (:ay, :anketsayi)
  ");
  $result = $statement->execute(
   array(
    ':ay'             => $_POST["ay"],
    ':anketsayi'            => $_POST["anketsayi"]
    
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
   "SELECT * FROM anketsayi 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["ay"]              = $row["ay"];
   $output["anketsayi"]             = $row["anketsayi"];
   
  }
  echo json_encode($output);
 }
 
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE anketsayi 
   SET ay = :ay, anketsayi = :anketsayi WHERE id = :id"
  );
  $result = $statement->execute(
   array(
    ':ay'             => $_POST["ay"],   
    ':anketsayi'            => $_POST["anketsayi"],
    
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
   "DELETE FROM tedarik WHERE id = :id"
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
