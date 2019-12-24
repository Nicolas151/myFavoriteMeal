<?php 


if (isset($_GET['id'])) {

	$recipeModel = new RecipeModel();

	$recipeModel->validate($_GET['id']);

	header('Location: index.php');

} else {

	// Redirection vers la page d'acceuil si aucun id reçu
	header('Location: index.php');

}