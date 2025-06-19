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
                                <h4 class="mb-sm-0">Yıllık Eğitim Planı</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Yıllık Eğitim Planı</li>
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
  <div class="row">
 <div class="col-md-3">
  <h6 class="form-title" onclick="toggleForm('filterForm')">
    Tarihe Göre Filtrele / Kayıt Ekle
    <i id="filterFormArrow" class="ri-arrow-down-line" style="float: right;"></i>
  </h6>
  <hr>
  <div id="filterForm" class="collapse-form">
    <form action="yillikegitimplani" method="post">
      <div class="form-group">
        <label for="startDate">Başlangıç Tarihi:</label>
        <input type="date" id="startDate" name="start_date" class="form-control">
      </div>
      <div class="form-group">
        <label for="endDate">Bitiş Tarihi:</label>
        <input type="date" id="endDate" name="end_date" class="form-control">
      </div><br/>
      <div class="form-group">
        <button type="submit" class="btn btn-info">Filtrele</button>
        <?php if($user["role"] == "admin" || $user["role"] == "superadmin") {
          echo '<button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>';
        }
        elseif 
        ($user["departman"] == "İNSAN KAYNAKLARI") {
          echo '<button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>';
        }
        ?>
      </div>
    </form>
  </div>
</div>
<div class="col-md-3">
  <h6 class="form-title" onclick="toggleForm('excelform')">
    Excel'e Aktar
    <i id="excelformArrow" class="ri-arrow-down-line" style="float: right;"></i>
  </h6>
  <hr>
  <div id="excelform" class="collapse-form">
    <form action="excel_egitim.php" method="post">
      <div class="form-group">
        <label for="baslangic">Başlangıç Tarihi:</label>
        <input type="date" id="baslangic" name="baslangic" class="form-control">
      </div>
      <div class="form-group">
        <label for="bitis">Bitiş Tarihi:</label>
        <input type="date" id="bitis" name="bitis" class="form-control">
      </div>
      <br/>
      <div class="form-group">
        <button type="submit" name="exportButton" class="btn btn-info">Excel Aktar</button>
      </div>
    </form>
  </div>
</div>

<style>
  .form-title {
    cursor: pointer;
    font-weight: bold;
  }

  .collapse-form {
    display: none;
  }

  .form-title i {
    margin-left: 5px;
    transition: transform 0.3s ease;
  }

  .open .ri-arrow-down-line {
    transform: rotate(180deg);
  }
</style>

<script>
  function toggleForm(formId) {
    const form = document.getElementById(formId);
    const arrow = document.getElementById(formId + "Arrow");
    const computedStyle = window.getComputedStyle(form);
    const isHidden = computedStyle.display === "none";

    if (isHidden) {
      form.style.display = "block";
      arrow.classList.add("open");
      arrow.classList.remove("ri-arrow-down-line");
      arrow.classList.add("ri-arrow-up-line");
    } else {
      form.style.display = "none";
      arrow.classList.remove("open");
      arrow.classList.remove("ri-arrow-up-line");
      arrow.classList.add("ri-arrow-down-line");
    }
  }
</script>

<script>
  document.getElementById('exportButton').addEventListener('click', function() {
    var startDate = document.getElementById('startDate').value;
    var endDate = document.getElementById('endDate').value;

    var formData = new FormData(document.getElementById('filterForm'));
    formData.append('start_date', startDate);
    formData.append('end_date', endDate);

    xhr.send(formData);
  });
</script>
  </div> </div>
</form>

  <?php
  require_once('vendor/php-excel-reader/excel_reader2.php');
  require_once('vendor/SpreadsheetReader.php');  


  $start_date = $_POST['start_date']; // Başlangıç tarihi
  $end_date = $_POST['end_date']; // Bitiş tarihi

  $query = "SELECT * FROM egitim WHERE 1=1 AND departman = 'GENEL'";

  // Başlangıç tarihi ve bitiş tarihi varsa sorguya ekle
  if (!empty($start_date) && !empty($end_date)) {
    $query .= " AND planlanan BETWEEN :start_date AND :end_date";
  }

  $query .= " ORDER BY planlanan ASC"; // Sıralama

  $statement = $pdoconnection->prepare($query);

  // Başlangıç tarihi ve bitiş tarihi varsa parametreleri ata
  if (!empty($start_date) && !empty($end_date)) {
    $statement->bindParam(':start_date', $start_date);
    $statement->bindParam(':end_date', $end_date);
  }

  $statement->execute();
  $result = $statement->fetchAll();

  $output = '';
  $output = '
  <table class="table table-striped table-bordered" id="employee_data">
    <thead> 
      <tr>
        <th width="15%">Eğitimin Konusu</th>
        <th width="15%">Eğitimi Veren Kişi/Kuruluş</th>
        <th width="5%">Eğitim Süresi</th>
        <th width="15%">Eğitime Katılacak Gruplar</th>
        <th width="4%">Planlanan Tarih</th>
        <th width="4%">Gerçekleşen Tarih</th>
        <th width="5%">Eğitim Formları</th>';
        
