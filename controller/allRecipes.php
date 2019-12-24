<?php 

session_start();

$recipe = new RecipeModel();

$meals = $recipe->getLastests();

require('view/allRecipesView.phtml');