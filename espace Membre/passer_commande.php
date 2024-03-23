<!DOCTYPE html>
<html>
<head>
    <title>Passation de Commandes</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Passation de Commandes</h1>

    <form action="traitement_commande.php" method="post">
        <label for="produit">Produit :</label>
        <select name="produit" id="produit">
            <?php
            // Inclusion du fichier de connexion à la base de données
            require_once 'database.php';

            // Récupérer les produits disponibles
            $requete_produits = $pdo->query('SELECT id, nom FROM produits');
            $produits = $requete_produits->fetchAll();

            foreach ($produits as $produit) {
                echo '<option value="' . $produit['id'] . '">' . $produit['nom'] . '</option>';
            }
            ?>
        </select>
        <br><br>
        <label for="quantite">Quantité :</label>
        <input type="number" name="quantite" id="quantite" min="1" required>
        <br><br>
        <input type="submit" value="Passer Commande">
    </form>
</body>
</html>
