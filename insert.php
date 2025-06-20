<?php

require_once 'mysql/mysqlsorgu.php';
$connection = getPDOConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $t1 = $_POST["t1"];
    $geceleme = $_POST["geceleme"];
    $carpan = $_POST["carpan"];
    $sayacdeger = $_POST["sayacdeger"];
    $tarih = $_POST["tarih"];
    $euro = $_POST["euro"];
    $devir = !empty($_POST["devir"]) ? $_POST["devir"] : NULL;

    
    // Devir değeri boş ise NULL olarak atayın
    if (empty($devir)) {
        $devir = NULL;
    }

    $statement = $connection->prepare("INSERT INTO kwhucret (t1, geceleme, tarih, euro, carpan, sayacdeger, devir) VALUES (:t1, :geceleme, :tarih, :euro, :carpan, :sayacdeger, :devir)");
    $statement->bindValue(':t1', $t1);
    $statement->bindValue(':geceleme', $geceleme);
    $statement->bindValue(':tarih', $tarih);
    $statement->bindValue(':euro', $euro);
    $statement->bindValue(':carpan', $carpan);
    $statement->bindValue(':sayacdeger', $sayacdeger);
    $statement->bindValue(':devir', $devir);
    $statement->execute();

    if ($statement->errorInfo()[0] !== '00000') {
        // Display the SQL error message
        echo 'Error: ' . $statement->errorInfo()[2];
    } else {
        // Display success message
        echo 'New data added!';
    }
    
    header("Location: https://www.vektraweb.com.tr/portal/lagunabeachalya/t1elektrik");
    exit();
}
?>
