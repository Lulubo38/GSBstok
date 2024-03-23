<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Récupérer toutes les commandes depuis la base de données
$recupCommandes = $pdo->query('SELECT id_demande, id_stock, quantite_demandee, date_demande, statut FROM demandes_commandes');
$commandes = $recupCommandes->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des commandes</title>
    <link rel="stylesheet" type="text/css" href="histo.css">
</head>
<body>
    <h1>Historique des commandes</h1>

    <div>
        <a href="dashboard_admin.php">Retour au tableau de bord</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID Demande</th>
                <th>ID Stock</th>
                <th>Quantité demandée</th>
                <th>Date Demande</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commandes as $commande) : ?>
                <tr>
                    <td><?php echo $commande['id_demande']; ?></td>
                    <td><?php echo $commande['id_stock']; ?></td>
                    <td><?php echo $commande['quantite_demandee']; ?></td>
                    <td><?php echo $commande['date_demande']; ?></td>
                    <td><?php echo $commande['statut']; ?></td>
                    <td><a href="valider_demande.php?id=<?php echo $commande['id_demande']; ?>">Valider</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
