<?php
session_start();
require_once 'database.php'; // Inclure le fichier de connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Afficher un message de bienvenue en fonction du rôle de l'utilisateur
if ($_SESSION['id_role'] == 1 || $_SESSION['id_role'] == 2) {
    // L'utilisateur est un administrateur
    $message = "Bonjour admin";
} else {
    // L'utilisateur est un utilisateur normal
    $message = "Bonjour utilisateur";
}

// Récupérer tous les produits par défaut
$requete_tous = $pdo->query('SELECT id, nom, quantite, type FROM produits');
$tous_les_produits = $requete_tous->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultation des Stocks</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Consultation des Stocks</h1>

    <!-- Bouton de déconnexion -->
    <form method="post" action="logout.php" style="text-align: right;">
        <input type="submit" value="Se déconnecter">
    </form>

    <!-- Message de bienvenue -->
    <p><?php echo $message; ?></p>

    <?php
    // Continuer avec le reste du contenu...
    ?>

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
            var tousLesProduits = <?php echo json_encode($tous_les_produits); ?>;

            var produitsFiltres = tousLesProduits.filter(function(produit) {
                if (typeSelectionne === 'tous') {
                    return true;
                } else {
                    return produit.type === typeSelectionne;
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

            if (produitsFiltres.length > 0) {
                produitsFiltres.forEach(function(produit) {
                    listeHtml += '<li>' + produit.nom + ' - Quantité : ' + produit.quantite;
                    listeHtml += ' <form action="passer_commande.php" method="post">';
                    listeHtml += '<input type="hidden" name="produit_id" value="' + produit.id + '">';
                    listeHtml += '<input type="number" name="quantite" value="1" min="1">';
                    listeHtml += '<input type="submit" value="Commander">';
                    listeHtml += '</form>';
                    listeHtml += '</li>';
                });
            } else {
                listeHtml += '<p>Aucun produit trouvé.</p>';
            }

            listeHtml += '</ul>';

            document.getElementById('listeProduits').innerHTML = listeHtml;
        });
    </script>
</body>
</html>
