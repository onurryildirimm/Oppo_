<?php
require_once "mysql/mysqlsorgu.php";
$conn = dbConnect();
mysqli_set_charset($conn, "utf8");

$title = $_POST['title'];
$message = $_POST['message'];

$usernames = $_POST['usernames'];
foreach ($usernames as $username) {
  $sql = "INSERT INTO notifications (title, message, username) VALUES ('$title', '$message', '$username')";
  if (mysqli_query($conn, $sql)) {
    echo "Bildirim başarıyla eklendi.";
  } else {
    echo "Bildirim eklenirken hata oluştu: " . mysqli_error($conn);
  }
}


?>

<?php


$title = $_POST['title'];
$message = $_POST['message'];

$usernames = $_POST['usernames'];
foreach ($usernames as $username) {
  $sql = "INSERT INTO notifications2 (title, message, username) VALUES ('$title', '$message', '$username')";
  if (mysqli_query($conn, $sql)) {
    echo "Bildirim başarıyla eklendi.";
  } else {
    echo "Bildirim eklenirken hata oluştu: " . mysqli_error($conn);
  }
}

header("location: bildirimekle");
exit;
?>






