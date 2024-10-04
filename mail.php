<?php
// Démarrer la session
session_start();

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Valider les données ici (ajoutez votre logique de validation)

    // Hash du mot de passe (pour la sécurité)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insérer les données de l'utilisateur dans la base de données
    // Remplacez ces variables par vos propres informations
    $servername = "localhost"; // ou votre serveur
    $db_username = "root"; // nom d'utilisateur de votre base de données
    $db_password = ""; // mot de passe de votre base de données
    $dbname = "votre_base_de_donnees"; // nom de votre base de données

    // Créer une connexion
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Échec de la connexion : " . $conn->connect_error);
    }

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Si l'utilisateur est créé avec succès, envoyer l'e-mail de confirmation
        $to = $email;
        $subject = "Confirmation de votre compte";
        $message = "Bonjour $username,\n\nMerci d'avoir créé un compte sur notre site. Veuillez confirmer votre adresse e-mail en cliquant sur le lien ci-dessous :\n\n";
        $message .= "http://votre_site.com/confirmation.php?email=" . urlencode($email); // Remplacez par votre URL
        $headers = "From: no-reply@votre_site.com"; // Remplacez par votre adresse e-mail

        // Envoyer l'e-mail
        if (mail($to, $subject, $message, $headers)) {
            echo "Inscription réussie ! Un e-mail de confirmation a été envoyé à $email.";
        } else {
            echo "Échec de l'envoi de l'e-mail de confirmation.";
        }
    } else {
        echo "Erreur lors de l'inscription : " . $stmt->error;
    }

    // Fermer la connexion
    $stmt->close();
    $conn->close();
}
?>

