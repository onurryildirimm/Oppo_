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
                                <h4 class="mb-sm-0">Tedarikçi Belirleme Formu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Tedarikçi Belirleme Formu</li>
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
                                        

    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    
<?php


$statement = $pdoconnection->prepare("SELECT * FROM tedarikcilistesi ORDER BY id DESC");
$statement->execute();
$result = $statement->fetchAll();
$output = '';

// Tablo başlığını ve açılış etiketini burada açın
$output .= '
    
    <thead> 
    <tr>
     <th width="14%">Tedarikçi Adı</th>
     <th width="14%">Ürün Grubu</th>
     <th width="8%">Fiyat Politikası</th>
     <th width="8%">Malzeme/Hizmet Özellikleri</th>
     <th width="8%">Tahsilat Politikası Ve Ödeme Kolaylıkları</th>
     <th width="10%">İş Programına Uygun Çalışma Yeteneği</th>
     <th width="10%">Benzer İş Bitirme Özelliği/Referanslar</th>
     <th width="10%">Kalite/Çevre/HACCP Sertifikası</th>
     <th width="10%">Mali Gücü</th>
     <th width="10%">Risk Karşılayabilme Yeteneği/Mal ve Hizmet Garantileri</th>
     <th width="8%">Çevresel Değerlendirme</th>
     <th width="8%">Statü</th>
     <th width="10%">Açıklama</th>
     <th width="5%">Güncelle</th>
    </tr>
    </thead>
';

