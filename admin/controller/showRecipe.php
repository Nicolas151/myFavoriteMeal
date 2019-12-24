<?php 


if (isset($_GET['recipeId'])) {

	$recipeModel = new RecipeModel();

	$recipe = $recipeModel->findById($_GET['recipeId']);

	$ingredients = $recipeModel->getIngredients($_GET['recipeId']);

	require('view/recipeView.phtml');

} else {

	// Redirection vers la page d'acceuil si aucun id reçu
	header('Location: index.php');

}
