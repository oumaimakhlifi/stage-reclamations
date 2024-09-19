<?php
session_start();
require("auth.php");
require("connection.php");

if ($_SESSION["role"] != "admin") {
    header("location: user_dashboard.php");
    exit();
}

// Supprimer les réclamations "terminées" depuis plus d'un mois
$delete_query = "DELETE FROM claim WHERE status = 'terminé' AND date_reclamation <= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
$delete_result = mysqli_query($conn, $delete_query);

// Gestion de la recherche par date et par nom d'utilisateur
$search_date = $_GET["search_date"] ?? "";
$search_username = $_GET["search_username"] ?? "";

if (!empty($search_date)) {
    $search_query = "SELECT claim.*, users.username FROM claim JOIN users ON claim.user_id = users.user_id WHERE DATE(claim.date_reclamation) = '$search_date'";
} elseif (!empty($search_username)) {
    $search_query = "SELECT claim.*, users.username FROM claim JOIN users ON claim.user_id = users.user_id WHERE users.username LIKE '%$search_username%'";
} else {
    $search_query = "SELECT claim.*, users.username FROM claim JOIN users ON claim.user_id = users.user_id";
}

$result = mysqli_query($conn, $search_query);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Administrateur</title>
    <!-- Intégrer les fichiers Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <h2 class="text-right">
            Bienvenue, Administrateur
            <a href="logout.php" class="btn btn-primary ml-2">
                <i class="fa fa-sign-out"></i> Se Déconnecter
            </a>
        </h2>

        <form class="form-inline mb-3" action="#" method="get">
            <!-- Champs de recherche par date -->
            <div class="input-group mr-2">
                <input type="date" class="form-control" name="search_date" value="<?php echo $search_date; ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Rechercher par Date</button>
                </div>
            </div>
            
            <!-- Champs de recherche par nom d'utilisateur -->
            <div class="input-group mr-2">
                <input type="text" class="form-control" name="search_username" placeholder="Nom d'utilisateur" value="<?php echo $search_username; ?>">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Rechercher par Nom</button>
                </div>
            </div>
            
            <!-- Bouton pour annuler la recherche -->
            <div class="input-group">
                <a href="admin_dashboard.php" class="btn btn-danger">Annuler la Recherche</a>
            </div>
        </form>
        
        <h3>Gérer les Réclamations</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Utilisateur</th>
                    <th>Description</th>
                    <th>Date de Réclamation</th>
                    <th>Priorité</th>
                    <th>Type de Panne</th>
                    <th>Étage</th>
                    <th>Fonction</th>
                    <th>Déplacement</th>
                    <th>Statut</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['date_reclamation'] . "</td>";
                        echo "<td>" . $row['priorite'] . "</td>";
                        echo "<td>" . $row['type_panne'] . "</td>";
                        echo "<td>" . $row['etage'] . "</td>";
                        echo "<td>" . $row['fonction'] . "</td>";
                        echo "<td>" . $row['deplacement'] . "</td>";
                        echo "<td>" . $row['status'] . "</td>";
                        echo "<td>";
                        echo "<a href='admin_edit_claim.php?id=" . $row['id'] . "' class='btn btn-warning mr-2'>Modifier</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>Aucune réclamation trouvée.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Inclure les fichiers Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Inclure FontAwesome pour l'icône de déconnexion -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</body>
</html>

