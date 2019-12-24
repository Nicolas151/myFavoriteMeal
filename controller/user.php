<?php 


try {
	
	// Si le formulaire est envoyé (input type "hidden" "userForm") création du compte
	if (isset($_POST['userForm'])) {

		// Creation du compte utilisateur
		$userModel = new UserModel();

		$userModel->signUp(
		    $_POST['firstname'],
		    $_POST['lastname'],
		    $_POST['email'],
		    $_POST['password'],
		    $_POST['city'],
		);

		// Creation de la session 
		$user = $userModel->findByEmailPassword($_POST['email'], $_POST['password']);

		$userSession = new UserSession();
		$userSession->create(
		    $user['id'],
		    $user['firstname'],
		    $user['lastname'],
		    $user['email']
		);

		// Redirection
		header('Location: index.php?action=userSuccess');

	} 
} catch(Exception $e) {

  	$errorMessage = 'Erreur : ' . $e->getMessage();

} finally {
    if (empty($errorMessage)) {

		$errorMessage = null;

	}
};

require('view/userView.phtml');




	
