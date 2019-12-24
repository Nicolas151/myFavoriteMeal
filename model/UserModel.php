<?php


class UserModel
{
    private $db;
        
    public function __construct()
    {
        $this->db = new Database();
    }

    public function findByEmailPassword($email, $password)
    {
        $user = $this->db->queryOne('
            SELECT
              id,
              firstname,
              lastname,
              email,
              password
            FROM user
            WHERE email = ?
        ', [$email]);

        if (empty($user)) {
            throw new Exception(
                'Identifiant ou mot de passe incorrect.'
            );
        }

        if (!$this->verifyPassword($password, $user['password'])) {
            throw new Exception(
                'Identifiant ou mot de passe incorrect.'
            );
        }

        unset($user['password']);

        return $user;
    }

    public function signUp(
        $firstname,
        $lastname,
        $email,
        $password,
        $city
    ) {
        // on vérifie s'il y a un utilisateur avec l'adresse email spécifiée
        $user = $this->db->queryOne('SELECT id FROM user WHERE email = ?', [$email]);

        if (!empty($user)) {
            throw new Exception(
                'Il existe déjà un compte utilisateur avec cette adresse email'
            );
        }

        $sql = '
            INSERT INTO user
            (firstname, lastname, email, password, city, created_at)
            VALUES
            (:firstname, :lastname, :email, :password, :city, :created_at)
        ';

        return $this->db->executeSql($sql, [
            ':firstname'  => $firstname,
            ':lastname'   => $lastname,
            ':email'      => $email,
            ':password'   => $this->hashPassword($password),
            ':city'       => $city,
            ':created_at' => date_create()->format('Y-m-d H:i:s'),
        ]);
    }

    private function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 11]);
    }

    private function verifyPassword($password, $hashedPassword)
    {
         // Si le mot de passe en clair est le même que la version hachée alors renvoie true.
        return crypt($password, $hashedPassword) === $hashedPassword;
    }
}