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
                                <h4 class="mb-sm-0">Ay Bazlı Hedef Takip</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Ay Bazlı Hedef Takip</li>
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
                                    
                                    <div>
 
                            
    <?php if($user["role"] == 'admin'){ echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
   ?>

</form>
</div>
  
    <br/>
    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
   <?php 

$username = 'homeandf_onur';
$password = '354472Onur';
$connection = new PDO( 'mysql:host=localhost;dbname=homeandf_lagunabeachalya', $username, $password ); 
$connection ->query("SET NAMES UTF8");

   
   $statement = $connection->prepare("SELECT * FROM hedeftakip ORDER BY id ASC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   
	<thead> 
    <tr>
     <th width="3%">Departman</th>
     <th width="5%">Performans Kriteri</th>

     <th width="3%">İzleme Yöntemi</th>

     <th width="2%">İşlem</th>
    
    </tr>
       </thead>
  ';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
        $hedef = $row[$ay . 'hedef'];
$gerceklesen = $row[$ay . 'gerceklesen'];

// $hedef ve $gerceklesen sayısal değilse, hata mesajı bastır
if (!is_numeric($hedef) || !is_numeric($gerceklesen)) {
    echo "";
} else {
    $sapma = $hedef - $gerceklesen;
    // Diğer işlemleri buraya ekleyebilirsiniz.
}
        $sapmaClass = ($hedef > $gerceklesen) ? 'text-danger' : (($hedef < $gerceklesen) ? 'text-success' : ''); // Kontrol ve uygun CSS sınıfını belirle

        
    $output .= '
    <tr>
 
    
           <td>'.$row["departman"].'</td>
            <td>'.$row["performanskriteri"].'</td>
           
            <td>'.$row["hedefaciklama"].'</td>
          
     
     
     
     <td><center><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Güncelle</button> <button type="button" id="'.$row["id"].'" class="btn btn-danger btn-xs delete">Sil</button><center></td>

     
    </tr>';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>

    </tr>
   ';
  }
  $output .= '</table>';
  
  /////////////////İKİNCİ OUTPUT////////////////////////////////////
  
  $output2 = '';
  $output2 .= '
   
	<thead> 
    <tr>
     <th width="3%">Departman</th>
     <th width="5%">Performans Kriteri</th>
     <th width="3%">Mevcut Durum</th>
     <th width="3%">Hedef Değer</th>
     <th width="3%">Hedef Birim</th>
     <th width="3%">'. $ayduzeltme[$ay] .'</th>
     
     
     
    
    </tr>
       </thead>
  ';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
    $output2 .= '
    <tr>
     <td>'.$row["departman"].'</td>
     <td>'.$row["performanskriteri"].'</td>
     <td>'.$row["mevcutdurum"].'</td>
     <td>'.$row["hedefdeger"].'</td>
     <td>'.$row["hedefaciklama"].'</td>
    
     <td>'.$row[$ay].'</td>
     
     
     
     

     
    </tr>';
   }
  }
  else
  {
   $output2 .= '
    <tr>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>
     <td align="center">-</td>

    </tr>
   ';
  }
  $output2 .= '</table>';
  
 
 //////GÜNCELLE VE SİL BUTONLARINI YETKİLENDİRME////////
 if($user["role"] == 'admin'){ 
     echo "$output"; }
 else {
     echo "$output2"; }
 

    
    ?>
   

