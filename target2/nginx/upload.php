<?php
// Check if a file was uploaded
if (isset($_FILES['file'])) {
    // Define the upload directory
    $uploadDir = '/usr/share/nginx/html/uploads/';

    // Check if the upload directory exists and is writable
    if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
        die('Upload directory is not writable.');
    }

    // Check for upload errors
    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        switch ($_FILES['file']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded.';
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded.';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = 'Missing a temporary folder.';
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = 'Failed to write file to disk.';
                break;
            default:
                $message = 'Unknown error occurred while uploading the file.';
                break;
        }
        die($message);
    }

    // Move the uploaded file to the upload directory
    $uploadedFilePath = $uploadDir . $_FILES['file']['name'];
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $uploadedFilePath)) {
        die('Failed to move uploaded file to destination directory.');
    }

    // Redirect to the uploaded files page
    header('Location: uploads/');
    exit;
} else {
    // No file was uploaded
    echo 'No file uploaded.';
}
?>
