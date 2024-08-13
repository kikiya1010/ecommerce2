<?php

class Role
{
    // Propriétés représentant les colonnes de la table.
    public $id;
    public $name;
    public $description;

    // Connexion à la base de données
    private $conn;
    private $table_name = "role";

    // Constructeur recevant la connexion à la base de données
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour créer un nouveau rôle
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (name, description) 
                  VALUES 
                  (:name, :description)";

        $stmt = $this->conn->prepare($query);
        // Nettoyage des données et assignation des paramètres
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour lire tous les rôles
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Méthode pour lire un seul rôle par ID
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        // Assignation des valeurs aux propriétés de l'objet
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->description = $row['description'];
    }

    // Méthode pour mettre à jour un rôle existant
    public function update()
    {
        $query = "UPDATE " . $this->table_name . " 
                  SET 
                      name = :name, 
                      description = :description
                  WHERE 
                      id = :id";

        $stmt = $this->conn->prepare($query);
        // Nettoyage des données et assignation des paramètres
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Méthode pour supprimer un rôle
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        // Nettoyage des données et assignation du paramètre
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
