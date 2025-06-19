<?php
 require_once 'mysql/mysqlsorgu.php';
  // PhpSpreadsheet'i dahil edin
 use PhpOffice\PhpSpreadsheet\IOFactory;
  require 'vendor/autoload.php';

// Excel dosyasını yükleyin
if (isset($_POST['upload'])) {
    if ($_FILES['excelFile']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['excelFile']['tmp_name'];
        $excel_name = $_FILES['excelFile']['name'];
        move_uploaded_file($tmp_name, $excel_name);
    } else {
        die("Excel dosyası yüklenirken bir hata oluştu.");
    }
    try {
        // Veritabanı bağlantısını oluşturun
        $pdo = getPDOConnection();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Excel dosyasını yükleyin ve verileri okuyun
        $spreadsheet = IOFactory::load($excel_name);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray(null, true, true, true);

        // Verileri MySQL veritabanına ekleyin
        foreach ($data as $row) {
            $stmt = $pdo->prepare("INSERT INTO urungrubu (urungrubu2) VALUES (?)");
            $stmt->bindParam(1, $row['A']);
            
            $stmt->execute();
        }

        echo "Excel dosyası başarıyla yüklendi ve veriler veritabanına eklendi.";
    } catch (PDOException $e) {
        die("Hata: " . $e->getMessage());
    }
}
// 5 saniye sonra yönlendirme
sleep(5);

// Yönlendirme işlemi
header("Location: urungrubuekle");
?>