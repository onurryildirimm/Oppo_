<?php


require_once "mysql/mysqlsorgu.php";


try {
    $connection = getPDOConnection();
    
    $aramaTerimi = $_POST['arama_terimi'];

    $query = "SELECT * FROM tedarikcilistesi WHERE statu = 'ONAYLI SATICI' AND tedarikciadi LIKE :arama_terimi ORDER BY id DESC";
    $statement = $connection->prepare($query);
    $aramaTerimi = $aramaTerimi . '%'; // Başlangıçta eşleşenleri getir
    $statement->bindValue(':arama_terimi', $aramaTerimi);

    if ($statement->execute()) {
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        $output = '';

        foreach ($results as $result) {
            $output .= '<div class="col-md-4">';
            $output .= '<div class="card">';
            $output .= '<center><img src="uploads/logotrans.png" width="200px"></center>';
            $output .= '<div class="card-body">';
            $output .= '<h5 class="card-title">' . htmlspecialchars($result['tedarikciadi']) . '</h5>';
            $output .= '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($result['il']) . '</h6>';
            $output .= '<p class="card-text">' . htmlspecialchars($result['adresi']) . '</p>';
            $output .= '</div>';
            $output .= '<div class="button-container">';
            $output .= '<a href="detaylidegerlendirme?id='.$result['id'].'" class="btn btn-info"><i class="fas fa-link"></i> İncele</a>';
            $output .= '</div></br>';
            $output .= '</div>';
            $output .= '</div>';
        }

        echo $output;
    } else {
        echo ''; // Boş bir çıktı
    }
} catch (PDOException $e) {
    echo 'Hata: ' . $e->getMessage();
}
?>
