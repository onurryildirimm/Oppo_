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
                                <h4 class="mb-sm-0">Tamamlanan İşler</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Tamamlanan İşler</li>
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
                                   <form action="hedeftakip2" method="POST">
  <label for="ay_secimi">İşlem Yapmak İstediğiniz Ayı Seçiniz:</label>
  <select name="ay_secimi" id="ay_secimi">
    <option value="ocak">Ocak</option>
    <option value="subat">Şubat</option>
    <option value="mart">Mart</option>
    <option value="nisan">Nisan</option>
    <option value="mayis">Mayıs</option>
    <option value="haziran">Haziran</option>
    <option value="temmuz">Temmuz</option>
    <option value="agustos">Ağustos</option>
    <option value="eylul">Eylül</option>
    <option value="ekim">Ekim</option>
    <option value="kasim">Kasım</option>
    <option value="aralik">Aralık</option>
  </select>
  <br><br>
  <input type="submit" class="btn btn-primary dropdown-toggle" value="Göster">
</form>
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
<?php include "footer.php" ?>