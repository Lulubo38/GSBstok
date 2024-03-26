<?php
// Inclure le fichier de connexion à la base de données
require_once 'database.php';

// Requête SQL pour récupérer le total des produits commandés par mois
$requete_total_par_mois = $pdo->query('SELECT MONTH(date_demande) AS mois, SUM(quantite_demandee) AS total FROM demandes_commandes GROUP BY MONTH(date_demande)');
$resultats = $requete_total_par_mois->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Total des Produits Commandés par Mois</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Total des Produits Commandés par Mois</h1>

    <table>
        <tr>
            <th>Mois</th>
            <th>Total</th>
        </tr>
        <?php foreach ($resultats as $resultat): ?>
            <tr>
                <td><?php echo $resultat['mois']; ?></td>
                <td><?php echo $resultat['total']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
