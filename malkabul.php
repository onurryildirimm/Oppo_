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
                                <h4 class="mb-sm-0">Mal Kabul Formu</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Mal Kabul Formu</li>
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
                            
    <?php if($user["departman"] == "KALİTE YÖNETİMİ" || $user["departman"] == "SATINALMA" || $user["departman"] == "BİLGİ İŞLEM") {
  echo '
    <button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>
    <br/>
  '; }
   ?>
    
   </div>
   <br />

    <div class="responsive">
	<table class="table table-striped table-bordered" id="employee_data">
	    
<?php

$statement = $pdoconnection->prepare("SELECT * FROM malkabul ORDER BY id DESC");
$statement->execute();
$result = $statement->fetchAll();
  $output = '';
  $output .= '
   
	<thead> 
    <tr>
     <th width="10%">Tarih</th>
     <th width="15%">Kabul Saati</th>
     <th width="15%">Ürün</th>
     <th width="10%">Tedarikçi</th>
     <th width="10%">Marka</th>
     <th width="10%">Parti No</th>
     <th width="10%">SKT</th>
     <th width="10%">Ürün Sıcaklık</th>
     <th width="10%">Araç Sıcaklık</th>
     <th width="10%">Araç Temizlik</th>
     <th width="10%">Ambalaj Temizlik</th>
     <th width="10%">Kabul Durumu</th>
     <th width="10%">Açıklama</th>
     <th width="10%">Kabul Yapan</th>
     <th width="10%">Güncelle</th>
    </tr>
       </thead>
  ';
  
  if($statement->rowCount() > 0)
{
   foreach($result as $row)
   {
       $pdfLinks = explode(",", $row["pdf"]); 
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
    <td>'.(!empty($row["tarih"]) ? date('d.m.Y', strtotime($row["tarih"])) : "-").'</td>
    <td>'.$row["saat"].'</td>
    <td>'.$row["urun"].'</td>
    <td>'.$row["tedarikci"].'</td>
    <td>'.$row["marka"].'</td>
    <td>'.$row["partino"].'</td>
    <td>'.(!empty($row["skt"]) ? date('d.m.Y', strtotime($row["skt"])) : "-").'</td>
    <td>'.$row["urunsicaklik"].'</td>
    <td>'.$row["aracsicaklik"].' </td>
    <td>'.$row["aractemizlik"].'</td>
    <td>'.$row["ambalajtemizlik"].'</td>
    <td>'.$row["kabuldurumu"].'</td>
    <td>'.$row["aciklama"].'</td>
    <td>'.$row["kabulyapan"].'</td>
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
                          
                          <label>Tarih</label>  
                          <input type="date" onkeyup="value=value.toUpperCase();" name="tarih" id="tarih" class="form-control">  
                          <br />  
                          <?php
    // Şu anki saat ve dakika bilgisini al
    $currentHour = date('H');
    $currentMinute = date('i');
    ?>
                          
                          <label for="saat">Saat:</label>
    <input type="time" name="saat" id="saat" class="form-control" value="<?php echo $currentHour . ':' . $currentMinute; ?>" readonly/>  
                          <br />  
                          
                           <label for="urun">Ürün</label>
<div class="input-group">
  <input type="text" name="urun_arama" id="urun_arama" class="form-control" placeholder="Ürün ara..." />
  <div class="input-group-append">
    <button class="btn btn-secondary" type="button" onclick="urunAra()">Ara</button>
  </div>
</div>

<select name="urun" id="urun" class="form-control">
  <option value="">Lütfen Seçiniz</option>
  <?php
    // Veritabanı bağlantısı oluşturma
  
    // Ürünleri listele
    $urunler = getUrunList($pdoconnection);
// Verileri option etiketleri olarak görüntüle
    foreach ($urunler as $urun) {
        echo "<option value='" . $urun["urun"] . "'>" . $urun["urun"] . "</option>";
    }
      // Veritabanı bağlantısını kapat
    $pdoconnection = null;
    
  ?>
</select>

<script>
function urunAra() {
  var urunAramaKelimesi = document.getElementById("urun_arama").value.toLowerCase();
  var urunDropdown = document.getElementById("urun");

  for (var i = 1; i < urunDropdown.options.length; i++) {
    var urun = urunDropdown.options[i].text.toLowerCase();
    if (urun.indexOf(urunAramaKelimesi) > -1) {
      urunDropdown.options[i].style.display = "";
    } else {
      urunDropdown.options[i].style.display = "none";
    }
  }
}
</script>
<br />    
<label>Tedarikçi</label>  
<select name="tedarikci" id="tedarikci" class="form-control">
    <option value="">Lütfen Seçiniz</option>
  <!-- Tedarikçiler burada listelenecek -->
</select> 
<br />  
<label>Marka</label>  
<select name="marka" id="marka" class="form-control">
    <option value="">Lütfen Seçiniz</option>
  <!-- Markalar burada listelenecek -->
</select>
                          <br />  
                          
                         
                          
                          <label>Parti No</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="partino" id="partino" class="form-control" autocomplete="off">  
                          <br /> 
                          
                          <label>Son Kullanım Tarihi</label>  
                          <input type="date" onkeyup="value=value.toUpperCase();" name="skt" id="skt" class="form-control">  
                          <br /> 
                          
<label>Ürün Sıcaklık</label>  
<select name="urunsicaklik" id="urunsicaklik" class="form-control" onchange="checkKabulDurumu()">  
    <option value="UYGUN">UYGUN</option>
    <option value="KISMEN UYGUN">KISMEN UYGUN</option> 
    <option value="UYGUN DEĞİL">UYGUN DEĞİL</option> 
</select> 
<br />  
                          
<label>Araç Sıcaklık</label>  
<select name="aracsicaklik" id="aracsicaklik" class="form-control" onchange="checkKabulDurumu()">  
    <option value="UYGUN">UYGUN</option>
    <option value="KISMEN UYGUN">KISMEN UYGUN</option> 
    <option value="UYGUN DEĞİL">UYGUN DEĞİL</option> 
</select> 
<br />  
                          
<label>Araç Temizliği</label>  
<select name="aractemizlik" id="aractemizlik" class="form-control" onchange="checkKabulDurumu()">  
    <option value="UYGUN">UYGUN</option>
    <option value="KISMEN UYGUN">KISMEN UYGUN</option> 
    <option value="UYGUN DEĞİL">UYGUN DEĞİL</option> 
</select> 
<br />  

<label>Ambalaj Temizliği</label>  
<select name="ambalajtemizlik" id="ambalajtemizlik" class="form-control" onchange="checkKabulDurumu()">  
    <option value="UYGUN">UYGUN</option>
    <option value="KISMEN UYGUN">KISMEN UYGUN</option> 
    <option value="UYGUN DEĞİL">UYGUN DEĞİL</option> 
</select> 
<br />  

<label>Kabul Durumu</label>  
<select name="kabuldurumu" id="kabuldurumu" class="form-control">
    <option value="">SEÇİM YAPINIZ</option>  
    <option value="KABUL">KABUL</option>
    <option value="ŞARTLI KABUL" disabled>ŞARTLI KABUL</option> 
    <option value="RED" disabled>RED</option> 
</select> 
                          <br />  
                          
                          <label>Açıklama</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="aciklama" id="aciklama" class="form-control" autocomplete="off">  
                          <br /> 
                          
                          <label>Kabul Yapan</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="kabulyapan" id="kabulyapan" class="form-control" value='<?php echo $user["name"].' '.$user["surname"]; ?>' readonly/>  
                          <br /> 

                          
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
// get the elements
var urunsicaklik = document.getElementById("urunsicaklik");
var aracsicaklik = document.getElementById("aracsicaklik");
var aracTemizlik = document.getElementById("aractemizlik");
var ambalajTemizlik = document.getElementById("ambalajtemizlik");
var kabulDurumu = document.getElementById("kabuldurumu");

// add event listeners to urunsicaklik, aracsicaklik, aracTemizlik, and ambalajTemizlik
urunsicaklik.addEventListener("change", checkKabulDurumu);
aracsicaklik.addEventListener("change", checkKabulDurumu);
aracTemizlik.addEventListener("change", checkKabulDurumu);
ambalajTemizlik.addEventListener("change", checkKabulDurumu);

// function to check and disable kabulDurumu
function checkKabulDurumu() {
  if (urunsicaklik.value === "KISMEN UYGUN" || urunsicaklik.value === "UYGUN DEĞİL" ||
      aracsicaklik.value === "KISMEN UYGUN" || aracsicaklik.value === "UYGUN DEĞİL" ||
      aracTemizlik.value === "KISMEN UYGUN" || aracTemizlik.value === "UYGUN DEĞİL" ||
      ambalajTemizlik.value === "KISMEN UYGUN" || ambalajTemizlik.value === "UYGUN DEĞİL") {
    kabulDurumu.disabled = false;
    for (var i = 0; i < kabulDurumu.options.length; i++) {
      if (kabulDurumu.options[i].value !== "ŞARTLI KABUL" && kabulDurumu.options[i].value !== "RED") {
        kabulDurumu.options[i].disabled = true;
      } else {
        kabulDurumu.options[i].disabled = false;
      }
    }
  } else {
    kabulDurumu.disabled = false;
    for (var i = 0; i < kabulDurumu.options.length; i++) {
      kabulDurumu.options[i].disabled = false;
    }
  }
}

</script>

<script>
    $(document).ready(function() {
  $('#urun').on('change', function() {
    var selectedUrun = $(this).val();

    // AJAX isteği göndererek ilgili markaları ve tedarikçileri çekin
    $.ajax({
      url: 'getMarkaTedarikci.php', // Verileri getirecek PHP dosyasının adını ve yolunu buraya ekleyin
      method: 'POST',
      data: { urun: selectedUrun },
      success: function(data) {
        var result = JSON.parse(data);

        // Marka ve tedarikçi seçim öğelerini güncelleyin
        $('#marka').html(result.markaOptions);
        $('#tedarikci').html(result.tedarikciOptions);
      }
    });
  });
});
</script>

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
  $('#tarih').val(''); 
  $('#urun').val('');
  $('#tedarikci').val('');
  $('#marka').val('');
  $('#partino').val('');
  $('#skt').val('');
  $('#urunsicaklik').val('');
  $('#aracsicaklik').val('');
  $('#aractemizlik').val('');
  $('#ambalajtemizlik').val('');
  $('#kabuldurumu').val('');
  $('#aciklama').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var tarih = $('#tarih').val();
  var saat = $('#saat').val();
  var urun = $('#urun').val();
  var tedarikci = $('#tedarikci').val();
  var marka = $('#marka').val();
  var partino = $('#partino').val();
  var skt = $('#skt').val();
  var urunsicaklik = $('#urunsicaklik').val();
  var aracsicaklik = $('#aracsicaklik').val();
  var aractemizlik = $('#aractemizlik').val();
  var ambalajtemizlik = $('#ambalajtemizlik').val();
  var kabuldurumu = $('#kabuldurumu').val();
  var aciklama = $('#aciklama').val();
  var kabulyapan = $('#kabulyapan').val();
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('tarih', tarih);
  formData.append('saat', saat);
  formData.append('urun', urun);
  formData.append('tedarikci', tedarikci);
  formData.append('marka', marka);
  formData.append('partino', partino);
  formData.append('skt', skt);
  formData.append('urunsicaklik', urunsicaklik);
  formData.append('aracsicaklik', aracsicaklik);
  formData.append('aractemizlik', aractemizlik);
  formData.append('ambalajtemizlik', ambalajtemizlik);
  formData.append('kabuldurumu', kabuldurumu);
  formData.append('aciklama', aciklama);
  formData.append('kabulyapan', kabulyapan);
  formData.append('employee_id', id);
  formData.append('action', action);

  // Boş bir dosya ekleyerek, "pdf[]" anahtarını FormData nesnesine ekleriz.
  formData.append('pdf[]', new File([], ''));

 

  if (urun != '') {
    $.ajax({
      url: "actionmalkabul.php",
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
  form_data.append("tarih", $("#tarih").val());
  form_data.append("urun", $("#urun").val());
  form_data.append("tedarikci", $("#tedarikci").val());
  form_data.append("marka", $("#marka").val());
  form_data.append("partino", $("#partino").val());
  form_data.append("skt", $("#skt").val());
  form_data.append("urunsicaklik", $("#urunsicaklik").val());
  form_data.append("aracsicaklik", $("#aracsicaklik").val());
  form_data.append("aractemizlik", $("#aractemizlik").val());
  form_data.append("ambalajtemizlik", $("#ambalajtemizlik").val());
  form_data.append("kabuldurumu", $("#kabuldurumu").val());
  form_data.append("aciklama", $("#aciklama").val());
  form_data.append("kabulyapan", $("#kabulyapan").val());
  
  $.ajax({
    url:"actionmalkabul.php",   
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
      $('#tarih').val(data.tarih);
      $('#tedarikci').val(data.tedarikci);
      $('#marka').val(data.marka);
      $('#partino').val(data.partino);
      $('#skt').val(data.skt);
      $('#urunsicaklik').val(data.urunsicaklik);
      $('#aracsicaklik').val(data.aracsicaklik);
      $('#aractemizlik').val(data.aractemizlik);
      $('#ambalajtemizlik').val(data.ambalajtemizlik);
      $('#kabuldurumu').val(data.kabuldurumu);
      $('#aciklama').val(data.aciklama);
      $('#kabulyapan').val(data.kabulyapan);
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
                url: "actionmalkabul.php",
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