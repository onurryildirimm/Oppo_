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
                                <h4 class="mb-sm-0">Hedef Kıyaslama</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Hedef Kıyaslama</li>
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
                                     
    
   
   <br />
   <style>
       .checkbox-group {
  margin-bottom: 10px;
}

.checkbox-group > div {
  display: inline-block;
  width: 25%;
  box-sizing: border-box;
  padding-right: 10px;
  vertical-align: top;
}

.checkbox-group label {
  margin-left: 5px;
}

   </style>
   <div>
   <form action="hedefkiyas2" method="POST">
  <label for="ay_secimi">Görüntülemek İstediğiniz Ayı Seçiniz:</label>
  <div class="checkbox-group">
  <div>
    <input type="checkbox" name="ay_secimi[]" value="ocak">
    <label>Ocak</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="subat">
    <label>Şubat</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="mart">
    <label>Mart</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="nisan">
    <label>Nisan</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="mayis">
    <label>Mayıs</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="haziran">
    <label>Haziran</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="temmuz">
    <label>Temmuz</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="agustos">
    <label>Ağustos</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="eylul">
    <label>Eylül</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="ekimh">
    <label>Ekim</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="kasim">
    <label>Kasım</label>
  </div>
  <div>
    <input type="checkbox" name="ay_secimi[]" value="aralik">
    <label>Aralık</label>
  </div>
</div>
<br/>
  <input type="submit" class="btn btn-primary dropdown-toggle" value="Göster">
</form><br/>
</div>
<div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
<?php

// Veritabanı bağlantısını oluştur
$connection = dbConnect();

// Seçilen ayları içeren bir dizi oluşturun
$aylar = isset($_POST["ay_secimi"]) ? $_POST["ay_secimi"] : array();

// Performans verilerini çekin
$result = getPerformanceData($connection, $aylar);

$output = '';
$output .= '
   <thead> 
    <tr>
     <th width="3%">Departman</th>
     <th width="5%">Performans Kriteri</th>
     <th width="3%">İzleme Kriteri</th>
';

// Seçilen aylar için sütun başlıklarını ekleyin
foreach ($aylar as $ay) {
    $output .= '<th width="3%">' . ucfirst($ay) . ' Hedef</th>';
    $output .= '<th width="3%">' . ucfirst($ay) . ' Gerçekleşen</th>';
}
$output .= '</thead>';

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $output .= '
      <tr>
       <td>' . $row["departman"] . '</td>
       <td>' . $row["performanskriteri"] . '</td>
       <td>' . $row["hedefaciklama"] . '</td>
    ';

        // Seçilen ayların hedef değerlerini ve gerçekleşenlerini satırlara ekleyin
        foreach ($aylar as $ay) {
            $ayhedef = $ay . 'hedef';
            $aygerceklesen = $ay . 'gerceklesen';
            $output .= '<td>' . $row[$ayhedef] . '</td>';
            $output .= '<td>' . $row[$aygerceklesen] . '</td>';
        }
        $output .= '</tr>';
    }
} else {
    $output .= '<tr><td colspan="' . (count($aylar) * 2 + 3) . '" align="center">Veri bulunamadı</td></tr>';
}

$output .= '</table>';

echo $output;

