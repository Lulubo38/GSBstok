<?php
// Inclusion du fichier database.php
require_once 'database.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $produit_id = $_POST['produit'];
    $quantite = $_POST['quantite'];

    // Connexion à la base de données (utilisation des variables définies dans database.php)
    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Enregistrer la commande dans la base de données (vous devez implémenter cette partie)
    // Exemple d'une requête préparée pour insérer la commande dans une table de commandes
    $requete_insert_commande = $bdd->prepare('INSERT INTO commandes (produit_id, quantite) VALUES (?, ?)');
    $requete_insert_commande->execute(array($produit_id, $quantite));

    // Mettre à jour le stock du produit dans la base de données (vous devez implémenter cette partie)
    // Exemple d'une requête préparée pour mettre à jour le stock du produit
    $requete_update_stock = $bdd->prepare('UPDATE produits SET quantite = quantite - ? WHERE id = ?');
    $requete_update_stock->execute(array($quantite, $produit_id));

    // Afficher un message de confirmation
    echo "Votre commande a été passée avec succès.";
}
?>
