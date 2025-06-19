<?php
include "header.php";
require_once 'mysql/mysqlsorgu.php';

$conn = dbConnect();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function fetchData($conn, $month) {
    $data = [];
    $sql = "SELECT * FROM enerjitakip WHERE month='$month' ORDER BY day";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[$row['day']] = $row;
        }
    }

    return $data;
}

$months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
$currentMonth = date('n') - 1; // PHP's date('n') returns 1-12 for January to December
$month = isset($_GET['month']) ? $_GET['month'] : $months[$currentMonth];
$data = fetchData($conn, $month);
?>


<style>
    th, td {
        white-space: nowrap;
        text-align: center;
    }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    .dataTables_scrollBody {
        overflow-x: auto;
    }
    .DTFC_LeftBodyLiner {
        background-color: white !important;
        top: -12px !important;
    }
    .DTFC_LeftWrapper {
        background-color: white !important;
    }
    .DTFC_LeftHeadWrapper {
        background-color: white !important;
    }
    .DTFC_Cloned th,
    .DTFC_Cloned td {
        background-color: white !important;
    }
    
    .table-responsive {
        overflow-x: auto;
    }

    .fixedHeader-floating {
        top: 60px !important; /* Başlıkların sayfanın üst kısmından uzaklığını ayarlayın */
        z-index: 1001 !important;
    }

    .fixedHeader-floating th {
        background-color: white !important;
    }
</style>
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
                        <h4 class="mb-sm-0">Tesis Enerji Tüketim Verisi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                <li class="breadcrumb-item active">Tesis Enerji Tüketim Verisi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="monthSelect">Ay Seçiniz:</label>
                        <select id="monthSelect" class="form-control">
                            <?php
                            foreach ($months as $m) {
                                echo "<option value='$m'" . ($m == $month ? " selected" : "") . ">$m</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table id="energyTable" class="table table-bordered display nowrap dataTable" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2">GÜN</th>
                                    <th colspan="6" style="text-align: center; color:red;"><?php echo strtoupper($month); ?><br><hr style="color:black"><a style="color:black">Tesis Enerji Tüketim Takip</a></th>
                                </tr>
                                <tr>
                                    <th>LNG/CNG - KG</th>
                                    <th>Motorin - LT</th>
                                    <th>Araç Akaryakıt - LT</th>
                                    <th>Tüp 12 KG - Adet</th>
                                    <th>Tüp 45 KG - Adet</th>
                                    <th>Kömür - KG</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 1; $i <= 31; $i++): ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td contenteditable="true" class="editable" data-day="<?php echo $i; ?>" data-month="<?php echo $month; ?>" data-field="lngcng"><?php echo isset($data[$i]['lngcng']) ? $data[$i]['lngcng'] : ''; ?></td>
                                    
                                    <td contenteditable="true" class="editable" data-day="<?php echo $i; ?>" data-month="<?php echo $month; ?>" data-field="motorin"><?php echo isset($data[$i]['motorin']) ? $data[$i]['motorin'] : ''; ?></td>
                                    
                                    <td contenteditable="true" class="editable" data-day="<?php echo $i; ?>" data-month="<?php echo $month; ?>" data-field="aracakaryakit"><?php echo isset($data[$i]['aracakaryakit']) ? $data[$i]['aracakaryakit'] : ''; ?></td>
                                    
                                    <td contenteditable="true" class="editable" data-day="<?php echo $i; ?>" data-month="<?php echo $month; ?>" data-field="tup12"><?php echo isset($data[$i]['tup12']) ? $data[$i]['tup12'] : ''; ?></td>
                                    
                                    <td contenteditable="true" class="editable" data-day="<?php echo $i; ?>" data-month="<?php echo $month; ?>" data-field="tup45"><?php echo isset($data[$i]['tup45']) ? $data[$i]['tup45'] : ''; ?></td>
                                    
                                    <td contenteditable="true" class="editable" data-day="<?php echo $i; ?>" data-month="<?php echo $month; ?>" data-field="komur"><?php echo isset($data[$i]['komur']) ? $data[$i]['komur'] : ''; ?></td>
                                    
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
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
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.3/js/dataTables.fixedColumns.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>
<script type="text/javascript" src="assets/js/fixedheader.js"></script>

<script>
$(document).ready(function() {
    var table = $('#energyTable').DataTable({
        scrollX: true,
        paging: false,
        ordering: false,
        info: false,
        searching: false,
        fixedHeader: {
            header: true,
            footer: false
        },
        autoWidth: false
    });

    // Function to format numbers based on the conditions
    function formatNumber(value) {
        let number = parseFloat(value.replace(/\./g, '').replace(',', '.'));
        if (number >= 1000) {
            return number.toLocaleString('de-DE', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        }
        return value.replace('.', ',');
    }

    // Apply AutoNumeric for editable fields with a custom function
    $('.editable').each(function() {
        new AutoNumeric(this, {
            digitGroupSeparator: '.',
            decimalCharacter: ',',
            decimalPlaces: 3,
            modifyValueOnWheel: false,
            minimumValue: '0',
            allowDecimalPadding: true,
            currencySymbol: '',
            unformatOnSubmit: true
        });
    });

    // Apply formatting on blur
    $('.editable').on('blur', function() {
        let autoNumeric = AutoNumeric.getAutoNumericElement(this);
        let value = autoNumeric.getNumericString(); // Get the value in numeric string format
        let formattedValue = formatNumber(value);

        // Update the cell value with the formatted value
        $(this).text(formattedValue);

        let day = $(this).data('day');
        let month = $(this).data('month');
        let field = $(this).data('field');

        // Send the formatted value to the server
        $.ajax({
            url: 'save_data_enerjitakip.php',
            type: 'POST',
            data: {
                day: day,
                month: month,
                field: field,
                value: value // Send the numeric string value
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Handle month selection change
    $('#monthSelect').on('change', function() {
        var selectedMonth = $(this).val();
        window.location.href = "?month=" + selectedMonth;
    });

    // Set the default month to the current month
    $('#monthSelect').val('<?php echo $month; ?>');
});
</script>

</body>
</html>
