<?php include "header.php"; ?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

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

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <style>
                                .aktif { color: green; }
                                .aktif-degil { color: red; }
                                .shortened { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
                                .hidden { display: none; }
                                .read-more { color: blue; cursor: pointer; }
                            </style>

                            <div class="responsive">
                                <table class="table table-striped table-bordered" id="employee_data">
                                    <thead> 
                                        <tr>
                                            <th width="5%">Tarih</th>
                                            <th width="10%">Tesis</th>
                                            <th width="8%">Kimden</th>
                                            <th width="15%">Kime</th>
                                            <th width="8%">Konu</th>
                                            <th width="20%">Bilgi</th>
                                            <th width="8%">Geçerlilik Tarihi</th>
                                            <th width="5%">Durumu</th>
                                            <th width="5%">Form Yazdır</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Veritabanı bağlantısını oluştur
                                        $pdo = getPDOConnection();
                                        // Memorandum listesini al
                                        $memorandumList = getMemorandumListOnayli($pdo);
                                        if (!empty($memorandumList)) {
                                            foreach ($memorandumList as $row) {
                                                $tarih = $row["tarih"];
                                                $gecerlilikTarihi = $row["gecerliliktarihi"];
                                                $bugun = date("Y-m-d");
                                                $durum = ($bugun < $gecerlilikTarihi) ? "Aktif" : "Aktif Değil";
                                                $durumClass = ($bugun < $gecerlilikTarihi) ? "aktif" : "aktif-degil";

                                                $bilgi = $row["bilgi"];
                                                $bilgiClass = '';
                                                $shortened = '';
                                                $fullBilgi = $bilgi;
                                                if (strlen($bilgi) > 70) {
                                                    $bilgiClass = 'shortened';
                                                    $shortened = substr($bilgi, 0, 70) . '...';
                                                }

                                                echo '
                                                <tr>
                                                    <td>' . $row["tarih"] . '</td>
                                                    <td>' . $row["tesis"] . '</td>
                                                    <td>' . $row["kimden"] . '</td>
                                                    <td>' . $row["kime"] . '</td>
                                                    <td>' . $row["konu"] . '</td>
                                                    <td>
                                                        <span class="content ' . $bilgiClass . '">' . $shortened . '</span>
                                                        <span class="hidden">' . $fullBilgi . '</span>
                                                        <a href="#" class="read-more" onclick="toggleContent(this)">Devamını Oku</a>
                                                    </td>
                                                    <td>' . $row["gecerliliktarihi"] . '</td>
                                                    <td class="' . $durumClass . '">' . $durum . '</td>
                                                    <td> 
                                                        <form method="post" action="memoform">
                                                            <input type="hidden" name="id" value="' . $row["id"] . '" />
                                                            <input type="hidden" name="tarih" value="' . $row["tarih"] . '" />
                                                            <input type="hidden" name="tesis" value="' . $row["tesis"] . '" />
                                                            <input type="hidden" name="kimden" value="' . $row["kimden"] . '" />
                                                            <input type="hidden" name="kime" value="' . $row["kime"] . '" />
                                                            <input type="hidden" name="konu" value="' . $row["konu"] . '" />
                                                            <input type="hidden" name="bilgi" value="' . $row["bilgi"] . '" />
                                                            <input type="hidden" name="gecerliliktarihi" value="' . $row["gecerliliktarihi"] . '" />
                                                            <button type="submit" class="btn btn-warning btn-xs update">
                                                                <i class="fa fa-file"></i> Yazdır
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>';
                                            }
                                        } else {
                                            echo '
                                            <tr>
                                                <td align="center" colspan="9">Veri Bulunamadı.</td>
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
      "responsive": true, "lengthChange": true, "autoWidth": false, "ordering": false,
      "buttons": ["copy", "excel"]
    }).buttons().container().appendTo('#employee_data_wrapper .col-md-6:eq(0)');
  });

  document.addEventListener("DOMContentLoaded", function() {
      var readMoreLinks = document.querySelectorAll('.read-more');

      for (var i = 0; i < readMoreLinks.length; i++) {
          readMoreLinks[i].addEventListener('click', function(event) {
              event.preventDefault();
              var contentWrapper = event.target.parentNode;
              var content = contentWrapper.querySelector('.hidden');
              var originalContent = content.innerHTML;
              contentWrapper.innerHTML = originalContent;

              var hideLink = document.createElement('a');
              hideLink.setAttribute('href', '#');
              hideLink.classList.add('hide-content');
              hideLink.textContent = 'Gizle';
              contentWrapper.appendChild(hideLink);

              var readMoreLink = document.createElement('a');
              readMoreLink.setAttribute('href', '#');
              readMoreLink.classList.add('read-more');
              readMoreLink.textContent = 'Devamını Oku';

              hideLink.addEventListener('click', function(e) {
                  e.preventDefault();
                  contentWrapper.innerHTML = originalContent.substr(0, 70) + '...';
                  contentWrapper.appendChild(readMoreLink);

                  readMoreLink.addEventListener('click', function(event) {
                      event.preventDefault();
                      contentWrapper.innerHTML = originalContent;
                      contentWrapper.appendChild(hideLink);
                  });
              });
          });
      }
  });
</script>

</body>
</html>
