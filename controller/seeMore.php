<?php 
    
//Reception de l'id de la derniere recette affichée (AJAX)
$lastId = $_POST['lastId'];

$recipe = new RecipeModel();

$meals = $recipe->getByLastId($lastId);


require('view/seeMoreView.phtml');
       