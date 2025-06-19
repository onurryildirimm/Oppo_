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
                                <h4 class="mb-sm-0">Atık Çizelgesi / Bitkisel Atık Yağ Verileri</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Atık Çizelgesi</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php

// Bağlantıyı kontrol edin
if ($connection->connect_error) {
    die("Veritabanı bağlantısında hata: " . $connection->connect_error);
}

// Ayları veritabanından çek
$sql = "SELECT DISTINCT ay FROM atikler2";
$result = $connection->query($sql);

// Ayları saklamak için boş bir dizi oluştur
$aylar = array();

// Ayları diziye ekle
while ($row = $result->fetch_assoc()) {
    $aylar[] = $row['ay'];
}
?>

<table class="table table-striped table-bordered" id="atikler2_tablosu" style="background-color: white;">

            <thead>
                <tr>
                    <th>Atık Türü</th>
                    <?php
                    // Ayların başlık satırını oluştur
                    foreach ($aylar as $ay) {
                        echo "<th data-ay='$ay'>$ay</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                // Atık miktarlarını veritabanından çek ve gruplayarak al
                $sql = "SELECT tur, GROUP_CONCAT(miktar ORDER BY FIELD(ay, '" . implode("', '", $aylar) . "')) AS miktarlar
        FROM atikler2
        GROUP BY tur";

                $result = $connection->query($sql);

                // Verileri tabloya ekle
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='atik_turu'>" . $row['tur'] . "</td>";
                    // Aylara göre miktarları ekle
                    $miktarlar = explode(',', $row['miktarlar']);
                    foreach ($miktarlar as $miktar) {
                        echo "<td class='atik_miktari'>$miktar</td>";
                    }
                    echo "</tr>";
                }
                ?>
                
            </tbody>
        </table>
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
     <script src="assets/js/jquery.js"></script>
     
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
  $(function () {
    $("#atikler2_tablosu").DataTable({
      "responsive": true, "lengthChange": true, "autoWidth": false, "ordering": false,
      "buttons": [ "excel"]
    }).buttons().container().appendTo('#atikler2_tablosu_wrapper .col-md-6:eq(0)');
  });
</script>   

<script>
      $(document).ready(function() {
    // Tablodaki hücrelere tıklama olayını ekle
    $('#atikler2_tablosu').on('click', '.atik_miktari', function() {
        var index = $(this).index(); // Tıkladığınız hücrenin indeksini alın
        var ay;
        if (index === 19) { // Eğer tıklanan hücre tablonun ilk sütunundaysa, işlem yapmayın
            return;
        } else { // Değilse, ayı doğru hücreden alın
            ay = $('#atikler2_tablosu thead th').eq(index).data('ay');
        }

        var eski_miktar = $(this).text();
        var yeni_miktar = prompt("Yeni miktarı giriniz:", eski_miktar);
        
        // Yeni miktarı veritabanına güncelle
        if (yeni_miktar !== null && yeni_miktar !== "" && yeni_miktar !== eski_miktar) {
            var atik_turu = $(this).closest('tr').find('.atik_turu').text();

            console.log("Atık Türü: " + atik_turu);
            console.log("Ay: " + ay);
            console.log("Yeni Miktar: " + yeni_miktar);

            // AJAX isteği
            $.ajax({
                type: "POST",
                url: "guncelleatik2.php",
                data: { atik_turu: atik_turu, ay: ay, yeni_miktar: yeni_miktar },
                success: function(data) {
                    console.log("Güncelleme başarılı: " + data);
                    // Sayfayı yenile
                  location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("Hata: " + error);
                }
            });
        }
    });
});


    </script>








    </body>

</html>