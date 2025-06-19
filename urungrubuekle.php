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
                                <h4 class="mb-sm-0">Stok Grubu Ekleme Formu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Stok Grubu Ekleme Formu</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                <style>
    .form-container {
        border: 2px dashed #ccc; /* Kesik çizgili çerçeve */
        padding: 20px;
        max-width: 400px; /* Formun maksimum genişliği */
        margin: 0 auto; /* Formu ortalamak için */
    }

    /* Dosya seçme alanını özelleştirme */
    input[type="file"] {
        border: none; /* Dosya seçme alanının kenarlığını kaldırın */
        background-color: transparent; /* Arka plan rengini saydam yapın */
        outline: none; /* Odak çerçevesini kaldırın */
        width: 100%; /* Dosya seçme alanını genişletmek için */
        padding: 10px 0; /* Boşluk eklemek için */
    }

    /* Yükle düğmesini özelleştirme */
    button[type="submit"] {
        background-color: #007bff; /* Arka plan rengi */
        color: #fff; /* Yazı rengi */
        border: none; /* Kenarlık yok */
        padding: 10px 20px; /* Boşluk eklemek için */
        cursor: pointer; /* El işareti farklı bir gösterge yapar */
    }

    /* Yükle düğmesine hover olduğunda stil eklemek */
    button[type="submit"]:hover {
        background-color: #0056b3; /* Hover rengi */
    }
</style>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                
                                <div class="card-body">
                                        <div align="center">
                            
    <?php if($user["magaza"] == "KALİTE YÖNETİMİ" || $user["magaza"] == "SATINALMA" || $user["role"] == "admin" || $user["role"] == "user" || $user["role"] == "midadmin" ) {
  echo '
    <button type="button" id="modal_button" class="btn btn-info">Manuel Kayıt Ekle</button>
    <br/><br/>
    Veya
     <br/><br/>
    <div class="form-container">
    <form action="stok_grup_veri_aktar.php" method="POST" enctype="multipart/form-data">
        <label>Excel Dosyasından Yükle:</label>
        <input type="file" name="excelFile" accept=".xlsx, .xls">
        <button type="submit" name="upload">Yükle</button>
    </form></div>'; }
   ?>
    
   </div>
   <br />

    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    
<?php


$statement = $pdoconnection->prepare("SELECT * FROM urungrubu ORDER BY id DESC");
$statement->execute();
$result = $statement->fetchAll();
$output = '';

// Tablo başlığını ve açılış etiketini burada açın
$output .= '
    
    <thead> 
    <tr>
     <th width="15%">Ürün Kodu</th>
     <th width="15%">Stok Grup Adı</th>
     <th width="5%">Güncelle</th>
    </tr>
    </thead>
';

if ($statement->rowCount() > 0) {
    foreach ($result as $row) {
        $output .= '
        <tr>
         <td>'.$row["id"].'</td>
         <td>'.$row["urungrubu2"].'</td>
         <td><center><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Güncelle</button>
         <button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Kaydı Sil</button></center>
         </td>
        </tr>';
    }
} else {
    $output .= '
    <tr>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>
     <td align="center">Veri Bulunamadı.</td>

    </tr>
   ';
}

// Tablo kapanış etiketini burada ekleyin
$output .= '</table>';

echo $output;
?>


<!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
 <div id="customerModal" class="modal fade">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Yeni Kayıt Oluştur</h4>
   </div>
   <div class="modal-body">
                          
                          <label>Ürün Grubu</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="urungrubu2" id="urungrubu2" class="form-control">  
                          <br />  
                          
                        
                          <input type="hidden" name="employee_id" id="employee_id" />  

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

<!-- Silme Modal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Kayıt Silme Onayı</h4>
                        <p class="text-muted mx-4 mb-0">Silme işleminden emin misiniz ? Bu işlemin geri dönüşü yoktur.</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-confirmed">Evet, Eminim!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
    
    
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
  var table = $("#employee_data").DataTable({
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    "ordering": false,
    
    
  });

  table.buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
});


    
   

 //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#urungrubu2').val(''); //This will clear Modal first name textbox
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var urungrubu2 = $('#urungrubu2').val();
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('urungrubu2', urungrubu2);
  formData.append('employee_id', id);
  formData.append('action', action);

  if (urungrubu2 != '') {
    $.ajax({
      url: "actionurungrubu.php",
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
        location.reload();
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
  form_data.append("urungrubu2", $("#urungrubu2").val());
  
  $.ajax({
    url:"actionurungrubu.php",   
    method:"POST",
    data: form_data,
    dataType:"json", // JSON veri bekliyorsunuz gibi görünüyor
    contentType: false,
    processData: false,
    success:function(data){
      $('#customerModal').appendTo("body").modal('show');
      $('.modal-title').text("Kayıt Güncelle"); 
      $('#action').val("Güncelle");
      $('#employee_id').val(id);
      $('#urungrubu2').val(data.urungrubu2);
      
    }
  });
});


 //Güncelleme İşlemlerini Bitiriyoruz

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
$(document).on('click', '.delete', function() {
        var id = $(this).attr("id"); // Bu kod, id özniteliğini kullanarak herhangi bir müşteri kimliğini çeker
        $('#removeNotificationModal').modal('show'); // Onay modal penceresini açar

        $('#delete-confirmed').click(function() {
            var action = "Delete"; // Silme işlemini tanımla
            $.ajax({
                url: "actionurungrubu.php",
                method: "POST",
                data: { employee_id: id, action: action },
                success: function(data) {
                    $('#removeNotificationModal').modal('hide'); // Onay modal penceresini kapatır
                    location.reload(true);
                    fetchUser(); // fetchUser() işlevi çağrılır ve verileri id'si sonuç olan etiketin altına yükler
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