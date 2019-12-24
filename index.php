<?php 


// Modification de la durée de vie du cookie de session (12h)
session_set_cookie_params(43200);
// Modification du temps de session côté serveur (12h)
ini_set('session.gc_maxlifetime', 43200);

// Chargement de la base de donnée, des classes et des modèles
require('classes/UserSession.php');
require('config/dbConnection.php');
require('model/RecipeModel.php');
require('model/UserModel.php');

// Gestion de l'appel des controleurs
if (isset($_GET['action'])) {

	switch ($_GET['action']) {
		case 'allRecipes':
		    require('controller/allRecipes.php');
		    break;
		case 'categories':
		    require('controller/categories.php');
		    break;
		case 'category':
		    require('controller/category.php');
		    break;
	    case 'createRecipe':
	        require('controller/createRecipe.php');
	        break;
        case 'deposit':
            require('controller/deposit.php');
            break;
        case 'depositSuccess':
            require('controller/depositSuccess.php');
            break;
        case 'login':
            require('controller/login.php');
            break;
        case 'logout':
            require('controller/logout.php');
            break;
        case 'seeMore':
            require('controller/seeMore.php');
            break;
        case 'seeMoreByCategory':
            require('controller/seeMoreByCategory.php');
            break;
        case 'showRecipe':
            require('controller/showRecipe.php');
            break;
		case 'user':
		    require('controller/user.php');
		    break;
        case 'userSuccess':
            require('controller/userSuccess.php');
            break;
		};

// Gestion des formulaires lors de la reception d'un input type "hidden"
} elseif (isset($_POST['userForm'])) {

	require('controller/user.php');

} elseif (isset($_POST['loginForm'])) {

	require('controller/login.php');

} else {
// Affichage de la page d'acceuil si aucun controleur n'est appelé
	require('controller/homeController.php');
};
