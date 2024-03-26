<?php
// Inclusion du fichier database.php
require_once 'database.php';

// Récupérer les produits les plus commandés depuis la base de données
try {
    // Connexion à la base de données (utilisation des variables définies dans database.php)
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Requête pour récupérer les produits les plus commandés
    $requete_produits_populaires = $bdd->query('SELECT id_stock, COUNT(*) as total_commandes FROM demandes_commandes GROUP BY id_stock ORDER BY total_commandes DESC');

    // Récupérer les résultats de la requête
    $produits_populaires = $requete_produits_populaires->fetchAll();
} catch(PDOException $e) {
    // En cas d'erreur, afficher un message d'erreur
    echo "Erreur : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Produits Populaires</title>
    <link rel="stylesheet" href="populaire.css"> <!-- Lien vers le fichier CSS externe -->
</head>
<body>
    <h1>Produits Populaires</h1>
    <table>
        <thead>
            <tr>
                <th>ID Produit</th>
                <th>Total Commandes</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($produits_populaires as $produit): ?>
                <tr>
                    <td><?php echo $produit['id_stock']; ?></td>
                    <td><?php echo $produit['total_commandes']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
