<?php
include '../mysql/mysqlsorgu.php';
$connection = dbConnect(); 
$pdoconnection = getPDOConnection();

include_once("../inc/config.php");
$firmalaraOzelIsim = "test1"; // Firma Laguna için
session_name($firmalaraOzelIsim);
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: login");
    exit;
}
$user = $_SESSION['login_user'];
$departman = $user['departman'];
$role = $user['role'];
$id = $user['id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Dosya Yönetimi</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">

    <!-- İşlem Butonları -->
    <?php if ($role == 'admin'): ?>
<div class="d-flex justify-content-between mb-3">
    <div>
        <button id="deleteButton" class="btn btn-danger">Sil</button>
        <button id="renameButton" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#renameModal">Yeniden Adlandır</button>
        <button id="copyButton" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#destinationModal">Kopyala</button>
        <button id="moveButton" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#destinationModal">Taşı</button>
        <button id="uploadButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">Dosya Yükle</button>
        <button id="createFolderButton" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#folderModal">Klasör Oluştur</button>
    </div>

<?php endif; ?>
        <?php
        // Ana dizin yolu
        $baseDir = realpath("uploads/");
        // Şu anki dizin
        $currentDir = realpath(isset($_GET['folder']) ? $_GET['folder'] : "uploads/");
        ?>
        <div class="d-flex justify-content-between mb-3">
            <div>
                <!-- Geri Dön Butonu (Ana dizinde değilse göster) -->
                <?php if ($currentDir !== $baseDir): ?>
                    <a href="<?php echo '?folder=' . urlencode(dirname($currentDir)); ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div>
                <input class="form-control form-control-sm" id="searchBox" type="text" placeholder="Ara...">
            </div>
        </div>
    </div>

    <!-- Dosya ve Klasör Listeleme (Tablo) -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Seç</th>
                    <th>Adı</th>
                    <th>Değiştirilme Tarihi</th> <!-- Tarih sütunu eklendi -->
                </tr>
            </thead>
            <tbody id="fileList">
                <?php
                // Normal dosya listeleme işlemi (sadece ana dizindeki dosyalar ve klasörler)
                $dir = isset($_GET['folder']) ? $_GET['folder'] : "uploads/";
                $files = scandir($dir);

                // Klasörleri listele
                foreach ($files as $file) {
                    $filePath = realpath($dir . '/' . $file);  // Tam dosya yolunu kullanıyoruz
                    if (is_dir($filePath) && $file != "." && $file != "..") {
                        $link = "?folder=" . urlencode($filePath);
                        $lastModified = date("d-m-Y H:i", filemtime($filePath));  // Dosya değiştirilme tarihi
                        echo "<tr>
                                <td><input type='checkbox' class='fileCheckbox' data-path='$filePath'></td>
                                <td><a href='$link' class='fileLink'><i class='fas fa-folder'></i> $file</a></td>
                                <td>$lastModified</td> <!-- Tarih bilgisi eklendi -->
                              </tr>";
                    }
                }
                // Ana dizin (web erişim için uygun olan kısım)
$baseDirWeb = 'uploads/';

// Dosya listeleme kısmında
foreach ($files as $file) {
    $filePath = realpath($dir . '/' . $file);  // Tam dosya yolunu alıyoruz
    if (!is_dir($filePath)) {
        // Web yolunu oluştururken sadece dosya adını kodluyoruz, dizinleri kodlamıyoruz
        $encodedFileName = rawurlencode($file);  // Dosya adı
        $relativePath = str_replace($baseDir, '', $filePath);  // Ana dizin yolunu çıkar
        $relativePath = rawurlencode('uploads/' . $relativePath);  // uploads kısmını ekle ve dosya yolunu kodla
        $relativePath = str_replace('%2F', '/', $relativePath);  // Dizini korumak için %2F'yi tekrar / ile değiştir
        $lastModified = date("d-m-Y H:i", filemtime($filePath));  // Dosya değiştirilme tarihi
        echo "<tr>
                <td><input type='checkbox' class='fileCheckbox' data-path='$filePath'></td>
                <td><a href='/portal/test1/dosyalar/$relativePath' class='fileLink'><i class='fas fa-file'></i> $file</a></td>
                <td>$lastModified</td> <!-- Tarih bilgisi eklendi -->
              </tr>";
    }
}


                ?>
            </tbody>
        </table>
    </div>

    <!-- Dosya Yükleme Modal -->
    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Dosya Yükle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
                        <button type="submit" class="btn btn-primary mt-3">Yükle</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Klasör Oluşturma Modal -->
    <div class="modal fade" id="folderModal" tabindex="-1" aria-labelledby="folderModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="folderModalLabel">Klasör Oluştur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="folderForm">
                        <input type="text" name="folderName" id="folderName" class="form-control" placeholder="Klasör Adı">
                        <button type="submit" class="btn btn-secondary mt-3">Oluştur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Klasör Seçim Modal -->
    <div class="modal fade" id="destinationModal" tabindex="-1" aria-labelledby="destinationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="destinationModalLabel">Klasör Seç</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <?php
                        // Klasörleri listeleyin
                        $folders = scandir("uploads/");
                        foreach ($folders as $folder) {
                            if (is_dir("uploads/" . $folder) && $folder != "." && $folder != "..") {
                                echo "<li class='list-group-item folder-item' data-folder='uploads/$folder'>$folder</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="confirmAction">Onayla</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Yeniden Adlandırma Modal -->
    <div class="modal fade" id="renameModal" tabindex="-1" aria-labelledby="renameModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="renameModalLabel">Dosya veya Klasörü Yeniden Adlandır</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="renameForm">
                        <input type="text" name="newName" id="newName" class="form-control" placeholder="Yeni Adı Girin">
                        <input type="hidden" name="oldPath" id="oldPath">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    <button type="button" id="confirmRename" class="btn btn-primary">Yeniden Adlandır</button>
                </div>
            </div>
        </div>
    </div>

<script>
$(document).ready(function(){
    var selectedAction = '';

    // Arama Fonksiyonu (sadece arama yapıldığında alt klasörleri tarar)
    $("#searchBox").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        if (value) {
            // Recursive tarama yap
            $.ajax({
                url: 'search.php',
                type: 'POST',
                data: { search: value },
                success: function(response) {
                    $("#fileList").html(response);
                }
            });
        } else {
            location.reload();  // Eğer arama kutusu boşsa sayfayı yenile
        }
    });

    // Dosya Yükleme
    $('#uploadForm').on('submit', function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'upload.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response){
                alert(response);
                location.reload(); // Sayfayı yeniler
            }
        });
    });

    // Yeniden adlandırma işlemi için dosya seçimi
    $('#renameButton').on('click', function(){
        var selectedFile = $('.fileCheckbox:checked').first().data('path');
        if (!selectedFile) {
            alert('Lütfen yeniden adlandırmak için bir dosya veya klasör seçin.');
            return;
        }
        $('#oldPath').val(selectedFile);
    });

    // Yeniden adlandırmayı onayla
    $('#confirmRename').on('click', function(){
        var oldPath = $('#oldPath').val();
        var newName = $('#newName').val();

        if (!newName) {
            alert('Yeni bir ad girin.');
            return;
        }

        $.ajax({
            url: 'rename.php',
            type: 'POST',
            data: { oldPath: oldPath, newName: newName },
            success: function(response){
                alert(response);
                location.reload();
            }
        });
    });

    // Klasör Oluşturma
    $('#folderForm').on('submit', function(e){
        e.preventDefault();
        var folderName = $('#folderName').val();
        $.ajax({
            url: 'create_folder.php',
            type: 'POST',
            data: { folderName: folderName },
            success: function(response){
                alert(response);
                location.reload();
            }
        });
    });

    // Seçilen Dosyaları Silme
    $('#deleteButton').on('click', function(){
        $('.fileCheckbox:checked').each(function(){
            var filePath = $(this).data('path');
            console.log(filePath);  // Dosya yolunu kontrol etmek için bunu ekleyin
            $.ajax({
                url: 'delete.php',
                type: 'GET',
                data: { file: filePath },
                success: function(response){
                    alert(response);
                    location.reload();
                }
            });
        });
    });

    // Kopyalama ve Taşıma İşlemleri için aksiyon seçimi
    $('#copyButton').on('click', function() {
        selectedAction = 'copy';
    });

    $('#moveButton').on('click', function() {
        selectedAction = 'move';
    });

    // Klasör seçimi ve onay
    $('.folder-item').on('click', function() {
        $('.folder-item').removeClass('active');
        $(this).addClass('active');
    });

    $('#confirmAction').on('click', function() {
        var destination = $('.folder-item.active').data('folder');
        if (!destination) {
            alert('Bir klasör seçmelisiniz!');
            return;
        }

        $('.fileCheckbox:checked').each(function(){
            var filePath = $(this).data('path');
            var actionUrl = selectedAction === 'copy' ? 'copy.php' : 'move.php';

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: { file: filePath, destination: destination },
                success: function(response) {
                    alert(response);
                    location.reload();
                }
            });
        });

        // Modalı kapat
        $('#destinationModal').modal('hide');
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
