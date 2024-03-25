<?php
// Inclusion du fichier database.php
require_once 'database.php';

// Vérifier si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php");
    exit;
}

// Vérifier si le formulaire a été soumis en méthode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $stock_id = $_POST['produit'];
    $quantite = $_POST['quantite'];

    // Récupérer l'ID utilisateur depuis la session
    $id_utilisateur = $_SESSION['id'];

    try {
        // Connexion à la base de données (utilisation des variables définies dans database.php)
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

        // Enregistrer la demande de commande dans la base de données avec l'ID utilisateur
        $requete_insert_demande = $bdd->prepare('INSERT INTO demandes_commandes (id_stock, quantite_demandee, id_utilisateur) VALUES (?, ?, ?)');
        $requete_insert_demande->execute(array($stock_id, $quantite, $id_utilisateur));

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
