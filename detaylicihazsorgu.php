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
                                <h4 class="mb-sm-0">Cihaz Bakım Detayları</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Cihaz Bakım Detayları</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <?php 
                  

                    // URL'den cihaz adını al
                    $cihazAdi = isset($_GET['cihaz_adi']) ? htmlspecialchars($_GET['cihaz_adi']) : '';

                    // Cihaz bilgilerini çek
                    $statement = $pdoconnection->prepare("SELECT * FROM yillikbakim WHERE cihaz_adi = :cihaz_adi");
                    $statement->bindParam(':cihaz_adi', $cihazAdi, PDO::PARAM_STR);
                    $statement->execute();
                    $cihazRow = $statement->fetch(PDO::FETCH_ASSOC);
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
                                            <h5 class="mb-1">Cihaz Bilgileri</h5>
                                            <p class="text-muted">Detaylar</p>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table mb-0 table-borderless">
                                                <tbody>
                                                    <tr>
                                                        <th><span class="fw-medium">Cihaz Adı:</span></th>
                                                        <td><?php echo htmlspecialchars($cihazRow['cihaz_adi']); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th><span class="fw-medium">Bakım Yapan:</span></th>
                                                        <td><?php echo htmlspecialchars($cihazRow['bakim_yapan']); ?>
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
                                                    
                                        <center><h6>Bakım Formu Yükle</h6></center>
<form action="upload_bakim.php" method="post" enctype="multipart/form-data">
    <label for="dosya">Dosya Seç:</label>
    <input type="file" name="dosya_yolu" id="dosya" required>
    <button type="submit">Yükle</button>
    <input type="hidden" name="cihaz_adi" value="<?php echo $cihazAdi; ?>">
</form>
                                    
                                                </div>
                                                
                                            </div>

                                            <div class="mt-3">
                                                <div class="row align-items-center">
                                               
                                                    <center><h3>
                                                        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
                                                         <?php
// Veritabanından cihaz adına ait formları çek
$cihazAdi = isset($_GET['cihaz_adi']) ? htmlspecialchars($_GET['cihaz_adi']) : '';

$statement = $pdoconnection->prepare("SELECT dosya_yolu FROM yillikbakim WHERE cihaz_adi = :cihaz_adi");
$statement->bindParam(':cihaz_adi', $cihazAdi, PDO::PARAM_STR);
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
        } else {
            echo 'Yüklü Form Bulunamadı.';
        }

        echo '</a>';
    }
} 
?>

                                                    </h3></center>
                                                    
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
                            
                            
                            <div class="row g-6 mb-3">
                                <div class="col-sm-12">
                                    <div class="card">
         <div class="card-body">
                                    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    Ürüne Ait Bakım Kayıtları:
                                        
<?php

// URL'den cihaz adını al
$cihazAdi = isset($_GET['cihaz_adi']) ? htmlspecialchars($_GET['cihaz_adi']) : '';

// Cihaz bilgilerini çek
$statement = $pdoconnection->prepare("SELECT * FROM yillikbakim WHERE cihaz_adi = :cihaz_adi");
$statement->bindParam(':cihaz_adi', $cihazAdi, PDO::PARAM_STR);
$statement->execute();
$cihazRows = $statement->fetchAll(PDO::FETCH_ASSOC);
$output = '';
$output .= '
    <thead> 
        <tr>
            <th width="10%">Cihaz Adı</th>
            <th width="15%">Bakım Tarihleri</th>
            <th width="15%">Bakım Yapan</th>
            <th width="5%">Güncelle</th>
        </tr>
    </thead>
';

if($statement->rowCount() > 0)
{
    foreach($cihazRows as $row)
    {
        $pdfLinks = explode(",", $row["pdf"]); 
        $pdfLinksHTML = "";
        foreach($pdfLinks as $pdfLink){
            if(!empty($pdfLink)){
                $pdfLinksHTML .= '<a href="'.$pdfLink.'"><i class="fa fa-file-pdf-o" style="font-size:24px;color:red"></i></a>';
            }
        }

        $output .= '
            <tr>
                <td>'.$row['cihaz_adi'].'</td>
                <td>'.date('d/m/Y', strtotime($row['bakim_tarih'])).'</td>
                <td>'.$row['bakim_yapan'].'</td>
                <td><center><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Güncelle</button> <button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Sil</button></center></td>     
            </tr>';
    }
}
else
{
    $output .= '
        <tr>
            <td align="center" colspan="4">Veri Bulunamadı.</td>
        </tr>
    ';
}

$output .= '</table>';
echo $output;
?>
    </div></div></div>
           </div> </div></div>
           <!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
 <div id="customerModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Yeni Kayıt Oluştur</h4>
   </div>
   <div class="modal-body">
                         
                          <label>Cihaz Adı</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="cihaz_adi" id="cihaz_adi" class="form-control">  
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