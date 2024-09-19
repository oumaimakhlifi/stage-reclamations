

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    require("connection.php");

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Erreur de requête : " . mysqli_error($conn));
    }

    $user = mysqli_fetch_assoc($result);

    if ($user) {
        session_start();
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["username"] = $username; // Ajouter cette ligne pour stocker le nom d'utilisateur dans la session

        if ($user["role"] == "admin") {
            header("location: admin_dashboard.php");
        } elseif ($user["role"] == "user") {
            header("location: user_dashboard.php");
        }
        exit();
    } else {
        $error_message = "Identifiants incorrects.";
    }

    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Intégrer les fichiers Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('claim.jpg');
            background-size: contain; /* Ajuster la taille de l'image pour qu'elle soit contenue */
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background-color: rgba(255, 255, 255, 0.8); /* Couleur d'arrière-plan légère */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <form action="login.php" method="post" class="login-form">
            <h2 class="mb-4">Login</h2>
            <div class="form-group">
                <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
        </form>
    </div>

    <!-- Inclure les fichiers Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
