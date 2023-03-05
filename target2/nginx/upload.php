<?php
// Check if a file was uploaded
if (isset($_FILES['file'])) {
    // Define the upload directory
    $uploadDir = '/var/www/html/uploads/';
    
    // Move the uploaded file to the upload directory
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $_FILES['file']['name']);
    
    // Redirect to the uploaded files page
    header('Location: /uploads/');
    exit;
} else {
    // No file was uploaded
    echo 'No file uploaded.';
}
?>
