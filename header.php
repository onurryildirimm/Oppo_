<?php
include 'mysql/mysqlsorgu.php';
$connection = dbConnect(); 
$pdoconnection = getPDOConnection();

include_once("inc/config.php");
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

updateUserStatus($pdoconnection, $id, 'Online');

header('Content-Type: text/html; charset=utf-8');

// Lisans bilgilerini veritabanından al
$licenseKey = "test1-VEKTRALIC-401476"; // Lisans anahtarı
$expiryDate = "2025-09-09"; // Lisans bitiş tarihi

// Şu anki tarihi al
$currentDate = new DateTime();

// Lisans bitiş tarihini DateTime nesnesine dönüştür
$expiryDateObj = new DateTime($expiryDate);

// Lisans kontrolü yap
if ($currentDate > $expiryDateObj) {
    // Lisans süresi geçmiş, sayfa çalışmasın
    echo "Lisans süresi geçmiş. Sayfayı kullanamazsınız.";
    exit;
}

// Lisans bitiş tarihi ile şu anki tarih arasındaki farkı hesapla
$interval = $currentDate->diff($expiryDateObj);

// Kalan gün, saat, dakika ve saniyeleri al
$remainingDays = $interval->days;
$remainingHours = $interval->h;
$remainingMinutes = $interval->i;
$remainingSeconds = $interval->s;

$notifications = getNotifications($pdoconnection, $user['username']);
?>

