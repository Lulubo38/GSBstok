<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

if (isset($_POST['envoi'])) {
    if (!empty($_POST['nom']) && !empty($_POST['mot_de_passe'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $mot_de_passe = $_POST['mot_de_passe'];

        // Rechercher l'utilisateur dans la table `utilisateurs` avec son rôle
        $recupUser = $pdo->prepare('SELECT u.id_utilisateur, u.nom, u.mot_de_passe, r.id_role FROM utilisateurs u INNER JOIN roles r ON u.id_role = r.id_role WHERE nom = ?');
        $recupUser->execute(array($nom));
        $user = $recupUser->fetch();

        // Si l'utilisateur est trouvé dans la table `utilisateurs`, vérifier le mot de passe
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            $_SESSION['nom'] = $nom;
            $_SESSION['id'] = $user['id_utilisateur'];
            $_SESSION['id_role'] = $user['id_role']; // Utiliser le rôle de l'utilisateur

            // Redirection en fonction du rôle de l'utilisateur
            if ($user['id_role'] == 1) {
                // L'utilisateur est un administrateur
                header('location: dashboard_admin.php');
                exit();
            } elseif ($user['id_role'] == 2) {
                // L'utilisateur est un utilisateur
                header('location: dashboard.php');
                exit();
            } elseif ($user['id_role'] == 3) {
                // L'utilisateur est un super administrateur
                header('location: dashboard_superadmin.php');
                exit();
            }
        } else {
            echo "Identifiant ou mot de passe incorrect.";
        }
    } else {
        echo "Veuillez compléter tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Connexion Utilisateur</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Connexion Utilisateur</h1>
    <form method="POST" action="" align="center">        
        <input type="text" name="nom" autocomplete="off" placeholder="Nom d'utilisateur">
        <br>
        <input type="password" name="mot_de_passe" autocomplete="off" placeholder="Mot de passe">
        <br><br>
        <input type="submit" name="envoi" value="Se connecter">
    </form>
    <br>

    <!-- Bouton pour l'inscription -->
    <form method="GET" action="inscription.php" align="center">
        <input type="submit" value="Inscription">
    </form>
</body>
</html>