mysqli_close($connection); // Veritabanı bağlantısını kapatıyoruz
?>


   

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div></div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  
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
  $('#departman').val(''); 
  $('#performanskriteri').val('');
  $('#mevcutdurum').val('');
  $('#hedefdeger').val('');
  $('#hedefaciklama').val('');
  $('#hedefizlemekriteri').val('');
  $('#politika').val('');
  $('#sure').val('');
  $('#strateji').val('');
  $('#kaynak').val('');
  $('#ocak').val('');
  $('#subat').val('');
  $('#mart').val('');
  $('#nisan').val('');
  $('#mayis').val('');
  $('#haziran').val('');
  $('#temmuz').val('');
  $('#agustos').val('');
  $('#eylul').val('');
  $('#ekim').val('');
  $('#kasim').val('');
  $('#aralik').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
  $('#action').val('Kayıt Ekle'); //This will reset Button value ot Create
 });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
  var departman             = $('#departman').val(); 
  var performanskriteri     = $('#performanskriteri').val();
  var mevcutdurum           = $('#mevcutdurum').val();
  var hedefdeger            = $('#hedefdeger').val();
  var hedefaciklama         = $('#hedefaciklama').val();
  var hedefizlemekriteri    = $('#hedefizlemekriteri').val();
  var politika              = $('#politika').val();
  var sure                  = $('#sure').val();
  var strateji              = $('#strateji').val();
  var kaynak                = $('#kaynak').val();
  var ocak                  = $('#ocak').val();
  var subat                 = $('#subat').val();
  var mart                  = $('#mart').val();
  var nisan                 = $('#nisan').val();
  var mayis                 = $('#mayis').val();
  var haziran               = $('#haziran').val();
  var temmuz                = $('#temmuz').val();
  var agustos               = $('#agustos').val();
  var eylul                 = $('#eylul').val();
  var ekim                  = $('#ekim').val();
  var kasim                 = $('#kasim').val();
  var aralik                = $('#aralik').val();
  var id                    = $('#employee_id').val();  //Get the value id
  var action                = $('#action').val();  //Get the value of Modal Action button and stored into action variable
  if(departman != '' && performanskriteri != '') //This condition will check both variable has some value
  {
   $.ajax({
    url : "actionhedef.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{departman:departman, performanskriteri:performanskriteri, mevcutdurum:mevcutdurum, hedefdeger:hedefdeger,hedefaciklama:hedefaciklama, hedefizlemekriteri:hedefizlemekriteri, politika:politika, sure:sure, strateji:strateji, kaynak:kaynak, ocak:ocak, subat:subat, mart:mart,  nisan:nisan, mayis:mayis, haziran:haziran, temmuz:temmuz, agustos:agustos, eylul:eylul, ekim:ekim, kasim:kasim, aralik:aralik, employee_id:id, action:action}, //Send data to server
    success:function(data){
        //It will pop up which data it was received from server side
     $('#customerModal').modal('hide');
     location.reload(true);//It will hide Customer Modal from webpage.
     fetchUser();    // Fetch User function has been called and it will load data under divison tag with id result
    }

   });
  }
  else
  {
   alert("Tüm Alanları Doldurmak Zorundasınız!"); //If both or any one of the variable has no value them it will display this message
  }
 });

 //This JQuery code is for Update customer data. If we have click on any customer row update button then this code will execute
 
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  var action = "Select";   //We have define action variable value is equal to select
  $.ajax({
   url:"actionhedef.php",   //Request send to "action.php page"
   method:"POST",    //Using of Post method for send data
   data:{employee_id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#customerModal').appendTo("body").modal('show');   //It will display modal on webpage
    $('.modal-title').text("Kayıt Güncelle"); //This code will change this class text to Update records
    $('#action').val("Güncelle");     //This code will change Button value to Update
    
    $('#employee_id').val(id);
    $('#departman').val(data.departman);
    $('#performanskriteri').val(data.performanskriteri);
    $('#mevcutdurum').val(data.mevcutdurum);
    $('#hedefdeger').val(data.hedefdeger);
    $('#hedefaciklama').val(data.hedefaciklama);
    $('#hedefizlemekriteri').val(data.hedefizlemekriteri);
    $('#politika').val(data.politika);
    $('#sure').val(data.sure);
    $('#strateji').val(data.strateji);
    $('#kaynak').val(data.kaynak);
    $('#ocak').val(data.ocak);
    $('#subat').val(data.subat);
    $('#mart').val(data.mart);
    $('#nisan').val(data.nisan);
    $('#mayis').val(data.mayis);
    $('#haziran').val(data.haziran);
    $('#temmuz').val(data.temmuz);
    $('#agustos').val(data.agustos);
    $('#eylul').val(data.eylul);
    $('#ekim').val(data.ekim);
    $('#kasim').val(data.kasim);
    $('#aralik').val(data.aralik);
   }
  });
  
 });
 

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  if(confirm("İlgili Kaydı Silmek İstediğinize Emin Misiniz?")) //Confim Box if OK then
  {
   var action = "Delete"; //Define action variable value Delete
   $.ajax({
    url:"actionhedef.php",    //Request send to "action.php page"
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