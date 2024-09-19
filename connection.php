<?php
require('config.php');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die('Failed to connect to database: ' . $conn->connect_error);
}



 
    date_default_timezone_set('Africa/Tunis');
    $currentTimestamp = time();
    $newTimestamp = $currentTimestamp + 3600; // Ajouter 1 heure (3600 secondes)
    date_default_timezone_set('Africa/Tunis');

?>

