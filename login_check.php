<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once("inc/config.php");

$firmalaraOzelIsim = "test1";
session_name($firmalaraOzelIsim);
session_start();
$db = new Db();

if (!$db->connect()) {
    die("Hata: Veritabanına bağlanırken bir hata oluştu." . $db->error());
}

// Kullanıcıdan gelen matematik cevabını alıyoruz
$user_answer = isset($_POST['math_answer']) ? $_POST['math_answer'] : null;

// Session'da saklanan doğru cevabı kontrol ediyoruz
if ($user_answer != $_SESSION['math_answer']) {
    header("location: login.php?type=math_error");
    exit;
}

$user = $_SESSION["login_user"];
if ($user) {
    header("location: /portal/test1");
    exit;
}

$username = isset($_POST["username"]) ? trim($_POST["username"]) : null;
$password = isset($_POST["password"]) ? trim($_POST["password"]) : null;

if (!$username || !$password) {
    header("location: login.php?type=error");
    exit;
}

// Kullanıcı adını güvenli hale getiriyoruz
$username = $db->quote($username);

// Sorguyu hazırlayalım
$query = "SELECT * FROM user WHERE username=$username";
$result = $db->select($query);

if ($result && count($result) == 1) {
    $storedPassword = $result[0]["password"];

    // Kullanıcı MD5 ile hashlenmiş bir şifre kullanıyor olabilir, kontrol edelim
    if (strlen($storedPassword) == 32) { // MD5 hash uzunluğu 32 karakterdir
        // Kullanıcının girdiği şifreyi MD5 ile hashleyip kontrol edelim
        if (md5($password) === $storedPassword) {
            // MD5 doğru, şimdi Argon2 ile yeniden hashleyip veritabanını güncelleyelim
            $newHashedPassword = password_hash($password, PASSWORD_ARGON2ID);
            $updateQuery = "UPDATE user SET password = '$newHashedPassword' WHERE username = $username";
            $db->query($updateQuery);
        } else {
            header("location: login.php?type=error");
            exit;
        }
    } elseif (password_verify($password, $storedPassword)) {
        // Şifre Argon2 ile hashlenmiş, kontrol ediyoruz
    } else {
        header("location: login.php?type=error");
        exit;
    }

    // Giriş başarılı, oturumu başlatıyoruz
    $_SESSION["login_user"] = array(
        "id" => $result[0]["id"],
        "name" => $result[0]["name"],
        "surname" => $result[0]["surname"],
        "username" => $result[0]["username"],
        "birthday" => $result[0]["birthday"],
        "telefon" => $result[0]["telefon"],
        "departman" => $result[0]["departman"],
        "gorev" => $result[0]["gorev"],
        "status" => $result[0]["status"],
        "role" => $result[0]["role"],
        "profile_image" => $result[0]["profile_image"]
    );

    // Giriş işlemini kaydedelim
    $id = $result[0]['id'];
    $user_name = $result[0]['name'];
    $log_date = date('Y-m-d');
    $log_time = date('H:i:s');
    $action = "Giriş Yaptı";

    try {
        $baglanti = new PDO("mysql:host=localhost;dbname=homeandf_test1;charset=utf8", "homeandf_onur", "354472Onur");
        $baglanti->query("SET NAMES UTF8");
        $sonuc = $baglanti->exec("INSERT INTO user_logs (user_name, log_date, log_time, action) VALUES ('$user_name', '$log_date', '$log_time', '$action')");
    } catch (PDOException $h) {
        echo "<b>HATA VAR :</b> " . $h->getMessage();
        exit;
    }

    header("location: /portal/test1");
    exit;
} else {
    header("location: login.php?type=error");
    exit;
}
