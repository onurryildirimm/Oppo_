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
                                <h4 class="mb-sm-0">Yıllık Bakım Planı</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Yıllık Bakım Planı</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    
                    <div class="page-content-wrapper">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card m-b-20">
                                        <div class="card-body">
                                        <div align="right">
                            
    <?php if($user["magaza"] == "Kalite Yönetimi" || $user["magaza"] == "Teknik Servis" || $user["role"] == "admin" || $user["role"] == "midadmin")  {
  echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
   ?>
    
   </div>
   <br />

    
	 <?php
$username = 'xxxxx';
$password = 'xxxxx';
$servername = "xxxx";
$dbname = "xxxxx";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Veritabanından cihaz adları ve bakım tarihlerini çekme
$sql = "SELECT cihaz_adi, bakim_tarih FROM yillikbakim";
$result = $conn->query($sql);

// Tabloyu oluşturmak için kullanılacak dizi
$tableData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Bakım tarihini DateTime nesnesine çevir
        $bakimTarihi = new DateTime($row['bakim_tarih']);
        
        // Ay ve hafta numarasını al
        $monthNumber = intval($bakimTarihi->format('n'));

        // Cihaz adına göre diziyi oluştur
        if (!isset($tableData[$row['cihaz_adi']][$monthNumber])) {
            $tableData[$row['cihaz_adi']][$monthNumber] = array_fill(1, 4, false); // Her ay için 4 haftalık bir dizi oluştur
        }

        // Tarihin hangi haftaya denk geldiğini kontrol et
        $haftaNumarasi = 0;
        $gun = intval($bakimTarihi->format('j'));

        if ($gun >= 1 && $gun <= 7) {
            $haftaNumarasi = 1;
        } elseif ($gun > 7 && $gun <= 14) {
            $haftaNumarasi = 2;
        } elseif ($gun > 14 && $gun <= 21) {
            $haftaNumarasi = 3;
        } elseif ($gun > 21 && $gun <= 31) {
            $haftaNumarasi = 4;
        } elseif ($gun > 31) {
            // Ayın son haftasını kontrol et
            $lastDayOfMonth = intval($bakimTarihi->format('t'));
            if ($gun > ($lastDayOfMonth - 6)) {
                $haftaNumarasi = 4;
            }
        }

        // Haftaya tik işareti ekle
        if ($haftaNumarasi > 0) {
            $tableData[$row['cihaz_adi']][$monthNumber][$haftaNumarasi] = true;
        }
    }
}

// Bağlantıyı kapat
$conn->close();

?>

<!DOCTYPE html>

    
    <style>
        .ok-icon-blue {
            font-size: 10px;
            color: green;
            border: 1px solid grey;
            padding: 8px;
            background: blue;
            text-align: center;
        }
    
        .ok-icon {
            font-size: 10px;
            color: green;
            border: 1px solid grey;
            padding: 8px;
            text-align: center;
        }
        
        @media only screen and (max-width: 1366px) {
    /* Özel stil kuralları buraya eklenebilir */
    .ok-icon {
        font-size: 4px;
        padding: 3px;
        color: green;
        border: 1px solid grey;
        text-align: center;
    }
}


       @media only screen and (min-width: 1367px) and (max-width: 1600px) {
    .ok-icon {
        /* Özel stil kuralları buraya eklenebilir */
        font-size: 6px;
        padding: 3px;
        color: green;
        border: 1px solid grey;
        text-align: center;
    }
}

@media only screen and (min-width: 1601px) {
    .ok-icon {
        font-size: 6px;
        padding: 8px;
        color: green;
        border: 1px solid grey;
        text-align: center;
    }
}
        
        .bos-icon {
            font-size: 10px;
            color: green;
            border: 1px solid grey;
            padding: 8px;
            text-align: center;
        }

      
        .ok-icon-container {
    text-align: center;
    font-size: 15px; /* veya istediğiniz bir boyut */
}
    </style>

