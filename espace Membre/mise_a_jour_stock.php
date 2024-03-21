<?php
// Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=gsb;charset=utf8', 'root', '');

// Récupérer tous les produits
$requete_produits = $bdd->query('SELECT id FROM produits');
$produits = $requete_produits->fetchAll();

// Parcourir tous les produits
foreach ($produits as $produit) {
    // Récupérer la quantité totale commandée pour ce produit
    $requete_total_commande = $bdd->prepare('SELECT SUM(quantite) AS total_commande FROM commandes WHERE produit_id = ?');
    $requete_total_commande->execute(array($produit['id']));
    $total_commande = $requete_total_commande->fetch(PDO::FETCH_ASSOC)['total_commande'];

    // Mettre à jour le stock du produit dans la table produits
    $requete_update_stock = $bdd->prepare('UPDATE produits SET quantite = quantite - ? WHERE id = ?');
    $requete_update_stock->execute(array($total_commande, $produit['id']));
}

echo "Le stock a été mis à jour avec succès en tenant compte des commandes.";
?>
