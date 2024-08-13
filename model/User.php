<?php

class User
{
    // Propriétés représentant les colonnes de la base de données.
    public $id;
    public $user_name;
    public $email;
    public $pwd;
    public $fname;
    public $lname;
    public $billing_address_id;
    public $shipping_address_id;
    public $token;
    public $role_id;

    // Connexion à la base de données.
    private $conn;
    private $table_name = "user";

    // Constructeur avec connexion à la base de données.
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour créer un nouvel utilisateur.
    public function create($userDetails)
    {
        $query = "INSERT INTO " . $this->table_name .
            " (user_name, email, pwd, role_id) 
                  VALUES (:user_name, :email, :pwd, :role_id)";
        $stmt = $this->conn->prepare($query);
        // Nettoyage et assignation des paramètres.
        $stmt->bindParam(":user_name", $userDetails['user_name']);
        $stmt->bindParam(":email", $userDetails['email']);
        $stmt->bindParam(":pwd", password_hash($userDetails['pwd'], PASSWORD_DEFAULT));
        $stmt->bindParam(":role_id", $userDetails['role_id']);

        return $stmt->execute();
    }

    // Méthode pour lire tous les utilisateurs.
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Méthode pour lire un utilisateur par ID.
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Assignation des propriétés.
        $this->id = $row['id'];
        $this->user_name = $row['user_name'];
        $this->email = $row['email'];
        $this->pwd = $row['pwd'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
        $this->billing_address_id = $row['billing_address_id'];
        $this->shipping_address_id = $row['shipping_address_id'];
        $this->token = $row['token'];
        $this->role_id = $row['role_id'];
    }

    // Méthode pour mettre à jour un utilisateur existant.
    public function update()
    {
        $query = "UPDATE " . $this->table_name .
            " SET user_name = :user_name, email = :email, pwd = :pwd, 
                       fname = :fname, lname = :lname, billing_address_id = :billing_address_id, 
                       shipping_address_id = :shipping_address_id, token = :token, role_id = :role_id
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        // Nettoyage et assignation des paramètres.
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":user_name", $this->user_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":pwd", $this->pwd);
        $stmt->bindParam(":fname", $this->fname);
        $stmt->bindParam(":lname", $this->lname);
        $stmt->bindParam(":billing_address_id", $this->billing_address_id);
        $stmt->bindParam(":shipping_address_id", $this->shipping_address_id);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":role_id", $this->role_id);

        return $stmt->execute();
    }

    // Méthode pour supprimer un utilisateur.
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        return $stmt->execute();
    }
    public function getAllUsers()
    {
        // Préparation de la requête SQL
        $query = "SELECT id, user_name, email, fname, lname, role_id FROM " . $this->table_name;

        // Préparation de l'instruction
        $stmt = $this->conn->prepare($query);

        // Exécution de la requête
        $stmt->execute();

        // Vérification de la présence de données
        if ($stmt->rowCount() > 0) {
            // Création d'un tableau pour stocker les utilisateurs
            $usersArray = array();

            // Parcours des résultats et ajout dans le tableau
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $userItem = array(
                    "id" => $id,
                    "user_name" => $user_name,
                    "email" => $email,
                    "fname" => $fname,
                    "lname" => $lname,
                    "role_id" => $role_id
                );

                array_push($usersArray, $userItem);
            }

            return $usersArray;
        } else {
            // Aucun utilisateur trouvé
            return "Aucun utilisateur trouvé.";
        }
    }

    public function findByEmail($email)
    {
        // Préparation de la requête pour trouver un utilisateur par email
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email LIMIT 1";

        // Préparation de l'instruction
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);

        // Exécution de la requête
        $stmt->execute();

        // Récupération de l'utilisateur si trouvé
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }

    public function getUserByUsername($username)
    {
        // Préparation de la requête pour trouver un utilisateur par nom d'utilisateur
        $query = "SELECT * FROM `user` WHERE `user_name` = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);

        // Exécution de la requête
        $stmt->execute();

        // Récupération de l'utilisateur si trouvé
        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            return null;
        }
    }
}
