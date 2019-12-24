<?php 


$recipe = new RecipeModel();

$meals = $recipe->getToValidate();

require('view/homeView.phtml');