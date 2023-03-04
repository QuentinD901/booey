<?php
session_start();

// Check if the user has already logged in
if (isset($_SESSION['user_id'])) {
    // The user is already authenticated, grant access to the secured page
    header('Location: secured_page.php');
    exit;
}

// Check if the session ID cookie is set
if (isset($_COOKIE['session_id'])) {
    $session_id = $_COOKIE['session_id'];

    // Look up the session ID in the session store
    if (session_id() != $session_id) {
        // The session ID in the cookie is not valid, redirect the user to the login page
        header('Location: login_page.php');
        exit;
    } else {
        // The session ID in the cookie is valid, check if it has expired
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60 * 30)) {
            // The session has expired, destroy the session and redirect the user to the login page
            session_unset();
            session_destroy();
            setcookie('session_id', '', time() - 3600, '/');
            header('Location: login_page.php');
            exit;
        } else {
            // The session is still active, update the last activity time
            $_SESSION['last_activity'] = time();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connect to the database
    $db_host = 'target2';
    $db_user = 'root';
    $db_password = 'root';
    $db_name = 'target2';

    $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if the username and password exist in the database
    $query = "SELECT id FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        // The user is authenticated, generate a session ID and store it in the session store
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];
        $session_id = session_id();

        $_SESSION['user_id'] = $user_id;
        $_SESSION['session_id'] = $session_id;
        $_SESSION['last_activity'] = time();

        // Set a cookie with the session ID
        setcookie('session_id', $session_id, 0, '/');

        // Redirect the user to the secured page
        header('Location: secured_page.php');
        exit;
    } else {
        // The user is not authenticated, display an error message
        echo "Invalid username or password.";
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
