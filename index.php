<?php
session_start();

$routes = [
    'home' => 'home.php',
    'contact' => 'contact.php',
    'about' => 'about.php',
    // ajoutez d'autres routes ici
];

$page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING);

if (!array_key_exists($page, $routes)) {
    // Si la page demandée n'existe pas dans $routes, renvoyer une erreur 404
    header("HTTP/1.0 404 Not Found");
    include('404.php'); // supposons que vous avez un fichier 404.php pour gérer les erreurs 404
} else {
    // Si la page demandée existe dans $routes, inclure le fichier PHP correspondant
    include($routes[$page]);
}


