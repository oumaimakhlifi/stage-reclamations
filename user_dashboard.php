<?php
session_start();
require("auth.php");
require("connection.php");

$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM claim WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

if (isset($_GET["search_date"])) {
    $search_date = $_GET["search_date"];
    $query = "SELECT * FROM claim WHERE user_id='$user_id' AND DATE(date_reclamation) = '$search_date'";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Utilisateur</title>
    <!-- Intégrer les fichiers Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <div class="text-right mb-3">
            <a href="logout.php" class="btn btn-primary">
                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Se Déconnecter
            </a>
        </div>

        <h2 class="mb-4" style="margin-top: -20px;">Bienvenue, Utilisateur</h2>
        
        <div class="row mb-3">
            <div class="col-md-6">
                <h3>Mes Réclamations</h3>
            </div>
            <div class="col-md-6 text-right">
                <form class="form-inline" action="user_dashboard.php" method="get">
                    <div class="input-group">
                        <input type="date" class="form-control" name="search_date">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">Rechercher</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Description</th>
                    <th>Type de Panne</th>
                    <th>Priorité</th>
                    <th>Étage</th>
                    <th>Fonction</th>
                    <th>Déplacement</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th> <a href='submit_claim.php' class='btn btn-success'>Ajouter une Réclamation</a></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['type_panne'] . "</td>";
                        echo "<td>" . $row['priorite'] . "</td>";
                        echo "<td>" . $row['etage'] . "</td>";
                        echo "<td>" . $row['fonction'] . "</td>";
                        echo "<td>" . $row['deplacement'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>" . $row['date_reclamation'] . "</td>";
                        echo "<td class='d-flex'>";
                        echo "<a href='edit_claim.php?id=" . $row['id'] . "' class='btn btn-warning mr-2'>Modifier</a>";
                        echo "<a href='delete_claim.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Voulez-vous vraiment supprimer cette réclamation ?\")'>Supprimer</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Aucune réclamation trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <?php if (isset($_GET["search_date"])) : ?>
            <div class="text-center">
                <a href="user_dashboard.php" class="btn btn-danger">Annuler la Recherche</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Inclure les fichiers Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html
