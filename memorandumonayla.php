<?php include "header.php"; ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Memorandum Onay Sayfası</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                <li class="breadcrumb-item active">Memorandum Onay Sayfası</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
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
                                            <th width="35%">Onay Durumu</th>
                                            <th width="5%">Onayla</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Veritabanı bağlantısını oluştur
                                        $pdo = getPDOConnection();
                                        // Memorandum listesini al
                                        $memorandumList = getMemorandumListOnay($pdo);
                                        if (!empty($memorandumList)) {
                                            foreach ($memorandumList as $row) {
                                                echo '
                                                <tr>
                                                    <td>' . $row["tarih"] . '</td>
                                                    <td>' . $row["tesis"] . '</td>
                                                    <td>' . $row["kimden"] . '</td>
                                                    <td>' . $row["kime"] . '</td>
                                                    <td>' . $row["konu"] . '</td>
                                                    <td>' . $row["bilgi"] . '</td>
                                                    <td>' . $row["gecerliliktarihi"] . '</td>
                                                    <td>' . $row["onaydurumu"] . '</td>
                                                    <td>
                                                        <button type="button" id="' . $row["id"] . '" class="btn btn-warning btn-xs update" onclick="onayla(' . $row["id"] . ')">
                                                            <i class="fa fa-check"></i> Onayla
                                                        </button>
                                                    </td>
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
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

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

<script>
  $(function () {
    $("#employee_data").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false, "ordering": false,
      "buttons": ["excel"]
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
  });

  function onayla(id) {
    $.ajax({
      url: 'actionmemoonayla.php',
      method: 'POST',
      data: { id: id },
      success: function(response) {
        location.reload(); // İşlem başarılı olduğunda sayfayı yenile
      },
      error: function(xhr, status, error) {
        console.error(error); // Hata mesajını konsola yazdır
      }
    });
  }
</script>

</body>
</html>
