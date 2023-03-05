<?php

// Check if a file was uploaded
if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {

    // Get the file name and extension
    $file_name = basename($_FILES["file"]["name"]);
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Generate a new unique file name to avoid overwriting existing files
    $new_file_name = uniqid() . '.' . $file_extension;

    // Specify the directory where uploaded files will be stored
    $target_dir = "/var/www/html/uploads/";

    // If the directory doesn't exist, create it
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Move the uploaded file to the target directory with the new file name
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $new_file_name)) {
        // File uploaded successfully, redirect back to the secured page
        header("Location: secured_page.html");
        exit();
    } else {
        // Error uploading file, display an error message
        echo "Sorry, there was an error uploading your file.";
    }

} else {
    // No file was uploaded or an error occurred, display an error message
    echo "Sorry, there was an error uploading your file.";
}
