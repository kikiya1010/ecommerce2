<?php

// Définition de la classe RegisterController pour gérer les inscriptions d'utilisateurs
class RegisterController
{
    private $db; // Variable pour stocker la connexion à la base de données

    // Constructeur de la classe qui initialise la connexion à la base de données
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Méthode pour enregistrer un nouvel utilisateur
    public function register($userDetails)
    {
        $email = $userDetails['email']; // Récupération de l'email depuis les détails de l'utilisateur
        $username = $userDetails['user_name']; // Récupération du nom d'utilisateur
        $password = $userDetails['pwd']; // Récupération du mot de passe
        $role_id = $userDetails['role_id']; // Récupération de l'identifiant du rôle

        // Vérifier si l'email ou le nom d'utilisateur sont déjà utilisés
        $checkQuery = "SELECT * FROM user WHERE email = :email OR user_name = :username";
        $stmt = $this->db->prepare($checkQuery);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Cet email ou nom d'utilisateur est déjà enregistré.";
        }

        // Chiffrer le mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insérer le nouvel utilisateur
        $insertQuery = "INSERT INTO user (user_name, email, pwd, role_id) VALUES (:username, :email, :pwd, :role_id)";
        $stmt = $this->db->prepare($insertQuery);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pwd', $hashedPassword);
        $stmt->bindParam(':role_id', $role_id);

        if ($stmt->execute()) {
            return "Inscription réussie !";
        } else {
            return "Une erreur est survenue lors de l'inscription.";
        }
    }
}
