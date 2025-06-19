<?php
require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM egitim ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  
 }
 
 
 
 if ($_POST["action"] == "Kayıt Ekle") {

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

    $pdf_paths = array(); 
    for ($i=0; $i < count($_FILES["pdf"]["name"]); $i++) { 

        if ($_FILES["pdf"]["name"][$i] != "") {

            $target_dir = "uploads/"; 
            $original_name = basename($_FILES["pdf"]["name"][$i]);
            $target_file = $target_dir . $original_name; 
            $uploadOk = 1; 
            $pdfFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 

            if (isset($_POST["submit"])) {
                $check = filesize($_FILES["pdf"]["tmp_name"][$i]);
                if ($check === false) {
                    $uploadOk = 0;
                }
            }

            if (file_exists($target_file)) {
                $path_parts = pathinfo($original_name);
                $new_name = $path_parts['filename'] . '_' . time() . '.' . $path_parts['extension'];
                $target_file = $target_dir . $new_name;
            }

            if ($_FILES["pdf"]["size"][$i] > 1000000) {
                echo "Dosya boyutu çok büyük.";
                $uploadOk = 0;
            }

            if ($pdfFileType != "pdf") {
                echo "Sadece PDF dosyalarına izin verilir.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["pdf"]["tmp_name"][$i], $target_file)) {
                    $pdf_paths[] = $target_file; 
                } else {
                    echo "Dosya yükleme hatası.";
                }
            }
        }
    }

if (!empty($pdf_paths)) {
    $pdf_paths_str = implode(",", $pdf_paths);
} else {
    $pdf_paths_str = ""; // pdf yüklenmediyse null değeri atanacak
}
    

    $query = "INSERT INTO egitim (konu, veren, sure, gruplar, planlanan, gerceklesen, pdf, username, departman) 
              VALUES (:konu, :veren, :sure, :gruplar, :planlanan, :gerceklesen, :pdf, :username, :departman)";

    $statement = $connection->prepare($query);

    $result = $statement->execute(
        array(
            ':konu'             => $_POST["konu"],
            ':veren'            => $_POST["veren"],
            ':sure'             => $_POST["sure"],
            ':gruplar'          => $gruplar_str,
            ':planlanan'        => $_POST["planlanan"],
            ':gerceklesen'      => $_POST["gerceklesen"],
            ':pdf'              => $pdf_paths_str, 
            ':username'         => $mail_str,
            ':departman'             => $_POST["departman"],
        )
    );

    if(!empty($result)) {
        echo 'Data İş';
    }
$konu = "EĞİTİM PLANLAMASI";
$query2 = "INSERT INTO operasyontakip (tarih, konu, icerik, departman) 
              VALUES (:tarih, :konu, :icerik, :departman)";

    $statement2 = $connection->prepare($query2);

    $result2 = $statement2->execute(
        array(
            ':tarih'             => $_POST["planlanan"],
            ':konu'              => $konu,
            ':icerik'            => $_POST["konu"],
            ':departman'         => $gruplar_str,
            
        )
    );

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
 //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select" )
{
    $output = array();
    $statement = $connection->prepare(
       "SELECT * FROM egitim 
        WHERE id = '".$_POST["employee_id"]."' 
        LIMIT 1"
    );
    $pdf_path = $row["pdf"];
    $statement->execute();
    $result = $statement->fetchAll();
    
    foreach($result as $row)
    {
        $output["konu"]        = $row["konu"];
        $output["veren"]       = $row["veren"];
        $output["sure"]        = $row["sure"];
        
        $gruplar = array(); // yeni dizi değişkeni oluşturuldu
        
        // gruplar sütunundaki veriler foreach döngüsü ile diziye aktarılıyor
        $gruplar = explode(",", $row["gruplar"]);
        foreach($gruplar as &$checkbox)
        {
            $checkbox = trim($checkbox); // trim() fonksiyonu ile boşluklar temizleniyor
        }
        $output["gruplar"] = $gruplar; // yeni dizi değişkeni $output["gruplar"]'a atanıyor
        
        $output["planlanan"]    = $row["planlanan"];
        $output["gerceklesen"]  = $row["gerceklesen"];
        $output["pdf"]  = $pdf_path;
       // gruplar sütunundaki veriler foreach döngüsü ile diziye aktarılıyor
        $username = explode(",", $row["username"]);
        foreach($username as &$checkbox)
        {
            $checkbox = trim($checkbox); // trim() fonksiyonu ile boşluklar temizleniyor
        }
        $output["username"] = $username; // yeni dizi değişkeni $output["gruplar"]'a atanıyor
        $output["departman"]  = $row["departman"];
        
    }
    
    echo json_encode($output);
}
 

if($_POST["action"] == "Güncelle") {
    $id = $_POST["employee_id"];

    $statement = $connection->prepare("SELECT * FROM egitim WHERE id=:id");
    $statement->execute(array(':id' => $id));
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    $pdf_paths = array();
    if (isset($_FILES["pdf"])) {
        foreach($_FILES["pdf"]["tmp_name"] as $key => $tmp_name){
            $target_dir = "uploads/";
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

    $statement = $connection->prepare("UPDATE egitim 
        SET konu = :konu, veren = :veren, sure = :sure, gruplar = :gruplar, planlanan = :planlanan, gerceklesen = :gerceklesen, pdf = :pdf, username = :username, departman = :departman WHERE id = :id");
    $result = $statement->execute(array(
        ':konu' => $_POST["konu"],
        ':veren' => $_POST["veren"],
        ':sure' => $_POST["sure"],
        ':gruplar' => $gruplar_str,
        ':planlanan' => $_POST["planlanan"],
        ':gerceklesen' => $_POST["gerceklesen"],
        ':departman' => $_POST["departman"],
        ':pdf' => implode(",", $pdf_paths),
        ':username'         => $mail_str,
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
