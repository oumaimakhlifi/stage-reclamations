<?php
session_start();
require("auth.php");
require("connection.php");

if (isset($_GET["id"])) {
    $claim_id = $_GET["id"];
    $user_id = $_SESSION["user_id"];

    $delete_query = "DELETE FROM claim WHERE id='$claim_id' AND user_id='$user_id'";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        header("location: user_dashboard.php");
        exit();
    } else {
        echo "Erreur lors de la suppression de la réclamation.";
    }
} else {
    echo "ID de réclamation non spécifié.";
}
?>
