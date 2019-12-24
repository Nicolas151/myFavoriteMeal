'use strict';

var IngredientList = function(){
	
	// Contenu de la liste d'ingredient.
    this.ingredients = null;

    this.ingredientsWithoutMeasureUnit = [
        'oeuf',
        'pomme',
        'abricot',
        'avocat',
        'banane',
        'citron',
        'clémentine',
        'coing',
        'figue',
        'fraise',
        'grenade',
        'kiwi',
        'mandarine',
        'mangue',
        'melon',
        'mirabelle',
        'orange',
        'pamplemousse',
        'pastèque',
        'pêche',
        'poire',
        'pomme',
        'prune',
        'tomate',
        'artichaut',
        'asperge',
        'aubergine',
        'betterave',
        'brocoli',
        'carotte',
        'céleri',
        'chou',
        'chou-fleur',
        'citrouille',
        'concombre',
        'courge',
        'courgette',
        'endive',
        'fenouil',
        'Laitue',
        'navet',
        'oignon',
        'panais',
        'patate',
        'poireau',
        'poivron',
        'pomme de terre',
        'potimarron',
        'potiron',
        'salade',
        'topinambour'
    ];

    this.liquideIngredients = [
        'eau',
        'eau de vie',
        'huile',
        'huile d\'olive',
        'huile de colza',
        'huile de noix',
        'huile de tournesol'
    ];

    this.load();

};

IngredientList.prototype.add = function(quantity, name) {

	this.ingredients.push(
    {
        quantity  : quantity,
        name      : name
    });

    this.save();
};

IngredientList.prototype.clear = function() {

	// Destruction de la liste dans le DOM storage.
    saveDataToDomStorage('liste ingredients', null);

    this.ingredients = [];

};

IngredientList.prototype.getIngredientWithoutMeasureUnit = function(ingredientName) {
    var index;

    for (index = 0; index < this.ingredientsWithoutMeasureUnit.length; index++) {

        if (ingredientName.innerText.toLowerCase() 
            === this.ingredientsWithoutMeasureUnit[index] || 
            ingredientName.innerText.toLowerCase() 
            === this.ingredientsWithoutMeasureUnit[index]+'s'|| 
            ingredientName.innerText.toLowerCase() 
            === this.ingredientsWithoutMeasureUnit[index]+'x') {

            // si le nom de l'ingredient est dans le tableau withoutMeasureUnit, 
            // on renvoi true
            return true;
        }
    }

    return false;

};

IngredientList.prototype.getLiquideIngredient = function(ingredientName) {
    var index;

    for (index = 0; index < this.liquideIngredients.length; index++) {

        if (ingredientName.innerText.toLowerCase() 
            === this.liquideIngredients[index] || 
            ingredientName.innerText.toLowerCase() 
            === this.liquideIngredients[index]+'s'|| 
            ingredientName.innerText.toLowerCase() 
            === this.liquideIngredients[index]+'x') {

            // si le nom de l'ingredient est dans le tableau liquideIngredients, 
            // on renvoi true
            return true;
        }
    }

    return false;

};

IngredientList.prototype.remove = function(ingredientName) {
    var index;

    // Recherche de l'ingrédient spécifié.
    for (index = 0; index < this.ingredients.length; index++) {

        if (this.ingredients[index].name == ingredientName){

            // L'ingredient spécifié a été trouvé, suppression.
            this.ingredients.splice(index, 1);

            this.save();

            return true;
        }
    }
    
    return false;
};

IngredientList.prototype.save = function() {

    // Enregistrement de la liste dans le DOM storage.
    saveDataToDomStorage('liste ingredients', this.ingredients);

};

IngredientList.prototype.load = function() {
    // Chargement de la liste d'ingredient depuis le DOM storage.
    this.ingredients = loadDataFromDomStorage('liste ingredients');

    if (this.ingredients == null) {

        this.ingredients = new Array();

    }
};