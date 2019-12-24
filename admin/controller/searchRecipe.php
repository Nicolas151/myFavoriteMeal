<?php 

// Gestion de la recherche par numéro (id)
if (isset($_POST['recipeId'])) {

	$recipeModel = new RecipeModel();
	$recipe = $recipeModel->findById($_POST['recipeId']);

	// On verifie que la recette existe
	if ($recipe != false) {

		$ingredients = $recipeModel->getIngredients($_POST['recipeId']);

		require('view/recipeView.phtml');

	} else {
		// Si la recette n'existe pas affichage d'une erreur
		header('Location: index.php?error=searchError#searchRecipe');
	};

  // Gestion de la recherche par titre
} elseif (isset($_POST['title'])) {

	$recipeModel = new RecipeModel();
	$recipe = $recipeModel->findByTitle($_POST['title']);

	// On verifie que la recette existe
	if ($recipe != false) {

		$ingredients = $recipeModel->getIngredients($recipe['id']);

		require('view/recipeView.phtml');

	} else{
		// Si la recette n'existe pas affichage d'une erreur
		header('Location: index.php?error=searchError#searchRecipe');
	}
}