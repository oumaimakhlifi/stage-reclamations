<?php
session_start();
require("auth.php");
require("connection.php");

if (isset($_GET["search_date"])) {
    $search_date = $_GET["search_date"];
    $user_id = $_SESSION["user_id"];

    $query = "SELECT * FROM claim WHERE user_id='$user_id' AND DATE(date_reclamation) = '$search_date'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Afficher les résultats de la recherche ici
            // Vous pouvez utiliser une structure similaire à celle dans user_dashboard.php
        }
    } else {
        echo "Aucune réclamation trouvée pour la date sélectionnée.";
    }
} else {
    echo "Date de recherche non spécifiée.";
}
?>
