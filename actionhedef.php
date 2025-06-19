<?php
require_once 'mysql/mysqlsorgu.php';

$ay = isset($_POST['ay']) ? $_POST['ay'] : '';

$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM hedeftakip ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  
   $statement = $connection->prepare("
   INSERT INTO hedeftakip (departman, performanskriteri, " . $ay . "hedef,   hedefaciklama) 
   VALUES (:departman, :performanskriteri, :hedefdeger, :hedefaciklama)
");

$result = $statement->execute(
    array(
        ':departman'            => $_POST["departman"],
        ':performanskriteri'    => $_POST["performanskriteri"],
        ':hedefdeger'           => $_POST["hedefdeger"],
     
        ':hedefaciklama'        => $_POST["hedefaciklama"]
    )
);

if (!empty($result)) {
    echo 'Data İşlendi';
}

 }


 //This Code is for fetch single customer data for display on Modal
if($_POST["action"] == "Select" )
 {
     
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM hedeftakip 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["departman"]             = $row["departman"];
   $output["performanskriteri"]     = $row["performanskriteri"];
   $output["hedefdeger"] = isset($row[$ay . "hedef"]) ? $row[$ay . "hedef"] : ''; // $ay değişkeni tanımlıysa ve beklenen değeri içeriyorsa, değeri atar, aksi halde boş bir değer atar
        
   $output["hedefaciklama"]         = $row["hedefaciklama"];
   
   
  }
  echo json_encode($output);
 }
 
 
 

 if($_POST["action"] == "Güncelle")
 {
    
  $statement = $connection->prepare(
   "UPDATE hedeftakip 
   SET departman = :departman, 
       performanskriteri = :performanskriteri, 
       " . $ay . "hedef = :hedefdeger, 
       
       hedefaciklama = :hedefaciklama 
   WHERE id = :id"
);
  $result = $statement->execute(
   array(
    ':departman'            => $_POST["departman"],
    ':performanskriteri'    => $_POST["performanskriteri"],
    ':hedefdeger'           => $_POST["hedefdeger"],
    
    ':hedefaciklama'        => $_POST["hedefaciklama"],
    ':id'                   => $_POST["employee_id"]
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
   "DELETE FROM hedeftakip WHERE id = :id"
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
