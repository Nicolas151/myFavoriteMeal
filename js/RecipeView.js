'use strict';

var RecipeView = function () {
	// selection de l'article "de" dans les phrases
	this.article = document.querySelectorAll('.article');
	//selection du nom de l'ingredient
	this.ingredientName = document.querySelectorAll('.ingredientName');

	this.ingredientList = new IngredientList();

};

RecipeView.prototype.testIngredientArticle = function () {
    // Gestion de l'article ("de","d'" ou " ") des ingrédients
    var ingredient;
       
    for (ingredient = 0; ingredient < this.ingredientName.length; ingredient++) {

        // si le nom de l'ingredient est dans l'un des tableaux, 
        // remplacement de l'article "de" par un espace ou un "d'" dans la phrase
        if (this.ingredientList.getIngredientWithoutMeasureUnit(this.ingredientName[ingredient])) {

            this.article[ingredient].innerHTML = ' ';

        } else if (this.ingredientList.getLiquideIngredient(this.ingredientName[ingredient])) {
            
            this.article[ingredient].innerHTML = ' d\'';

        }
    }
};

RecipeView.prototype.run = function () {

    this.testIngredientArticle();

};
