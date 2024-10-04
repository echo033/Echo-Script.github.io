<?php
session_start();
include('config.php'); // Fichier de connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Vérification si l'utilisateur existe déjà
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Un compte avec cet email existe déjà.";
    } else {
        // Hash du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion dans la base de données
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        if ($stmt->execute()) {
            // Connexion automatique après inscription
            $_SESSION['username'] = $username;
            header("Location: welcome.php"); // Redirection vers une page de bienvenue
            exit();
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }
}
?>
