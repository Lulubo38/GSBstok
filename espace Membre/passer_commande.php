<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $produit_id = $_POST['produit_id'];
    $quantite = $_POST['quantite'];

    // Vérifier la validité des données
    if (!is_numeric($quantite) || $quantite <= 0) {
        echo "La quantité commandée n'est pas valide.";
        exit;
    }

    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=gsb;charset=utf8', 'root', '');

    // Enregistrer la commande dans la base de données
    $requete_insert_commande = $bdd->prepare('INSERT INTO commandes (produit_id, quantite) VALUES (?, ?)');
    $requete_insert_commande->execute(array($produit_id, $quantite));

    // Mettre à jour le stock du produit dans la base de données
    $requete_update_stock = $bdd->prepare('UPDATE produits SET quantite = quantite - ? WHERE id = ?');
    $requete_update_stock->execute(array($quantite, $produit_id));

    // Afficher un message de confirmation
    echo "Votre commande a été passée avec succès.";
}
?>
