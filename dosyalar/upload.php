<?php
if(isset($_FILES['fileToUpload'])) {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
        echo "Dosya başarıyla yüklendi.";
    } else {
        echo "Dosya yükleme başarısız.";
    }
}
?>
