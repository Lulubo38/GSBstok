<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Récupérer les commandes de l'utilisateur actuellement connecté depuis la table demandes_commandes
$requete_commandes = $pdo->prepare('SELECT * FROM demandes_commandes WHERE id_utilisateur = ?');
$requete_commandes->execute([$_SESSION['id']]);
$commandes = $requete_commandes->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Historique des commandes</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="dashboard.css"> <!-- Lien vers le fichier CSS externe -->
</head>
<body>
    <h1>Historique des commandes</h1>

    <div class="dashboard-container">
        <a href="dashboard.php">Retour au tableau de bord</a>
        <a href="logout.php">Déconnexion</a>
    </div>

    <div id="listeCommandes">
        <?php if (count($commandes) > 0): ?>
            <table>
                <tr>
                    <th>Date de commande</th>
                    <th>Produit</th>
                    <th>Quantité</th>
                </tr>
                <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td><?php echo $commande['date_demande']; ?></td>
                        <td><?php echo $commande['id_stock']; ?></td>
                        <td><?php echo $commande['quantite_demandee']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucune commande trouvée.</p>
        <?php endif; ?>
    </div>
</body>
</html>
