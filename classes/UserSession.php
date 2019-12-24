<?php


class UserSession
{
    public function __construct()
    {
        // Le module de session de PHP est-il démarré
        if (session_status() == PHP_SESSION_NONE) {
            // Si non, on le démarre
            session_start();
        }
    }

    public function create($userId, $firstname, $lastname, $email)
    {
        // Stocker les infos utilisateur dans la session
        $_SESSION['user'] = [
            'id'        => $userId,
            'firstname' => $firstname,
            'lastname'  => $lastname,
            'email'     => $email,
        ];
        // Regénérer l'ID de session
        session_regenerate_id(true);
    }

    public function destroy()
    {
        session_regenerate_id(true);
        $_SESSION = [];
        session_destroy();
    }

    public function getFirstname()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }
        return $_SESSION['user']['firstname'];
    }

    public function getFullname()
    {
        if (!$this->isAuthenticated()) {
            return null;
        }
        return $_SESSION['user']['firstname'] . ' ' .$_SESSION['user']['lastname'];
    }

    public function isAuthenticated()
    {
        return array_key_exists('user', $_SESSION);
    }
}