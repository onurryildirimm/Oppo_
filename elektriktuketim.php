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
                        <h4 class="mb-sm-0">Enerji Tüketim</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                <li class="breadcrumb-item active">Enerji Tüketim</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Ay Seçimi -->
            <div class="row mb-3">
                <div class="col-3">
                    <select id="monthSelect" class="form-select">
                        <option value="">Tüm Aylar</option>
                        <option value="01">Ocak</option>
                        <option value="02">Şubat</option>
                        <option value="03">Mart</option>
                        <option value="04">Nisan</option>
                        <option value="05">Mayıs</option>
                        <option value="06">Haziran</option>
                        <option value="07">Temmuz</option>
                        <option value="08">Ağustos</option>
                        <option value="09">Eylül</option>
                        <option value="10">Ekim</option>
                        <option value="11">Kasım</option>
                        <option value="12">Aralık</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <br />
                            <div>
                                <?php
                              

                                // Check connection
                                if ($connection->connect_error) {
                                    die("Connection failed: " . $connection->connect_error);
                                }
                                ?>
                                <div class="responsive">
                                    <?php
                                    $query = "SELECT * FROM kayitlar ORDER BY id ASC";
                                    $result = $connection->query($query);
                                    ?>
                                    <table class="table table-striped table-bordered responsive" id="employee_data">
                                        <thead>
                                            <tr>
                                                <th>Tarih</th>
                                                <th>Konaklayan</th>
                                                <th>T1 Elektrik Sayaç D.</th>
                                                <th>T2 Elektrik Sayaç D.</th>
                                                <th>T3 Elektrik Sayaç D.</th>
                                                <th>Kapasitif Sayac</th>
                                                <th>Reaktif Sayac</th>
                                                <th>Sebeke Suyu</th>
                                                <th>Kuyu Suyu</th>
                                                <th>LNG</th>
                                                <th>Mazot</th>
                                                <th>Kömür</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                            <tr data-id="<?php echo $row['id']; ?>">
                                                <?php foreach ($row as $key => $value):
                                                    if ($key == "tarih"):
                                                        $formattedDate = date('d-m-Y', strtotime($value)); // Veritabanından gelen tarihi YYYY-MM-DD formatına dönüştür
                                                    ?>
                                                    <td class="date-cell" data-column="<?php echo $key; ?>" data-date="<?php echo $formattedDate; ?>"><?php echo $formattedDate; ?></td>
                                                    <?php elseif ($key != "id"): ?>
                                                    <td contenteditable="true" onBlur="saveToDatabase(this, '<?php echo $key; ?>', this.parentNode.getAttribute('data-id'))"><?php echo htmlspecialchars($value); ?></td>
                                                    <?php endif;
                                                endforeach; ?>
                                            </tr>
                                            <?php endwhile; ?>
                                            <tr id="newRow" data-id="0"></tr>
                                        </tbody>
                                    </table>
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
    <script src="assets/js/jquery.js"></script>
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
            // Tarih hücresine tıklandığında input oluşturma
            $('body').on('click', '.date-cell', function() {
                var dateValue = $(this).attr('data-date');
                if (!$(this).find('input').length) {  // Eğer input zaten yoksa oluştur
                    $(this).html('<input type="date" class="date-input" value="' + dateValue + '">');
                    $(this).find('input').focus();
                }
            });

            // Input dışında bir yere tıklandığında input'u kaydet ve kaldır
            $('body').on('blur', '.date-input', function() {
                var input = $(this);
                var newValue = input.val();
                var cell = input.parent();
                var column = cell.attr('data-column');
                var id = cell.closest('tr').attr('data-id');

                saveToDatabase(input, column, id, newValue);
                cell.attr('data-date', newValue); // Tarih değerini güncelle
                cell.html(newValue); // Gösterilen değeri güncelle
            });

            // Diğer hücreler için onblur olayı
            $('body').on('blur', '[contenteditable]', function() {
                var cell = $(this);
                var newValue = cell.text();
                var column = cell.attr('data-column');
                var id = cell.closest('tr').attr('data-id');

                saveToDatabase(cell, column, id, newValue);
            });

            // Ay seçimi değiştiğinde tabloyu filtrele
            $('#monthSelect').change(function() {
                var selectedMonth = $(this).val();
                filterTableByMonth(selectedMonth);
            });
        });

        function saveToDatabase(element, column, id, value) {
            $.ajax({
                url: "save_edit.php",
                type: "POST",
                data: {
                    column: column,
                    value: value,
                    id: id
                },
                success: function(response) {
                    console.log('Kaydedildi');
                },
                error: function(xhr, status, error) {
                    console.log('Hata: ' + error);
                }
            });
        }

        function filterTableByMonth(month) {
            $('#employee_data tbody tr').each(function() {
                var date = $(this).find('.date-cell').attr('data-date');
                if (date) {
                    var rowMonth = date.split('-')[1];
                    if (month === "" || rowMonth === month) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                }
            });
        }
    </script>
