<?php 
    

if (!array_key_exists('ingredients', $_POST)) {

	$ingredients = [];

} else {

    $ingredients = $_POST['ingredients'];
};

require('../../view/ingredientListView.phtml');


       