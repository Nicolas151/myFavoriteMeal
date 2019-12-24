<?php 


$recipe = new RecipeModel();

$recipe->edit(
    $_POST['recipeDetails']['recipeId'],
    $_POST['recipeDetails']['title'],
    $_POST['recipeDetails']['description'],
    $_POST['recipeDetails']['recipe'],
    $_POST['recipeDetails']['categorie'],
    $_POST['ingredients']
    );

header('Location: index.php');