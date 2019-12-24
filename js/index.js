'use strict';

/////////////////////////////////////////////////////////////////////////////////////////
// FONCTIONS                                                                           //
/////////////////////////////////////////////////////////////////////////////////////////

function clickDeleteRecipeButton() {
    $('#deleteRecipe').on('click', 
        function() {
            //affichage d'une alerte avant suppression d'une recette
            $('#deleteAlert').removeClass('hidden');
        }
    );
}

function clickSeeMoreButton() {
    $('#seeMore').on('click',
        function() {
            //Requete Ajax pour affichage de 8 recettes supplémentaire lors du click
            $.ajax({
                type: 'POST',
                url: 'index.php?action=seeMore',
                data: { 
                    lastId : $('.mealItems:last').data('id')
                    },
                success: function(display) {
                  $(".mealItems:last").after(display);
                },
                error: function() {
                  alert('La requête n\'a pas abouti'); 
                }
            });  
        }
    );
}

function clickSeeMoreByCategoryButton() {
    $('#seeMoreByCategory').on('click', 
        function() {
            //Requete Ajax pour affichage de 8 recettes supplémentaire lors du click
            $.ajax({
                type: 'POST',
                url: 'index.php?action=seeMoreByCategory',
                data: { 
                    lastId : $('.mealItems:last').data('id'),
                    category : $('.mealItems:first').data('category')
                    },
                success: function(display) {
                  $(".mealItems:last").after(display);
                },
                error: function() {
                  alert('La requête n\'a pas abouti'); 
                }
            });   
        }
    );
}

function runEditForm() {
   var editForm;

   editForm = new EditForm();

   editForm.run();

}

function runFormValidation() {
    var forms;
    var formValidator;
    // récupérer les formulaires
    forms = $('form');

    // Pour chaque formulaire s'il y en a instancier et lancer un validateur
    if (forms.length === 0) {
        return;
    }

    forms.each(function () {
        formValidator = new FormValidator($(this));
        formValidator.run();
    });
}

 function runRecipeForm() {
    var recipeForm;

    recipeForm = new RecipeForm();

    recipeForm.run();

 }
 
function runRecipeView() {
    var recipeView;

    recipeView = new RecipeView;

    recipeView.run();
}

function toggleConnexionMenu() {

    // En natif
    var connexionMenu = document.getElementById('connexionMenu');
    var button = document.getElementById('connexionButton');

    // Si utilisateur déja connecté

    if(button == null)
    {
        return;
    }

    button.addEventListener('click', 
      function () { 
        connexionMenu.classList.toggle('open'); 
    });
} 


/////////////////////////////////////////////////////////////////////////////////////////
// CODE PRINCIPAL                                                                      //
/////////////////////////////////////////////////////////////////////////////////////////

$(function () {

    // Exécution de la gestion du bouton de suppression (admin)
    clickDeleteRecipeButton();

    // Exécution de la gestion du bouton "voir plus" (allRecipesView.phtml)
    clickSeeMoreButton();

    // Exécution de la gestion du bouton "voir plus" (categoryView.phtml)
    clickSeeMoreByCategoryButton();

    // Exécution de la validation de formulaire si besoin.
    runFormValidation();

    // Exécution de la gestion du processus de modification d'une recette (admin).
    if(typeof EditForm != 'undefined')
    {
        runEditForm();

    }

    // Exécution de la gestion du processus de dépot d'une recette si besoin.
     if(typeof RecipeForm != 'undefined')
    {
        runRecipeForm();

    }

    // Exécution de la gestion du processus de dépot d'une recette si besoin.
     if(typeof RecipeView != 'undefined')
    {
        runRecipeView();

    }

    // Exécution de la gestion du menu de connexion.
    toggleConnexionMenu();


});