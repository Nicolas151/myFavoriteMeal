<?php 


session_start();

// Vérification que l'utilisateur est bien connecté
$userSession = new UserSession();

if ($userSession->isAuthenticated()) {

	$recipeModel = new RecipeModel();
	$categories = $recipeModel->getCategoryList();

	// Si l'utilisateur est connecté affichage du formulaire de dépot de recette
	require('view/depositView.phtml');

} else {

	// Si l'utilisateur n'est pas connecté affichage de la page de connection 
	header('Location: index.php?action=login');

}
