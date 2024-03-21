<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=gsb;charset=utf8;', 'root', '');

if (isset($_POST['envoi'])) {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];

        // Rechercher l'utilisateur dans la table `utilisateurs`
        $recupUser = $bdd->prepare('SELECT id_u, nom_u, mot_de_passe, id_role FROM utilisateurs WHERE nom_u = ?');
        $recupUser->execute(array($pseudo));
        $user = $recupUser->fetch();

        // Si l'utilisateur est trouvé dans la table `utilisateurs`, vérifier le mot de passe
        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id'] = $user['id_u'];
            $_SESSION['id_role'] = $user['id_role']; // Utiliser le rôle de l'utilisateur

            if ($user['id_role'] == 1 || $user['id_role'] == 2) {
                // L'utilisateur est un administrateur
                header('location: index.php'); // Rediriger l'administrateur vers la page d'accueil des administrateurs
                exit();
            } else {
                // L'utilisateur est un utilisateur normal
                header('location: index.php'); // Rediriger l'utilisateur normal vers la page d'accueil des utilisateurs normaux
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
</head>
<body>
    <h1>Connexion Utilisateur</h1>
    <form method="POST" action="" align="center">        
        <input type="text" name="pseudo" autocomplete="off" placeholder="Nom d'utilisateur">
        <br>
        <input type="password" name="mdp" autocomplete="off" placeholder="Mot de passe">
        <br><br>
        <input type="submit" name="envoi" value="Se connecter">
    </form>
    <br>
    <p>Vous êtes administrateur ?</p>
    <form method="GET" action="connexion_admin.php" align="center">
        <input type="submit" value="Je suis administrateur">
    </form>
</body>
</html>
