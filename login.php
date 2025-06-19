<?php
$firmalaraOzelIsim = "test1";
session_name($firmalaraOzelIsim);
// Oturumu başlatmadan önce eski oturumu sonlandırın
session_start();
session_unset(); // Tüm oturum verilerini temizler
session_destroy(); // Oturumu tamamen sonlandırır

// Yeni bir oturum başlatın
session_start();

include_once("inc/config.php");

$db = new Db();
if (!$db->connect()) {
    die("Hata: Veritabanına bağlanırken bir hata oluştu." . $db->error());
}

// Rastgele matematik sorusu oluştur
$sayi1 = rand(1, 10);
$sayi2 = rand(1, 10);
$_SESSION['math_answer'] = $sayi1 + $sayi2;

$user = $_SESSION["login_user"];
if ($user) {
    header("location: /portal/test1");
    exit;
}


?>

<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <meta charset="utf-8" />
    <title>VektraWeb - Yönetim Portalı</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="VektraWeb Bulut Tabanlı Yönetim Portalı" name="description" />
    <meta content="VektraWeb" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

</head>
<body>
    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/portal/demo/login_check.php" class="d-inline-block auth-logo">
                                    <img src="assets/images/vektralogo.png" alt="" height="70">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Yönetim Portalı Giriş Ekranı</p>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Hoşgeldiniz !</h5>
                                    <p class="text-muted">Kullanıcı Bilgileriniz İle Giriş Yapabilirsiniz</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="POST" action="login_check.php" class="box">
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Kullanıcı Mail</label>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Mail Adresinizi Giriniz">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Şifre</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Şifrenizi Giriniz" name="password" id="pwd">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <!-- Matematik sorusu -->
                                        <div class="mb-3">
                                            <label class="form-label" for="math_answer">Güvenlik Sorusu: <?php echo $sayi1 . " + " . $sayi2 . " = ?"; ?></label>
                                            <input type="text" class="form-control" name="math_answer" id="math_answer" placeholder="Cevabınızı Giriniz">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="customControlInline">
                                            <label class="form-check-label" for="auth-remember-check">Beni Hatırla</label>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Giriş Yap</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>document.write(new Date().getFullYear())</script> VektraWeb tarafından oluşturulmuştur. Tüm Hakları Saklıdır.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/libs/particles.js/particles.js"></script>
    <script src="assets/js/pages/particles.app.js"></script>
    <script src="assets/js/pages/password-addon.init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
           // Checkbox'ı seçildiğinde bir çerez oluştur
var checkbox = document.getElementById("customControlInline");
checkbox.addEventListener("change", function(){
    var username = document.getElementById("username").value;
    var password = document.getElementById("pwd").value;

    if (this.checked) {
        document.cookie = "login_username=" + encodeURIComponent(username) + "; expires=Fri, 31 Dec 9999 23:59:59 GMT";
        document.cookie = "login_password=" + encodeURIComponent(password) + "; expires=Fri, 31 Dec 9999 23:59:59 GMT";
    } else {
        document.cookie = "login_username=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
        document.cookie = "login_password=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
});

// Sayfa yüklendiğinde çerezleri kontrol et ve checkbox'ı işaretle
window.onload = function(){
    var cookies = document.cookie.split("; ");
    var savedUsername = "";
    var savedPassword = "";
    var rememberMeChecked = false;

    for (var i = 0; i < cookies.length; i++) {
        var parts = cookies[i].split("=");
        var name = parts[0];
        var value = decodeURIComponent(parts[1]);
        
        if (name === "login_username") {
            savedUsername = value;
        } else if (name === "login_password") {
            savedPassword = value;
        } else if (name === "customControlInline") {
            rememberMeChecked = value === "true";
        }
    }

    if (savedUsername) {
        document.getElementById("username").value = savedUsername;
    }

    if (savedPassword) {
        document.getElementById("pwd").value = savedPassword;
    }

    if (rememberMeChecked) {
        document.getElementById("customControlInline").checked = true;
    }
};
</script>

 <script>
        // URL'deki parametreleri kontrol et
        const urlParams = new URLSearchParams(window.location.search);
        const errorType = urlParams.get('type');

        // Eğer 'type' parametresi 'math_error' ise SweetAlert ile uyarı göster
        if (errorType === 'math_error') {
            Swal.fire({
                icon: 'error',
                title: 'Yanlış Cevap',
                text: 'Güvenlik sorusuna verdiğiniz cevap yanlış. Lütfen tekrar deneyin.',
                confirmButtonText: 'Tamam'
            });
        }

        // Eğer 'type' parametresi 'error' ise SweetAlert ile uyarı göster
        if (errorType === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'Giriş Başarısız',
                text: 'Kullanıcı adı veya şifre yanlış. Lütfen tekrar deneyin.',
                confirmButtonText: 'Tamam'
            });
        }
    </script>

</body>



</html>