<?php 


session_start();

try {

	$recipeModel = new RecipeModel();

	// Reception de l'id de la recette en GET
	$recipe = $recipeModel->findByValidateId($_GET['recipeId']);
	$ingredients = $recipeModel->getIngredients($_GET['recipeId']);

} catch(Exception $e) {

  	$errorMessage = 'Erreur : ' . $e->getMessage();

} finally {

    if (empty($errorMessage)) {

		$errorMessage = null;

	}
};

require('view/recipeView.phtml');
