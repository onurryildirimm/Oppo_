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
                                <h4 class="mb-sm-0">Eşya Takip Formu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laguna Beach Alya</a></li>
                                        <li class="breadcrumb-item active">Eşya Takip Formu</li>
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
    <?php if($user["role"] == 'admin'){ echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>'; }
   ?>
    </div>
    <br />
    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
    <?php 
    require_once('vendor/php-excel-reader/excel_reader2.php');
    require_once('vendor/SpreadsheetReader.php');
    $statement = $pdoconnection->prepare("SELECT * FROM esyatakip");
    $statement->execute();
    $result = $statement->fetchAll();
    $output = '';
    $output .= '
	<thead> 
    <tr>
     <th width="8%"><center>Cinsi</center></th>
     <th width="8%"><center>Miktar</center></th>
     <th width="8%"><center>Marka</center></th>
     <th width="8%"><center>Seri No</center></th>
     <th width="8%"><center>Çıkış Nedeni</center></th>
     <th width="5%"><center>İlgili Departman</center></th>
     <th width="2%"><center>Takip Sorumlusu</center></th>
     <th width="2%"><center>Tedarikçi</center></th>
     <th width="2%"><center>Durumu</center></th>
     <th width="2%"><center>Çıkış Tarihi</center></th>
     <th width="2%"><center>Beklenen Geliş</center></th>
     <th width="2%"><center>Geliş Tarihi</center></th>
     <th width="2%"><center>Güncelle</center></th>
    </tr>
       </thead>
  ';
  if($statement->rowCount() > 0)
  {
   foreach ($result as $row) {

   $output .= '
<tr>
    <td><center>' . $row["cinsi"] . '</center></td>
    <td><center>' . $row["miktar"] . '</center></td>
    <td><center>' . $row["marka"] . '</center></td>
    <td><center>' . $row["serino"] . '</center></td>
    <td><center>' . $row["cikisnedeni"] . '</center></td>
    <td><center>' . $row["ilgilidepartman"] . '</center></td>
    <td><center>' . $row["takipsorumlusu"] . '</center></td>
    <td><center>' . $row["tedarikcifirma"] . '</center></td>
    <td><center>' . $row["durumu"] . '</center></td>';

// Çıkış Tarihi
if (!empty($row["cikistarihi"]) && strtotime($row["cikistarihi"])) {
    $output .= '<td>' . date('d.m.Y', strtotime($row["cikistarihi"])) . '</td>';
} else {
    $output .= '<td>-</td>';
}

// Beklenen Geliş Tarihi
if (!empty($row["beklenengelistarihi"]) && strtotime($row["beklenengelistarihi"])) {
    $output .= '<td>' . date('d.m.Y', strtotime($row["beklenengelistarihi"])) . '</td>';
} else {
    $output .= '<td>-</td>';
}

// Geliş Tarihi
if (!empty($row["gelistarihi"]) && strtotime($row["gelistarihi"])) {
    $output .= '<td>' . date('d.m.Y', strtotime($row["gelistarihi"])) . '</td>';
} else {
    $output .= '<td>-</td>';
}

$output .= '<td><center><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></center></td>
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
    
    

        <div id="customerModal" class="modal fade">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h4 class="modal-title">Create New Records</h4>
        </div>
        <div class="modal-body">
                         
                          <label>Cinsi:</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="cinsi" id="cinsi" class="form-control">  
                          <br />  
                          <label>Miktar:</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="miktar" id="miktar" class="form-control">
                          <br />  
                          <label>Marka:</label>  
                          <input type="text" name="marka" id="marka"  class="form-control" >  
                          <br />  
                          <label>Seri No:</label>  
                          <input type="text"  name="serino" id="serino"  class="form-control" required >  
                          <br /> 
                         <label>Çıkış Nedeni:</label>  
                          <select name="cikisnedeni" id="cikisnedeni" name="cikisnedeni" class="form-control">
                          <option value="YIRTIK">YIRTIK</option>
                          <option value="KIRIK">KIRIK</option>
                          <option value="EMANET">EMANET</option>
                          <option value="BAKIM">BAKIM</option>
                          
                          </select>
                          <br />  
                        
                          <label>İlgili Departman</label>  
                          <select name="ilgilidepartman" id="ilgilidepartman" name="departman" class="form-control">
                          <option value="YÖNETİM KURULU">YÖNETİM KURULU</option>
                          <option value="ÖN BÜRO">ÖN BÜRO</option>
                          <option value="HOUSE KEEPING">HOUSE KEEPING</option>
                          <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                          <option value="MİSAFİR İLİŞKİLERİ">MİSAFİR İLİŞKİLERİ</option>
                          <option value="SERVİS">SERVİS</option>
                          <option value="GECE MÜDÜRÜ">GECE MÜDÜRÜ</option>
                          <option value="SATINALMA">SATINALMA</option>
                          <option value="MUHASEBE">MUHASEBE</option>
                          <option value="SATIŞ PAZARLAMA">SATIŞ PAZARLAMA</option>
                          <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                          <option value="BİLGİ İŞLEM">BİLGİ İŞLEM</option>
                          <option value="GENEL MÜDÜR">GENEL MÜDÜR</option>
                          <option value="GENEL KOORDİNATÖR">GENEL KOORDİNATÖR</option>
                          <option value="OPERASYON MÜDÜRÜ">OPERASYON MÜDÜRÜ</option>
                          <option value="KALİTE YÖNETİMİ">KALİTE YÖNETİMİ</option>
                          <option value="ANİMASYON EĞLENCE">ANİMASYON EĞLENCE</option>
                          <option value="MUTFAK">MUTFAK</option>
                          <option value="SERVİS">SERVİS</option>
                          <option value="GÜVENLİK">GÜVENLİK</option>
                          </select>
                          <br />  
                          
                          <label>Takip Sorumlusu</label>  
                          <select name="takipsorumlusu" id="takipsorumlusu" name="takipsorumlusu" class="form-control">
                          <option value="YÖNETİM KURULU">YÖNETİM KURULU</option>
                          <option value="ÖN BÜRO">ÖN BÜRO</option>
                          <option value="HOUSE KEEPING">HOUSE KEEPING</option>
                          <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                          <option value="MİSAFİR İLİŞKİLERİ">MİSAFİR İLİŞKİLERİ</option>
                          <option value="SERVİS">SERVİS</option>
                          <option value="GECE MÜDÜRÜ">GECE MÜDÜRÜ</option>
                          <option value="SATINALMA">SATINALMA</option>
                          <option value="MUHASEBE">MUHASEBE</option>
                          <option value="SATIŞ PAZARLAMA">SATIŞ PAZARLAMA</option>
                          <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                          <option value="BİLGİ İŞLEM">BİLGİ İŞLEM</option>
                          <option value="GENEL MÜDÜR">GENEL MÜDÜR</option>
                          <option value="GENEL KOORDİNATÖR">GENEL KOORDİNATÖR</option>
                          <option value="OPERASYON MÜDÜRÜ">OPERASYON MÜDÜRÜ</option>
                          <option value="KALİTE YÖNETİMİ">KALİTE YÖNETİMİ</option>
                          <option value="ANİMASYON EĞLENCE">ANİMASYON EĞLENCE</option>
                          <option value="MUTFAK">MUTFAK</option>
                          <option value="SERVİS">SERVİS</option>
                          <option value="GÜVENLİK">GÜVENLİK</option>
                          </select>
                          <br />  
                          <label>Tedarikci Firma:</label>  
                          <input type="text"  name="tedarikcifirma" id="tedarikcifirma"  class="form-control" required >
                          <br /> 
                          
                          <label>Durumu:</label>  
                          <select name="durumu" id="durumu" name="durumu" class="form-control">
                          <option value="ÇIKIŞI YAPILDI">ÇIKIŞI YAPILDI</option>
                          <option value="GİRİŞİ YAPILDI">GİRİŞİ YAPILDI</option>
                          </select>
                          <br />  
                          
                          <label>Çıkış Tarihi:</label>  
                          <input type="date"  name="cikistarihi" id="cikistarihi" class="form-control">
                          <br />  
                          
                          <label>Beklenen Geliş:</label>  
                          <input type="date"  name="beklenengelistarihi	" id="beklenengelistarihi"  class="form-control">
                          <br />  
                          
                          <label>Giriş Tarihi:</label>  
                          <input type="date"  name="gelistarihi	" id="gelistarihi" class="form-control">
                     

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
      
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
    
  });
  
  </script>
    
  <script>
 

 //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#cinsi').val(''); //This will clear Modal first name textbox
  $('#miktar').val(''); //This will clear Modal last name textbox
  $('#marka').val('');
  $('#serino').val('');
  $('#cikisnedeni').val('');
  $('#ilgilidepartman').val('');
  $('#takipsorumlusu').val('');
  $('#tedarikcifirma').val('');
  $('#durumu').val('');
  $('#cikistarihi').val('');
  $('#beklenengelistarihi').val('');
  $('#gelistarihi').val('');

  
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
  $('#action').val('Kayıt Ekle'); //This will reset Button value ot Create
 });

 $('#action').click(function(){
  var cinsi           = $('#cinsi').val(); 
  var miktar          = $('#miktar').val();
  var marka           = $('#marka').val();
  var serino          = $('#serino').val();
  var cikisnedeni     = $('#cikisnedeni').val();
  var ilgilidepartman = $('#ilgilidepartman').val();
  var takipsorumlusu  = $('#takipsorumlusu').val();
  var tedarikcifirma  = $('#tedarikcifirma').val();
  var durumu          = $('#durumu').val();
  var cikistarihi     = $('#cikistarihi').val();
  var beklenengelistarihi = $('#beklenengelistarihi').val();
  var gelistarihi     = $('#gelistarihi').val();
  var id              = $('#employee_id').val(); 
  var action          = $('#action').val();
  if(cinsi != '') 
  {
   $.ajax({
    url : "actionesyatakip.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{cinsi:cinsi, miktar:miktar, marka:marka, serino:serino, cikisnedeni:cikisnedeni, ilgilidepartman:ilgilidepartman, takipsorumlusu:takipsorumlusu, tedarikcifirma:tedarikcifirma, durumu:durumu, cikistarihi:cikistarihi, beklenengelistarihi:beklenengelistarihi, gelistarihi:gelistarihi, employee_id:id, action:action}, //Send data to server
    success:function(data){
     $('#customerModal').modal('hide');
     location.reload(true);
     fetchUser();   
    }

   });
  }
  else
  {
   alert("İsim Alanı Boş Geçilemez!"); //If both or any one of the variable has no value them it will display this message
  }
 });

 //This JQuery code is for Update customer data. If we have click on any customer row update button then this code will execute
 $(document).on('click', '.update', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  var action = "Select";   //We have define action variable value is equal to select
  $.ajax({
   url:"actionesyatakip.php",   //Request send to "action.php page"
   method:"POST",    //Using of Post method for send data
   data:{employee_id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#customerModal').appendTo("body").modal('show');   //It will display modal on webpage
    $('.modal-title').text("Kullanıcı Güncelle"); //This code will change this class text to Update records
    $('#action').val("Güncelle");     //This code will change Button value to Update
    
    $('#employee_id').val(id);
    $('#cinsi').val(data.cinsi);
    $('#marka').val(data.marka);
    $('#serino').val(data.serino);
    $('#cikisnedeni').val(data.cikisnedeni);
    $('#ilgilidepartman').val(data.ilgilidepartman);
    $('#takipsorumlusu').val(data.takipsorumlusu);
    $('#tedarikcifirma').val(data.tedarikcifirma);
    $('#durumu').val(data.durumu);
    $('#cikistarihi').val(data.cikistarihi);
    $('#beklenengelistarihi').val(data.beklenengelistarihi);
    $('#gelistarihi').val(data.gelistarihi);
    
   }
  });
  
 });
 

 //This JQuery code is for Delete customer data. If we have click on any customer row delete button then this code will execute
 $(document).on('click', '.delete', function(){
  var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
  if(confirm("Kullanıcıyı Silmek İstediğinize Emin Misiniz?")) //Confim Box if OK then
  {
   var action = "Delete"; //Define action variable value Delete
   $.ajax({
    url:"actionesyatakip.php",    //Request send to "action.php page"
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