<?php 

//Reception de l'id de la derniere recette affichée et de sa categorie (AJAX)
$lastId = $_POST['lastId'];

$category = $_POST['category'];

$recipe = new RecipeModel();

$meals = $recipe->getByLastIdAndCategory($lastId, $category);

require('view/seeMoreView.phtml');