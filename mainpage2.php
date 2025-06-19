<div class="col-xxl-7">
                        <div class="col-xl-12 col-md-8">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Yaklaşan Eğitimler</h4>
                                    
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table align-middle table-borderless table-centered table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col" style="width: 40px;">Konu</th>
                                                    <th scope="col">Eğitimi Veren</th>
                                                    <th scope="col">Süre</th>
                                                    <th scope="col">Katılacaklar</th>
                                                    <th scope="col">Tarih</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php 
            $conn = mysqli_connect("localhost", "homeandf_onur", "354472Onur", "homeandf_lagunabeachalya");
            $limit = 12;
            $currentDate = date("Y-m-d");

    // Yaklaşan çıkış tarihi olan oyunları sorgulayın
    $sql = "SELECT konu, veren, sure, gruplar, planlanan FROM egitim WHERE planlanan > '$currentDate' ORDER BY planlanan ASC LIMIT 10";
            $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $row["konu"];
        echo "<tr>";
        echo "<td style='max-width: 250px; overflow: hidden; text-overflow: ellipsis;'>" . $row["konu"] . "</td>";
        echo "<td>" . $row["veren"] . "</td>";
        echo "<td>" . $row["sure"] . "</td>";
        echo "<td style='max-width: 70px; overflow: hidden; text-overflow: ellipsis;'>" . $row["gruplar"] . "</td>";
        echo "<td class='text-right'>" . date('d.m.Y', strtotime($row["planlanan"])) . " </td>";
        echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Sonuç Bulunamadı.</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <?php
        if ($total_results > $limit) {
            echo "<div class='pagination'>";
            for ($i=1; $i<=$total_pages; $i++) {
                echo "<a href='?page=".$i."' class='page-link'";
                if ($i==$page)  echo " class='active'";
                echo ">".$i."</a> ";
            }
            echo "</div>";
        }
    ?>
        </tbody>
    </table>
    <?php
        if ($total_results2 > $limit2) {
            echo "<div class='pagination'>";
            for ($i=1; $i<=$total_pages2; $i++) {
                echo "<a href='?page2=".$i."' class='page-link'";
                if ($i==$page2)  echo " class='active'";
                echo ">".$i."</a> ";
            }
            echo "</div>";
        }
    ?>
    <?php
// Veritabanı bağlantısı
$conn = mysqli_connect("localhost", "homeandf_onur", "354472Onur", "homeandf_lagunabeachalya");

// Bağlantı hatası kontrolü
if (!$conn) {
    die("Veritabanı bağlantısı başarısız: " . mysqli_connect_error());
}

// Veritabanından "KABUL", "RED" ve "ŞARTLI KABUL" sayılarını çekme
$sql_kabul = "SELECT COUNT(*) as kabul_sayisi FROM malkabul WHERE kabuldurumu = 'KABUL'";
$sql_red = "SELECT COUNT(*) as red_sayisi FROM malkabul WHERE kabuldurumu = 'RED'";
$sql_sartli_kabul = "SELECT COUNT(*) as sartli_kabul_sayisi FROM malkabul WHERE kabuldurumu = 'ŞARTLI KABUL'";

$result_kabul = mysqli_query($conn, $sql_kabul);
$result_red = mysqli_query($conn, $sql_red);
$result_sartli_kabul = mysqli_query($conn, $sql_sartli_kabul);

// Veriyi alma
$row_kabul = mysqli_fetch_assoc($result_kabul);
$row_red = mysqli_fetch_assoc($result_red);
$row_sartli_kabul = mysqli_fetch_assoc($result_sartli_kabul);

// Veritabanı bağlantısını kapatma
mysqli_close($conn);

// "KABUL", "RED" ve "ŞARTLI KABUL" sayıları
$kabul_sayisi = (int)$row_kabul['kabul_sayisi'];
$red_sayisi = (int)$row_red['red_sayisi'];
$sartli_kabul_sayisi = (int)$row_sartli_kabul['sartli_kabul_sayisi'];
?>
                                    </div><!-- end -->
                                </div><!-- end cardbody -->
                            </div><!-- end card -->
                        </div><!-- end col -->
                        </div></div>
                        <div class="row">
    <div class="col-xxl-3 col-md-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Mal Kabul Oranları</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <div id="pie-chart"></div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->


<div class="col-xxl-9">
                        <div class="col-xl-12 col-md-8">
                            <div class="card card-height-100">
                                <div class="card-header align-items-center d-flex">
                                    <h6>Son 5 Mal Kabul</h6>
                                    
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table align-middle table-borderless table-centered table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                   
                                                    <th scope="col">Tarih</th>
                                                    <th scope="col">Saat</th>
                                                    <th scope="col">Tedarikçi</th>
                                                    <th scope="col">Marka</th>
                                                    <th scope="col">Kabul Durumu</th>
                                                  <th scope="col">Açıklama</th>  
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php 
            $conn = mysqli_connect("localhost", "homeandf_onur", "354472Onur", "homeandf_lagunabeachalya");
         
    $sql = "SELECT * FROM malkabul ORDER BY id DESC LIMIT 8";
            $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
    
        echo "<tr>";
        echo "<td class='text-right'>" . date('d.m.Y', strtotime($row["tarih"])) . " </td>";
        echo "<td>" . $row["saat"] . "</td>";
        echo "<td>" . $row["tedarikci"] . "</td>";
        echo "<td style='max-width: 70px; overflow: hidden; text-overflow: ellipsis;'>" . $row["marka"] . "</td>";
       echo "<td>" . $row["kabuldurumu"] . "</td>";
       echo "<td>" . $row["aciklama"] . "</td>";
        echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>Sonuç Bulunamadı.</td></tr>";
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
    <?php
        if ($total_results > $limit) {
            echo "<div class='pagination'>";
            for ($i=1; $i<=$total_pages; $i++) {
                echo "<a href='?page=".$i."' class='page-link'";
                if ($i==$page)  echo " class='active'";
                echo ">".$i."</a> ";
            }
            echo "</div>";
        }
    ?>
        </tbody>
    </table>
    <?php
        if ($total_results2 > $limit2) {
            echo "<div class='pagination'>";
            for ($i=1; $i<=$total_pages2; $i++) {
                echo "<a href='?page2=".$i."' class='page-link'";
                if ($i==$page2)  echo " class='active'";
                echo ">".$i."</a> ";
            }
            echo "</div>";
        }
    ?>

</div></div></div></div><!-- end row -->
                        