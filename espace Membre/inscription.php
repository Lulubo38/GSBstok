<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $email = htmlspecialchars($_POST['email']);
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Hash du mot de passe

        // Vérification si l'utilisateur existe déjà
        $checkUser = $pdo->prepare('SELECT id_utilisateur FROM utilisateurs WHERE nom = ?');
        $checkUser->execute(array($nom));
        $existingUser = $checkUser->fetch();

        if ($existingUser) {
            echo "Cet utilisateur existe déjà.";
        } else {
            // Préparation de la requête d'insertion dans la table utilisateurs
            $insertUser = $pdo->prepare('INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)');
            $insertUser->execute(array($nom, $email, $mot_de_passe));

            // Sélection de l'utilisateur nouvellement inscrit
            $recupUser = $pdo->prepare('SELECT id_utilisateur FROM utilisateurs WHERE nom = ?');
            $recupUser->execute(array($nom));
            $user = $recupUser->fetch();

            if ($user) {
                $_SESSION['pseudo'] = $nom;
                $_SESSION['id'] = $user['id_utilisateur'];  
                header('Location: dashboard.php'); // Redirection après inscription
                exit();
            }
        }
    } else {
        echo "Veuillez compléter tous les champs...";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Inscription</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" align="center">
        <label for="nom">Nom d'utilisateur :</label>
        <input type="text" id="nom" name="nom" autocomplete="off" required><br><br>
        
        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" autocomplete="off" required><br><br>
        
        <label for="mot_de_passe">Mot de passe :</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" autocomplete="off" required><br><br>
        
        <input type="submit" value="S'inscrire">
    </form>

    <!-- Bouton de redirection vers la page de connexion -->
    <form method="GET" action="index.php" align="center">
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
