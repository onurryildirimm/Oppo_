<?php
require_once 'mysql/mysqlsorgu.php';

$pdoconnection = getPDOConnection();

// Ajax isteğinden gelen "id" verisini al
$id = $_POST['notificationIds'];

// Bildirimi veritabanından sil
$statement = $pdoconnection->prepare("DELETE FROM notifications WHERE id = :id");
$statement->bindParam(':id', $id);
$statement->execute();
?>
