<?php
session_start();
require_once 'database.php';

// Vérifier si l'utilisateur est connecté et est administrateur
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Traitement des actions de l'administrateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['ajouter_stock'])) {
        // Récupérer les données du formulaire d'ajout de stock
        $nom_nouveau_stock = $_POST['nom_nouveau_stock'];
        $quantite_nouveau_stock = $_POST['quantite_nouveau_stock'];
        $description_nouveau_stock = $_POST['description_nouveau_stock'];
        $type_nouveau_stock = $_POST['type_nouveau_stock'];

        // Insérer le nouveau stock dans la base de données
        $requete_insert_stock = $pdo->prepare('INSERT INTO stocks (nom, quantite_disponible, description, type) VALUES (?, ?, ?, ?)');
        $requete_insert_stock->execute([$nom_nouveau_stock, $quantite_nouveau_stock, $description_nouveau_stock, $type_nouveau_stock]);

        // Enregistrer le mouvement correspondant dans la table des mouvements
        $id_stock = $pdo->lastInsertId(); // Obtenez l'ID du nouveau stock inséré
        $type_mouvement = 'entree'; // Type de mouvement pour une nouvelle entrée de stock
        $quantite_mouvement = $quantite_nouveau_stock; // La quantité ajoutée est égale à la quantité du nouveau stock
        $date_mouvement = date("Y-m-d H:i:s"); // Date et heure actuelles

        $requete_insert_mouvement = $pdo->prepare('INSERT INTO mouvements (id_stock, type_mouvement, quantite, date_mouvement) VALUES (?, ?, ?, ?)');
        $requete_insert_mouvement->execute([$id_stock, $type_mouvement, $quantite_mouvement, $date_mouvement]);
    } elseif (isset($_POST['supprimer_stock'])) {
        // Récupérer l'ID du stock à supprimer
        $id_stock_a_supprimer = $_POST['id_stock_a_supprimer'];

        // Supprimer le stock de la base de données
        $requete_supprimer_stock = $pdo->prepare('DELETE FROM stocks WHERE id_stock = ?');
        $requete_supprimer_stock->execute([$id_stock_a_supprimer]);
    } elseif (isset($_POST['modifier_quantite'])) {
        // Récupérer l'ID du stock et la nouvelle quantité
        $id_stock_a_modifier = $_POST['id_stock_a_modifier'];
        $nouvelle_quantite = $_POST['nouvelle_quantite'];

        // Mettre à jour la quantité du stock dans la base de données
        $requete_modifier_quantite = $pdo->prepare('UPDATE stocks SET quantite_disponible = ? WHERE id_stock = ?');
        $requete_modifier_quantite->execute([$nouvelle_quantite, $id_stock_a_modifier]);
    }

    // Rediriger l'administrateur vers la même page pour éviter le renvoi du formulaire
    header("Location: gerer_stock.php");
    exit;
}

// Récupérer les stocks depuis la base de données
$requete_stocks = $pdo->query('SELECT id_stock, nom, quantite_disponible, description, type FROM stocks');
$stocks = $requete_stocks->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Stocks</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Gérer les Stocks</h1>

    <div>
        <a href="dashboard_admin.php">Retour au tableau de bord</a>
        <a href="logout.php">Déconnexion</a>
    </div>

    <h2>Ajouter un Nouveau Stock</h2>
    <form action="" method="post">
        <label for="nom_nouveau_stock">Nom :</label>
        <input type="text" name="nom_nouveau_stock" id="nom_nouveau_stock" required>
        <label for="quantite_nouveau_stock">Quantité :</label>
        <input type="number" name="quantite_nouveau_stock" id="quantite_nouveau_stock" min="1" required>
        <label for="description_nouveau_stock">Description :</label>
        <input type="text" name="description_nouveau_stock" id="description_nouveau_stock" required>
        <label for="type_nouveau_stock">Type :</label>
        <select name="type_nouveau_stock" id="type_nouveau_stock">
            <option value="medicament">Médicament</option>
            <option value="materiel">Matériel</option>
        </select>
        <input type="submit" name="ajouter_stock" value="Ajouter Stock">
    </form>

    <h2>Liste des Stocks Existants</h2>
    <table>
        <thead>
            <tr>
                <th>ID Stock</th>
                <th>Nom</th>
                <th>Quantité Disponible</th>
                <th>Description</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stocks as $stock) : ?>
                <tr>
                    <td><?php echo $stock['id_stock']; ?></td>
                    <td><?php echo $stock['nom']; ?></td>
                    <td><?php echo $stock['quantite_disponible']; ?></td>
                    <td><?php echo $stock['description']; ?></td>
                    <td><?php echo $stock['type']; ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="id_stock_a_modifier" value="<?php echo $stock['id_stock']; ?>">
                            <input type="number" name="nouvelle_quantite" min="0" required>
                            <input type="submit" name="modifier_quantite" value="Modifier Quantité">
                        </form>
                        <form action="" method="post">
                            <input type="hidden" name="id_stock_a_supprimer" value="<?php echo $stock['id_stock']; ?>">
                            <input type="submit" name="supprimer_stock" value="Supprimer">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