<div class="responsive">
    <table class="table table-striped table-bordered" id="employee_data">
        <thead>
            <tr>
                <th><center>Cihaz Adı</center></th>
                <?php
                // Türkçe ay isimlerini içeren bir dizi
                $ayIsimleri = [
                    "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
                    "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"
                ];

                for ($i = 1; $i <= 12; $i++) {
                    echo "<th><center>" . $ayIsimleri[$i-1] . "<br><hr> 1  |  2  |  3  |  4 </center></th>";
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
foreach ($tableData as $cihazAdi => $cihazAylar) {
    echo "<tr><td><center><a href='detaylicihazsorgu?cihaz_adi=" . urlencode($cihazAdi) . "'>$cihazAdi</a></center></td>";

    for ($i = 1; $i <= 12; $i++) {
        echo "<td>";

        // Cihazın ilgili ayında bakım yapıldı mı kontrol et
        $haftaNumarasi = sprintf('%02d', $i);
        $bakimVar = false;

        // Eğer cihazın ilgili ayında herhangi bir haftada bakım yapıldıysa
        if (isset($cihazAylar[$i])) {
            // Her bir tik için bir tik işareti ekle
            foreach ($cihazAylar[$i] as $hafta => $tik) {
                
                if ($tik) {
                    // Bakım yapan TEKNİK SERVİS ise mavi renk ekle
                    $bakimYapan = $cihazAylar['bakim_yapan'][$i][$hafta];
                    if (mb_strtoupper($bakimYapan, 'UTF-8') == mb_strtoupper("TEKNİK SERVİS", 'UTF-8')) {
                     echo "<span class='ok-icon-blue'>✔</span>";
                    } else {
                    echo "<span class='ok-icon'>✔</span>";
                    }
                } else {
                    echo "<span class='ok-icon'>-</span>";
                }
            }
        } else {
            // Bakım olmayan hafta için boş bir hücre ekle
            echo "";
        }
        
        echo "</td>";
    }
    echo "</tr>";
}
?>

        </tbody>
    </table>
</div></div></div></div></div>

<!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
 <div id="customerModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Yeni Kayıt Oluştur</h4>
   </div>
   <div class="modal-body">
                         
                         <label>Cihaz Adı</label>
<select name="cihaz_adi" id="cihaz_adi" class="form-control">
    <?php
$username = 'homeandf_onur';
$password = '354472Onur';
$dbname = 'homeandf_lagunabeachalya';

try {
    $connection = new PDO("mysql:host=localhost;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // MySQL'den cihaz adlarını al
    $cihazListesiQuery = $connection->query("SELECT cihaz FROM cihazlistesi");
    $cihazlar = $cihazListesiQuery->fetchAll(PDO::FETCH_COLUMN);

} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}

?>
    <?php
    // MySQL'den alınan cihaz adlarını seçenek olarak ekle
    foreach ($cihazlar as $cihaz) {
        echo "<option value=\"$cihaz\">$cihaz</option>";
    }
    ?>
</select>
                          <br />  
                          <label>Bakım Tarih</label>  
                          <input type="date" onkeyup="value=value.toUpperCase();" name="bakim_tarih" id="bakim_tarih" class="form-control">  
                          <br /> 
                          
                           <label>Bakım Yapan</label>  
                          <select name="bakim_yapan" id="bakim_yapan" class="form-control">
                              <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                              <option value="YETKİLİ SERVİS">YETKİLİ SERVİS</option>
                              <option value="YETKİLİ & TEKNİK SERVİS">YETKİLİ & TEKNİK SERVİS</option></select>
 
                        
                          <input type="hidden" name="employee_id" id="employee_id" />  
    <br />
   </div>
   <div class="modal-footer">
    <input type="hidden" name="employee_id" id="employee_id" />
    <input type="submit" name="action" id="action" class="btn btn-info" />
    <button type="button" class="btn btn-danger" onclick="closeModal()">Kapat</button>
    <script>function closeModal() {
    $('#customerModal').modal('hide');
}</script>
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

   $(function () {
    $("#employee_data").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false,
      "buttons": ["copy", "excel"]
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
  });
</script>

<script>
    //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#cihaz_adi').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var cihaz_adi = $('#cihaz_adi').val();
  var bakim_tarih = $('#bakim_tarih').val();
  var bakim_yapan = $('#bakim_yapan').val();
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('cihaz_adi', cihaz_adi);
  formData.append('bakim_tarih', bakim_tarih);
  formData.append('bakim_yapan', bakim_yapan);
  formData.append('employee_id', id);
  formData.append('action', action);

    if (bakim_tarih != '') {
    $.ajax({
      url: "actioncihazdetay.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(data) {
        $('#customerModal').modal('hide');
        location.reload(true);
        fetchUser();
      },
      error: function(xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
        alert("Dosya yüklenirken hata oluştu. Lütfen tekrar deneyin.");
      }
    });
  } else {
    alert("Tüm Alanları Doldurmak Zorundasınız!");
  }
});

 //Güncelleme İşlemlerini Yapıyoruz 
 
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); 
  var action = "Select";
  var form_data = new FormData();
  form_data.append("employee_id", id);
  form_data.append("action", action);
  form_data.append("cihaz_adi", $("#cihaz_adi").val());
  form_data.append("bakim_tarih", $("#bakim_tarih").val());
  form_data.append("bakim_yapan", $("#bakim_yapan").val());
  
  $.ajax({
    url:"actioncihazdetay.php",   
    method:"POST",
    data: form_data,
    dataType:"json",
    contentType: false,
    processData: false,
    success:function(data){
      $('#customerModal').appendTo("body").modal('show');
      $('.modal-title').text("Kayıt Güncelle"); 
      $('#action').val("Güncelle");
      $('#employee_id').val(id);
      $('#cihaz_adi').val(data.cihaz_adi);
      $('#bakim_tarih').val(data.bakim_tarih);
      $('#bakim_yapan').val(data.bakim_yapan);
      
    }
  });
});


 //Güncelleme İşlemlerini Bitiriyoruz

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  if(confirm("İlgili Kaydı Silmek İstediğinize Emin Misiniz?")) //Confim Box if OK then
  {
   var action = "Delete"; //Define action variable value Delete
   $.ajax({
    url:"actioncihazdetay.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{employee_id:id, action:action}, //Data send to server from ajax method
    success:function(data)
    {
        location.reload(true);
     fetchUser();    // fetchUser() function has been called and it will load data under divison tag with id result
        //It will pop up which data it was received from server side
    }
   })
  }
  else  //Confim Box if cancel then 
  {
   return false; //No action will perform
  }
 });

</script>

</body>
</html>
