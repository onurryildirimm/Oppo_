<?php
require_once 'mysql/mysqlsorgu.php';

if(isset($_POST['id']) && isset($_POST['ay']) && isset($_POST['value'])) {
    $id = $_POST['id'];
    $ay = $_POST['ay'];
    $value = $_POST['value'];

    $connection = getPDOConnection();
    $connection->query("SET NAMES UTF8");

    // Güncellenen sütunun adını dinamik olarak belirlemek için
    $column = $ay . 'gerceklesen';

    $query = "UPDATE hedeftakip SET $column = :value WHERE id = :id";
    $statement = $connection->prepare($query);
    $statement->bindParam(':value', $value);
    $statement->bindParam(':id', $id);

    if($statement->execute()) {
        echo 'Değer güncellendi.';
    } else {
        echo 'Hata: Değer güncellenemedi.';
    }
}
?>
