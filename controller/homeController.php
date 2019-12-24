<?php 


session_start();

$recipe = new RecipeModel();

$meals = $recipe->getLastests();

$categories = $recipe->getCategoryList();

require('view/homeView.phtml');