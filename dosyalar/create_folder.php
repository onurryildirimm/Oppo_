<?php
if(isset($_POST['folderName'])) {
    $folderName = "uploads/" . $_POST['folderName'];

    if(!is_dir($folderName)) {
        mkdir($folderName, 0777, true);
        echo "Klasör başarıyla oluşturuldu.";
    } else {
        echo "Bu isimde bir klasör zaten mevcut.";
    }
}
?>