<!-- This is Customer Modal. It will be use for Create new Records and Update Existing Records!-->
<div id="customerModal" class="modal fade"  >
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
    <h4 class="modal-title">Create New Records</h4>
   </div>
   <div class="modal-body">
                          <label>Departman</label>  
                          <select name="departman" id="departman" class="form-control">  
                               <option value="YÖNETİM">YÖNETİM</option> 
                               <option value="MİSAFİR İLİŞKİLERİ">MİSAFİR İLİŞKİLERİ</option> 
                               <option value="ÖN BÜRO">ÖN BÜRO</option> 
                               <option value="SATIN ALMA">SATIN ALMA</option>
                               <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                               <option value="MUTFAK">MUTFAK</option>
                               <option value="HOUSE KEEPING">HOUSE KEEPING</option>
                               <option value="YİYECEK İÇECEK">YİYECEK İÇECEK</option>
                               <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                               <option value="YÖNETİM SİSTEMLERİ">YÖNETİM SİSTEMLERİ</option>
                          </select> 
                          <br />  
                          <label>Performans Kriteri</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="performanskriteri" id="performanskriteri" class="form-control" value="-">  
                          <br />  
                       
                          <label><?php echo $ayduzeltme[$ay] ?> Hedef Değeri</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="hedefdeger" id="hedefdeger" class="form-control" value="<?php echo $hedef; ?>">
                          <br />  
                          <label><?php echo $ayduzeltme[$ay] ?> Gerçekleşen</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="gerceklesen" id="gerceklesen" class="form-control" >  
                          <br />  
                          <label>İzleme Yöntemi</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="hedefaciklama" id="hedefaciklama" class="form-control">  
                          <br />  
                         
  
                          
                          
                          <input type="hidden" name="employee_id" id="employee_id" />  
    <br />
   </div>
   <div class="modal-footer">
    <input type="hidden" name="employee_id" id="employee_id" />
    <input type="hidden" name="ay" id="ay" >
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
    var ay = '<?php echo $ay; ?>';
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("ay_secimi").value = ay;
    });
    </script>
    
    <script>

  $(function () {
    var dataTable = $("#employee_data").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "buttons": ["excel"],
        "stateSave": true // DataTables state saving özelliğini etkinleştir
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');

    // DataTables güncellendikten sonra state'i kaydet
    dataTable.on('draw.dt', function () {
        dataTable.state.save();
    });
});

</script>

<script>

 //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#departman').val(''); 
  $('#performanskriteri').val('');
  $('#mevcutdurum').val('');
  $('#hedefdeger').val('');
  $('#hedefaciklama').val('');


 
  
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
  $('#action').val('Kayıt Ekle'); //This will reset Button value ot Create
 });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function () {
    $('#customerModal').modal('hide'); // Modal penceresini kapat
    
    var departman = $('#departman').val();
    var performanskriteri = $('#performanskriteri').val();
    var hedefdeger = $('#hedefdeger').val();
    var gerceklesen = $('#gerceklesen').val();
    var hedefaciklama = $('#hedefaciklama').val();
    var id = $('#employee_id').val();
    var action = $('#action').val();
   
    if (departman != '' && performanskriteri != '') {
        $.ajax({
            url: "actionhedef.php", //Request send to "action.php page"
            method: "POST", //Using of Post method for send data
            data: {
                departman: departman,
                performanskriteri: performanskriteri,
                hedefdeger: hedefdeger,
                gerceklesen: gerceklesen,
                hedefaciklama: hedefaciklama,
                employee_id: id,
                ay: ay,
                action: action
            }, //Send data to server
            success: function (data) {
                location.reload(); // Sayfanın yeniden yüklenmesi
                fetchUser();
    $('#customerModal').modal('hide');
    
    // DataTable state'ini güncelle
    dataTable.state.save();
}
        });
    } else {
        alert("Tüm Alanları Doldurmak Zorundasınız!"); //If both or any one of the variable has no value them it will display this message
    }
});

// ...

$(document).on('click', '.update', function () {
    var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
    
    var action = "Select"; //We have define action variable value is equal to select
    $.ajax({
        url: "actionhedef.php", //Request send to "action.php page"
        method: "POST", //Using of Post method for send data
        data: {
            employee_id: id,
            ay: ay,
            action: action
        }, //Send data to server
        dataType: "json", //Here we have define json data type, so server will send data in json format.
        success: function (data) {
            $('#customerModal').appendTo("body").modal('show'); //It will display modal on webpage
            $('.modal-title').text("Kayıt Güncelle"); //This code will change this class text to Update records
            $('#action').val("Güncelle"); //This code will change Button value to Update

            $('#employee_id').val(id);
            $('#departman').val(data.departman);
            $('#performanskriteri').val(data.performanskriteri);
            $('#hedefdeger').val(data.hedefdeger);
            $('#gerceklesen').val(data.gerceklesen);
            $('#hedefaciklama').val(data.hedefaciklama);
            fetchUser();
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


</script>

    </body>

</html>