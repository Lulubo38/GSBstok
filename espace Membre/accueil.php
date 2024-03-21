<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <h1>Bienvenue sur notre site</h1>

    <!-- Section d'inscription -->
    <section>
        <h2>Inscription</h2>
        <form method="POST" action="inscription.php" align="center">
            <label for="pseudo">Nom d'utilisateur :</label>
            <input type="text" id="pseudo" name="pseudo" autocomplete="off" required><br><br>
            
            <label for="email">Adresse e-mail :</label>
            <input type="email" id="email" name="email" autocomplete="off" required><br><br>
            
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" autocomplete="off" required><br><br>
            
            <input type="submit" value="S'inscrire">
        </form>
    </section>

    <!-- Section de connexion -->
    <section>
        <h2>Connexion</h2>
        <form method="POST" action="connexion.php" align="center">
            <label for="pseudo">Nom d'utilisateur :</label>
            <input type="text" id="pseudo" name="pseudo" autocomplete="off" required><br><br>
            
            <label for="mdp">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" autocomplete="off" required><br><br>
            
            <input type="submit" value="Se connecter">
        </form>
    </section>
</body>
</html>
