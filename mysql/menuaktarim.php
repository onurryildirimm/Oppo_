<?php
require_once "mysqlsorgu.php";

$menuItems = [
    ['Ana Sayfa', '/portal/lagunabeachalya', 'ri-honour-line'],
    ['İş Listem', 'yapilacaklar', 'ri-hand-coin-line'],
    ['Departman İşleri', 'departmanisler', 'ri-bubble-chart-line'],
    ['Devam Eden İşler', 'devamedenisler', 'ri-dashboard-2-line'],
    ['Tamamlanan İşler', 'tamamlananisler', 'ri-dashboard-2-line'],
    ['Hedef Takip', 'hedeftakip', 'ri-apps-2-line'],
    ['Hedef Kıyaslama', 'hedefkiyas', 'ri-apps-2-line'],
    ['Yıllık Eğitim Planı', 'yillikegitimplani', 'ri-pages-line'],
    ['Departman Eğitim Planı', 'departmanegitimplani', 'ri-pages-line'],
    ['Konaklama Takip', 'konaklamatakip', 'ri-hand-heart-line'],
    ['Elektrik Sayaç Takip', 'tesiselektriksayactakip', 'ri-hand-heart-line'],
    ['Su Sayaç Takip', 'sutakip', 'ri-hand-heart-line'],
    ['Tesis Enerji Takip', 'tesisenerjituketim', 'ri-hand-heart-line'],
    ['Depo Mal Kabul', 'urungrubuekle', 'ri-rocket-line'],
    ['Ürün Ekle', 'urunekle', 'ri-rocket-line'],
    ['Tedarikçi Sicil', 'tedarikcisicil', 'ri-rocket-line'],
    ['Teknik Servis', 'cihazekle', 'ri-settings-3-line'],
    ['İlaçlama Planı', 'yillikilaclama', 'las la-bug'],
    ['Atık Çizelgesi', 'atikplani', 'ri-recycle-fill'],
    ['Eşya Takip Formu', 'esyatakip', 'ri-file-edit-line'],
    ['Memorandum Hazırla', 'memorandumhazirla', 'ri-file-list-3-line'],
    ['İK Tutanaklar', 'iktutanak', 'ri-file-2-line'],
    ['Yönetim Sistemleri Dökümanları', 'dosyalarim', 'ri-file-2-line'],
    ['Dosyalarım', 'dosyalarim2', 'ri-file-2-line'],
];



// Veritabanına bağlan
$connection = dbConnect(); // dbConnect fonksiyonunu daha önce belirttiğin gibi kullanıyoruz

// Menü öğelerini ekle
function insertMenuItems($menuItems, $connection) {
    $sql = "INSERT INTO menu_items (name, link, icon) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);

    foreach ($menuItems as $menu) {
        $stmt->bind_param("sss", $menu[0], $menu[1], $menu[2]);
        $stmt->execute();
    }

    echo "Menü öğeleri başarıyla eklendi!";
}

// Menü öğelerini veritabanına aktar
insertMenuItems($menuItems, $connection);

?>