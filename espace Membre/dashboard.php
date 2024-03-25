<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Récupérer les stocks depuis la base de données
$requete_stocks = $pdo->query('SELECT id_stock, nom, quantite_disponible, type FROM stocks');
$stocks = $requete_stocks->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Consultation des Stocks</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="dashboard.css"> <!-- Lien vers le fichier CSS externe -->
</head>
<body>
    <h1>Consultation des Stocks</h1>

    <div class="dashboard-container">
        <a href="logout.php">Déconnexion</a>
        <a href="passer_commande.php" class="passer-commande-btn">Passer Commande</a> <!-- Lien vers la page passer_commande.php -->
        <?php if ($_SESSION['id_role'] != 1) : ?>
            <a href="historique_utilisateur.php" class="historique-commande-btn">Historique des commandes</a>
        <?php endif; ?>
    </div>

    <label for="type">Afficher :</label>
    <select id="type">
        <option value="tous">Tous</option>
        <option value="medicament">Médicaments</option>
        <option value="materiel">Matériel</option>
    </select>

    <div id="listeProduits">
        <!-- Contenu généré dynamiquement en JavaScript -->
    </div>

    <script>
        document.getElementById('type').addEventListener('change', function() {
            var typeSelectionne = this.value;
            var tousLesStocks = <?php echo json_encode($stocks); ?>;

            var stocksFiltres = tousLesStocks.filter(function(stock) {
                if (typeSelectionne === 'tous') {
                    return true;
                } else {
                    return stock.type === typeSelectionne;
                }
            });

            var listeHtml = '<h2>';
            if (typeSelectionne === 'medicament') {
                listeHtml += 'Médicaments';
            } else if (typeSelectionne === 'materiel') {
                listeHtml += 'Matériel';
            } else {
                listeHtml += 'Tous les Produits';
            }
            listeHtml += '</h2><ul>';

            if (stocksFiltres.length > 0) {
                stocksFiltres.forEach(function(stock) {
                    listeHtml += '<li>' + stock.nom + ' - Quantité disponible : ' + stock.quantite_disponible + '</li>';
                });
            } else {
                listeHtml += '<p>Aucun stock trouvé.</p>';
            }

            listeHtml += '</ul>';

            document.getElementById('listeProduits').innerHTML = listeHtml;
        });
    </script>
</body>
</html>
