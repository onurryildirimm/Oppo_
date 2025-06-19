<?php include "header.php";

// PDO bağlantısını oluştur
$pdo = getPDOConnection();

// Memorandum ve kullanıcı verilerini al
$memorandumList = getMemorandumList($pdo);
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
                        <h4 class="mb-sm-0">Memorandum Hazırlama Sayfası</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                <li class="breadcrumb-item active">Memorandum Hazırlama Sayfası</li>
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
                                <?php if($user["role"] == "admin" || $user["role"] == "superadmin") {
                                    echo '<button type="button" id="modal_button" class="btn btn-info">Yeni Kayıt Ekle</button>';
                                } ?>
                            </div>
                            <br />

                            <div class="responsive">
                                <table class="table table-striped table-bordered" id="employee_data">
                                    <thead>
                                        <tr>
                                            <th width="15%">Tarih</th>
                                            <th width="20%">Tesis</th>
                                            <th width="15%">Kimden</th>
                                            <th width="15%">Kime</th>
                                            <th width="15%">Konu</th>
                                            <th width="35%">Bilgi</th>
                                            <th width="20%">Geçerlilik Tarihi</th>
                                            <th width="20%">Onay Durumu</th>
                                            <th width="5%">Güncelle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($memorandumList) > 0) {
                                            foreach ($memorandumList as $row) {
                                                $pdfLinks = explode(",", $row["pdf"]);
                                                $pdfLinksHTML = "";
                                                foreach ($pdfLinks as $pdfLink) {
                                                    if (!empty($pdfLink)) {
                                                        $pdfLinksHTML .= '<a href="' . $pdfLink . '"><i class="fa fa-file-pdf-o" style="font-size:24px;color:red"></i></a>';
                                                    }
                                                }
                                                if (empty($pdfLinksHTML)) {
                                                    $pdfLinksHTML = "Form Yüklenmemiş";
                                                }

                                                $bilgi = mb_strlen($row["bilgi"]) > 100 ? mb_substr($row["bilgi"], 0, 100) . '...' : $row["bilgi"];
                                                $kime = mb_strlen($row["kime"]) > 100 ? mb_substr($row["kime"], 0, 100) . '...' : $row["kime"];

                                                echo '
                                                <tr>
                                                    <td>' . $row["tarih"] . '</td>
                                                    <td>' . $row["tesis"] . '</td>
                                                    <td>' . $row["kimden"] . '</td>
                                                    <td>' . $kime . '</td>
                                                    <td>' . $row["konu"] . '</td>
                                                    <td>' . $bilgi . '</td>
                                                    <td>' . $row["gecerliliktarihi"] . '</td>
                                                    <td>' . $row["onaydurumu"] . '</td>     
                                                    <td><button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update">Güncelle</button></td>     
                                                </tr>';
                                            }
                                        } else {
                                            echo '
                                            <tr>
                                                <td colspan="9" align="center">Veri Bulunamadı.</td>
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
                                            <h4 class="modal-title">Yeni Kayıt Oluştur</h4>
                                        </div>
                                        <div class="modal-body">
                                            <label>Tarih</label>  
                                            <input type="date" name="tarih" id="tarih" class="form-control">
                                            <br />
                                            <label for="tesis">Tesis:</label>
                                            <select name="tesis" id="tesis" class="form-control">
                                                <option value="LAGUNA BEACH ALYA">LAGUNA BEACH ALYA</option>
                                            </select>
                                            <br />
                                            <label for="kimden">Kimden</label>
                                            <select name="kimden" id="kimden" class="form-control">
                                                <option value="İNSAN KAYNAKLARI">İNSAN KAYNAKLARI</option>
                                                <option value="GENEL MÜDÜR">GENEL MÜDÜR</option>
                                                <option value="OPERASYON MÜDÜRÜ">OPERASYON MÜDÜRÜ</option>
                                            </select>
                                            <br />
                                            <div class="form-group">
                                                <label>Kime</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kime" id="kime">
                                                            <label class="form-check-label" for="all_users">Tümünü Seç</label>
                                                        </div>
                                                        <?php 
                                                        $half_count = ceil(count($userList) / 2);
                                                        foreach ($userList as $index => $user) {
                                                            if ($index == $half_count) {
                                                                echo '</div><div class="col-md-6">';
                                                            }
                                                            echo '
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="usernames[]" value="' . $user['username'] . '" id="user_' . $user['id'] . '">
                                                                <label class="form-check-label" for="user_' . $user['id'] . '">' . $user['departman'] . '</label>
                                                            </div>';
                                                        }
                                                        ?>
                                                        <script>
                                                        const allUsersCheckbox = document.getElementById('kime');
                                                        const userCheckboxes = document.querySelectorAll('input[name="usernames[]"]');
                                                        allUsersCheckbox.addEventListener('change', (event) => {
                                                            userCheckboxes.forEach((checkbox) => {
                                                                checkbox.checked = event.target.checked;
                                                            });
                                                        });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <label>Konu</label>  
                                            <input type="text" name="konu" id="konu" class="form-control" autocomplete="off"> 
                                            <br />
                                            <label for="bilgi">Bilgi</label>
                                            <textarea name="bilgi" id="bilgi" class="form-control"></textarea>
                                            <br />
                                            <label>Geçerlilik Tarihi</label>  
                                            <input type="date" name="gecerliliktarihi" id="gecerliliktarihi" class="form-control">
                                            <br />
                                            <label>Onay Durumu</label>  
                                            <input type="text" name="onaydurumu" id="onaydurumu" class="form-control" value="ONAY BEKLENİYOR" readonly />
                                            <input type="hidden" name="employee_id" id="employee_id" />
                                            <br />
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="employee_id" id="employee_id" />
                                            <input type="submit" name="action" id="action" class="btn btn-info" />
                                            <button type="button" class="btn btn-danger" onclick="closeModal()">Kapat</button>
                                            <script>function closeModal() { $('#customerModal').modal('hide'); }</script>
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

<!-- JAVASCRIPT -->
<script src="assets/js/jquery.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<script src="assets/libs/feather-icons/feather.min.js"></script>
<script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
<script src="assets/js/plugins.js"></script>
<script src="assets/datatables/jquery.dataTables.min.js"></script>
<script src="assets/datatables/dataTables.bootstrap4.min.js"></script>
<script src="assets/datatables/dataTables.responsive.min.js"></script>
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
      "buttons": ["copy", "excel"]
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
  });

  //This JQuery code will Reset value of Modal item when modal will load for create new records
  $('#modal_button').click(function(){
    $('#customerModal').appendTo("body").modal('show');
    $('#tarih').val('');
    $('#tesis').val('');
    $('#kimden').val('');
    $('#kime').val('');
    $('#konu').val('');
    $('#bilgi').val('');
    $('#gecerliliktarihi').val('');
    $('.modal-title').text("Yeni Kayıt Ekle");
    $('#action').val('Kayıt Ekle');
  });

  //This JQuery code is for Create new records or Update existing records
  $('#action').click(function(){
    var tarih = $('#tarih').val(); 
    var tesis = $('#tesis').val();
    var kimden = $('#kimden').val();
    var kime = [];
    $('input[name="usernames[]"]:checked').each(function() {
      kime.push($(this).closest('.form-check').find('.form-check-label').text());
    });
    var konu = $('#konu').val();
    var bilgi = $('#bilgi').val();
    var gecerliliktarihi = $('#gecerliliktarihi').val();
    var id = $('#employee_id').val();
    var action = $('#action').val();
    var formData = new FormData();
    formData.append('tarih', tarih);
    formData.append('tesis', tesis);
    formData.append('kimden', kimden);
    formData.append('kime', kime.join(', '));
    formData.append('konu', konu);
    formData.append('bilgi', bilgi);
    formData.append('gecerliliktarihi', gecerliliktarihi);
    formData.append('onaydurumu', onaydurumu);
    formData.append('employee_id', id);
    formData.append('action', action);

    if (tarih != '' && bilgi != '') {
      $.ajax({
        url: "actionmemorandum.php",
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
          alert("Veri gönderilirken hata oluştu. Lütfen tekrar deneyin.");
        }
      });
    } else {
      alert("Tüm Alanları Doldurmak Zorundasınız!");
    }
  });

  //This JQuery code is for Update customer data
  $(document).on('click', '.update', function() {
    var id = $(this).attr("id");
    var action = "Select";
    
    $.ajax({
      url: "actionmemorandum.php",
      method: "POST",
      data: {
        employee_id: id,
        action: action
      },
      dataType: "json",
      success: function(data) {
        $('#customerModal').appendTo("body").modal('show');
        $('.modal-title').text("Kayıt Güncelle");
        $('#action').val("Güncelle");
        
        $('#employee_id').val(id);
        $('#tarih').val(data.tarih);
        $('#tesis').val(data.tesis);
        $('#kimden').val(data.kimden);
        $('#konu').val(data.konu);
        $('#bilgi').val(data.bilgi);
        $('#gecerliliktarihi').val(data.gecerliliktarihi);
        $('#onaydurumu').val(data.onaydurumu);
        
        // Checkboxları güncelle
        $('input[name="usernames[]"]').each(function() {
          var checkboxValue = $(this).closest('.form-check').find('.form-check-label').text();
          if (data.kime.includes(checkboxValue)) {
            $(this).prop('checked', true);
          } else {
            $(this).prop('checked', false);
          }
        });
      },
      error: function(xhr, status, error) {
        console.log(xhr);
        console.log(status);
        console.log(error);
        alert("Kayıt seçilirken bir hata oluştu.");
      }
    });
  });

</script>

</body>
</html>
