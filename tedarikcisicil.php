<?php include "header.php" ?>

<!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Tedarikçi Sicilleri</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Tedarikçi Sicilleri</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <style>
    :root {
        --gradient: linear-gradient(to left top, #DD2476 10%, #FF512F 90%) !important;
    }

    .card {
        background: #fff;
        border: 1px solid #28121c;
        margin-bottom: 2rem;
        height: 400px; /* Tüm kartların yüksekliği 400 piksel olsun */
    }

    .button-container {
        display: flex;
        justify-content: center;
    }
</style>

<!-- end page title -->
<div class="container mx-auto mt-4">
    <input type="text" id="arama_terimi" placeholder="Tedarikçi Arama">
    
</div>
<div class="container mx-auto mt-4">
    <div id="sonuclar" class="row">
        <div class="container mx-auto mt-4">
            <div class="row">
                <?php
             
                // Sayfa numarasını belirleme
                $sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
                $tedarikciSayfaLimit = 6; // Her sayfada gösterilecek tedarikçi sayısı

                try {
                    // Veritabanına bağlan
                
                    $pdoconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Toplam tedarikçi sayısını al
                    $query = "SELECT COUNT(*) AS toplam FROM tedarikcilistesi WHERE statu = 'ONAYLI SATICI'";
                    $stmt = $pdoconnection->query($query);
                    $toplamTedarikciler = $stmt->fetch(PDO::FETCH_ASSOC)['toplam'];

                    // Toplam sayfa sayısını hesapla
                    $toplamSayfa = ceil($toplamTedarikciler / $tedarikciSayfaLimit);

                    // Başlangıç indeksi
                    $baslangic = ($sayfa - 1) * $tedarikciSayfaLimit;

                    // Sayfalama sorgusu
                    $query = "SELECT * FROM tedarikcilistesi WHERE statu = 'ONAYLI SATICI' ORDER BY id DESC LIMIT $baslangic, $tedarikciSayfaLimit";
                    $statement = $pdoconnection->query($query);

                    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="col-md-4">';
                        echo '<div class="card">';
                        echo '<center><img src="uploads/logotrans.png" width="200px"></center>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($row['tedarikciadi']) . '</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row['il']) . '</h6>';
                        echo '<p class="card-text">' . htmlspecialchars($row['adresi']) . '</p>';
                        echo '</div>';
                        echo '<div class="button-container">';
                        echo '<a href="detaylidegerlendirme?id='.$row["id"].'" class="btn btn-info"><i class="fas fa-link"></i> İncele</a>';
                        echo '</div></br>';
                        echo '</div>';
                        echo '</div>';
                    }
                    
                    // Sayfalama bağlantıları (Bootstrap Pagination)
                    echo '<nav aria-label="Sayfalandırma">';
                    echo '<ul class="pagination">';
                    for ($i = 1; $i <= $toplamSayfa; $i++) {
                        echo '<li class="page-item ' . ($i == $sayfa ? 'active' : '') . '"><a class="page-link" href="?sayfa=' . $i . '">' . $i . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</nav>';
                } catch (PDOException $e) {
                    echo 'Hata: ' . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </div>
</div>



    <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © VektraWeb tarafından oluşturulmuştur.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                              Tüm Hakları Saklıdır.
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->
</div>
</div>
    <!-- END layout-wrapper -->
    
    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    
    
    <!-- JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
  integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8="
  crossorigin="anonymous"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>

    <!-- apexcharts -->
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
  
    <!-- Vector map-->
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>

    <!-- Dashboard init -->
    <script src="assets/js/pages/dashboard-analytics.init.js"></script>
  
    <!-- App js -->
    <script src="assets/js/app.js"></script>
  
    <!--datatable js-->
    <script type="text/javascript" src="assets/datatables/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="assets/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="assets/datatables/dataTables.responsive.min.js"></script>
<script src="assets/datatables/responsive.bootstrap4.min.js"></script>
<script src="assets/datatables/dataTables.buttons.min.js"></script>
<script src="assets/datatables/buttons.bootstrap4.min.js"></script>
<script src="assets/datatables/jszip.min.js"></script>
<script src="assets/datatables/pdfmake.min.js"></script>
<script src="assets/datatables/vfs_fonts.js"></script>
<script src="assets/datatables/buttons.html5.min.js"></script>
<script src="assets/datatables/buttons.print.min.js"></script>
<script src="assets/datatables/buttons.colVis.min.js"></script>

    <script src="assets/js/pages/datatables.init.js"></script>
    

<script>
$(document).ready(function() {
    $('#arama_terimi').on('input', function() {
        var aramaTerimi = $(this).val();

        $.ajax({
            url: 'arama.php',
            method: 'POST',
            data: { arama_terimi: aramaTerimi },
            success: function(response) {
                // Arama sonuçları geldiğinde sadece sonuçları göster
                $('#sonuclar').html(response);
            }
        });
    });
});
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Tüm "Bildirimi Sil" butonlarına tıklanma olayı dinleyici ekleme
        var deleteButtons = document.querySelectorAll(".deletenotify");
        deleteButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                var notificationId = button.getAttribute("data-notificationid");

                // POST isteği gönderme işlemi
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "notifytemizle.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // İstek başarıyla tamamlandı, sayfayı yenileme gibi bir işlem yapabilirsiniz
                        location.reload();
                    }
                };

                // POST verilerini ayarlama
                var data = "notificationIds=" + encodeURIComponent(notificationId);
                xhr.send(data);
            });
        });
    });
</script>
    </body>

</html>