<?php
$targetDirectory = "documents/";

if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

if (!empty($_FILES['files']['name'][0])) {
    $totalFiles = count($_FILES['files']['name']);
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $maxsize = 5 * 1024 * 1024;

    for ($i = 0; $i < $totalFiles; $i++) {
        $fileName = $_FILES['files']['name'][$i];
        $fileTmp  = $_FILES['files']['tmp_name'][$i];
        $fileSize = $_FILES['files']['size'][$i];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $targetFile = $targetDirectory . $fileName;

        if (in_array($fileType, $allowedExtensions) && $fileSize <= $maxsize) {
            if (move_uploaded_file($fileTmp, $targetFile)) {
                echo "File <b>$fileName</b> berhasil diunggah.<br>";

                echo "<img src='$targetFile' width='150' style='height:auto; margin:5px; border:1px solid #ccc; border-radius:6px;'><br>";
            } else {
                echo "Gagal mengunggah file <b>$fileName</b>.<br>";
            }
        } else {
            echo "File <b>$fileName</b> tidak valid (bukan gambar atau melebihi ukuran maksimum 5MB).<br>";
        }
    }
} else {
    echo "Tidak ada file yang diunggah.";
}
?>
