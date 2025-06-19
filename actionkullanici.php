<?php
include 'mysql/mysqlsorgu.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// PDO bağlantısını oluştur
$pdo = getPDOConnection();

if (isset($_POST["action"])) {

    // Tüm verileri yüklemek için
    if ($_POST["action"] == "Load") {
        $userList = getUserList($pdo);
        // Verileri gerektiği gibi işleyin
    }

    // Yeni Kayıt Ekle
    if ($_POST["action"] == "Kayıt Ekle") {
        $result = addUser($pdo, $_POST);
        if (!empty($result)) {
            echo 'Data İşlendi';
        }
    }

    // Belirli bir kullanıcıyı modalda göstermek için veri çekme
    if ($_POST["action"] == "Select") {
        $user = getUserById($pdo, $_POST["employee_id"]);
        echo json_encode($user);
    }

    // Kayıt güncelleme
    if ($_POST["action"] == "Güncelle") {
        $result = updateUser($pdo, $_POST);
        if (!empty($result)) {
            echo 'Data Updated';
        }
    }

    // Kayıt silme
    if ($_POST["action"] == "Delete") {
        $result = deleteUser($pdo, $_POST["employee_id"]);
        if (!empty($result)) {
            echo 'Data Deleted';
        }
    }
}
?>
