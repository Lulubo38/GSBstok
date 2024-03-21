<?php
session_start();

// Vérifier si l'utilisateur est connecté et s'il a le rôle d'administrateur
if (!isset($_SESSION['pseudo']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: index.php'); // Rediriger vers une autre page s'il n'est pas autorisé
    exit();
}

// Récupérer le stock de produits depuis la base de données
$bdd = new PDO('mysql:host=localhost;dbname=gsb;charset=utf8', 'root', '');
$stockQuery = $bdd->query('SELECT * FROM produits');
$stock = $stockQuery->fetchAll();

// Récupérer les commandes des utilisateurs
$commandesQuery = $bdd->query('SELECT * FROM commandes');
$commandes = $commandesQuery->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Administrateur</title>
</head>
<body>
    <h2>Accueil Administrateur</h2>

    <!-- Affichage du stock de produits -->
    <h3>Stock de produits</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Quantité</th>
                <th>Type</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stock as $produit): ?>
                <tr>
                    <td><?php echo $produit['id']; ?></td>
                    <td><?php echo $produit['nom']; ?></td>
                    <td><?php echo $produit['quantite']; ?></td>
                    <td><?php echo $produit['type']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Affichage des commandes -->
    <h3>Commandes des utilisateurs</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produit ID</th>
                <th>Quantité</th>
                <th>État</th>
                <th>Date de commande</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande): ?>
                <tr>
                    <td><?php echo $commande['id']; ?></td>
                    <td><?php echo $commande['produit_id']; ?></td>
                    <td><?php echo $commande['quantite']; ?></td>
                    <td><?php echo $commande['etat']; ?></td>
                    <td><?php echo $commande['date_commande']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bouton de déconnexion -->
    <form method="post" action="logout.php">
        <input type="submit" value="Se déconnecter">
    </form>
</body>
</html>