<!DOCTYPE html>
<html lang="tr" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

     <meta charset="UTF-8">
    <title>VektraWeb - Yönetim Portalı</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="VektraWeb Bulut Tabanlı Yönetim Portalı" name="description" />
    <meta content="VektraWeb" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <!-- plugin css -->
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.dataTables.min.css">

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="../lagunabeachalya" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="assets/images/vektralogo.png" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/vektralogo.png" alt="" height="50">
                        </span>
                    </a>

                    <a href="../lagunabeachalya" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="assets/images/vektralogo.png" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="assets/images/vektralogo.png" alt="" height="50">
                        </span>
                    </a>
                </div>
                <div class="position-relative">
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <!--<div class="dropdown topbar-head-dropdown ms-1 header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-category-alt fs-22'></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                        <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h6 class="m-0 fw-semibold fs-15"> Ek Uygulamalar </h6>
                                </div>
                                
                            </div>
                        </div>

                        <div class="p-2">
                            <div class="row g-0">
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="assets/images/brands/WhatsApp.png" alt="WhatsApp">
                                        <span>WhatsApp</span>
                                    </a>
                                </div>
                                <div class="col">
                                    <a class="dropdown-icon-item" href="#!">
                                        <img src="assets/images/brands/mail.png" alt="mail">
                                        <span>E-Mail</span>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div> -->

                
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?php 
    $usernames = $user["username"];

    try {
        $sql = "SELECT COUNT(*) as total FROM notifications WHERE username = :username";
        $stmt = $pdoconnection->prepare($sql);
        $stmt->bindParam(':username', $usernames, PDO::PARAM_STR);
        $stmt->execute();

        // Sonuçları al
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_notifications = $row['total'];
        echo $total_notifications;

    } catch (PDOException $e) {
        echo "Sorgu hatası: " . $e->getMessage();
    }
    ?><span class="visually-hidden">unread messages</span></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Bildirim Paneli </h6>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="px-2 pt-2">
                                <ul class="nav nav-tabs dropdown-tabs nav-tabs-custom" data-dropdown-tabs="true" id="notificationItemsTab" role="tablist">
                                    <li class="nav-item waves-effect waves-light">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-noti-tab" role="tab" aria-selected="true">
                                            Bildirimler (<?php 
    try {
        $sql = "SELECT COUNT(*) as total FROM notifications WHERE username = :username";
        $stmt = $pdoconnection->prepare($sql);
        $stmt->bindParam(':username', $usernames, PDO::PARAM_STR);
        $stmt->execute();

        // Sonuçları al
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_notifications = $row['total'];
        echo $total_notifications;

    } catch (PDOException $e) {
        echo "Sorgu hatası: " . $e->getMessage();
    }
    ?>)
                                        </a>
                                    </li>
                                    
                                </ul>
                            </div>

                        </div>
                         
                        <div class="tab-content position-relative" id="notificationItemsTabContent">
    <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
        <div data-simplebar style="max-height: 300px;" class="pe-2">
            <?php
            try {
                $sql = "SELECT * FROM notifications WHERE username = :username";
                $stmt = $pdoconnection->prepare($sql);
                $stmt->bindParam(':username', $usernames, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (count($result) > 0) {
                    foreach($result as $row) {
            ?>
                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                        <div class="d-flex">
                            <div class="avatar-xs me-3 flex-shrink-0">
                                <span class="avatar-title bg-info-subtle text-info rounded-circle fs-16">
                                    <i class="bx bx-badge-check"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <a href="mesajlar" class="stretched-link">
                                    <h6 class="mt-0 mb-2 lh-base"><?php
                                        $message = $row["message"];
                                        $maxLength = 12; // Kısaltılan metin için belirlenen maksimum karakter sayısı
                                        if (strlen($message) > $maxLength) {
                                            $message = substr($message, 0, $maxLength) . "..."; // İstenilen karakter sayısı kadar kısaltılır ve sonuna üç nokta eklenir
                                        }
                                        echo $message;
                                    ?></h6>
                                </a>
                                <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                    <span><i class="mdi mdi-clock-outline"></i> <?php echo $row["title"]; ?></span>
                                </p>
                            </div>
                            <div class="px-2 fs-15">
                                <div class="form-check notification-check">
                                    <button type="button" class="btn btn-danger btn-xs deletenotify" data-notificationid="<?php echo $row['id']; ?>"><i class="ri-delete-bin-5-line"></i></button>
                                    <label class="form-check-label" for="all-notification-check01"></label>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                    } // foreach sonu
                } // if sonu
            } catch (PDOException $e) {
                echo "Sorgu hatası: " . $e->getMessage();
            }
            ?>
            
            <div class="my-3 text-center view-all">
                <button type="button" id="gotoInbox" class="btn btn-soft-success waves-effect waves-light">Mesaj Kutusuna Git <i class="ri-arrow-right-line align-middle"></i></button>
            </div>
        </div>
        <script>
            document.getElementById("gotoInbox").addEventListener("click", function() {
                window.location.href = "mesajlar"; 
            });
        </script>
    </div>

    <div class="tab-pane fade p-4" id="alerts-tab" role="tabpanel" aria-labelledby="alerts-tab"></div>

    <div class="notification-actions" id="notification-actions">
        <div class="d-flex text-muted justify-content-center">
            Select <div id="select-content" class="text-body fw-semibold px-1">0</div> Result <button type="button" class="btn btn-link link-danger p-0 ms-3" data-bs-toggle="modal" data-bs-target="#removeNotificationModal">Remove</button>
        </div>
    </div>
</div></div>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="<?php echo $user["profile_image"]; ?>" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo $user["name"]; ?> <?php echo $user["surname"]; ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?php echo $user["gorev"]; ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        
                        <h6 class="dropdown-header">Hoşgeldin <?php echo $user["name"].' '.$user["surname"]; ?></h6>
                        <a class="dropdown-item" href="profil"><i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Profil</span></a>
                        <a class="dropdown-item" href="mesajlar"><i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Mesaj Kutusu</span></a>
                        <a class="dropdown-item" href="yapilacaklar"><i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span class="align-middle">Yapılacak Listem</span></a>
                        
                        <div class="dropdown-divider"></div>
                        
                        
                        <a class="dropdown-item" href="logout"><i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span class="align-middle" data-key="t-logout">Çıkış Yap</span></a>
                    </div>
                </div>
            </div>
        </div>
    
</header>


        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <!-- Dark Logo-->
                <a href="../lagunabeachalya" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="assets/images/vektralogo.png" alt="" height="40">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/vektralogo.png" alt="" height="40">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="../lagunabeachalya" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="assets/images/logotrans.png" alt="" height="25">
                    </span>
                    <span class="logo-lg">
                        <img src="assets/images/vektralogo.png" alt="" height="50">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <?php 
                    $userId = $id;  // $id = $user['id']; olarak tanımlanmış
                    
    
    function getUserMenuItemsWithCategory($userId, $connection) {
    $sql = "SELECT mi.name, mi.link, mi.icon, mi.category 
        FROM menu_items mi 
        JOIN user_permissions up ON mi.id = up.menu_item_id 
        WHERE up.user_id = ? AND up.is_visible = 1
        ORDER BY mi.id ASC";




    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    return $stmt->get_result();
}

$userId = $id;  // Oturumdaki kullanıcı id'si
$menuItems = getUserMenuItemsWithCategory($userId, $connection);

// Geçerli kategoriye göre menü öğelerini gruplayalım
$currentCategory = '';
echo '<ul class="navbar-nav" id="navbar-nav">
<li class="menu-title"><span data-key="t-menu">Menu</span></li>';

while ($menuItem = $menuItems->fetch_assoc()) {
    // Eğer menü öğesinin bir kategorisi varsa
    if (!empty($menuItem['category'])) {
        // Yeni bir kategoriye geçtiysek başlık ekleyelim
        if ($menuItem['category'] != $currentCategory) {
            if ($currentCategory != '') {
                // Önceki kategori için listeyi kapat
                echo '</ul></div></li>';
            }

            // Kategori başlığı ve açılır menü yapısı ekleyelim
            // Kategorinin kendi belirlenen ikonu varsa onu kullan, yoksa kategori başlığında ikon olmayabilir
            $categoryIcon = !empty($menuItem['icon']) ? $menuItem['icon'] : '';

            echo '<li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebar-' . strtolower($menuItem['category']) . '" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebar-' . strtolower($menuItem['category']) . '">
                        <i class="' . $categoryIcon . '"></i> <span>' . $menuItem['category'] . '</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebar-' . strtolower($menuItem['category']) . '">
                        <ul class="nav nav-sm flex-column">';
            
            // Yeni kategoriye geçiyoruz, currentCategory'yi güncelle
            $currentCategory = $menuItem['category'];
        }

        // Kategorisi olan menü öğesini "-" ile ekleyelim, ikon olmadan
        echo '<li class="nav-item">
                <a class="nav-link menu-link" href="' . $menuItem['link'] . '">
                    - <span>' . $menuItem['name'] . '</span>
                </a>
              </li>';
    } else {
        // Kategorisi olmayan tek başına menü öğesi, kategorinin altına girmemesi için ayrı gösteriyoruz
        if ($currentCategory != '') {
            // Mevcut kategoriyi kapatalım
            echo '</ul></div></li>';
            $currentCategory = '';  // Kategori boşaltılıyor
        }

        // Kategorisi olmayan menü öğesi ID sırasına göre gösterilecek
        $menuIcon = !empty($menuItem['icon']) ? $menuItem['icon'] : 'ri-file-line';  // Varsayılan ikon

        echo '<li class="nav-item">
                <a class="nav-link menu-link" href="' . $menuItem['link'] . '">
                    <i class="' . $menuIcon . '"></i>
                    <span>' . $menuItem['name'] . '</span>
                </a>
              </li>';
    }
}

// Eğer hala açık bir kategori varsa kapanış ekleyelim
if ($currentCategory != '') {
    echo '</ul></div></li>';
}

echo '</ul>';

?>
                            </div>
                        </li>

                        
                                                        </ul>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>