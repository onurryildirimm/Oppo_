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
                                <h4 class="mb-sm-0">Ürün Tanımlama Formu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Ürün Tanımlama Formu</li>
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
    <form action="aracekle_veri_aktar.php" method="POST" enctype="multipart/form-data">
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



   
  $statement = $pdoconnection->prepare("SELECT * FROM urunekle ORDER BY id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   
	<thead> 
    <tr>
     <th width="15%">Ürün</th>
     <th width="15%">Grubu</th>
     <th width="15%">Ambalaj Miktarı</th>
     <th width="15%">Birim</th>
     <th width="15%">Marka</th>
     <th width="15%">Tedarikçi</th>
     <th width="5%">Güncelle</th>
    
    </tr>
       </thead>
  ';
  
  if($statement->rowCount() > 0)
{
   foreach($result as $row)
   {
       $pdfLinks = explode(",", $row["pdf"]); // pdf yollarını virgülle ayırarak diziye aktar
       $pdfLinksHTML = "";
       foreach($pdfLinks as $pdfLink){
            if(!empty($pdfLink)){
                $pdfLinksHTML .= '<a href="'.$pdfLink.'"><i class="fa fa-file-pdf-o" style="font-size:24px;color:red"></i></a>';
            }
       }
       if(empty($pdfLinksHTML)) {
            $pdfLinksHTML = "Form Yüklenmemiş";
       }
       $output .= '
        <tr>
         <td>'.$row["urun"].'</td>
         <td>'.$row["grup"].'</td>
         <td>'.$row["ambalajmiktari"].'</td>
         <td>'.$row["birim"].'</td>
         <td>'.$row["marka"].'</td>
         <td>'.$row["firma"].'</td>
              
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
    <h4 class="modal-title">Yeni Kayıt Oluştur</h4>
   </div>
   <div class="modal-body">
                          <label>Ürün</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="urun" id="urun" class="form-control">  
                          <br />  
                          <label>Ürün Grubu</label>  
                          <select name="grup" id="grup" class="form-control" onchange="grupSecildi()">
                          <?php
                          $username = 'homeandf_onur';
                          $password = '354472Onur';

                          try {
                   
                          $pdoconnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          } catch (PDOException $e) {
                          die("Veritabanı bağlantısı başarısız: " . $e->getMessage());
                          }
                          $statement = $pdoconnection->prepare("SELECT * FROM urungrubu ORDER BY id DESC");
                          $statement->execute();
                          while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                          echo "<option value=\"{$row['urungrubu2']}\">{$row['urungrubu2']}</option>";
                          }
                          ?>
                          
                          </select>
                          <br />  
                          <label>Ambalaj Mikratı</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="ambalajmiktari" id="ambalajmiktari" class="form-control">  
                          <br />  
                          <label>Birim</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="birim" id="birim" class="form-control">
                          <br />
                          <label>Marka</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="marka" id="marka" class="form-control">
                           <br />
                          <label>Tedarikçi Firma</label>
                          <select name="firma" id="firma" class="form-control">
                          <!-- Tedarikçi firmaları ürün grubuna göre dinamik olarak doldurulacak -->
                          </select>
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
function grupSecildi() {
    // Seçilen grup değerini alın
    var secilenGrup = document.getElementById("grup").value;

    // AJAX isteği göndererek ilgili tedarikçileri çekin
    $.ajax({
        url: "getTedarikciler.php", // Tedarikçileri getirecek PHP dosyasının adı
        method: "POST",
        data: { secilenGrup: secilenGrup }, // Seçilen grup değerini gönderin
        success: function(data) {
            // Veritabanından gelen tedarikçileri işleyin
            var tedarikciler = JSON.parse(data);

            // <select> öğesini hedefleyin
            var selectFirma = document.getElementById("firma");

            // <select> öğesini temizleyin
            selectFirma.innerHTML = "";

            // Veritabanından gelen tedarikçileri <select> öğesine ekleyin
            for (var i = 0; i < tedarikciler.length; i++) {
                var option = document.createElement("option");
                option.value = tedarikciler[i].tedarikciadi; // Tedarikçi adı
                option.text = tedarikciler[i].tedarikciadi; // Tedarikçi adı
                selectFirma.appendChild(option);
            }
            console.log(data);
        }
    });
}


</script>

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
  $('#urun').val(''); //This will clear Modal first name textbox
  $('#grup').val(''); //This will clear Modal last name textbox
  $('#ambalajmiktari').val('');
  $('#birim').val('');
  $('#marka').val('');
  $('#firma').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
  $('#action').val('Kayıt Ekle'); //This will reset Button value ot Create

 });

 //This JQuery code is for Click on Modal action button for Create new records or Update existing records. This code will use for both Create and Update of data through modal
 $('#action').click(function(){
     $('#customerModal').modal('hide'); // Modal penceresini kapat
     location.reload(true); // Sayfanın tamamen yenilenmesi
  var urun              = $('#urun').val(); 
  var grup              = $('#grup').val();
  var ambalajmiktari    = $('#ambalajmiktari').val();
  var birim             = $('#birim').val();
  var marka             = $('#marka').val();
  var firma             = $('#firma').val();
  var id                = $('#employee_id').val();  //Get the value of hidden field customer id
  var action        = $('#action').val();  //Get the value of Modal Action button and stored into action variable
  if(urun != '' && grup != '') //This condition will check both variable has some value
  {
   $.ajax({
    url : "actionurunekle.php",    //Request send to "action.php page"
    method:"POST",     //Using of Post method for send data
    data:{urun:urun, grup:grup, ambalajmiktari:ambalajmiktari, birim:birim, marka:marka, firma:firma, employee_id:id, action:action}, //Send data to server
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
    var id = $(this).attr("id"); // Modalı açacak veriyi alın
    var action = "Select";
    $.ajax({
        url: "actionurunekle.php",
        method: "POST",
        data: { employee_id: id, action: action },
        dataType: "json",
        success: function(data) {
            $('#customerModal').modal('show');
            $('.modal-title').text("Kayıt Güncelle");
            $('#action').val("Güncelle");
            $('#employee_id').val(id);
            $('#urun').val(data.urun);
            $('#grup').val(data.grup);
            $('#ambalajmiktari').val(data.ambalajmiktari);
            $('#birim').val(data.birim);
            $('#marka').val(data.marka);
            $('#firma').val(data.firma);
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