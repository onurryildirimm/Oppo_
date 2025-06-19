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
                    <!-- end page title -->

                 

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div align="right">
                            
    <?php if($user["role"] == 'admin'){ echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
    
    elseif ($user["departman"] == 'TEKNİK SERVİS')
    { echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
   ?>
   </div>
     <br />
                                   
                                     <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
   <?php 

   
   $statement = $pdoconnection->prepare("SELECT * FROM yillikbakim ORDER BY id DESC");
 $statement->execute();
  $result = $statement->fetchAll();

  $output = '';
  $output = '
  <table class="table table-striped table-bordered" id="employee_data">
    <thead> 
      <tr>
        <th width="15%">Ekipman Adı</th>
        <th width="15%">Bakım Detayı</th>
        <th width="5%">Bakım Periyodu</th>
        <th width="15%">Sorumlu/Tedarikçi</th>
        <th width="4%">Planlanan Tarih</th>
        <th width="4%">Gerçekleşen Tarih</th>
        <th width="5%">Bakım Formları</th>';
        
if ($user["role"] == "admin" || $user["role"] == "superadmin") {
  $output .= '<th width="3%">Güncelle</th>';
}
elseif 
        ($user["departman"] == "TEKNİK SERVİS") {
$output .= '<th width="3%">Güncelle</th>';
            
        }
$output .= '
      </tr>
    </thead>
    <tbody>
';
  
  if($statement->rowCount() > 0) {
    foreach($result as $row) {
      $pdfLinks = explode(",", $row["pdf"]); // pdf yollarını virgülle ayırarak diziye aktar
      $pdfLinksHTML = "";
      foreach($pdfLinks as $pdfLink) {
        if(!empty($pdfLink)) {
          $pdfLinksHTML .= '<a href="'.$pdfLink.'"><i class="ri-file-pdf-line" style="font-size:24px;color:red"></i></a>';
        }
      }
      if(empty($pdfLinksHTML)) {
        $pdfLinksHTML = "Form Yüklenmemiş";
      }
      $output .= '
        <tr>
          <td>'.$row["ekipmanadi"].'</td>
          <td>'.$row["bakimdetay"].'</td>
          <td>'.$row["bakimperiyodu"].'</td>
          <td>'.$row["sorumlutedarikci"].'</td>
          <td>'.($row["plantarihi"] ? date('d.m.Y', strtotime($row["plantarihi"])) : '').'</td>
          <td>'.($row["gerceklesentarih"] ? date('d.m.Y', strtotime($row["gerceklesentarih"])) : '').'</td>
          <td><center>' . $pdfLinksHTML . '</center></td>';
        if ($user["role"] == "admin" || $user["role"] == "superadmin") {
          $output .= '<td><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></td>';
        }
        elseif 
        ($user["departman"] == "TEKNİK SERVİS") {
            $output .= '<td><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></td>';
        }
      $output .= '</tr>';
  }
} else {
    $output .= '
      <tr>
        <td colspan="8" align="center">Veri Bulunamadı.</td>
      </tr>
    ';
  }
  
  $output .= '
      </tbody>
    </table>
  ';
  
  echo $output;

    
    ?>

          
   

<!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
<div id="customerModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Create New Records</h4>
   </div>
   <div class="modal-body">
                          <label>Ekipman Adı</label>
<select name="ekipmanadi" id="ekipmanadi" class="form-control">
    <?php

try {

    $pdoconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // MySQL'den cihaz adlarını al
    $cihazListesiQuery = $pdoconnection->query("SELECT cihaz FROM cihazlistesi");
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
<br/>
                          
                          <label>Bakım Detay:</label>  
                          <input type="text" name="bakimdetay" id="bakimdetay" class="form-control" />  
                          <br /> 
                          
                          <label>Bakım Periyodu:</label>  
                          <input type="text" name="bakimperiyodu" id="bakimperiyodu" class="form-control" />  
                          <br /> 
                          
                          <label>Sorumlu/Tedarikçi:</label>  
                          <input type="text" name="sorumlutedarikci" id="sorumlutedarikci" class="form-control" />  
                          <br /> 

                          <label>Planlanan Tarih:</label>  
                          <input type="date" name="plantarihi" id="plantarihi" class="form-control" />  
                          <br /> 
                          
                          <label>Gerçekleşen Tarih:</label>  
                          <input type="date" name="gerceklesentarih" id="gerceklesentarih" class="form-control" />  
                          <br /> 
                          
                          
                          
                          <label>Bakım Formu:</label><br />  
                          <input type="file" name="pdf[]" id="pdf" multiple>
                        
                    
                          
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
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
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
        //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#ekipmanadi').val(''); //This will clear Modal first name textbox
  $('#bakimdetay').val(''); //This will clear Modal last name textbox
  $('#bakimperiyodu').val('');
  $('#sorumlutedarikci').val('');
  $('#plantarihi').val('');
  $('#gerceklesentarih').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var ekipmanadi = $('#ekipmanadi').val();
  var bakimdetay = $('#bakimdetay').val();
  var bakimperiyodu = $('#bakimperiyodu').val();
  var sorumlutedarikci = $('#sorumlutedarikci').val();
  var plantarihi = $('#plantarihi').val();
  var gerceklesentarih = $('#gerceklesentarih').val();
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('ekipmanadi', ekipmanadi);
  formData.append('bakimdetay', bakimdetay);
  formData.append('bakimperiyodu', bakimperiyodu);
  formData.append('sorumlutedarikci', sorumlutedarikci);
  formData.append('plantarihi', plantarihi);
  formData.append('gerceklesentarih', gerceklesentarih);
  formData.append('employee_id', id);
  formData.append('action', action);

  // Boş bir dosya ekleyerek, "pdf[]" anahtarını FormData nesnesine ekleriz.
  formData.append('pdf[]', new File([], ''));

  var pdfFiles = $('#pdf')[0].files;
  if (pdfFiles.length > 0) {
    for (var i = 0; i < pdfFiles.length; i++) {
      formData.append('pdf[]', pdfFiles[i]);
    }
  }

  if (ekipmanadi != '') {
    $.ajax({
      url: "actionyenibakim.php",
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
  form_data.append("ekipmanadi", $("#ekipmanadi").val());
  form_data.append("bakimdetay", $("#bakimdetay").val());
  form_data.append("bakimperiyodu", $("#bakimperiyodu").val());
  form_data.append("sorumlutedarikci", $("#sorumlutedarikci").val());
  form_data.append("plantarihi", $("#plantarihi").val());
  form_data.append("gerceklesentarih", $("#gerceklesentarih").val());
  
  var pdfFiles = $('#pdf')[0].files;
  if (pdfFiles.length > 0) {
    for (var i = 0; i < pdfFiles.length; i++) {
      form_data.append("pdf[]", pdfFiles[i]);
    }
  } else {
    form_data.append("pdf", ""); // değer boş ise, pdf alanı boş bırakılır
  }
  

  $.ajax({
    url:"actionyenibakim.php",   
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
      $('#ekipmanadi').val(data.ekipmanadi);
      $('#bakimdetay').val(data.bakimdetay);
      $('#bakimperiyodu').val(data.bakimperiyodu);
      $('#sorumlutedarikci').val(data.sorumlutedarikci);
      $('#plantarihi').val(data.plantarihi);
      $('#gerceklesentarih').val(data.gerceklesentarih);
      
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
    url:"actionis.php",    //Request send to "action.php page"
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