if ($statement->rowCount() > 0) {
    foreach ($result as $row) {
        $urungrubu = (!empty($row["urungrubu"]) && $row["urungrubu"] !== "undefined") ? $row["urungrubu"] : 'Ürün grubu seçilmemiş';

        $output .= '
        <tr>
         <td>'.$row["tedarikciadi"].'</td>
         <td>'.$urungrubu.'</td>
         <td>'.$row["fiyat"].'</td>
         <td>'.$row["urunhizmetkalitesi"].'</td>
         <td>'.$row["odemevadesi"].'</td>
         <td>'.$row["calismayetenegi"].'</td>
         <td>'.$row["referanslar"].'</td>
         <td>'.$row["firmabelgedurumu"].'</td>
         <td>'.$row["maliguc"].'</td>
         <td>'.$row["risk"].'</td>
         <td>'.$row["cevreseldegerleme"].'</td>
         <td>'.$row["statu"].'</td>
         <td>'.$row["aciklama"].'</td>
         <td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Güncelle</button></td>
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
                          
                          <label>Tedarikçi Adı</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="tedarikciadi" id="tedarikciadi" class="form-control" readonly/>  
                          <br />  
                          <label>Fiyat Politikası</label>
                          <select name="fiyat" id="fiyat" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Malzeme/Hizmet Özellikleri</label>
                          <select name="urunhizmetkalitesi" id="urunhizmetkalitesi" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Tahsilat Politikası Ve Ödeme Kolaylıkları</label>
                          <select name="odemevadesi" id="odemevadesi" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>İş Programına Uygun Çalışma Yeteneği</label>
                          <select name="calismayetenegi" id="calismayetenegi" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Benzer İş Bitirme Özelliği/Referanslar</label>
                          <select name="referanslar" id="referanslar" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Kalite/Çevre/HACCP Sertifikası</label>
                          <select name="firmabelgedurumu" id="firmabelgedurumu" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Mali Gücü</label>
                          <select name="maliguc" id="maliguc" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Risk Karşılayabilme Yeteneği/Mal ve Hizmet Garantileri</label>
                          <select name="risk" id="risk" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Çevresel Değerlendirme</label>
                          <select name="cevreseldegerleme" id="cevreseldegerleme" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="KABUL">KABUL</option>
                          <option value="RED">RED</option>
                          </select>
                          <br />  
                          <label>Statü</label>
                          <select name="statu" id="statu" class="form-control">
                          <option value="">Lütfen Seçiniz</option>
                          <option value="ONAYLI SATICI">ONAYLI SATICI</option>
                          <option value="ONAYSIZ SATICI">ONAYSIZ SATICI</option>
                
                          </select>
                          <br />  
                          <label>Açıklama</label>  
                          <input type="text-area" onkeyup="value=value.toUpperCase();" name="aciklama" id="aciklama" class="form-control" >  
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
  $('#tedarikciadi').val(''); //This will clear Modal first name textbox
  $('#urungrubu').val('');
  $('#fiyat').val('');
  $('#urunhizmetkalitesi').val('');
  $('#odemevadesi').val('');
  $('#calismayetenegi').val('');
  $('#referanslar').val('');
  $('#firmabelgedurumu').val('');
  $('#maliguc').val('');
  $('#risk').val('');
  $('#cevreseldegerleme').val('');
  $('#statu').val('');
  $('#aciklama').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var tedarikciadi          = $('#tedarikciadi').val();
  
  var fiyat                 = $('#fiyat').val();
  var urunhizmetkalitesi    = $('#urunhizmetkalitesi').val();
  var odemevadesi           = $('#odemevadesi').val();
  var calismayetenegi       = $('#calismayetenegi').val();
  var referanslar           = $('#referanslar').val();
  var firmabelgedurumu      = $('#firmabelgedurumu').val();
  var maliguc               = $('#maliguc').val();
  var risk                  = $('#risk').val();
  var cevreseldegerleme     = $('#cevreseldegerleme').val();
  var statu                 = $('#statu').val();
  var aciklama              = $('#aciklama').val();
  var id                    = $('#employee_id').val();
  var action                = $('#action').val();
  var formData = new FormData();
  formData.append('tedarikciadi', tedarikciadi);
  
  formData.append('fiyat', fiyat);
  formData.append('odemevadesi', odemevadesi);
  formData.append('calismayetenegi', calismayetenegi);
  formData.append('referanslar', referanslar);
  formData.append('firmabelgedurumu', firmabelgedurumu);
  formData.append('maliguc', maliguc);
  formData.append('risk', risk);
  formData.append('cevreseldegerleme', cevreseldegerleme);
  formData.append('statu', statu);
  formData.append('aciklama', aciklama);
  formData.append('employee_id', id);
  formData.append('action', action);

  // Boş bir dosya ekleyerek, "pdf[]" anahtarını FormData nesnesine ekleriz.
  formData.append('pdf[]', new File([], ''));

 

  if (tedarikciadi != '' ) {
    $.ajax({
      url: "actiontedarikcibelirleme.php",
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
  form_data.append("tedarikciadi", $("#tedarikciadi").val());
  form_data.append("urungrubu", $("#urungrubu").val());
  form_data.append("fiyat", $("#fiyat").val());
  form_data.append("odemevadesi", $("#odemevadesi").val());
  form_data.append("calismayetenegi", $("#calismayetenegi").val());
  form_data.append("referanslar", $("#referanslar").val());
  form_data.append("firmabelgedurumu", $("#firmabelgedurumu").val());
  form_data.append("maliguc", $("#maliguc").val());
  form_data.append("risk", $("#risk").val());
  form_data.append("cevreseldegerleme", $("#cevreseldegerleme").val());
  form_data.append("statu", $("#statu").val());
  form_data.append("aciklama", $("#aciklama").val());
  

  $.ajax({
    url:"actiontedarikcibelirleme.php",   
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
      $('#tedarikciadi').val(data.tedarikciadi);
      $('#urungrubu').val(data.urungrubu);
      $('#fiyat').val(data.fiyat);
      $('#odemevadesi').val(data.odemevadesi);
      $('#calismayetenegi').val(data.calismayetenegi);
      $('#referanslar').val(data.referanslar);
      $('#odemevadesi').val(data.odemevadesi);
      $('#firmabelgedurumu').val(data.firmabelgedurumu);
      $('#maliguc').val(data.maliguc);
      $('#risk').val(data.risk);
      $('#cevreseldegerleme').val(data.cevreseldegerleme);
      $('#statu').val(data.statu);
      $('#aciklama').val(data.aciklama);
      
      
      
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
    url:"actiontedarikcibelirleme.php",    //Request send to "action.php page"
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