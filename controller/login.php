<?php


try {

	// Si le formulaire est envoyé (input type "hidden" "loginForm") création de la session
	if (isset($_POST['loginForm'])) {

		$userModel = new UserModel();

		$user = $userModel->findByEmailPassword($_POST['email'], $_POST['password']);

		$userSession = new UserSession();
		$userSession->create(
		    $user['id'],
		    $user['firstname'],
		    $user['lastname'],
		    $user['email']
		);

		// Redirection vers la page d'acceuil
		header('Location: index.php');

	} 
	
} catch(Exception $e) {

  	$errorMessage = 'Erreur : ' . $e->getMessage();

} finally {

    if (empty($errorMessage)) {

		$errorMessage = null;

	}
};

require('view/loginView.phtml');