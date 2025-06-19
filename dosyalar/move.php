<?php
if (isset($_POST['file']) && isset($_POST['destination'])) {
    $sourceFile = $_POST['file'];
    $destinationDir = $_POST['destination'];

    if (file_exists($sourceFile) && is_dir($destinationDir)) {
        $fileName = basename($sourceFile);
        $destinationPath = $destinationDir . '/' . $fileName;

        if (rename($sourceFile, $destinationPath)) {
            echo "Dosya başarıyla taşındı.";
        } else {
            echo "Dosya taşınamadı.";
        }
    } else {
        echo "Dosya veya hedef dizin bulunamadı.";
    }
}
?>
