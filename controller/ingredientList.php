<?php 


session_start();

// Vérification que l'utilisateur est bien connecté
if (isset($_SESSION['user'])) {

	if (!array_key_exists('ingredients', $_POST)) {

		$ingredients = [];

	} else {

	    $ingredients = $_POST['ingredients'];
	};

	 require('../view/ingredientListView.phtml');

} else {

	// Si l'utilisateur n'est pas connecté affichage de la page de connection 
	header('Location: index.php?action=login');

}

