<?php
include 'header.php'; // Fonksiyonların olduğu dosyayı dahil ediyoruz

$connection = dbConnect();

// Kullanıcıları ve menü öğelerini alalım
$users = $connection->query("SELECT id, username FROM user");

// Kullanıcının mevcut yetkilerini al
$selectedUserId = isset($_POST['user_id']) ? $_POST['user_id'] : null;
$selectedPermissions = [];
if ($selectedUserId) {
    $permissions = $connection->prepare("SELECT menu_item_id FROM user_permissions WHERE user_id = ?");
    $permissions->bind_param("i", $selectedUserId);
    $permissions->execute();
    $result = $permissions->get_result();
    while ($row = $result->fetch_assoc()) {
        $selectedPermissions[] = $row['menu_item_id'];
    }
}

// Menü öğelerini kategorilerine göre alalım
$menuItems = $connection->query("SELECT id, name, category FROM menu_items ORDER BY category ASC, id ASC");

$menuByCategory = [];
while ($menuItem = $menuItems->fetch_assoc()) {
    $category = $menuItem['category'] ? $menuItem['category'] : 'Kategorisiz';
    $menuByCategory[$category][] = $menuItem;
}
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Menü Yetki Ayarı</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">VektraWeb</a></li>
                                <li class="breadcrumb-item active">Kullanıcı Yetkilendirme</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-6 mx-auto">
                    <div class="card shadow-sm">
                        <div class="card-header  text-white">
                            <h5 class="card-title mb-0">Kullanıcı Yetkilendirme</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="menuyetkiayari.php">
                                <!-- Kullanıcı seçme dropdown -->
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Kullanıcı Seç</label>
                                    <select class="form-select" name="user_id" id="user_id" onchange="this.form.submit()">
                                        <option selected disabled>Kullanıcı Seçin</option>
                                        <?php while ($user = $users->fetch_assoc()) { ?>
                                            <option value="<?php echo $user['id']; ?>" <?php echo ($selectedUserId == $user['id']) ? 'selected' : ''; ?>>
                                                <?php echo $user['username']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </form>

                            <?php if ($selectedUserId): ?>
                                <form method="post" action="yetkilendirme.php">
                                    <input type="hidden" name="user_id" value="<?php echo $selectedUserId; ?>">

                                    <!-- Menü yetkileri kategorilere göre gösterim -->
                                    <?php foreach ($menuByCategory as $category => $menuItems): ?>
                                        <h6 class="mt-4"><?php echo $category; ?></h6>
                                        <div class="form-check">
                                            <?php foreach ($menuItems as $menuItem): ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="checkbox" name="menu_items[]" value="<?php echo $menuItem['id']; ?>"
                                                        id="menuItem<?php echo $menuItem['id']; ?>" <?php echo in_array($menuItem['id'], $selectedPermissions) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="menuItem<?php echo $menuItem['id']; ?>">
                                                        <?php echo $menuItem['name']; ?>
                                                    </label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endforeach; ?>

                                    <!-- Gönder butonu -->
                                    <div class="mt-4 d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">Yetkilendir</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div> <!-- end card -->
                </div>
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div> <!-- page-content -->
</div> <!-- main-content -->

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

<!-- DataTables -->
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
</body>
</html>
