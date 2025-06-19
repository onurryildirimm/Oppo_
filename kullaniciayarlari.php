<?php
include 'header.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

// PDO bağlantısını oluştur
$pdo = getPDOConnection();

// Kullanıcı listesini çek
$userList = getUserList($pdo);
?>

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
                        <h4 class="mb-sm-0">KULLANICI LİSTESİ</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Laguna Beach Alya</a></li>
                                <li class="breadcrumb-item active">Kullanıcı Listesi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

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
                                        <thead>
                                            <tr>
                                                <th width="8%"><center>Adı Soyadı</center></th>
                                                <th width="8%"><center>Kullanıcı Mail</center></th>
                                                <th width="8%"><center>Telefon</center></th>
                                                <th width="8%"><center>Departman</center></th>
                                                <th width="8%"><center>Görev</center></th>
                                                <th width="5%"><center>Rol</center></th>
                                                <th width="2%"><center>Güncelle</center></th>
                                                <th width="2%"><center>Mail</center></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(count($userList) > 0) {
                                                foreach ($userList as $row) {
                                                    $role = ($row["role"] == "admin") ? "Sistem Yöneticisi" : "Kullanıcı";
                                                    echo '
                                                    <tr>
                                                        <td><center>' . $row["name"] .' ' . $row["surname"] . '</center></td>
                                                        <td><center>' . $row["username"] . '</center></td>
                                                        <td><center>' . $row["telefon"] . '</center></td>
                                                        <td><center>' . $row["departman"] . '</center></td>
                                                        <td><center>' . $row["gorev"] . '</center></td>
                                                        <td><center>' . $role . '</center></td>
                                                        <td><center><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></center></td>
                                                        <td>
                                                            <form action="girisbilgisigonder.php" method="post" target="_blank">
                                                                <input type="hidden" name="username" value="' . $row["username"] . '">
                                                                <input type="hidden" name="name" value="' . $row["name"] . '">
                                                                <input type="hidden" name="surname" value="' . $row["surname"] . '">
                                                                <button type="submit" class="btn btn-info btn-xs">Mail Gönder</button>
                                                            </form>
                                                        </td>
                                                    </tr>';
                                                }
                                            } else {
                                                echo '
                                                <tr>
                                                    <td colspan="8" align="center">Veri Bulunamadı.</td>
                                                </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Modal for Create/Update -->
                                <div id="customerModal" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Create New Records</h4>
                                            </div>
                                            <div class="modal-body">
                                                <label>Adı:</label>  
                                                <input type="text" onkeyup="value=value.toUpperCase();" name="name" id="name" class="form-control">  
                                                <br />  
                                                <label>Soyadı:</label>  
                                                <input type="text" onkeyup="value=value.toUpperCase();" name="surname" id="surname" class="form-control">
                                                <br />  
                                                <label>Kullanıcı Mail:</label>  
                                                <input type="text" name="username" id="username"  class="form-control">  
                                                <br />  
                                                <label>Şifre:</label>  
                                                <input type="password"  name="password" id="password"  class="form-control" required>  
                                                <br /> 
                                                <label>Telefon:</label>  
                                                <input type="text" onkeyup="value=value.toUpperCase();" name="telefon" id="telefon"  class="form-control">  
                                                <br />
                                                <label>Departman</label>  
                                                <select name="departman" id="departman" class="form-control">
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
    <option value="GÜVENLİK">GÜVENLİK</option>
                                                </select>
                                                <br />  
                                                <label>Görevi</label>  
                                                <select name="gorev" id="gorev" class="form-control">
                                                    <option value="YÖNETİCİ">YÖNETİCİ</option>
                                                    <option value="ŞEF">ŞEF</option>
                                                </select>
                                                <br /> 
                                                <input type="hidden"  name="profile_image" id="profile_image" value="avatars/1321.png" class="form-control" readonly/>
                                                <label>Yetki Düzeyi</label>  
                                                <select name="role" id="role" class="form-control">  
                                                    <option value="user">KULLANICI</option>
                                                    <option value="admin">SİSTEM YÖNETİCİSİ</option>
                                                </select>
                                                <br />  
                                                <input type="hidden" name="employee_id" id="employee_id" />  
                                            </div>
                                            <div class="modal-footer">
                                                <input type="submit" name="action" id="action" class="btn btn-info">
                                                <button type="button" class="btn btn-danger" onclick="closeModal()">Kapat</button>
                                                <script>
                                                    function closeModal() {
                                                        $('#customerModal').modal('hide');
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End of Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

<!-- DataTables -->
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

  //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
      $('#customerModal').appendTo("body").modal('show'); //It will load modal on web page
      $('#name').val('');
      $('#surname').val('');
      $('#username').val('');
      $('#password').val('');
      $('#telefon').val('');
      $('#departman').val('');
      $('#gorev').val('');
      $('#role').val('');

      $('.modal-title').text("Yeni Kullanıcı Ekle"); //It will change Modal title to Create new Records
      $('#action').val('Kayıt Ekle'); //This will reset Button value to Create
  });

  $('#action').click(function(){
      var name = $('#name').val();
      var surname = $('#surname').val();
      var username = $('#username').val();
      var password = $('#password').val();
      var telefon = $('#telefon').val();
      var departman = $('#departman').val();
      var gorev = $('#gorev').val();
      var role = $('#role').val();
      var id = $('#employee_id').val();
      var action = $('#action').val();
      
      if(name != '') {
          $.ajax({
              url : "actionkullanici.php",
              method: "POST",
              data: {
                  name: name, surname: surname, username: username, 
                  password: password, telefon: telefon, departman: departman, 
                  gorev: gorev, role: role, employee_id: id, action: action
              },
              success: function(data) {
                  $('#customerModal').modal('hide');
                  location.reload(true);
              }
          });
      } else {
          alert("İsim Alanı Boş Geçilemez!");
      }
  });

  $(document).on('click', '.update', function(){
      var id = $(this).attr("id");
      var action = "Select";
      $.ajax({
          url: "actionkullanici.php",
          method: "POST",
          data: {employee_id: id, action: action},
          dataType: "json",
          success: function(data){
              $('#customerModal').appendTo("body").modal('show');
              $('.modal-title').text("Kullanıcı Güncelle");
              $('#action').val("Güncelle");

              $('#employee_id').val(id);
              $('#name').val(data.name);
              $('#surname').val(data.surname);
              $('#username').val(data.username);
              $('#password').val('');
              $('#telefon').val(data.telefon);
              $('#departman').val(data.departman);
              $('#gorev').val(data.gorev);
              $('#role').val(data.role);
              $('#password').prop('required', true);
          }
      });
  });

  $(document).on('click', '.delete', function(){
      var id = $(this).attr("id");
      if(confirm("Kullanıcıyı Silmek İstediğinize Emin Misiniz?")) {
          var action = "Delete";
          $.ajax({
              url: "actionkullanici.php",
              method: "POST",
              data: {employee_id: id, action: action},
              success: function(data) {
                  location.reload(true);
              }
          })
      } else {
          return false;
      }
  });
</script>

</body>
</html>
