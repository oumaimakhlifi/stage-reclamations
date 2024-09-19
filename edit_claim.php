<?php
session_start();
require("auth.php");
require("connection.php");

$claim_id = $_GET["id"];

// Vérifier si l'utilisateur peut accéder à la réclamation
$query = "SELECT * FROM claim WHERE id='$claim_id' AND user_id='{$_SESSION["user_id"]}'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Réclamation introuvable.";
    exit();
}

$claim = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_type_panne = $_POST["type_panne"];
    $new_fonction = $_POST["fonction"];
    $new_priorite = $_POST["priorite"];
    $new_etage = $_POST["etage"];
    $new_deplacement = $_POST["deplacement"];
    $new_description = $_POST["description"];
   
    $current_date = date("Y-m-d H:i:s");
   
    $update_query = "UPDATE claim SET type_panne='$new_type_panne', fonction='$new_fonction', priorite='$new_priorite', etage='$new_etage', deplacement='$new_deplacement', description='$new_description', date_reclamation='$current_date' WHERE id='$claim_id' AND user_id='{$_SESSION["user_id"]}'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        header("location: user_dashboard.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour de la réclamation.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier la Réclamation</title>
    <!-- Intégrer les fichiers Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-3">
        <h2>Modifier la Réclamation</h2>
        <form action="edit_claim.php?id=<?php echo $claim_id; ?>" method="post">
            <div class="form-group">
                <label for="type_panne">Type de Panne :</label>
                <select class="form-control" name="type_panne" required>
                    <option value="logiciel" <?php if ($claim["type_panne"] == "logiciel") echo "selected"; ?>>Logiciel</option>
                    <option value="materiel" <?php if ($claim["type_panne"] == "materiel") echo "selected"; ?>>Matériel</option>
                </select>
            </div>
            
            <div class="form-group">
    <label for="fonction">Fonction :</label>
    <select class="form-control" name="fonction" required>
        <option value="Direction Générale" <?php if ($claim["fonction"] == "Direction Générale") echo "selected"; ?>>Direction Générale</option>
        <option value="Direction de l'Exploitation" <?php if ($claim["fonction"] == "Direction de l'Exploitation") echo "selected"; ?>>Direction de l'Exploitation</option>
        <option value="Direction de la Navigation Aerienne" <?php if ($claim["fonction"] == "Direction de la Navigation Aerienne") echo "selected"; ?>>Direction de la Navigation Aérienne</option>
        <option value="Direction de la Surete et de la Securite" <?php if ($claim["fonction"] == "Direction de la Surete et de la Securite") echo "selected"; ?>>Direction de la Sûreté et de la Sécurité</option>
        <option value="Direction des Ressources Humaines" <?php if ($claim["fonction"] == "Direction des Ressources Humaines") echo "selected"; ?>>Direction des Ressources Humaines</option>
        <option value="Direction Financiere et Administrative" <?php if ($claim["fonction"] == "Direction Financiere et Administrative") echo "selected"; ?>>Direction Financière et Administrative</option>
        <option value="Direction des Projets" <?php if ($claim["fonction"] == "Direction des Projets") echo "selected"; ?>>Direction des Projets</option>
        <option value="Direction de la Communication et des Relations Publiques" <?php if ($claim["fonction"] == "Direction de la Communication et des Relations Publiques") echo "selected"; ?>>Direction de la Communication et des Relations Publiques</option>
        <option value="Direction de la Qualite et de la Conformite" <?php if ($claim["fonction"] == "Direction de la Qualite et de la Conformite") echo "selected"; ?>>Direction de la Qualité et de la Conformité</option>
    </select>
</div>

            
<div class="form-group">
    <label for="priorite">Priorité :</label>
    <select class="form-control" name="priorite" required>
        <option value="elevee" <?php if ($claim["priorite"] == "elevee") echo "selected"; ?>>Élevée</option>
        <option value="moyenne" <?php if ($claim["priorite"] == "moyenne") echo "selected"; ?>>Moyenne</option>
        <option value="faible" <?php if ($claim["priorite"] == "faible") echo "selected"; ?>>Faible</option>
    </select>
</div>

            
            <div class="form-group">
                <label for="etage">Étage :</label>
                <input class="form-control" type="number" name="etage" value="<?php echo $claim["etage"]; ?>" required min="0" max="4">
            </div>
            
            <div class="form-group">
                <label for="deplacement">Déplacement :</label>
                <input class="form-control" name="deplacement" value="<?php echo $claim["deplacement"]; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" name="description" rows="4" cols="50" required><?php echo $claim["description"]; ?></textarea>
            </div>
            
            <div class="form-group d-flex justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg mr-3">Enregistrer</button>
                <a href="user_dashboard.php" class="btn btn-danger btn-lg">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Inclure les fichiers Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

