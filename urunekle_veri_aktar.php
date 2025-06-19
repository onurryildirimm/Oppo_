<?php
require_once 'mysql/mysqlsorgu.php';
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
            $stmt = $pdo->prepare("INSERT INTO urunekle (urun, grup, ambalajmiktari, birim, marka, firma) VALUES (:urun, :grup, :ambalajmiktari, :birim, :marka, :firma)");
            $stmt->bindParam(':urun', $row['A']);
            $stmt->bindParam(':grup', $row['B']);
            $stmt->bindParam(':ambalajmiktari', $row['C']);
            $stmt->bindParam(':birim', $row['D']);
            $stmt->bindParam(':marka', $row['E']);
            $stmt->bindParam(':firma', $row['F']);

            $stmt->execute();
        }

        echo "Excel dosyası başarıyla yüklendi ve veriler veritabanına eklendi.";
    } catch (PDOException $e) {
        die("Hata: " . $e->getMessage());
    }
}
?>
