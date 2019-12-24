<?php 


$recipeModel = new RecipeModel();

$recipeModel->delete($_GET['id']);

header('Location: index.php');
