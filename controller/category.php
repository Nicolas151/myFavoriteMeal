<?php 


session_start();

$recipe = new RecipeModel();

$meals = $recipe->getByCategory($_GET['id']);

require('view/categoryView.phtml');