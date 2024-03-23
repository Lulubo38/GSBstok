<?php
// Inclusion du fichier database.php
require_once 'database.php';

// Vérifier si le formulaire a été soumis en méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $stock_id = $_POST['produit'];
    $quantite = $_POST['quantite'];

    try {
        // Connexion à la base de données (utilisation des variables définies dans database.php)
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

        // Enregistrer la demande de commande dans la base de données
        $requete_insert_demande = $bdd->prepare('INSERT INTO demandes_commandes (id_stock, quantite_demandee) VALUES (?, ?)');
        $requete_insert_demande->execute(array($stock_id, $quantite));

        // Afficher un message de confirmation
        echo "Votre demande de commande a été enregistrée. Elle est en attente d'approbation de l'administrateur.";
    } catch(PDOException $e) {
        // En cas d'erreur, afficher un message d'erreur
        echo "Erreur : " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="commande.css">
</head>
<body>
    <h1></h1>

    <a href="dashboard.php"><button>Retour à Dashboard</button></a>
</body>
</html>
