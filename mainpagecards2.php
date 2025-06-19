 <?php 
 // Lisans bitiş tarihi
                                    

                                    // Şu anki tarihi al
                                    $currentDate = new DateTime();

                                    // Lisans bitiş tarihini DateTime nesnesine dönüştür
                                    $expiryDateObj = new DateTime($expiryDate);

                                    // Lisans bitiş tarihi ile şu anki tarih arasındaki farkı hesapla
                                    $interval = $currentDate->diff($expiryDateObj);

                                    // Kalan günü al
                                    $remainingDays = $interval->days;
                                    ?>
 
 <div class="row">
                        <div class="col-xxl-5">
    <div class="d-flex flex-column h-100">
        <div class="row h-100">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="alert alert-warning border-0 rounded-0 m-0 d-flex align-items-center <?php echo ($remainingDays < 30) ? 'blinking' : ''; ?>" role="alert">
                            <i data-feather="alert-triangle" class="text-warning me-2 icon-sm"></i>
                            <div class="flex-grow-1 text-truncate">
                                Kalan Lisans Süresi <b>
                                    <?php
                                    

                                    echo "{$remainingDays} Gün.";
?></b>
<style>
    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

    .blinking {
        animation: blink 1s infinite;
    }
</style>

                                                    </div>
                                                    
                                                </div>

                                                <div class="row align-items-end">
                                                    <div class="col-sm-8">
                                                        <div class="p-3">
                                                            <p class="fs-16 lh-base">Lisans süreniz sona erdiğinde<span class="fw-semibold"> portala erişiminiz kısıtlanacaktır.</span> Lisans sürenizi aşağıdaki buton aracılığı ile uzatabilirsiniz.<i class="mdi mdi-arrow-right"></i></p>
                                                            <div class="mt-3">
                                                                <a href="#" class="btn btn-success">Lisans Uzat</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="px-3">
                                                            <img src="assets/images/user-illustarator-2.png" class="img-fluid" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> <!-- end card-body-->
                                        </div>
                                    </div> <!-- end col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Toplam Kullanıcı</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
            
            $toplamsayisi = $baglanti->query("SELECT count(*) FROM user")->fetchColumn();
            
            echo $toplamsayisi;
            
            ?>">0</span></h2>
                                                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0">Kayıtlı Kullanıcı</p>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                                <i data-feather="users" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Online Kullanıcı</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
            
            $onlinesayisi = $baglanti->query("SELECT count(*) FROM user WHERE status = 'Online'")->fetchColumn();
            
            echo $onlinesayisi;
            
            ?>">0</span></h2>
                                                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"> Sistemde Aktif</p>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                                <i data-feather="activity" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Devam Eden İşler</p>
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="<?php $baglanti=new PDO("mysql:host=localhost;dbname=homeandf_lagunabeachalya","homeandf_onur","354472Onur"); 
                                        $devameden = $baglanti->query("SELECT count(*) FROM isler WHERE durumu = 'DEVAM EDİYOR' ")->fetchColumn();
                                        echo $devameden; ?>">0</span> Adet
                                                        </h2>
                                                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"> Devam Eden İş Mevcut</p>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                                <i data-feather="clock" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->

                                    <div class="col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fw-medium text-muted mb-0">Toplam Mal Kabul</p>
                                                        
                                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value" data-target="<?php $conn = mysqli_connect("localhost", "homeandf_onur", "354472Onur", "homeandf_lagunabeachalya");
$sql = "SELECT * FROM malkabul";
if ($result=mysqli_query($conn,$sql)) {
    $rowcount=mysqli_num_rows($result);
    print  $rowcount; 
}
?>">0</span> Adet</h2>
                                                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"> Depo İşlemi</p>
                                                    </div>
                                                    <div>
                                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                                <i data-feather="external-link" class="text-info"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- end card body -->
                                        </div> <!-- end card-->
                                    </div> <!-- end col-->
                                </div> <!-- end row-->
                            </div>
                        </div> <!-- end col-->   