</div>


    
    
    
    
   <script>
 $(document).ready(function() {
    // Tarih hücresine tıklandığında input oluşturma
    $('body').on('click', '.date-cell', function() {
        var dateValue = $(this).attr('data-date');
        if (!$(this).find('input').length) {  // Eğer input zaten yoksa oluştur
            $(this).html('<input type="date" class="date-input" value="' + dateValue + '">');
            $(this).find('input').focus();
        }
    });

    // Input dışında bir yere tıklandığında input'u kaydet ve kaldır
    $('body').on('blur', '.date-input', function() {
        var input = $(this);
        var newValue = input.val();
        var cell = input.parent();
        var column = cell.attr('data-column');
        var id = cell.closest('tr').attr('data-id');

        saveToDatabase(input, column, id, newValue);
        cell.attr('data-date', newValue); // Tarih değerini güncelle
        cell.html(newValue); // Gösterilen değeri güncelle
    });

    // Diğer hücreler için onblur olayı
    $('body').on('blur', '[contenteditable]', function() {
        var cell = $(this);
        var newValue = cell.text();
        var column = cell.attr('data-column');
        var id = cell.closest('tr').attr('data-id');

        saveToDatabase(cell, column, id, newValue);
    });
});

function saveToDatabase(element, column, id, value) {
    $(element).css("background", "#FFF url('loaderIcon.gif') no-repeat right");

    if (!value) {
        if ($(element).is('input')) {
            value = $(element).val();
        } else {
            value = $(element).text();
        }
    }

    $.ajax({
        url: "save_edit.php",
        type: "POST",
        data: {
            column: column,
            editval: value,
            id: id
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (data.status === 'success') {
                $(element).css("background", "#FDFDFD");
                console.log("Success:", data);
                if (id == 0) {
                    $(element).closest('tr').attr('data-id', data.id);
                }
                // Veri başarıyla kaydedildiğinde kullanıcıya bilgi ver
               
            } else {
                console.error("Error:", data.message);
                // Hata mesajını sadece küçük değer girildiğinde göster
                if (data.message === 'Yeni değer önceki değerden küçük olamaz!') {
                    alert(data.message);
                }
            }
        },
        error: function(xhr, status, error) {
            console.log("Error:", xhr.responseText);
            // Hata mesajını konsola yazdır
            console.log("Bir hata oluştu! Lütfen tekrar deneyin.");
        }
    });
}

// Enter tuşuna basıldığında yeni satır ekleme
document.addEventListener('keydown', function(event) {
    if (event.key === "Enter") {
        var tableBody = document.querySelector("#employee_data tbody");
        var newRow = document.createElement('tr');
        newRow.setAttribute('data-id', '0'); // Yeni kayıt için geçici ID

        var columns = ['tarih', 'konaklayan', 't1', 't2', 't3', 'kapasitif_sayac', 'reaktif_sayac', 'sebeke_suyu', 'kuyu_suyu', 'lng', 'mazot', 'komur'];
        columns.forEach(function(column) {
            var newCell = newRow.insertCell();
            newCell.setAttribute('data-column', column);  // Kolon bilgisini ekle
            if (column === 'tarih') {
                var input = document.createElement('input');
                input.type = 'date';
                input.className = 'form-control';
                input.onblur = function() {
                    saveToDatabase(this, column, newRow.getAttribute('data-id'), this.value);
                };
                newCell.appendChild(input);
            } else {
                newCell.setAttribute('contenteditable', 'true');
                newCell.onblur = function() {
                    saveToDatabase(this, column, newRow.getAttribute('data-id'), this.innerText);
                };
            }
        });

        tableBody.appendChild(newRow);
    }
});


</script>

</body>
 
</html>
