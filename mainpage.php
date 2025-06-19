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
                            $currentDate = date("Y-m-d");
                            $egitimler = getEgitimler($connection, $currentDate);

                            if (!empty($egitimler)) {
                                foreach ($egitimler as $row) {
                                    echo "<tr>";
                                    echo "<td style='max-width: 250px; overflow: hidden; text-overflow: ellipsis;'>" . $row["konu"] . "</td>";
                                    echo "<td>" . $row["veren"] . "</td>";
                                    echo "<td>" . $row["sure"] . "</td>";
                                    echo "<td style='max-width: 70px; overflow: hidden; text-overflow: ellipsis;'>" . $row["gruplar"] . "</td>";
                                    echo "<td class='text-right'>" . date('d.m.Y', strtotime($row["planlanan"])) . " </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>Sonuç Bulunamadı.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div><!-- end -->
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div><!-- end row -->
<?php 
// Kabul, Red ve Şartlı Kabul sayılarını al
$counts = getKabulRedCounts($connection);

// "KABUL", "RED" ve "ŞARTLI KABUL" sayıları
$kabul_sayisi = $counts['kabul_sayisi'];
$red_sayisi = $counts['red_sayisi'];
$sartli_kabul_sayisi = $counts['sartli_kabul_sayisi'];
?>
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
                    <h6>Son 8 Mal Kabul</h6>
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
                                $malKabul = getLastMalKabul($connection);

                                if (!empty($malKabul)) {
                                    foreach ($malKabul as $row) {
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
                                    echo "<tr><td colspan='6'>Sonuç Bulunamadı.</td></tr>";
                                }
                                mysqli_close($connection);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end cardbody -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->
</div>