if ($user["role"] == "admin" || $user["role"] == "superadmin") {
  $output .= '<th width="3%">Güncelle</th>';
}
elseif 
        ($user["departman"] == "İNSAN KAYNAKLARI") {
$output .= '<th width="3%">Güncelle</th>';
            
        }
$output .= '
      </tr>
    </thead>
    <tbody>
';
  
  if($statement->rowCount() > 0) {
    foreach($result as $row) {
      $pdfLinks = explode(",", $row["pdf"]); // pdf yollarını virgülle ayırarak diziye aktar
      $pdfLinksHTML = "";
      foreach($pdfLinks as $pdfLink) {
        if(!empty($pdfLink)) {
          $pdfLinksHTML .= '<a href="'.$pdfLink.'"><i class="ri-file-pdf-line" style="font-size:24px;color:red"></i></a>';
        }
      }
      if(empty($pdfLinksHTML)) {
        $pdfLinksHTML = "Form Yüklenmemiş";
      }
      $output .= '
        <tr>
          <td>'.$row["konu"].'</td>
          <td>'.$row["veren"].'</td>
          <td>'.$row["sure"].'</td>
          <td>'.$row["gruplar"].'</td>
          <td>'.($row["planlanan"] ? date('d.m.Y', strtotime($row["planlanan"])) : '').'</td>
          <td>'.($row["gerceklesen"] ? date('d.m.Y', strtotime($row["gerceklesen"])) : '').'</td>
          <td><center>' . $pdfLinksHTML . '</center></td>';
        if ($user["role"] == "admin" || $user["role"] == "superadmin") {
          $output .= '<td><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></td>';
        }
        elseif 
        ($user["departman"] == "İNSAN KAYNAKLARI") {
            $output .= '<td><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></td>';
        }
      $output .= '</tr>';
  }
} else {
    $output .= '
      <tr>
        <td colspan="8" align="center">Veri Bulunamadı.</td>
      </tr>
    ';
  }
  
  $output .= '
      </tbody>
    </table>
  ';
  
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
                          
                          <label>Eğitimin Konusu</label>  
                          <input type="text" onkeyup="value=value.toUpperCase();" name="konu" id="konu" class="form-control">  
                          <br />  
                          <label>Eğitimi Veren Kişi/Kuruluş</label>
                          <input type="text" onkeyup="value=value.toUpperCase();" name="veren" id="veren" class="form-control">  
                          <br />  
                          <label>Süre</label>
                          <input type="text" onkeyup="value=value.toUpperCase();" name="sure" id="sure" class="form-control" >  
                          <br />
 <label>Eğitim Katılacak Gruplar:</label> <br>   

<input type="hidden" name="gruplar[]" id="gruplar" value="">
<input type="checkbox" name="gruplar[]" id="gruplar" value="Mutfak Personeli"> Mutfak Personeli<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="Servis Personeli"> Servis Personeli<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="House Keeping Personeli"> House Keeping Personeli<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="Hamam&Spa Personeli"> Hamam&Spa Personeli<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="Teknik Personeli"> Teknik Personeli<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="Yönetim Kadrosu"> Yönetim Kadrosu<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="İlgili Departman Personeli"> İlgili Departman Personeli<br>
<input type="checkbox" name="gruplar[]" id="gruplar" value="Tüm Personel"> Tüm Personel <br><br/>


<label>Hatırlatma Maili Kimlere Gitsin?</label><br/>
<?php 

$query = "SELECT * FROM user";
$stmt = $pdoconnection->prepare($query);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="row">
    <div class="col-md-6">
        <?php 
        $i = 0;
        foreach ($rows as $row) {
            if ($i % 2 == 0) {
        ?>
            <input type="checkbox" name="username[]" value="<?php echo $row['username']; ?>" /> <?php echo $row['name'].' '.$row['surname']; ?><br>
        <?php
            }
            $i++;
        }
        ?>
    </div>
    <div class="col-md-6">
        <?php 
        $i = 0;
        foreach ($rows as $row) {
            if ($i % 2 != 0) {
        ?>
            <input type="checkbox" name="username[]" value="<?php echo $row['username']; ?>" /> <?php echo $row['name'].' '.$row['surname']; ?><br>
        <?php
            }
            $i++;
        }
        ?>
    </div>
