'use strict';

var FormValidator = function (form) {
    this.form = form;
    this.errorMessage = form.find('.error-message');
    this.totalErrorCount = form.find('.total-error-count');

    // listing général de toutes les erreurs de validatoin trouvées
    this.errorMessages = null;
};

FormValidator.prototype.checkDataTypes = function () {
    this.form.find('[data-type]').each(function(index, field) {
        var value;
        value = $(field).val().trim();

        var regexEmail = /^[\w.-]+@[\da-z][\w.-]*\.[a-z0-9-]{2,}/i;
        var regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*&?-])[A-Za-z\d@$!%*&?-]{8,}$/;

        switch ($(field).data('type')) {
            case 'email':
                if (value.length && !regexEmail.test(value)) {
                    this.errorMessages.push({
                        fieldName: $(field).data('name'),
                        message: 'doit être une adresse email valide'
                    });
                }
                break;
            case 'password':
                if (value.length && !regexPassword.test(value)) {
                    this.errorMessages.push({
                        fieldName: $(field).data('name'),
                        message: 'doit comporter 8 caractères dont 1 minuscule, 1 majuscule, 1 chiffre et un caractère spécial'
                    });
                }
                break;
            case 'password-confirmation':
                if (this.form.find('[data-type="password"]').length && this.form.find('[data-type="password"]').val() !== value) {
                    this.errorMessages.push({
                        fieldName: $(field).data('name'),
                        message: ' est différent du champ mot de passe'
                    });
                }
                break;
        }
    }.bind(this));
};

FormValidator.prototype.checkMaximumLength = function () {
    this.form.find('[data-maxlength]').each(function(index, field) {
        if ($(field).val().trim().length && $(field).val().trim().length > $(field).data('maxlength')) {
            this.errorMessages.push({
                fieldName: $(field).data('name'),
                message: 'doit comporter au maximum ' + $(field).data('maxlength') + ' caractère(s)'
            });
        }
    }.bind(this));
};

FormValidator.prototype.checkMinimumLength = function () {
    this.form.find('[data-minlength]').each(function(index, field) {
        if ($(field).val().trim().length && $(field).val().trim().length < $(field).data('minlength')) {
            this.errorMessages.push({
                fieldName: $(field).data('name'),
                message: 'doit comporter au moins ' + $(field).data('minlength') + ' caractère(s)'
            });
        }
    }.bind(this));
};

FormValidator.prototype.checkRequiredFields = function () {
    this.form.find('[data-required]').each(function(index, field) {
        if (!$(field).val().trim().length) {
            this.errorMessages.push({
                fieldName: $(field).data('name'),
                message: 'est requis'
            });
        }
    }.bind(this));
};

FormValidator.prototype.onSubmit = function (event) {
    var errorMessage;

    this.errorMessage.hide();

    errorMessage = '';

    this.errorMessages  = [];
    // Execution des différentes validations
    this.checkRequiredFields();
    this.checkMaximumLength();
    this.checkMinimumLength();
    this.checkDataTypes();

    // Enregistrement du nombre d'erreurs de validation trouvées dans le formulaire
    this.form.data('validation-error-count', this.errorMessages.length);

    if (this.errorMessages.length) {
        this.totalErrorCount.text(this.errorMessages.length);

        this.errorMessages.forEach(function (error) {
            errorMessage += 'Le champ <em><strong>' + error.fieldName + '</strong></em> ' + error.message + '.<br>';
        });

        this.errorMessage.children('p').html(errorMessage);

        this.errorMessage.fadeIn('slow');

        event.preventDefault();
    }

};

FormValidator.prototype.run = function () {
    // mise en place de l'écouteur d'évènement d'envoi
    this.form.on('submit', this.onSubmit.bind(this));

    // s'il y a déjà une erreur (PHP) afficher le message d'erreur
    if (this.errorMessage.children('p').text().length) {
        this.errorMessage.fadeIn('slow');
    }
};