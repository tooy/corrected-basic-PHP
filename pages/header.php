<?php
session_start(); // Commence ou continue une session

if (!isset($_SESSION['dateFirstVisit'])) {
    // Si c'est la première visite, stocker la date actuelle
    $_SESSION['dateFirstVisit'] = date("Y-m-d H:i:s");
}

if (!isset($_SESSION['countViewPage'])) {
    // Initialise le compteur de pages vues s'il n'existe pas encore
    $_SESSION['countViewPage'] = 0;
} else {
    // Si le compteur de pages vues existe déjà, l'incrémenter
    $_SESSION['countViewPage']++;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $metaTitle ?></title>
    <meta name="description" content="<?= $metaDescription ?>">
</head>
<body>
<header>
    <!-- Votre code HTML pour le header ici -->
</header>
