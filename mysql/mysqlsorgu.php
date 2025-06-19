<?php

// Veritabanı bağlantısı fonksiyonu
function dbConnect() {
    $servername = "localhost";
    $username = "xxxxx";
    $password = "xxxxx";
    $dbname = "xxxxx";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }
    return $conn;
}


// PDO bağlantısını döndüren fonksiyon
function getPDOConnection() {
    $pdo = new PDO("mysql:host=localhost;dbname=xxxxx", "xxxxx", "xxxxx");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
 try {
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
    }
}

// Seçilen grup için tedarikçileri döndüren fonksiyon
function getTedarikcilerByGrup($pdo, $secilenGrup) {
    $sql = "SELECT tedarikciadi FROM tedarikcilistesi WHERE urungrubu LIKE :secilenGrup";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':secilenGrup', '%' . $secilenGrup . '%', PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Yaklaşan eğitimleri getirme fonksiyonu
function getEgitimler($conn, $currentDate, $limit = 10) {
    $sql = "SELECT konu, veren, sure, gruplar, planlanan FROM egitim WHERE planlanan > ? ORDER BY planlanan ASC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $currentDate, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Kabul, Red ve Şartlı Kabul sayıları fonksiyonu
function getKabulCounts($conn) {
    $counts = [];

    $sql_kabul = "SELECT COUNT(*) as kabul_sayisi FROM malkabul WHERE kabuldurumu = 'KABUL'";
    $sql_red = "SELECT COUNT(*) as red_sayisi FROM malkabul WHERE kabuldurumu = 'RED'";
    $sql_sartli_kabul = "SELECT COUNT(*) as sartli_kabul_sayisi FROM malkabul WHERE kabuldurumu = 'ŞARTLI KABUL'";

    $result_kabul = $conn->query($sql_kabul);
    $result_red = $conn->query($sql_red);
    $result_sartli_kabul = $conn->query($sql_sartli_kabul);

    $counts['kabul_sayisi'] = $result_kabul->fetch_assoc()['kabul_sayisi'];
    $counts['red_sayisi'] = $result_red->fetch_assoc()['red_sayisi'];
    $counts['sartli_kabul_sayisi'] = $result_sartli_kabul->fetch_assoc()['sartli_kabul_sayisi'];

    return $counts;
}

// Son 8 Mal Kabul kaydını getirme fonksiyonu
function getLastMalKabul($conn, $limit = 8) {
    $sql = "SELECT * FROM malkabul ORDER BY id DESC LIMIT ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Toplam kullanıcı sayısını getiren fonksiyon
function getTotalUsers($conn) {
    $sql = "SELECT count(*) as total_users FROM user";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_users'];
}

// Online kullanıcı sayısını getiren fonksiyon
function getOnlineUsers($conn) {
    $sql = "SELECT count(*) as online_users FROM user WHERE status = 'Online'";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['online_users'];
}

// Devam eden işler sayısını getiren fonksiyon
function getOngoingJobs($conn) {
    $sql = "SELECT count(*) as ongoing_jobs FROM isler WHERE durumu = 'DEVAM EDİYOR'";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['ongoing_jobs'];
}

// Toplam mal kabul sayısını getiren fonksiyon
function getTotalMalKabul($conn) {
    $sql = "SELECT count(*) as total_malkabul FROM malkabul";
    $result = $conn->query($sql);
    return $result->fetch_assoc()['total_malkabul'];
}

// Kabul, Red ve Şartlı Kabul sayıları fonksiyonu
function getKabulRedCounts($connection) {
    $counts = [];

    $sql_kabul = "SELECT COUNT(*) as kabul_sayisi FROM malkabul WHERE kabuldurumu = 'KABUL'";
    $sql_red = "SELECT COUNT(*) as red_sayisi FROM malkabul WHERE kabuldurumu = 'RED'";
    $sql_sartli_kabul = "SELECT COUNT(*) as sartli_kabul_sayisi FROM malkabul WHERE kabuldurumu = 'ŞARTLI KABUL'";

    $result_kabul = $connection->query($sql_kabul);
    $result_red = $connection->query($sql_red);
    $result_sartli_kabul = $connection->query($sql_sartli_kabul);

    $counts['kabul_sayisi'] = (int)$result_kabul->fetch_assoc()['kabul_sayisi'];
    $counts['red_sayisi'] = (int)$result_red->fetch_assoc()['red_sayisi'];
    $counts['sartli_kabul_sayisi'] = (int)$result_sartli_kabul->fetch_assoc()['sartli_kabul_sayisi'];

    return $counts;
}

// Ayları veritabanından çeken fonksiyon
function getDistinctMonths($connection) {
    $sql = "SELECT DISTINCT ay FROM atikler";
    $result = $connection->query($sql);

    $aylar = array();
    while ($row = $result->fetch_assoc()) {
        $aylar[] = $row['ay'];
    }
    return $aylar;
}

// Atık türlerine göre miktarları çeken fonksiyon
function getAtikMiktarlari($connection, $aylar) {
    $sql = "SELECT tur, GROUP_CONCAT(miktar ORDER BY FIELD(ay, '" . implode("', '", $aylar) . "')) AS miktarlar
            FROM atikler
            GROUP BY tur";

    $result = $connection->query($sql);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function updateAtikMiktari($connection, $atik_turu, $ay, $yeni_miktar) {
    $stmt = $connection->prepare("UPDATE atikler2 SET miktar = ? WHERE tur = ? AND ay = ?");
    $stmt->bind_param("sss", $yeni_miktar, $atik_turu, $ay);

    if ($stmt->execute()) {
        return "Atık miktarı güncellendi";
    } else {
        return "Hata oluştu: " . $connection->error;
    }

    $stmt->close();
}

// Seçilen aylar için performans verilerini çeken fonksiyon
function getPerformanceData($connection, $aylar) {
    $aySutunlari = array();
    foreach ($aylar as $ay) {
        $ayhedef = $ay . "hedef";
        $aygerceklesen = $ay . "gerceklesen";
        $aySutunlari[] = "$ayhedef, $aygerceklesen";
    }

    $sql = "SELECT departman, performanskriteri, hedefaciklama, " . implode(", ", $aySutunlari) . " FROM hedeftakip ORDER BY id ASC LIMIT 500";
    $statement = $connection->prepare($sql);
    $statement->execute();
    return $statement->get_result();
}

// Belirli bir ürün için markaları çeken fonksiyon
function getMarkalar($connection, $selectedUrun) {
    $stmt = $connection->prepare("SELECT DISTINCT marka FROM urunekle WHERE urun = ?");
    $stmt->bind_param("s", $selectedUrun);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $markaOptions = '';
    while ($row = $result->fetch_assoc()) {
        $markaOptions .= '<option value="' . $row['marka'] . '">' . $row['marka'] . '</option>';
    }
    
    $stmt->close();
    return $markaOptions;
}

// Belirli bir ürün için tedarikçileri çeken fonksiyon
function getTedarikciler($connection, $selectedUrun) {
    $stmt = $connection->prepare("SELECT DISTINCT firma FROM urunekle WHERE urun = ?");
    $stmt->bind_param("s", $selectedUrun);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $tedarikciOptions = '';
    while ($row = $result->fetch_assoc()) {
        $tedarikciOptions .= '<option value="' . $row['firma'] . '">' . $row['firma'] . '</option>';
    }
    
    $stmt->close();
    return $tedarikciOptions;
}

// SMTP ayarlarını veritabanından çeken fonksiyon
function getSMTPSettings($pdo) {
    $settings = [];

    $settings['server'] = $pdo->query("SELECT server FROM smtpayar")->fetchColumn();
    $settings['username'] = $pdo->query("SELECT username FROM smtpayar")->fetchColumn();
    $settings['password'] = $pdo->query("SELECT password FROM smtpayar")->fetchColumn();
    $settings['guvenlik'] = $pdo->query("SELECT guvenlik FROM smtpayar")->fetchColumn();
    $settings['port'] = $pdo->query("SELECT port FROM smtpayar")->fetchColumn();

    return $settings;
}

// Belirli bir ay için konaklama verilerini çeken fonksiyon
function fetchKonaklamaData($pdo, $month) {
    $sql = "SELECT * FROM konaklama WHERE month = :month ORDER BY day";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':month', $month, PDO::PARAM_STR);
    $stmt->execute();

    $data = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[$row['day']] = $row;
    }

    return $data;
}

// Konaklama verisini güncelleyen fonksiyon
function updateKonaklamaData($pdo, $day, $month, $field, $value) {
    $sql = "INSERT INTO konaklama (day, month, $field) VALUES (:day, :month, :value)
            ON DUPLICATE KEY UPDATE $field = :value";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':day', $day, PDO::PARAM_INT);
    $stmt->bindParam(':month', $month, PDO::PARAM_STR);
    $stmt->bindParam(':value', $value, PDO::PARAM_STR);

    if ($stmt->execute()) {
        return "Record updated successfully";
    } else {
        return "Error updating record: " . implode(", ", $stmt->errorInfo());
    }
}

// Kullanıcı listesini çeken fonksiyon
function getUserList($pdo) {
    $sql = "SELECT * FROM user";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Yeni kullanıcı ekleme fonksiyonu
function addUser($pdo, $data) {
    // Şifreyi Argon2 ile hashleyin
    $passwords = password_hash($data['password'], PASSWORD_ARGON2ID);

    $photo = "avatars/4128176.png";
    $sql = "
        INSERT INTO user (name, surname, username, password, telefon, departman, gorev, role, profile_image) 
        VALUES (:name, :surname, :username, :password, :telefon, :departman, :gorev, :role, :profile_image)
    ";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([
        ':name' => $data["name"],
        ':surname' => $data["surname"],
        ':username' => $data["username"],
        ':password' => $passwords, // Argon2 ile hashlenmiş şifre
        ':telefon' => $data["telefon"],
        ':departman' => $data["departman"],
        ':gorev' => $data["gorev"],
        ':role' => $data["role"],
        ':profile_image' => $photo
    ]);
}


// Belirli bir kullanıcıyı getiren fonksiyon
function getUserById($pdo, $id) {
    $sql = "SELECT * FROM user WHERE id = :id LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Bildirimler

function getNotificationCount($connection, $username) {
    $stmt = $connection->prepare("SELECT COUNT(*) as total FROM notifications WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}

function getNotifications($connection, $username) {
    $stmt = $connection->prepare("SELECT * FROM notifications WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



// Kullanıcı güncelleme fonksiyonu
function updateUser($pdo, $data) {
    if (!empty($data['password'])) {
        $passwords = md5($data['password']);
        $sql = "
            UPDATE user 
            SET name = :name, surname = :surname, username = :username, password = :password, 
                telefon = :telefon, departman = :departman, gorev = :gorev, role = :role  
            WHERE id = :id
        ";
        $params = [
            ':name' => $data["name"],
            ':surname' => $data["surname"],
            ':username' => $data["username"],
            ':password' => $passwords,
            ':telefon' => $data["telefon"],
            ':departman' => $data["departman"],
            ':gorev' => $data["gorev"],
            ':role' => $data["role"],
            ':id' => $data["employee_id"]
        ];
    } else {
        $sql = "
            UPDATE user 
            SET name = :name, surname = :surname, username = :username, telefon = :telefon, 
                departman = :departman, gorev = :gorev, role = :role  
            WHERE id = :id
        ";
        $params = [
            ':name' => $data["name"],
            ':surname' => $data["surname"],
            ':username' => $data["username"],
            ':telefon' => $data["telefon"],
            ':departman' => $data["departman"],
            ':gorev' => $data["gorev"],
            ':role' => $data["role"],
            ':id' => $data["employee_id"]
        ];
    }
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

// Kullanıcı silme fonksiyonu
    function deleteUser($pdo, $id) {
    $sql = "DELETE FROM user WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

// Kullanıcı loglarını kaydetme fonksiyonu
function logUserAction($pdo, $user_name, $log_date, $log_time, $action) {
    try {
        $stmt = $pdo->prepare("INSERT INTO user_logs (user_name, log_date, log_time, action) VALUES (:user_name, :log_date, :log_time, :action)");
        $stmt->execute([
            ':user_name' => $user_name,
            ':log_date' => $log_date,
            ':log_time' => $log_time,
            ':action' => $action
        ]);
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}

// Kullanıcı durumunu güncelleme fonksiyonu
function updateUserStatus($pdo, $id, $status) {
    try {
        $stmt = $pdo->prepare("UPDATE user SET status = :status WHERE id = :id");
        $stmt->execute([
            ':status' => $status,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
    }
}



// Ürün listesini getir
function getUrunList($pdo) {
    $stmt = $pdo->prepare("SELECT DISTINCT urun FROM urunekle");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// memorandum verilerini almak için fonksiyon
function getMemorandumList($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM memorandum ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertMemorandum($pdo, $tarih, $tesis, $kimden, $kime, $konu, $bilgi, $gecerliliktarihi, $onaydurumu) {
    $query = "INSERT INTO memorandum (tarih, tesis, kimden, kime, konu, bilgi, gecerliliktarihi, onaydurumu)
              VALUES (:tarih, :tesis, :kimden, :kime, :konu, :bilgi, :gecerliliktarihi, :onaydurumu)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':tarih', $tarih);
    $stmt->bindParam(':tesis', $tesis);
    $stmt->bindParam(':kimden', $kimden);
    $stmt->bindParam(':kime', $kime);
    $stmt->bindParam(':konu', $konu);
    $stmt->bindParam(':bilgi', $bilgi);
    $stmt->bindParam(':gecerliliktarihi', $gecerliliktarihi);
    $stmt->bindParam(':onaydurumu', $onaydurumu);
    return $stmt->execute();
}

function updateMemorandum($pdo, $id, $tarih, $tesis, $kimden, $kime, $konu, $bilgi, $gecerliliktarihi, $onaydurumu) {
    $query = "UPDATE memorandum SET tarih = :tarih, tesis = :tesis, kimden = :kimden, kime = :kime, konu = :konu, bilgi = :bilgi, gecerliliktarihi = :gecerliliktarihi, onaydurumu = :onaydurumu WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':tarih', $tarih);
    $stmt->bindParam(':tesis', $tesis);
    $stmt->bindParam(':kimden', $kimden);
    $stmt->bindParam(':kime', $kime);
    $stmt->bindParam(':konu', $konu);
    $stmt->bindParam(':bilgi', $bilgi);
    $stmt->bindParam(':gecerliliktarihi', $gecerliliktarihi);
    $stmt->bindParam(':onaydurumu', $onaydurumu);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function deleteMemorandum($pdo, $id) {
    $query = "DELETE FROM memorandum WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function selectMemorandumById($pdo, $id) {
    $query = "SELECT * FROM memorandum WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function updateMemorandumStatus($pdo, $id, $status) {
    $query = "UPDATE memorandum SET onaydurumu = :status WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':status', $status);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

function getMemorandumListOnay($pdo, $status = 'ONAY BEKLENİYOR') {
    $query = "SELECT * FROM memorandum WHERE onaydurumu = :status ORDER BY id DESC";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':status', $status);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function approveMemorandum($pdo, $id) {
    $query = "UPDATE memorandum SET onaydurumu = 'ONAYLANDI' WHERE id = :id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id', $id);
    return $statement->execute();
}

function getMemorandumListOnayli($pdo, $status = 'ONAYLANDI') {
    $query = "SELECT * FROM memorandum WHERE onaydurumu = :status ORDER BY id DESC";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':status', $status);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// Tüm verileri yüklemek için fonksiyon
function loadDataIlaclama() {
    $connection = dbConnect();
    $statement = $connection->prepare("SELECT * FROM yillikilaclama ORDER BY id DESC LIMIT 500");
    $statement->execute();
    return $statement->fetchAll();
}



?>
