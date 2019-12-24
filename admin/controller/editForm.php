<?php 


//Gestion du formulaire de modification de la page d'acceuil en POST (homeView.phtml)
if (isset($_POST['recipeId'])) {

	$recipeModel = new RecipeModel();
	$recipe = $recipeModel->findById($_POST['recipeId']);

	// On verifie que la recette existe
	if ($recipe != false) {

		$categories = $recipeModel->getCategoryList();

		$ingredients = $recipeModel->getIngredients($_POST['recipeId']);

	} else {
		// Si la recette n'existe pas affichage d'une erreur
		header('Location: index.php?error=editError#editRecipe');
	}

//Gestion du bouton "modifier" dans l'affichage de la recette en GET (recipeView.phtml)
} elseif (isset($_GET['recipeId'])) {

	$recipeModel = new RecipeModel();
	$recipe = $recipeModel->findById($_GET['recipeId']);

	$categories = $recipeModel->getCategoryList();

	$ingredients = $recipeModel->getIngredients($_GET['recipeId']);

} else {

	// Redirection vers la page d'acceuil si aucun id reçu	
	header('Location: index.php');
}

require('view/editView.phtml');
