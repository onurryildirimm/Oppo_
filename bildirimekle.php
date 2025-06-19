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
                                <h4 class="mb-sm-0">Bildirim Ekle</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Laguna Beach Alya</a></li>
                                        <li class="breadcrumb-item active">Bildirim Ekle</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                 
                <div align="center" class="align-self-center">

                        <div class="col-sm-4">
                            
                            <div class="card">
                                
                                <div class="card-body">
                                    
                                            
            
                                        <form class="" method="post" action="bildirimguncelle.php" enctype="multipart/form-data">
                                            <input type="hidden" name="employee_id" id="employee_id" />

                                                <div class="form-group">
                                                    <label>Başlık</label>
                                                    <input type="text" class="form-control" required  name="title" />
                                                </div>
            
                                                <div class="form-group">
                                                    <label>Mesaj</label>
                                                    <input type="text" class="form-control" required  name="message" />
                                                </div>
                                                    
                                          
                                                <div class="form-group">
  <label>Bildirim Kimlere Gidecek:</label>
<div class="row">
  <div class="col-md-6">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" name="all_users" id="all_users">
      <label class="form-check-label" for="all_users">
        Tümünü Seç
      </label>
    </div>
    <?php 
    $query = "SELECT * FROM user";

    $stmt = $pdoconnection->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count = count($rows);
    $half_count = ceil($count / 2);
    $i = 0;
    
    foreach ($rows as $row) {
      if ($i == $half_count) {
        echo '</div><div class="col-md-6">';
      }
    ?>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="usernames[]" value="<?php echo $row['username']; ?>" id="user_<?php echo $row['id']; ?>">
        <label class="form-check-label" for="user_<?php echo $row['id']; ?>">
          <?php echo $row['name']. " " .$row['surname']; ?>
        </label>
      </div>
    <?php 
      $i++;
    }
    ?>
  </div>
</div></div>

<script>
  const allUsersCheckbox = document.getElementById('all_users');
  const userCheckboxes = document.querySelectorAll('input[name="usernames[]"]');
  allUsersCheckbox.addEventListener('change', (event) => {
    userCheckboxes.forEach((checkbox) => {
      checkbox.checked = event.target.checked;
    });
  });
</script>



                                                
                                                
                                                
                                                
                                                
                                                
                                                <div class="form-group">
                                                    <div>
                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                                                            Gönder
                                                        </button>
                                                       
                                                    </div>
                                                </div>
                                            </form>
            
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
            $(document).ready(function() {
                $('form').parsley();
            });
        </script>
        <script>
$(document).ready(function(){
    $('#exampleModal').modal('show');
});
</script>

<script>
  // datePicker'ı etkinleştirin
  $(document).ready(function() {
    $('#dob-input').datepicker({
      format: 'dd/mm/yyyy', // format ayarları
      autoclose: true,
      todayHighlight: true,
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