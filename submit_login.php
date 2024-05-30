<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Connexion à la base de données
    $servername = "localhost";
    $username = "root";
    $dbname = "emploiconnect";
    $conn = new mysqli($servername, $username, '', $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Rechercher l'utilisateur dans la base de données
    $sql = "SELECT id, password FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Vérifier le mot de passe
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Mot de passe correct, démarrer la session
            $_SESSION['userid'] = $row['id'];
            header("Location: dashboard.html");
        } else {
            // Mot de passe incorrect
            echo "Incorrect password.";
        }
    } else {
        // Aucun utilisateur trouvé avec cet email
        echo "No user found with this email.";
    }

    // Fermer la connexion
    $conn->close();
}
?>
