<?php 


session_start();

$recipe = new RecipeModel();

$categories = $recipe->getCategoryList();

require('view/categoriesView.phtml');