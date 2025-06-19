<?php
if (isset($_POST['oldPath']) && isset($_POST['newName'])) {
    $oldPath = $_POST['oldPath'];
    $newName = basename($_POST['newName']); // Yeni adın güvenli olmasını sağla (sadece ad kısmı)
    $newPath = dirname($oldPath) . '/' . $newName; // Eski yolun dizinini al ve yeni adı ekle

    // Dosya veya klasör yeniden adlandır
    if (file_exists($oldPath)) {
        if (rename($oldPath, $newPath)) {
            echo "Dosya başarıyla yeniden adlandırıldı.";
        } else {
            echo "Yeniden adlandırma işlemi başarısız oldu.";
        }
    } else {
        echo "Dosya veya klasör bulunamadı.";
    }
}
?>
