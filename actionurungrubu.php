<?php


require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM urungrubu ORDER BY id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 //This code for Create new Records
 if($_POST["action"] == "Kayıt Ekle")
 {
  $statement = $connection->prepare("
   INSERT INTO urungrubu (urungrubu2) 
   VALUES (:urungrubu2)
  ");
  $result = $statement->execute(
   array(
    ':urungrubu2'            => $_POST["urungrubu2"]
    
   )
  );
  if(!empty($result))
  {
   echo 'Data İşlendi';
  }
$konu = "EĞİTİM PLANLAMASI";
$query2 = "INSERT INTO operasyontakip (tarih, konu, icerik, departman) 
              VALUES (:tarih, :konu, :icerik, :departman)";

    $statement2 = $connection->prepare($query2);

    $result2 = $statement2->execute(
        array(
            ':tarih'             => $_POST["termintarihi"],
            ':konu'              => $_POST["gundem"],
            ':icerik'            => $_POST["alinankarar"],
            ':departman'         => $_POST["sorumludepartman"],
            
        )
    );

}
 


 //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select" )
 {
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM urungrubu 
   WHERE id = '".$_POST["employee_id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["urungrubu2"]             = htmlspecialchars($row["urungrubu2"]);
  
   
  }
  echo json_encode($output);
 }
 
 

 if($_POST["action"] == "Güncelle")
 {
  $statement = $connection->prepare(
   "UPDATE urungrubu SET urungrubu2 = :urungrubu2 WHERE id = :id");
  $result = $statement->execute(
   array(
    ':urungrubu2' => $_POST["urungrubu2"],
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
   "DELETE FROM urungrubu WHERE id = :id"
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
