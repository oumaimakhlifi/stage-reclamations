<?php
session_start();
require("auth.php");
require("connection.php");

if ($_SESSION["role"] != "admin") {
    header("location: user_dashboard.php");
    exit();
}

if (isset($_GET["id"])) {
    $claim_id = $_GET["id"];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_status = $_POST["status"];

        $update_query = "UPDATE claim SET status='$new_status' WHERE id='$claim_id'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            header("location: admin_dashboard.php");
            exit();
        } else {
            $error_message = "Erreur lors de la mise à jour du statut.";
        }
    }

    $claim_query = "SELECT * FROM claim WHERE id='$claim_id'";
    $claim_result = mysqli_query($conn, $claim_query);
    $claim = mysqli_fetch_assoc($claim_result);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Modifier Réclamation</title>
    <!-- Intégrer les fichiers Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Modifier Réclamation</h2>
        <?php
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
        ?>
        <form action="admin_edit_claim.php?id=<?php echo $claim_id; ?>" method="post">
            <div class="form-group">
                <label for="status">Statut:</label>
                <select class="form-control" name="status" id="status">
                    <option value="En attente" <?php if ($claim['status'] == "En attente") echo "selected"; ?>>En attente</option>
                    <option value="En cours" <?php if ($claim['status'] == "En cours") echo "selected"; ?>>En cours</option>
                    <option value="Terminé" <?php if ($claim['status'] == "Terminé") echo "selected"; ?>>Terminé</option>
                </select>
            </div>
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary mr-2">Enregistrer</button>
                <a href="admin_dashboard.php" class="btn btn-danger ml-2">Annuler</a>
            </div>
        </form>
    </div>

    <!-- Inclure les fichiers Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