</div>
<br/>
                            <label>Planlanan Tarih</label>
                            <input type="date" onkeyup="value=value.toUpperCase();" name="planlanan" id="planlanan" class="form-control">
                          <br />  
                            <label>Gerçekleşen Tarih</label>
                            <input type="date" onkeyup="value=value.toUpperCase();" name="gerceklesen" id="gerceklesen" class="form-control">  
                          <br />
                          
                          <label>Eğitim Formu</label><br />  
                          <input type="file" name="pdf[]" id="pdf" multiple>

                            <br />  
                        
                          <input type="hidden" name="employee_id" id="employee_id" />  
                          <input type="hidden" name="departman" id="departman" value="<?php echo $departman; ?>"> 
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
  $('#konu').val(''); //This will clear Modal first name textbox
  $('#veren').val(''); //This will clear Modal last name textbox
  $('#sure').val('');
  $('#gruplar').val('');
  $('#username').val('');
  $('#planlanan').val('');
  $('#gerceklesen').val('');
  $('.modal-title').text("Yeni Kayıt Ekle"); //It will change Modal title to Create new Records
$('#action').val('Kayıt Ekle'); 
 });
$('#action').click(function() {
  var konu = $('#konu').val();
  var veren = $('#veren').val();
  var sure = $('#sure').val();
  var gruplar = [];
  $('input[name="gruplar[]"]:checked').each(function() {
    gruplar.push($(this).val());
  });
  var username = [];
  $('input[name="username[]"]:checked').each(function() {
    username.push($(this).val());
  });
  var planlanan = $('#planlanan').val();
  var gerceklesen = $('#gerceklesen').val();
  var departman = $('#departman').val();
  var id = $('#employee_id').val();
  var action = $('#action').val();
  var formData = new FormData();
  formData.append('konu', konu);
  formData.append('veren', veren);
  formData.append('sure', sure);
  formData.append('gruplar', JSON.stringify(gruplar));
  formData.append('username', JSON.stringify(username));
  formData.append('planlanan', planlanan);
  formData.append('gerceklesen', gerceklesen);
  formData.append('departman', departman);
  formData.append('employee_id', id);
  formData.append('action', action);

  // Boş bir dosya ekleyerek, "pdf[]" anahtarını FormData nesnesine ekleriz.
  formData.append('pdf[]', new File([], ''));

  var pdfFiles = $('#pdf')[0].files;
  if (pdfFiles.length > 0) {
    for (var i = 0; i < pdfFiles.length; i++) {
      formData.append('pdf[]', pdfFiles[i]);
    }
  }

  if (konu != '' && veren != '') {
    $.ajax({
      url: "actionegitim.php",
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
  form_data.append("konu", $("#konu").val());
  form_data.append("veren", $("#veren").val());
  form_data.append("sure", $("#sure").val());
  form_data.append("planlanan", $("#planlanan").val());
  form_data.append("gerceklesen", $("#gerceklesen").val());
  form_data.append("departman", $("#departman").val());
  var pdfFiles = $('#pdf')[0].files;
  if (pdfFiles.length > 0) {
    for (var i = 0; i < pdfFiles.length; i++) {
      form_data.append("pdf[]", pdfFiles[i]);
    }
  } else {
    form_data.append("pdf", ""); // değer boş ise, pdf alanı boş bırakılır
  }
  
  form_data.append("gruplar", JSON.stringify($("input[name='gruplar[]']:checked").map(function(){
    return $(this).val();
  }).get()));
  
  form_data.append("username", JSON.stringify($("input[name='username[]']:checked").map(function(){
    return $(this).val();
  }).get()));
  
  $.ajax({
    url:"actionegitim.php",   
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
      $('#konu').val(data.konu);
      $('#veren').val(data.veren);
      $('#sure').val(data.sure);
      var gruplar = data.gruplar; 
      $('input[name="gruplar[]"]').prop('checked', false); // Tüm checkboxları işaretsiz yapın
      for (var i = 0; i < gruplar.length; i++) {
        $('input[name="gruplar[]"][value="' + gruplar[i] + '"]').prop('checked', true); // Seçili olan checkboxları işaretleyin
      }
      var username = data.username;
      // İlgili departman personeli ve yönetim kadrosu dışındaki tüm kullanıcıları seçili yapın
      $('input[name="username[]"]').prop('checked', false); // Tüm checkboxları işaretsiz yapın
      for (var i = 0; i < username.length; i++) {
        $('input[name="username[]"][value="' + username[i] + '"]').prop('checked', true); // Seçili olan checkboxları işaretleyin
      }
      $('#planlanan').val(data.planlanan);
      $('#gerceklesen').val(data.gerceklesen);
      $('#departman').val(data.departman);
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