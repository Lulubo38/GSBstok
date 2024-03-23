<?php
require_once 'database.php'; 

$database = new Database();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['nom'])) {
    // Redirection vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: index.php");
    exit();
}

// Gestion de la durée de session
if (isset($_SESSION['nom'])) {
    $session_duration = 1800; // en secondes (30 minutes)
    $current_time = time();
    $login_time = $_SESSION['login_time'];

    $session_time_remaining = $session_duration - ($current_time - $login_time);

    if ($session_time_remaining <= 0) {
        // Redirection vers le script de déconnexion si la session a expiré
        header("Location: logout.php");
        exit();
    }
}

// Affichage des informations de session
$nom = $_SESSION['nom'];

// Récupération des informations de l'utilisateur
$sql = "SELECT id_utilisateur, nom, prenom, id_role FROM utilisateurs WHERE nom = :nom";
$database->query($sql);
$database->bind(':nom', $nom);
$database->execute();

if ($database->rowCount() == 1) {
    $user = $database->single();
    $prenom = $user['prenom'];
    $id_role = $user['id_role'];
} else {
    $prenom = "?";
    $id_role = "";
}
?>
