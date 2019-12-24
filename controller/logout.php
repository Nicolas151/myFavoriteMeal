<?php


$userSession = new UserSession();

// Destruction de la session
$userSession->destroy();

// Redirection vers la page d'acceuil
header('Location: index.php');
