<?php 


// Chargement de la base de donnée et des modèles
require('../classes/UserSession.php');
require('../config/dbConnection.php');
require('../model/RecipeModel.php');
require('../model/UserModel.php');

// Gestion de l'appel des controleurs
if (isset($_GET['action'])) {

	switch ($_GET['action']) {
		case 'delete':
		    require('controller/deleteRecipe.php');
		    break;
		case 'edit':
		    require('controller/editForm.php');
		    break;
		case 'editIngredient':
		    require('controller/editIngredientList.php');
		    break;
		case 'editRecipe':
		    require('controller/editRecipe.php');
		    break;
		case 'searchRecipe':
		    require('controller/searchRecipe.php');
		    break;
		case 'showRecipe':
		    require('controller/showRecipe.php');
		    break;
		case 'validate':
		    require('controller/validateRecipe.php');
		    break;
		} 

// Gestion du formulaire editForm lors de la reception d'un input type "hidden"
} elseif (isset($_POST['editForm'])) {

	require('controller/editRecipe.php');

} else {

	// Affichage de la page d'acceuil si aucun controleur n'est appelé
	require('controller/homeController.php');
	
};
