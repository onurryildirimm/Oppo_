<?php
include_once ("inc/config.php");
$db = new Db();
if (!$db->connect()) {
    die("Hata: Veritabanına bağlanırken bir hata oluştu." . $db->error());
}
$user = $_SESSION["login_user"];
$username = $_POST["username"];
if ($user) {
    header("location: /portal/sadullahoglu");
    exit;
}

?>



<!doctype html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

     <meta charset="utf-8" />
    <title>VektraWeb - Yönetim Portalı</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="VektraWeb Bulut Tabanlı Yönetim Portalı" name="description" />
    <meta content="VektraWeb" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <!-- plugin css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="/portal/sadullahoglu/login_check.php" class="d-inline-block auth-logo">
                                    <img src="assets/images/vektralogo.png" alt="" height="50">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Yönetim Portalı Giriş Ekranı</p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Hata !</h5>
                                    <p class="text-muted">Giriş yapmaya çalıştığınız sırada hata meydana geldi</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="POST" action="login" class="box" onsubmit="return checkStuff()">

                                        <p>Kullanıcı Adı-Şifre ya da Robot kontrol doğrulaması başarısız oldu.</p> <p>Lütfen Tekrar Deneyin.</p>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Tekrar Dene</button>
                                        </div>
  
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
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
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- particles js -->
    <script src="assets/libs/particles.js/particles.js"></script>
    <!-- particles app js -->
    <script src="assets/js/pages/particles.app.js"></script>
    <!-- password-addon init -->
    <script src="assets/js/pages/password-addon.init.js"></script>
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

</body>



</html>