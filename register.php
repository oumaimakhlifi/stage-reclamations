<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = "user"; // Par défaut, les nouveaux utilisateurs ont le rôle "user"

    require("connection.php");

    // Vérifier si l'utilisateur existe déjà
    $check_query = "SELECT * FROM users WHERE username='$username'";
    $check_result = mysqli_query($conn, $check_query);

    if ($check_result && mysqli_num_rows($check_result) > 0) {
        $error_message = "Cet utilisateur existe déjà.";
    } else {
        // Insérer l'utilisateur dans la base de données
        $insert_query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            // Rediriger vers la page de connexion
            header("location: login.php");
            exit();
        } else {
            $error_message = "Erreur lors de l'inscription.";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form action="register.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">S'inscrire</button>
    </form>
    <p>Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
</body>
</html>
