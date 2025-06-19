<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Dosya veya klasör yolunu kontrol et
    echo "Silme işlemi için dosya yolu: " . $file . "<br>";

    // Eğer dosya bir klasörse özyinelemeli olarak sil
    if (is_dir($file)) {
        echo "Bir klasör siliniyor...<br>";
        if (deleteDirectory($file)) {
            echo "Klasör ve içeriği başarıyla silindi.";
        } else {
            echo "Klasör silinemedi.";
        }
    } 
    // Eğer dosya ise dosya olarak sil
    else if (file_exists($file)) {
        echo "Dosya mevcut. Siliniyor...<br>";
        if (unlink($file)) {
            echo "Dosya başarıyla silindi.";
        } else {
            echo "Dosya silinemedi.";
        }
    } else {
        echo "Dosya veya klasör bulunamadı.";
    }
}

// Klasörü ve içindekileri silen özyinelemeli fonksiyon
function deleteDirectory($dir) {
    if (!is_dir($dir)) {
        return false;
    }

    $items = scandir($dir);
    foreach ($items as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }
        $filePath = $dir . '/' . $item;
        if (is_dir($filePath)) {
            // Klasörse özyinelemeli olarak sil
            deleteDirectory($filePath);
        } else {
            // Dosyaysa sil
            unlink($filePath);
        }
    }

    // Klasör boş olduğunda sil
    return rmdir($dir);
}
?>
