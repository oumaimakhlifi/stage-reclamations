<?php
session_start();
require("auth.php");
require("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $type_panne = $_POST["type_panne"];
    $fonction = $_POST["fonction"];
    $priorite = $_POST["priorite"];
    $etage = $_POST["etage"];
    $deplacement = $_POST["deplacement"];
    $description = $_POST["description"];
    $status = "En attente";

    $insert_query = "INSERT INTO claim (user_id, type_panne, fonction, priorite, etage, deplacement, description, status, date_reclamation) VALUES ('$user_id', '$type_panne', '$fonction', '$priorite', '$etage', '$deplacement', '$description', '$status', NOW())";

    $insert_result = mysqli_query($conn, $insert_query);

    if ($insert_result) {
        header("location: user_dashboard.php");
        exit();
    } else {
        echo "Erreur lors de la soumission de la réclamation.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Soumettre une Réclamation</title>
    <!-- Intégrer les fichiers Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Soumettre une Réclamation</h2>
        
        <form action="submit_claim.php" method="post">
            <div class="form-group">
                <label for="type_panne">Type de Panne :</label>
                <select class="form-control" name="type_panne" required>
                    <option value="logiciel">Logiciel</option>
                    <option value="materiel">Matériel</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="fonction">Fonction :</label>
                <select class="form-control" name="fonction" required>
                    <option value="Direction Générale">Direction Générale</option>
                    <option value="Direction de l'Exploitation">Direction de l'Exploitation</option>
                    <option value="Direction de la Navigation Aerienne">Direction de la Navigation Aérienne</option>
                    <option value="Direction de la Maintenance">Direction de la Maintenance</option>
                    <option value="Direction des Ressources Humaines">Direction des Ressources Humaines</option>
                    <option value="Direction Financiere et Administrative">Direction Financière et Administrative</option>
                    <option value="Direction de la Communication et des Relations Publiques">Direction de la Communication et des Relations Publiques</option>
                    <option value="Direction de la Qualite et de la Conformite">Direction de la Qualité et de la Conformité</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="priorite">Priorité :</label>
                <select class="form-control" name="priorite" required>
                    <option value="elevee">Élevée</option>
                    <option value="moyenne">Moyenne</option>
                    <option value="faible">Faible</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="etage">Étage :</label>
                <input class="form-control" type="number" name="etage" required min="0" max="4">
            </div>
            
            <div class="form-group">
                <label for="deplacement">Déplacement :</label>
                <input class="form-control" name="deplacement" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description :</label>
                <textarea class="form-control" name="description" rows="4" cols="50" required></textarea>
            </div>
            
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mr-2">Soumettre</button>
                <a href="user_dashboard.php" class="btn btn-danger ml-2">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Inclure les fichiers Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateForm() {
            var etageInput = document.getElementById("etage");
            var etageError = document.getElementById("etageError");
            var etageValue = parseInt(etageInput.value);
            
            if (etageValue < 0 || etageValue > 4) {
                etageError.textContent = "L'étage doit être compris entre 0 et 4.";
                return false;
            } else {
                etageError.textContent = "";
                return true;
            }
        }
    </script>
</body>
</html>


