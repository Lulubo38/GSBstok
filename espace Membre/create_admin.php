<?php
session_start();

// Vérification de l'authentification de l'administrateur
if (!isset($_SESSION['pseudo']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php'); // Rediriger vers une autre page s'il n'est pas autorisé
    exit();
}

// Traitement du formulaire de création de compte administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification des champs
    if (!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $email = htmlspecialchars($_POST['email']);
        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // Hash du mot de passe

        // Connexion à la base de données
        $bdd = new PDO('mysql:host=localhost;dbname=gsb;charset=utf8', 'root', '');

        // Insertion de l'administrateur dans la table utilisateurs
        $insertAdmin = $bdd->prepare('INSERT INTO utilisateurs (nom_u, email_u, mot_de_passe, id_role) VALUES (?, ?, ?, ?)');
        $insertAdmin->execute(array($pseudo, $email, $mdp, 2)); // 2 correspond à l'ID du rôle "admin"

        // Redirection vers une page de confirmation ou une autre page
        header('Location: admin_created.php');
        exit();
    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte administrateur</title>
</head>
<body>
    <h2>Création de compte administrateur</h2>
    
    <!-- Formulaire de création de compte administrateur -->
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" align="center">
        <label for="pseudo">Nom d'utilisateur :</label><br>
        <input type="text" id="pseudo" name="pseudo" required><br><br>
        
        <label for="email">Adresse e-mail :</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="mdp">Mot de passe :</label><br>
        <input type="password" id="mdp" name="mdp" required><br><br>
        
        <input type="submit" value="Créer le compte">
    </form>

    <?php
    // Affichage du message d'erreur s'il y a lieu
    if (isset($error_message)) {
        echo '<p style="color: red;">' . $error_message . '</p>';
    }
    ?>

    <!-- Lien pour revenir à la page d'accueil des administrateurs -->
    <p><a href="accueil_admin.php">Retour à l'accueil administrateur</a></p>
</body>
</html>
