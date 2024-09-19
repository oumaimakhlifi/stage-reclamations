<?php
session_start();
require("auth.php");
require("connection.php");

if ($_SESSION["role"] != "admin") {
    header("location: user_dashboard.php");
    exit();
}

$query = "SELECT * FROM claim";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gérer Réclamations</title>
</head>
<body>
    <h2>Gérer Réclamations</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Contenu</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>";
                echo "<a href='admin_edit_claim.php?id=" . $row['id'] . "' style='background-color: orange;'>Modifier Statut</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucune réclamation trouvée.</td></tr>";
        }
        ?>
    </table>
    
    <p><a href="admin_dashboard.php">Retour</a></p>
</body>
</html>



