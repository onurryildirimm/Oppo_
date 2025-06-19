<?php
//Database connection by using PHP PDO
require_once "mysql/mysqlsorgu.php";
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  loadDataIlaclama();
  
 }
 
 
 
 if ($_POST["action"] == "Kayıt Ekle") {

    addRecordIlaclama(); }
 
 //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select" )
{
    $output = array();
    $statement = $connection->prepare(
       "SELECT * FROM yillikilaclama 
        WHERE id = '".$_POST["employee_id"]."' 
        LIMIT 1"
    );
    $pdf_path = $row["pdf"];
    $statement->execute();
    $result = $statement->fetchAll();
    
    foreach($result as $row)
    {
        $output["planlanantarih"]        = $row["planlanantarih"];
        $output["durum"]       = $row["durum"];
        $output["bitistarihi"]        = $row["bitistarihi"];
        $output["pdf"]  = $pdf_path;
       
        
    }
    
    echo json_encode($output);
}
 

if($_POST["action"] == "Güncelle") {
    $id = $_POST["employee_id"];

    $statement = $connection->prepare("SELECT * FROM yillikilaclama WHERE id=:id");
    $statement->execute(array(':id' => $id));
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    $pdf_paths = array();
    if (isset($_FILES["pdf"])) {
        foreach($_FILES["pdf"]["tmp_name"] as $key => $tmp_name){
            $target_dir = "ilacform/";
            $target_file = $target_dir . basename($_FILES["pdf"]["name"][$key]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if($imageFileType != "pdf") {
                echo "Sadece PDF dosyaları yüklenebilir.";
                $uploadOk = 0;
            }
            if ($uploadOk == 1 && move_uploaded_file($_FILES["pdf"]["tmp_name"][$key], $target_file)) {
                $pdf_paths[] = $target_file;
            } else {
                $pdf_paths[] = $row['pdf'];
            }
        }
    } else {
        $pdf_paths[] = $row['pdf'];
    }

    if (isset($_POST['gruplar'])) {
        $gruplar = $_POST['gruplar'];
        if (!is_array($gruplar)) {
            $gruplar = json_decode($gruplar);
        }
        $gruplar_str = implode(", ", $gruplar);
    } else {
        $gruplar_str = "";
    }
    if (isset($_POST['username'])) {
        $mail = $_POST['username'];
        if (!is_array($mail)) {
            $mail = json_decode($mail);
        }
        $mail_str = implode(", ", $mail);
    } else {
        $mail_str = "";
    }

    $statement = $connection->prepare("UPDATE yillikilaclama 
        SET planlanantarih = :planlanantarih, durum = :durum, bitistarihi = :bitistarihi, pdf = :pdf WHERE id = :id");
    $result = $statement->execute(array(
        ':planlanantarih' => $_POST["planlanantarih"],
        ':durum' => $_POST["durum"],
        ':bitistarihi' => $_POST["bitistarihi"],
        ':pdf' => implode(",", $pdf_paths),
        ':id' => $id
    ));

    if(!empty($result)) {
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
