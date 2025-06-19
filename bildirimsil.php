<?php
require_once "mysql/mysqlsorgu.php";
$connection = getPDOConnection();

// Ajax isteğinden gelen "id" verisini al
$id = $_POST['id'];

// Bildirimi veritabanından sil
$statement = $connection->prepare("DELETE FROM notifications2 WHERE id = :id");
$statement->bindParam(':id', $id);
$statement->execute();
?>
