<?php


session_start();

// Vérification que l'utilisateur est bien connecté
$userSession = new UserSession();

if ($userSession->isAuthenticated()) {
    $recipe = new RecipeModel();

    $recipe->create(
        $_POST['recipeDetails']['title'],
        $_POST['recipeDetails']['description'],
        $_POST['recipeDetails']['recipe'],
        $_SESSION['user']['id'],
        $_POST['recipeDetails']['categorie'],
        $_POST['ingredients']
        );
} else {
	// Si l'utilisateur n'est pas connecté affichage de la page de connection 
	header('Location: index.php?action=login');
};