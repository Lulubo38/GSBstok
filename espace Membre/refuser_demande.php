<?php
session_start();
require_once 'database.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Vérifier si l'ID de la demande est fourni dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Rediriger vers une page d'erreur ou à une autre page appropriée
    header("Location: erreur.php");
    exit;
}

// Récupérer l'ID de la demande de commande depuis l'URL
$id_demande = $_GET['id'];

// Supprimer la demande de commande de la base de données
$requete_supprimer_demande = $pdo->prepare('DELETE FROM demandes_commandes WHERE id_demande = ?');
$requete_supprimer_demande->execute([$id_demande]);

// Rediriger vers la page dashboard.php
header("Location: dashboard_admin.php");
exit;
?>
