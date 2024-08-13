<?php

// Définition de la classe UserController pour gérer les opérations sur les utilisateurs
class UserController
{
    public $users = []; // Tableau pour stocker les utilisateurs récupérés de la base de données
    private $db; // Variable pour stocker la connexion à la base de données

    // Constructeur de la classe qui initialise la connexion à la base de données
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser($user_id, $fname, $lname)
    {
        $query = "UPDATE `user` SET fname = :fname, lname = :lname WHERE id = :user_id"; // Requête SQL pour mettre à jour l'utilisateur

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':fname', $fname); // Liaison du paramètre fname
            $stmt->bindParam(':lname', $lname); // Liaison du paramètre lname
            $stmt->bindParam(':user_id', $user_id); // Liaison du paramètre user_id
            $stmt->execute();

            return true; // Retourne vrai si la mise à jour est réussie
        } catch (PDOException $e) {
            // Gestion de l'erreur
            return false;
        }
    }

    // Méthode pour lister tous les utilisateurs
    public function listUsers()
    {
        try {
            $query = "SELECT id, user_name, email, fname, lname FROM user"; // Requête SQL pour récupérer les utilisateurs
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $this->users = $stmt->fetchAll(PDO::FETCH_ASSOC); // Stocke les utilisateurs dans la variable $users
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage(); // Affiche le message d'erreur en cas d'échec
        }
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($userId)
    {
        try {
            $query = "DELETE FROM user WHERE id = :id"; // Requête SQL pour supprimer l'utilisateur
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $userId, PDO::PARAM_INT); // Liaison du paramètre id
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage(); // Affiche le message d'erreur en cas d'échec
        }
    }
}
