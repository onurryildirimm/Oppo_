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
                                <h4 class="mb-sm-0">Devam Eden İşler</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Devam Eden İşler</li>
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
   ?>
   </div>
     <br />
                                     <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
   <?php 
   
   $statement = $pdoconnection->prepare("SELECT * FROM isler WHERE durumu = 'DEVAM EDİYOR' ORDER BY id DESC LIMIT 500");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   
	<thead> 
    <tr>
     <th width="5%">No</th>
     <th width="8%">Tarih</th>
     <th width="8%">Gündem</th>
     <th width="8%">Gündeme Getiren</th>
     <th width="20%">Alınan Karar</th>
     <th width="8%">Sorumlu Departman</th>
     <th width="8%">Termin Tarihi</th>
     <th width="8%">Kontrol Sorumlusu</th>
     <th width="30%">Sonuç Açıklama</th>
     <th width="8%">Durumu</th>
     
     <th width="10%">Güncelle</th>
    
    </tr>
       </thead>
  ';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
       
    $output .= '
    <tr>
     <td>'.$row["id"].'</td>
     <td>'.date('d.m.Y', strtotime($row["tarih"])).'</td>
     <td>'.$row["gundem"].'</td>
     <td>'.$row["gundemegetiren"].'</td>
     <td>'.$row["alinankarar"].'</td>
     <td>'.$row["sorumludepartman"].'</td>
     <td>'.date('d.m.Y', strtotime($row["termintarihi"])).'</td>
     <td>'.$row["kontrolsorumlusu"].'</td>
     <td>'.$row["sonucaciklama"].'</td>
     <td>'.$row["durumu"].'</td>
     
     <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Güncelle</button></td>

     
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
    <h4 class="modal-title">Create New Records</h4>
   </div>
   <div class="modal-body">
                          <label>Tarih</label>  
                          <input type="date" name="tarih" id="tarih" class="form-control" />  
                          <br />  
                          <label>Gündem</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="gundem" id="gundem" class="form-control">  
                          <br />  
                          <label>Gündeme Getiren</label>  
                          <select name="gundemegetiren" id="gundemegetiren" class="form-control">  
                               <option value="GENEL MÜDÜR">GENEL MÜDÜR</option>
                               <option value="OPERASYON MÜDÜRÜ">OPERASYON MÜDÜRÜ</option> 
                               <option value="ANİMASYON">ANİMASYON</option>
                               <option value="MUHASEBE">MUHASEBE</option>
                               <option value="SATIN ALMA">SATIN ALMA</option> 
                               <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                               <option value="SERVİS">SERVİS</option>
                               <option value="HOUSE KEEPING">HOUSE KEEPING</option>
                               <option value="SPA & HAMAM">SPA & HAMAM</option>
                               <option value="BİLGİ İŞLEM">BİLGİ İŞLEM</option>
                               <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                               <option value="ÖN BÜRO">ÖN BÜRO</option>
                               <option value="GUEST RELATIONS">GUEST RELATIONS</option>
                               <option value="KALİTE YÖNETİMİ">KALİTE YÖNETİMİ</option>
                               <option value="DANIŞMA">DANIŞMA</option>
                               <option value="MUTFAK">MUTFAK</option>
                               <option value="SATIŞ PAZARLAMA">SATIŞ PAZARLAMA</option>
                          </select> 
                          <br />  
                          <label>Alınan Karar</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="alinankarar" id="alinankarar"  class="form-control" >  
                          <br />  
                          <label>Sorumlu Departman</label>  
                          <select name="sorumludepartman" id="sorumludepartman" class="form-control">  
                               <option value="GENEL MÜDÜR">GENEL MÜDÜR</option> 
                               <option value="OPERASYON MÜDÜRÜ">OPERASYON MÜDÜRÜ</option> 
                               <option value="ANİMASYON">ANİMASYON</option>
                               <option value="MUHASEBE">MUHASEBE</option>
                               <option value="SATIN ALMA">SATIN ALMA</option> 
                               <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                               <option value="SERVİS">SERVİS</option>
                               <option value="HOUSE KEEPING">HOUSE KEEPING</option>
                               <option value="SPA HAMAM">SPA & HAMAM</option>
                               <option value="BİLGİ İŞLEM">BİLGİ İŞLEM</option>
                               <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                               <option value="ÖN BÜRO">ÖN BÜRO</option>
                               <option value="GENEL">GENEL</option>
                               <option value="GUEST RELATIONS">GUEST RELATIONS</option>
                               <option value="KALİTE YÖNETİMİ">KALİTE YÖNETİMİ</option>
                               <option value="DANIŞMA">DANIŞMA</option>
                               <option value="MUTFAK">MUTFAK</option>
                               <option value="SATIŞ PAZARLAMA">SATIŞ PAZARLAMA</option>
                          </select> 
                          <br />  
                         <label>Termin Tarihi</label>  
                          <input type="date" name="termintarihi" id="termintarihi" class="form-control" />  
                          <br />  
                         <label>Kontrol Sorumlusu</label>  
                          <select name="kontrolsorumlusu" id="kontrolsorumlusu" class="form-control">  
                               <option value="GENEL MÜDÜR">GENEL MÜDÜR</option>
                               <option value="OPERASYON MÜDÜRÜ">OPERASYON MÜDÜRÜ</option> 
                               <option value="ANİMASYON">ANİMASYON</option>
                               <option value="MUHASEBE">MUHASEBE</option>
                               <option value="SATIN ALMA">SATIN ALMA</option> 
                               <option value="TEKNİK SERVİS">TEKNİK SERVİS</option>
                               <option value="SERVİS">SERVİS</option>
                               <option value="HOUSE KEEPING">HOUSE KEEPING</option>
                               <option value="SPA HAMAM">SPA & HAMAM</option>
                               <option value="BİLGİ İŞLEM">BİLGİ İŞLEM</option>
                               <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                               <option value="ÖN BÜRO">ÖN BÜRO</option>
                               <option value="GUEST RELATIONS">GUEST RELATIONS</option>
                               <option value="KALİTE YÖNETİMİ">KALİTE YÖNETİMİ</option>
                               <option value="DANIŞMA">DANIŞMA</option>
                               <option value="MUTFAK">MUTFAK</option>
                               <option value="SATIŞ PAZARLAMA">SATIŞ PAZARLAMA</option>
                          </select> 
                          <br /> 
                          <label>Sonuç Açıklama</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="sonucaciklama" id="sonucaciklama" class="form-control">  
                          <br />
                          <label>Durumu</label>  
                          <select name="durumu" id="durumu" class="form-control">  
                               <option value="DEVAM EDİYOR">DEVAM EDİYOR</option> 
                               <option value="TAMAMLANDI">TAMAMLANDI</option> 
                               
                          </select> 
                          <br />  
                          <label>Kapanış Tarihi</label>  
                          <input type="date" name="kapanistarihi" id="kapanistarihi" class="form-control" value="" />  
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

 });
    </script>
    
    <script>
        //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
  $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
  $('#tarih').val(''); //This will clear Modal first name textbox
  $('#gundem').val(''); //This will clear Modal last name textbox
  $('#gundemegetiren').val('');
  $('#alinankarar').val('');
  $('#sorumludepartman').val('');
  $('#termintarihi').val('');
  $('#kontrolsorumlusu').val('');
  $('#sonucaciklama').val('');
  
  $('#kapanistarihi').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
  $('#action').val('Kayıt Ekle'); //This will reset Button value ot Create

 });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
     $('#customerModal').modal('hide'); // Modal penceresini kapat
     location.reload(true); // Sayfanın tamamen yenilenmesi
  var tarih             = $('#tarih').val(); 
  var gundem            = $('#gundem').val();
  var gundemegetiren    = $('#gundemegetiren').val();
  var alinankarar       = $('#alinankarar').val();
  var sorumludepartman  = $('#sorumludepartman').val();
  var termintarihi      = $('#termintarihi').val();
  var kontrolsorumlusu  = $('#kontrolsorumlusu').val();
  var sonucaciklama     = $('#sonucaciklama').val();
  var durumu            = $('#durumu').val();
  var kapanistarihi     = $('#kapanistarihi').val();
  var id                = $('#employee_id').val();  //Get the value of hidden field customer id
  var action        = $('#action').val();  //Get the value of Modal Action button and stored into action variable
  if(tarih != '' && gundem != '') //This condition will check both variable has some value
  {
   $.ajax({
    url : "actionis.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{tarih:tarih, gundem:gundem, gundemegetiren:gundemegetiren, alinankarar:alinankarar, sorumludepartman:sorumludepartman, termintarihi:termintarihi, kontrolsorumlusu:kontrolsorumlusu, sonucaciklama:sonucaciklama, durumu:durumu, kapanistarihi:kapanistarihi, employee_id:id, action:action}, //Send data to server
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
   url:"actionis.php",   //Request send to "action.php page"
   method:"POST",    //Using of Post method for send data
   data:{employee_id:id, action:action},//Send data to server
   dataType:"json",   //Here we have define json data type, so server will send data in json format.
   success:function(data){
    $('#customerModal').appendTo("body").modal('show');   //It will display modal on webpage
    $('.modal-title').text("Kayıt Güncelle"); //This code will change this class text to Update records
    $('#action').val("Güncelle");     //This code will change Button value to Update
    
    $('#employee_id').val(id);
    $('#tarih').val(data.tarih);
    $('#gundem').val(data.gundem);
    $('#gundemegetiren').val(data.gundemegetiren);
    $('#alinankarar').val(data.alinankarar);
    $('#sorumludepartman').val(data.sorumludepartman);
    $('#termintarihi').val(data.termintarihi);
    $('#kontrolsorumlusu').val(data.kontrolsorumlusu);
    $('#sonucaciklama').val(data.sonucaciklama);
    $('#durumu').val(data.durumu);
    $('#kapanistarihi').val(data.kapanistarihi);
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