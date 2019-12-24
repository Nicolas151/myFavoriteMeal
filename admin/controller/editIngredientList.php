<?php 


$recipeModel = new RecipeModel();

$ingredients = $recipeModel->getIngredients($_POST['recipeId']);

//envoi des ingredients en JSON
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($ingredients);

