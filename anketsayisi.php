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
                                <h4 class="mb-sm-0">Aylara Göre Anket Sayısı Ekle</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Aylara Göre Anket Sayısı Ekle</li>
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
                            
    <?php if($user["role"] == "admin" || $user["role"] == "midadmin") {
  echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
   ?>
    
   </div>
   <br />

    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    
<?php
$aylar = array(
    'ocak' => 'Ocak',
    'subat' => 'Şubat',
    'mart' => 'Mart',
    'nisan' => 'Nisan',
    'mayis' => 'Mayıs',
    'haziran' => 'Haziran',
    'temmuz' => 'Temmuz',
    'agustos' => 'Ağustos',
    'eylul' => 'Eylül',
    'ekim' => 'Ekim',
    'kasim' => 'Kasım',
    'aralik' => 'Aralık'
);

$username = 'homeandf_onur';
$password = '354472Onur';
$connection = new PDO('mysql:host=localhost;dbname=homeandf_lagunabeachalya', $username, $password);

$statement = $connection->prepare("SELECT * FROM anketsayi ORDER BY id ASC");
$statement->execute();
$result = $statement->fetchAll();
$output = '';
$output .= '
	<thead> 
	<tr>
		<th width="8%"><center>İlgili Ay</center></th>
		<th width="8%"><center>Anket Sayısı</center></th>
		<th width="8%"><center>Güncelle</center></th>
	</tr>
	</thead>
';

if ($statement->rowCount() > 0) {
	foreach ($result as $row) {
		 $ay = $aylar[$row["ay"]]; // Diziye göre ay değerini al

		$output .= '
		<tr>
			<td><center>'.$ay.'</center></td>
			<td><center>'.$row["anketsayi"].'</center></td>
			<td><center><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Güncelle</button></center></td>     
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
                          
                          <label>Ay</label>  
                          <select name="ay" id="ay" class="form-control">  
                               <option value="ocak">Ocak</option> 
                               <option value="subat">Şubat</option> 
                               <option value="mart">Mart</option> 
                               <option value="nisan">Nisan</option>
                               <option value="mayis">Mayıs</option>
                               <option value="haziran">Haziran</option>
                               <option value="temmuz">Temmuz</option>
                               <option value="agustos">Ağustos</option>
                               <option value="eylul">Eylül</option>
                               <option value="ekim">Ekim</option>
                               <option value="kasim">Kasım</option>
                               <option value="aralik">Aralık</option>
                          </select>  
                          <br />  
                          
                          <label>Anket Sayısı</label>  
                          <input type="number" onkeyup="value=value.toUpperCase();" name="anketsayi" id="anketsayi" class="form-control">  
                        
                        
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

  
  $(function () {
    $("#employee_data").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false,
      "buttons": ["excel"]
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
    
   

 //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#ay').val('');
  $('#anketsayi').val(''); //This will clear Modal first name textbox
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var ay = $('#ay').val();
  var anketsayi = $('#anketsayi').val();
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('ay', ay);
  formData.append('anketsayi', anketsayi);
  formData.append('employee_id', id);
  formData.append('action', action);

    if (ay != '' && anketsayi != '') {
    $.ajax({
      url: "actionanketsayi.php",
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
  form_data.append("ay", $("#ay").val());
  form_data.append("anketsayi", $("#anketsayi").val());
 
  
  $.ajax({
    url:"actionanketsayi.php",   
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
      $('#ay').val(data.ay);
      $('#anketsayi').val(data.anketsayi);
      
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