'use strict';

var RecipeForm = function () {
    this.categorie = $('#categorie');
    this.description = $('#description');
    this.form = $('#recipe-form');
    this.ingredient = $('#ingredient');
    this.ingredientDisplay = $('#ingredientDisplay');
    this.quantity = $('#quantity');
    this.recipe = $('#recipe');
    this.title = $('#title');
    this.validateIngredient = $('#validate-ingredient');

    this.ingredientList = new IngredientList();

    this.recipeDetails = {};
      
};

RecipeForm.prototype.onAjaxRefreshIngredientList = function(ingredientListViewHtml) {

    // Insertion de la liste (la vue en PHP) dans le document HTML.
    this.ingredientDisplay.html(ingredientListViewHtml);

    // Gestion de l'article ("de","d'" ou " ") des ingrédients (en natif)
    var article;
    var ingredientName;

    // selection de l'article "de" dans la phrase
    article = document.querySelectorAll('.article');

    // selection du nom de l'ingredient
    ingredientName = document.querySelectorAll('.ingredientName');

    var ingredient;

    // si le nom de l'ingredient est dans l'un des tableaux, 
    // remplacement de l'article "de" par un espace ou un "d'" dans la phrase
    for (ingredient = 0; ingredient < ingredientName.length; ingredient++) {

        if (this.ingredientList.getIngredientWithoutMeasureUnit(ingredientName[ingredient])) {

            article[ingredient].innerHTML = ' ';

        } else if (this.ingredientList.getLiquideIngredient(ingredientName[ingredient])) {
            
            article[ingredient].innerHTML = ' d\'';

        }
    }
};

RecipeForm.prototype.onClickRemoveIngredient = function (event) {

    this.ingredientList.remove($(event.currentTarget).data('ingredient-name'));

    this.refreshIngredientView();

    event.preventDefault();
};

RecipeForm.prototype.onClickValidateIngredient = function () {

    // Ajout de l'ingredient dans la liste.
    this.ingredientList.add
        (
            // Saisie de la quantité
            this.quantity.val(),
            // Saisie de du nom de l'ingredient
            this.ingredient.val()

        );

    this.refreshIngredientView();

};

RecipeForm.prototype.onClickValidateRecipe = function() {

    var ingredients;
    var recipeDetails;
    var recipe;

    //Récupération des données des champs du formulaire
    recipeDetails = {
        title       : this.title.val(),
        description : this.description.val(),
        recipe      : this.recipe.val(),
        categorie   : this.categorie.val()
    };

    recipe = {
        ingredients : this.ingredientList.ingredients,
        recipeDetails : recipeDetails
    };

    // Vérification du nombre d'erreur dans le formulaire
     if (this.form.data('validation-error-count') > 0)
    {
        // Pas d'envoi si une erreur est présente
        alert('Erreur(s) dans le formulaire');
        return;
    }   

    // Envoi des données du formulaire et de la liste d'ingredients en AJAX
    $.ajax({
            type: 'POST',
            url: 'index.php?action=createRecipe',
            data: { 
                recipeDetails: recipeDetails, 
                ingredients: this.ingredientList.ingredients 
                },
            success: function() {
                window.location = 'index.php?action=depositSuccess';
              ; },
            error: function() {
                alert('La requête n\'a pas abouti'); 
            }
          });   

    // Suppression des ingredients.
    this.ingredientList.clear();

    // Empêcher le navigateur d'envoyer le formulaire.
    event.preventDefault();

};

RecipeForm.prototype.refreshIngredientView = function() {
    
    var ingredientList;

    ingredientList = {
        ingredients : this.ingredientList.ingredients
    };

    $.post
    (
        'controller/ingredientList.php',                // URL de destination
        ingredientList,                                 // Données HTTP POST
        this.onAjaxRefreshIngredientList.bind(this)     // Au retour de la réponse HTTP
    );

    // Réinitialisation des champs
    this.ingredient.val(''); 
    this.quantity.val('');

};

RecipeForm.prototype.run = function () {

    // Installation d'un gestionnaire d'évènement sur la soumission du formulaire.
    this.form.on('submit', this.onClickValidateRecipe.bind(this));

    // Installation d'un gestionnaire d'évènement sur le bouton de suppression des ingredients.
    this.ingredientDisplay.on('click', 'button', this.onClickRemoveIngredient.bind(this));

    // Installation des gestionnaires de validation d'ingredient
    this.validateIngredient.on('click', this.onClickValidateIngredient.bind(this));    

    // Affichage initial de la liste des ingredients (pas d'ingredient)
    this.refreshIngredientView();

};