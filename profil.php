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
                                <h4 class="mb-sm-0">Profil Sayfam</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                        <li class="breadcrumb-item active">Profil Sayfam</li>
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
                                    <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?php echo $user["profile_image"]; ?>" alt="user" class="rounded-circle" width="150px" height="150px">
                    <div class="mt-3">
                      <h4><?php echo $user["name"].' '.$user["surname"] ?></h4>
                      <p class="text-secondary mb-1"><?php echo $user["username"]?></p>
                      <p class="text-muted font-size-sm"><?php echo $user["telefon"]?></p>
                      
                    </div>
                  </div>
                </div>
              </div>
              
            <div class="col-md-12">
              <div class="card mb-7">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">İsim Soyisim</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $user["name"].' '.$user["surname"]; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $user["username"]; ?>
                    </div>
                  </div>
                  <hr>
                  
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Cep Telefonu</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $user["telefon"]; ?>
                    </div>
                  </div>
            
                    <hr>
              <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Departman</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $user["departman"]; ?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Görevi</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?php echo $user["gorev"]; ?>
                    </div>
                  </div>
                  <hr>
                  
       
                  
                  </div>
                  </div>
                </div>
              </div>



            </div>
          </div>

        </div>
    </div>
            <?php include "footer.php" ?>