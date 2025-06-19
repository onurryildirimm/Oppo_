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
                                <h4 class="mb-sm-0">Tedarikçi Ekleme Formu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Tedarikçi Ekleme Formu</li>
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
                            
    <?php if($user["magaza"] == "KALİTE YÖNETİMİ" || $user["magaza"] == "SATINALMA" || $user["role"] == "admin" || $user["role"] == "user" || $user["role"] == "midadmin") {
  echo '
    <button type="button" id="modal_button" class="btn btn-info">Manuel Kayıt Ekle</button>
    <br/><br/>
    Veya
     <br/><br/>
    <div class="form-container">
    <form action="tedarikci_veri_aktar.php" method="POST" enctype="multipart/form-data">
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


$statement = $pdoconnection->prepare("SELECT * FROM tedarikcilistesi ORDER BY id ASC");
$statement->execute();
$result = $statement->fetchAll();
$output = '';

// Tablo başlığını ve açılış etiketini burada açın
$output .= '
    
    <thead> 
    <tr>
     <th width="14%">Tedarikçi Adı</th>
     <th width="14%">Adresi</th>
     <th width="6%">İlçe</th>
     <th width="6%">İl</th>
     <th width="10%">Yetkili</th>
     <th width="10%">Mail</th>
     <th width="9%">Telefon</th>
     <th width="25%">Ürün Grubu</th>
     <th width="5%">Güncelle</th>
    </tr>
    </thead>
';

if ($statement->rowCount() > 0) {
    foreach ($result as $row) {
        $output .= '
        <tr>
         <td>'.$row["tedarikciadi"].'</td>
         <td>'.$row["adresi"].'</td>
         <td>'.$row["ilce"].'</td>
         <td>'.$row["il"].'</td>
         <td>'.$row["yetkiliadi"].'</td>
         <td>'.$row["mail"].'</td>
         <td>'.$row["telefon"].'</td>
         <td>'.$row["urungrubu"].'</td>
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
                          <input type="text" onkeyup="value=value.toUpperCase();" name="tedarikciadi" id="tedarikciadi" class="form-control">  
                          <br />  
                          <label>Adres</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="adresi" id="adresi" class="form-control">  
                          <br />  
                          <label>İlçe</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="ilce" id="ilce" class="form-control">  
                          <br /> 
                          <label>İl</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="il" id="il" class="form-control">  
                          <br /> 
                          <label>Yetkili Adı</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="yetkiliadi" id="yetkiliadi" class="form-control">  
                          <br /> 
                          <label>Mail</label>  
                          <input type="text" oninput="kucukHarfeDonustur(this)" name="mail" id="mail" class="form-control">
                          <script>
function kucukHarfeDonustur(input) {
    input.value = input.value.toLowerCase();
}
</script>
                          <br /> 
                          <label>Telefon</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="telefon" id="telefon" class="form-control">  
                          <br /> 
                          
                           <label>Tedarik Sağladığı Ürünler:</label><br/>
<input type="text" id="aramaKutusu" placeholder="Ürün ara...">
<br/><br/>

<?php 

$query = "SELECT * FROM urungrubu";
$stmt = $connection->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-md-6">
        <?php 
        $rowCount = count($rows);
        for ($i = 0; $i < $rowCount / 2; $i++) {
            $row = $rows[$i];
        ?>
            <div class="urunSatiri">
                <input type="checkbox" name="urungrubu[]" value="<?php echo $row['urungrubu2']; ?>" /> 
                <span class="urunAdi"><?php echo $row['urungrubu2']; ?></span><br>
            </div>
        <?php
        }
        ?>
    </div>

    <div class="col-md-6">
        <?php 
        for ($i = $rowCount / 2; $i < $rowCount; $i++) {
            $row = $rows[$i];
        ?>
            <div class="urunSatiri">
                <input type="checkbox" name="urungrubu[]" value="<?php echo $row['urungrubu2']; ?>" /> 
                <span class="urunAdi"><?php echo $row['urungrubu2']; ?></span><br>
            </div>
        <?php
        }
        ?>
    </div>
</div>
<br/>

<script>
document.getElementById('aramaKutusu').addEventListener('input', function() {
    var aramaKelimesi = this.value.toLowerCase();
    
    var urunSatirlari = document.getElementsByClassName('urunSatiri');
    
    filtrele(urunSatirlari, aramaKelimesi);
});

function filtrele(urunSatirlari, aramaKelimesi) {
    for (var i = 0; i < urunSatirlari.length; i++) {
        var urunAdi = urunSatirlari[i].getElementsByClassName('urunAdi')[0].innerText.toLowerCase();
        
        if (urunAdi.includes(aramaKelimesi)) {
            urunSatirlari[i].style.display = 'block';
        } else {
            urunSatirlari[i].style.display = 'none';
        }
    }
}
</script>

                        
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
  $('#adresi').val(''); //This will clear Modal last name textbox
  $('#ilce').val('');
  $('#il').val('');
  $('#yetkiliadi').val('');
  $('#mail').val('');
  $('#telefon').val('');
  $('#urungrubu').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var tedarikciadi = $('#tedarikciadi').val();
  var adresi       = $('#adresi').val();
  var ilce         = $('#ilce').val();
  var il           = $('#il').val();
  var yetkiliadi   = $('#yetkiliadi').val();
  var mail         = $('#mail').val();
  var telefon      = $('#telefon').val();
  var urungrubu    = [];
  $('input[name="urungrubu[]"]:checked').each(function() {
    urungrubu.push($(this).val());
  });
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('tedarikciadi', tedarikciadi);
  formData.append('adresi', adresi);
  formData.append('ilce', ilce);
  formData.append('il', il);
  formData.append('yetkiliadi', yetkiliadi);
  formData.append('mail', mail);
  formData.append('telefon', telefon);
  formData.append('urungrubu', JSON.stringify(urungrubu));
  formData.append('employee_id', id);
  formData.append('action', action);

  // Boş bir dosya ekleyerek, "pdf[]" anahtarını FormData nesnesine ekleriz.
  formData.append('pdf[]', new File([], ''));

 

  if (tedarikciadi != '' ) {
    $.ajax({
      url: "actiontedarikci.php",
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
  form_data.append("adresi", $("#adresi").val());
  form_data.append("ilce", $("#ilce").val());
  form_data.append("il", $("#il").val());
  form_data.append("yetkiliadi", $("#yetkiliadi").val());
  form_data.append("mail", $("#mail").val());
  form_data.append("telefon", $("#telefon").val());
  form_data.append("urungrubu", JSON.stringify($("input[name='urungrubu[]']:checked").map(function(){
    return $(this).val();
  }).get()));

  $.ajax({
    url:"actiontedarikci.php",   
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
      $('#adresi').val(data.adresi);
      $('#ilce').val(data.ilce);
      $('#il').val(data.il);
      $('#yetkiliadi').val(data.yetkiliadi);
      $('#mail').val(data.mail);
      $('#telefon').val(data.telefon);
      
      var urungrubu = data.urungrubu;
      // İlgili departman personeli ve yönetim kadrosu dışındaki tüm kullanıcıları seçili yapın
      $('input[name="urungrubu[]"]').prop('checked', false); // Tüm checkboxları işaretsiz yapın
      for (var i = 0; i < urungrubu.length; i++) {
        $('input[name="urungrubu[]"][value="' + urungrubu[i] + '"]').prop('checked', true); // Seçili olan checkboxları işaretleyin
      }
      
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