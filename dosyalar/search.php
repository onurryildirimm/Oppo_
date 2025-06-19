<?php
if (isset($_POST['search'])) {
    $search = strtolower($_POST['search']);
    $dir = "uploads/";

    function scanDirRecursiveForSearch($dir) {
        $files = scandir($dir);
        $results = [];
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                $filePath = $dir . '/' . $file;
                if (is_dir($filePath)) {
                    $results = array_merge($results, scanDirRecursiveForSearch($filePath));  // Alt klasörleri de tarar
                }
                $results[] = $filePath;
            }
        }
        return $results;
    }

    $allFiles = scanDirRecursiveForSearch($dir);
    $foundFiles = array_filter($allFiles, function($file) use ($search) {
        return strpos(strtolower($file), $search) !== false;
    });

    // Sonuçları döndür
    foreach ($foundFiles as $filePath) {
        $file = basename($filePath);
        $icon = is_dir($filePath) ? "fas fa-folder" : "fas fa-file";
        $link = is_dir($filePath) ? "?folder=" . urlencode($filePath) : $filePath;

        echo "<div class='list-group-item'>
                <input type='checkbox' class='fileCheckbox' data-path='$filePath'>
                <a href='$link' class='fileLink'><i class='$icon'></i> $file</a>
              </div>";
    }
}
?>
