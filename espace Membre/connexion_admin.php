<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['pseudo']) && !empty($_POST['mdp'])) {
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mdp = $_POST['mdp'];

        // Connexion à la base de données
        $bdd = new PDO('mysql:host=localhost;dbname=gsb;charset=utf8', 'root', '');

        // Recherche de l'utilisateur dans la table utilisateurs
        $recupUser = $bdd->prepare('SELECT id_u, mot_de_passe, role FROM utilisateurs WHERE nom_u = ?');
        $recupUser->execute(array($pseudo));
        $user = $recupUser->fetch();

        // Vérification du mot de passe
        if ($user && password_verify($mdp, $user['mot_de_passe'])) {
            // Condition pour vérifier les permissions
            if ($user['role'] == 'admin' || $user['role'] == 'super-admin') {
                $_SESSION['pseudo'] = $pseudo;
                $_SESSION['id'] = $user['id_u'];  
                header('Location: inscription.php'); // Redirection vers la page d'inscription
                exit();
            } else {
                header('Location: index.php'); // Redirection vers la page d'accueil des administrateurs
                exit();
            }
        } else {
            echo "Identifiant ou mot de passe incorrect.";
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
    <title>Connexion Administrateur</title>
</head>
<body>
    <h2>Connexion Administrateur</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" align="center">
        <label for="pseudo">Nom d'utilisateur :</label>
        <input type="text" id="pseudo" name="pseudo" autocomplete="off" required><br><br>
        
        <label for="mdp">Mot de passe :</label>
        <input type="password" id="mdp" name="mdp" autocomplete="off" required><br><br>
        
        <input type="submit" value="Se connecter">
    </form>
</body>
</html>
