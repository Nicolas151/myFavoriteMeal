<?php 


session_start();

// Vérification que l'utilisateur est bien connecté
$userSession = new UserSession();

if ($userSession->isAuthenticated()) {

	require('view/depositSuccessView.phtml');

} else {

	// Si l'utilisateur n'est pas connecté affichage de la page de connection 
	header('Location: index.php?action=login');

}
