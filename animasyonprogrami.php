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
                                <h4 class="mb-sm-0">Animasyon Programı</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Animasyon Programı</li>
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
                            
    <?php if($user["role"] == "admin") {
  echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
   ?>
    
   </div>
   <br />

    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    
<?php
header('Content-Type: text/html; charset=utf-8');

$username = 'homeandf_onur';
$password = '354472Onur';


$statement = $pdoconnection->prepare("SELECT * FROM animasyon ORDER BY id DESC");
$statement->execute();
$result = $statement->fetchAll();
$output = '';
$output .= '
    <thead> 
        <tr>
            <th width="10%">Days</th>
            <th width="12%">07:30</th>
            <th width="12%">10:00</th>
            <th width="12%">10:30</th>
            <th width="12%">11:00</th>
            <th width="12%">12:00</th>
            <th width="12%">14:30</th>
            <th width="12%">15:00</th>
            <th width="12%">16:00</th>
            <th width="12%">16:30</th>
            <th width="12%">21:00</th>
            <th width="5%">Güncelle</th>
        </tr>
    </thead>';

if ($statement->rowCount() > 0) {
    foreach ($result as $row) {
        $pdfLinks = explode(",", $row["pdf"]); // pdf yollarını virgülle ayırarak diziye aktar
        $pdfLinksHTML = "";
        foreach ($pdfLinks as $pdfLink) {
            if (!empty($pdfLink)) {
                $pdfLinksHTML .= '<a href="' . $pdfLink . '"><i class="fa fa-file-pdf-o" style="font-size:24px;color:red"></i></a>';
            }
        }
        if (empty($pdfLinksHTML)) {
            $pdfLinksHTML = "Form Yüklenmemiş";
        }

        $bilgi = $row["bilgi"];
        $kime = $row["kime"];

        // Bilgi alanı için kısaltma işlemi
        if (mb_strlen($bilgi) > 100) {
            $bilgi = mb_substr($bilgi, 0, 100) . '...';
        }

        // Kime alanı için kısaltma işlemi
        if (mb_strlen($kime) > 100) {
            $kime = mb_substr($kime, 0, 100) . '...';
        }

        $output .= '
        <tr>
            <td>' . $row["gunler"] . '</td>
            <td>' . $row["yediotuz"] . '</td>
            <td>' . $row["onsaat"] . '</td>
            <td>' . $row["onotuz"] . '</td>
            <td>' . $row["onbir"] . '</td>
            <td>' . $row["oniki"] . '</td>
            <td>' . $row["ondortotuz"] . '</td>
            <td>' . $row["onbes"] . '</td>
            <td>' . $row["onalti"] . '</td>
            <td>' . $row["onaltiotuz"] . '</td>
            <td>' . $row["yirmibir"] . '</td>
            <td><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></td>     
        </tr>';
    }
} else {
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
    </tr>';
}
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
                          <label>Günler</label>  
                          <input type="text"  name="gunler" id="gunler" class="form-control">
                          <br />  
                          <label>07:30</label>  
                          <input type="text"  name="yediotuz" id="yediotuz" class="form-control">
                          <br />  
                          <label>10:00</label>  
                          <input type="text"  name="onsaat" id="onsaat" class="form-control">
                          <br />  
                          <label>10:30</label>  
                          <input type="text"  name="onotuz" id="onotuz" class="form-control">
                          <br />  
                            <label>11:00</label>  
                          <input type="text"  name="onbir" id="onbir" class="form-control">
                          <br />
                          <label>12:00</label>  
                          <input type="text"  name="oniki" id="oniki" class="form-control">
                          <br />
                          
                          <label>14:30</label>  
                          <input type="text" name="ondortotuz" id="ondortotuz" class="form-control">
                          <br />
                          
                          <label>15:00</label>  
                          <input type="text"  name="onbes" id="onbes" class="form-control">
                          <br />
                          
                           <label>16:00</label>  
                          <input type="text" name="onalti" id="onalti" class="form-control">
                          <br />
                          
                          <label>16:30</label>  
                          <input type="text" name="onaltiotuz" id="onaltiotuz" class="form-control">
                          <br />
                          
                          <label>21:00</label>  
                          <input type="text" name="yirmibir" id="yirmibir" class="form-control">
                          <br />
                          
                        
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
      "buttons": ["excel"]
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
  });
    </script>
    
   
<script>
//This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show');
  $('#gunler').val('');
  $('#yediotuz').val('');
  $('#onsaat').val('');
  $('#onotuz').val('');
  $('#onbir').val('');
  $('#oniki').val('');
  $('#ondortotuz').val('');
  $('#onbes').val('');
  $('#onalti').val('');
  $('#onaltiotuz').val('');
  $('#yirmibir').val('');
  $('.modal-title').text("Yeni Kayıt Ekle");
  $('#action').val('Kayıt Ekle');
 });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
var gunler = $('#gunler').val(); 
var yediotuz = $('#yediotuz').val(); 
var onsaat = $('#onsaat').val(); 
var onotuz = $('#onotuz').val(); 
var onbir = $('#onbir').val();
var oniki = $('#oniki').val();
var ondortotuz = $('#ondortotuz').val();
var onbes = $('#onbes').val();
var onalti = $('#onalti').val();  
var onaltiotuz = $('#onaltiotuz').val();
var yirmibir = $('#yirmibir').val();
var id                = $('#employee_id').val();  
var action        = $('#action').val();
var formData = new FormData();
  formData.append('gunler', gunler);
  formData.append('yediotuz', yediotuz);
  formData.append('onsaat', onsaat);
  formData.append('onotuz', onotuz);
  formData.append('onbir', onbir);
  formData.append('oniki', oniki);
  formData.append('ondortotuz', ondortotuz);
  formData.append('onbes', onbes);
  formData.append('onalti', onalti);
  formData.append('onaltiotuz', onaltiotuz);
  formData.append('yirmibir', yirmibir);
  formData.append('employee_id', id);
  formData.append('action', action);
  if (onsaat != '' && onotuz != '') {
    $.ajax({
      url: "actionanimasyon.php",
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

 //This JQuery code is for Update customer data. If we have click on any customer row update button then this code will execute
  // Kaydı seçme işlemi
  $(document).on('click', '.update', function() {
    var id = $(this).attr("id");
    var action = "Select";
    
    $.ajax({
      url: "actionanimasyon.php",
      method: "POST",
      data: {
        employee_id: id,
        action: action
      },
      dataType: "json",
      success: function(data) {
        $('#customerModal').appendTo("body").modal('show');
        $('.modal-title').text("Kayıt Güncelle");
        $('#action').val("Güncelle");
        
        $('#employee_id').val(id);
        $('#gunler').val(data.gunler);
        $('#yediotuz').val(data.yediotuz);
        $('#onsaat').val(data.onsaat);
        $('#onotuz').val(data.onotuz);
        $('#onbir').val(data.onbir);
        $('#oniki').val(data.oniki);
        $('#ondortotuz').val(data.ondortotuz);
        $('#onbes').val(data.onbes);
        $('#onalti').val(data.onalti);
        $('#onaltiotuz').val(data.onaltiotuz);
        $('#yirmibir').val(data.yirmibir);
        
        
        // Checkboxları güncelle
        $('input[name="usernames[]"]').each(function() {
          var checkboxValue = $(this).closest('.form-check').find('.form-check-label').text();
          if (data.kime.includes(checkboxValue)) {
            $(this).prop('checked', true);
          } else {
            $(this).prop('checked', false);
          }
        });
      },
      error: function(xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
        alert("Kayıt seçilirken bir hata oluştu.");
      }
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