<?php
session_start();
require_once 'database.php';

// Vérifier si l'utilisateur est connecté


// Vérifier si l'ID de la demande est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Rediriger vers une page d'erreur ou à une autre page appropriée
    header("Location: erreur.php");
    exit;
}

// Récupérer l'ID de la demande de commande depuis l'URL
$id_demande = $_GET['id'];

// Mettre à jour le statut de la demande de commande dans la base de données
$requete_update_statut = $pdo->prepare('UPDATE demandes_commandes SET statut = "validée" WHERE id_demande = ?');
$requete_update_statut->execute([$id_demande]);

// Récupérer la quantité demandée et l'ID du stock correspondant à la demande
$requete_info_demande = $pdo->prepare('SELECT id_stock, quantite_demandee FROM demandes_commandes WHERE id_demande = ?');
$requete_info_demande->execute([$id_demande]);
$info_demande = $requete_info_demande->fetch();

$id_stock = $info_demande['id_stock'];
$quantite_demandee = $info_demande['quantite_demandee'];

// Mettre à jour la quantité disponible dans le stock correspondant
$requete_update_stock = $pdo->prepare('UPDATE stocks SET quantite_disponible = quantite_disponible - ? WHERE id_stock = ?');
$requete_update_stock->execute([$quantite_demandee, $id_stock]);

// Rediriger vers la page dashboard.php
header("Location: dashboard_admin.php");
exit;
?>
