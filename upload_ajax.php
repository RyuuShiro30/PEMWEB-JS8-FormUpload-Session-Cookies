<?php
$targetDirectory = "uploads/";
if (!file_exists($targetDirectory)) {
    mkdir($targetDirectory, 0777, true);
}

if (isset($_FILES['file'])) {

    if (is_array($_FILES['file']['name'])) {
        $totalFiles = count($_FILES['file']['name']);
    } else {
        $totalFiles = 1;
    }

    $successMessages = []; 
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    $maxsize = 5 * 1024 * 1024; // 5 MB

    for ($i = 0; $i < $totalFiles; $i++) {
        $errors = array();

        $file_name = is_array($_FILES['file']['name']) ? $_FILES['file']['name'][$i] : $_FILES['file']['name'];
        $file_size = is_array($_FILES['file']['size']) ? $_FILES['file']['size'][$i] : $_FILES['file']['size'];
        $file_tmp  = is_array($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'][$i] : $_FILES['file']['tmp_name'];

        if (empty($file_name)) continue; 

        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowedExtensions)) {
            $errors[] = "Ekstensi **$file_name** tidak valid. Hanya JPG, PNG, GIF yang diizinkan.";
        }
        if ($file_size > $maxsize) {
            $errors[] = "Ukuran **$file_name** melebihi batas 5 MB.";
        }

        if (empty($errors)) {
            $target_path = $targetDirectory . basename($file_name);
            if (move_uploaded_file($file_tmp, $target_path)) {
                $successMessages[] = "File **$file_name** berhasil diunggah.";
            } else {
                $successMessages[] = "Gagal mengunggah file **$file_name** (Kesalahan Server).";
            }
        } else {
            $successMessages[] = implode('<br>', $errors);
        }
    }

    echo implode('<br>', $successMessages);
    
} else {
    echo "Tidak ada file yang diterima.";
}
?>
