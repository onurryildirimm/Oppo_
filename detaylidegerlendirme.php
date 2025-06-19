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
                                <h4 class="mb-sm-0">Tedarikçi Detayları</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Tedarikçi Detayları</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php 
               
// İlk önce id parametresini kontrol et
$id = isset($_GET['id']) ? $_GET['id'] : null;
$tedarikciadi = isset($_GET['tedarikciadi']) ? $_GET['tedarikciadi'] : null;

if ($id) {
    $query = "SELECT * FROM tedarikcilistesi WHERE id = :id";
    $statement = $pdoconnection->prepare($query);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
} elseif ($tedarikciadi) {
    $query = "SELECT * FROM tedarikcilistesi WHERE tedarikciadi = :tedarikciadi";
    $statement = $pdoconnection->prepare($query);
    $statement->bindParam(':tedarikciadi', $tedarikciadi, PDO::PARAM_STR);
} 

// Sorguyu çalıştır
if ($statement->execute()) {
    $row = $statement->fetch(PDO::FETCH_ASSOC);

        // Şimdi $row üzerinden verilere erişebilirsiniz
        $il = htmlspecialchars($row['il']);
        // Diğer verilere de benzer şekilde erişebilirsiniz
                     } 
                     
                    ?>

                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div>
                                        <div class="flex-shrink-0 avatar-md mx-auto">
                                            <div class="avatar-title bg-light rounded">
                                                <img src="uploads/logotrans.png" alt="" height="50" />
                                            </div>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <h5 class="mb-1">Tedarikçi Bilgileri</h5>
                                            <p class="text-muted">Detaylar</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th><span class="fw-medium">Tedarikçi:</span></th>
                                                        <td><?php echo htmlspecialchars($row['tedarikciadi']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Adres:</span></th>
                                                        <td><?php echo htmlspecialchars($row['adresi']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Email</span></th>
                                                        <td><?php echo htmlspecialchars($row['mail']); ?></td>
                                                    </tr>
                                                    <tr>
                                         
                                                        <th><span class="fw-medium">Telefon:</span></th>
                                                        <td><?php echo htmlspecialchars($row['telefon']); ?>1</td>
                                                    </tr>
                                                    
                                                        <th><span class="fw-medium">İl/İlçe</span></th>
                                                        <td><?php echo htmlspecialchars($row['il'].' '.$row['ilce']); ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                
                                    
                                
                                <!--end card-body-->
                                <div class="card-body border-top border-top-dashed p-4">
                                    <div>
                                        
                                        <div>
                                            <div>
                                                <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                    
                                                    <center><h6>Tedarikçi Belge Yükle</h6></center>
<form action="upload_tedarikci.php" method="post" enctype="multipart/form-data">
    <label for="dosya">Dosya Seç:</label>
    <input type="file" name="dosya_yolu" id="dosya" required>
    <button type="submit">Yükle</button>
    <input type="hidden" name="id" value="<?php echo $idt; ?>">
</form></div>
<div class="mt-3">
                                                <div class="row align-items-center">
                                               
                                                    <center><h4>
                                                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">Tedarikçi Belgeleri:<br><br>
                                                         <?php
// Veritabanından cihaz adına ait formları çek
$idt = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';

$statement = $pdoconnection->prepare("SELECT dosya_yolu FROM tedarikcilistesi WHERE id = :id");
$statement->bindParam(':id', $idt, PDO::PARAM_STR);
$statement->execute();
$dosyaYollariString = $statement->fetchColumn();

// Virgülle ayrılmış dosya yollarını diziye çevir
$dosyaYollari = explode(',', $dosyaYollariString);

// Dosya yollarını döngü ile kontrol et
if (!empty($dosyaYollari) && $dosyaYollari[0] !== null) {
    foreach ($dosyaYollari as $dosyaYolu) {
        $dosyaUzantisi = strtolower(pathinfo($dosyaYolu, PATHINFO_EXTENSION));
      
        echo '<a href="' . $dosyaYolu . '" target="_blank">';

        // Dosya türüne göre ikon ekle
        if ($dosyaUzantisi == 'pdf') {
            echo '<i class="fa fa-file-pdf-o" style="font-size:24px;color:red"></i>';
        } elseif (in_array($dosyaUzantisi, array('doc', 'docx'))) {
            echo '<i class="fa fa-file-word-o" style="font-size:24px;color:blue"></i>';
        } elseif (in_array($dosyaUzantisi, array('xls', 'xlsx'))) {
            echo '<i class="fa fa-file-excel-o" style="font-size:24px;color:green"></i>';
        } 

        echo '</a>';
    }
} 
?></h4></center><hr>
                                                    
                                              
                                                    <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                        <center><h6>Tedarikçi Mal Kabul Performansı</h6></center>
                                                        
                                                
                                                
                                                
                                            </div>

                                            <div class="mt-3">
                                                <div class="row align-items-center">
                                                    <?php
// Veritabanı bağlantısı
$hostname = 'localhost';
$username = 'homeandf_onur';
$password = '354472Onur';
$database = 'homeandf_lagunabeachalya';

try {
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tedarikciAdi = $row['tedarikciadi'];

    // Toplam işlem sayısını çek
    $queryislem = "SELECT COUNT(*) as islem_sayisi FROM malkabul WHERE tedarikci = :tedarikciAdi";
    $statement = $db->prepare($queryislem);
    $statement->bindParam(':tedarikciAdi', $tedarikciAdi, PDO::PARAM_STR);
    $statement->execute();
    $toplamIslemSayisi = $statement->fetch(PDO::FETCH_ASSOC)['islem_sayisi'];

    // Puanlar
    $ağırlıkŞartlıKabulPuan = 5;
    $ağırlıkRedPuan = 10;

    // Puanları çek
    $queryPuanlar = "SELECT kabulsayisi, sartlikabulsayisi, redsayisi, toplampuan FROM tedarikcilistesi WHERE id = :id";
    $statementPuanlar = $db->prepare($queryPuanlar);
    $statementPuanlar->bindParam(':id', $id, PDO::PARAM_INT);
    $statementPuanlar->execute();
    $puanlar = $statementPuanlar->fetch(PDO::FETCH_ASSOC);

    // Şartlı kabul puanını düş
    $sartliPuanDususu = $puanlar['sartlikabulsayisi'] * $ağırlıkŞartlıKabulPuan;
    $toplamPuan = '100' - $sartliPuanDususu;

    // Red puanını düş
    $redPuanDususu = $puanlar['redsayisi'] * $ağırlıkRedPuan;
    $toplamPuan = '100' - $redPuanDususu;

    // Toplam puanı hesapla ve güncelle
    $formatlıPuan = number_format(max(0, min(100, $toplamPuan)), 1);

// Eğer ondalık kısım sıfırsa, ondalık kısmı gösterme
$formatlıPuan = rtrim(rtrim($formatlıPuan, '0'), '.');

$queryUpdatePuan = "UPDATE tedarikcilistesi SET toplampuan = :toplampuan WHERE id = :id";
        $statementUpdatePuan = $db->prepare($queryUpdatePuan);
        $statementUpdatePuan->bindParam(':toplampuan', $formatlıPuan, PDO::PARAM_STR);
        $statementUpdatePuan->bindParam(':id', $id, PDO::PARAM_INT);
        $statementUpdatePuan->execute();

    // Toplam puanı görüntüle
    echo "<center><h3>$formatlıPuan/100</h3></center>";

} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>



                                                    
                                                    
                                                </div><!-- end row -->
                                                
                                                
                                            </div>   </div>   </div></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                                    <div class="card-body border-top border-top-dashed p-4">
                                    <div>
                                        
                                        <div>
                                            <div>
                                                <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                                    
                                        <center><h6>Tedarikçi Genel Değerlendirme</h6></center>
                                                        
                                                
                                                </div>
                                                
                                            </div>

                                            <div class="mt-3">
                                                <div class="row align-items-center">
                                                    
                                                    <center><h3><?php echo $row['toplampuan']; ?>/100</h3></center>
                                                    
                                                </div><!-- end row -->
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div>
                            <!--end card-->
                        </div>
                        <!--end col-->

                        <div class="col-xxl-9">
                            <div class="card">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Tedarikçi Ürün Kabul Tarihçesi</h4>
                                    
                                </div><!-- end card header -->

                                <div class="card-header p-0 border-0 bg-light-subtle">
                                    <div class="row g-0 text-center">
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
            
                                        $urungiris = $baglanti->query("SELECT count(*) FROM malkabul WHERE tedarikci = '" . $row['tedarikciadi'] . "'")->fetchColumn();

            
                                        echo $urungiris;
            
            ?>">0</span> Adet</h5>
                                                <p class="text-muted mb-0">Ürün Girişi</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
            
                                        $kabul = $baglanti->query("SELECT count(*) FROM malkabul WHERE kabuldurumu = 'KABUL' AND tedarikci = '" . $row['tedarikciadi'] . "'")->fetchColumn();

            
                                        echo $kabul;
            
            ?>">0</span> Adet</h5>
                                                <p class="text-muted mb-0">Sorunsuz Kabul</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0">
                                                <h5 class="mb-1"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
            
                                        $sartlikabul = $baglanti->query("SELECT count(*) FROM malkabul WHERE kabuldurumu = 'ŞARTLI KABUL' AND tedarikci = '" . $row['tedarikciadi'] . "'")->fetchColumn();
                                        echo $sartlikabul;?>">0</span> Adet</h5>
                                                <p class="text-muted mb-0">Şartlı Kabul</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6 col-sm-3">
                                            <div class="p-3 border border-dashed border-start-0 border-end-0">
                                                <h5 class="mb-1 text-danger"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
            
                                        $red = $baglanti->query("SELECT count(*) FROM malkabul WHERE kabuldurumu = 'RED' AND tedarikci = '" . $row['tedarikciadi'] . "'")->fetchColumn();
                                        echo $red;?>">0</span> Adet</h5>
                                                <p class="text-muted mb-0">Red</p>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                </div><!-- end card header -->

                                <div class="card-body p-0 pb-2">
                                    <div id="grafikDiv">
                                <canvas id="myChart" width="400" height="150"></canvas>
                                    
                                </div>
                                </div><!-- end card body -->
                            </div><!-- end card -->
                            
                            <div class="row g-4 mb-3">
                                <div class="col-sm-auto">
                                    <div class="card">
         <div class="card-body">
                                    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    Tedarikçiye Ait Son 3 Kayıt:
                                        
<?php

$statement = $pdoconnection->prepare("SELECT * FROM malkabul WHERE tedarikci = '" . $row['tedarikciadi'] . "' ORDER BY id DESC LIMIT 3");
$statement->execute();
$result = $statement->fetchAll();
  $output = '';
  $output .= '
   
	<thead> 
    <tr>
     <th width="10%">Tarih</th>
     <th width="15%">Ürün</th>
     
     <th width="10%">Marka</th>
     <th width="10%">Parti No</th>
     <th width="10%">SKT</th>
     <th width="10%">Ürün Sıcaklık</th>
     <th width="10%">Araç Sıcaklık</th>
     <th width="10%">Araç Temizlik</th>
     <th width="10%">Ambalaj Temizlik</th>
     <th width="10%">Kabul Durumu</th>
     <th width="10%">Açıklama</th>
     <th width="10%">Kabul Yapan</th>
     
    </tr>
       </thead>
  ';
  
  if($statement->rowCount() > 0)
{
   foreach($result as $row)
   {
       $pdfLinks = explode(",", $row["pdf"]); 
       $pdfLinksHTML = "";
       foreach($pdfLinks as $pdfLink){
            if(!empty($pdfLink)){
                $pdfLinksHTML .= '<a href="'.$pdfLink.'"><i class="fa fa-file-pdf-o" style="font-size:24px;color:red"></i></a>';
            }
       }
       if(empty($pdfLinksHTML)) {
            $pdfLinksHTML = "Form Yüklenmemiş";
       }
       $output .= '
        <tr>
         <td>'.date('d.m.Y', strtotime($row["tarih"])).'</td>
         <td>'.$row["urun"].'</td>
         
         <td>'.$row["marka"].'</td>
         <td>'.$row["partino"].'</td>
         <td>'.date('d.m.Y', strtotime($row["skt"])).'</td>
         <td>'.$row["urunsicaklik"].'</td>
         <td>'.$row["aracsicaklik"].' </td>
         <td>'.$row["aractemizlik"].'</td>
         <td>'.$row["ambalajtemizlik"].'</td>
         <td>'.$row["kabuldurumu"].'</td>
         <td>'.$row["aciklama"].'</td>
         <td>'.$row["kabulyapan"].'</td>
              
            
        </tr>';
   }
}
  else
  {
   $output .= '
    <tr>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 

    
    ?>
    </div></div></div>
           </div> </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    <!-- gridjs js -->
    <script src="assets/libs/gridjs/gridjs.umd.js"></script>
    <script src="../../../../unpkg.com/gridjs%406.0.6/plugins/selection/dist/selection.umd.js"></script>

    <!--Swiper slider js-->
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>

    <!--seller-details init js -->
    <script src="assets/js/pages/seller-details.init.js"></script>

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
document.addEventListener("DOMContentLoaded", function () {
    // PHP kodlarından verileri çekmek için JavaScript kullanıyoruz
  
    var kabul = <?php echo $kabul; ?>;
    var sartliKabul = <?php echo $sartlikabul; ?>;
    var red = <?php echo $red; ?>; // Eksik olan red değişkeni eklendi

    // Çubuk grafiğini oluştur
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sorunsuz Kabul', 'Şartlı Kabul', 'Red'],
            datasets: [{
                label: 'Adet',
                data: [kabul, sartliKabul, red],
                barThickness: 80,
                backgroundColor: [
                    
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(255, 0, 0, 0.5)', // Kırmızı
                ],
                borderColor: [
                    
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 0, 0, 0.5)', // Kırmızı
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true, // Grafiği responsive hale getirin
            maintainAspectRatio: true, // En boy oranını korumayı devre dışı bırakın
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // Ondalık haneleri kapatın
                    }
                }
            }
        }
    });
});
</script>
<script>
$(function () {
  var table = $("#employee_data").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "ordering": false,
    
  
  });

  table.buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
});
</script>


</body>
</html>