<?php

class Product
{
    // Propriétés représentant les colonnes de la table.
    public $id;
    public $name;
    public $quantity;
    public $price;
    public $img_url;
    public $description;

    // Connexion à la base de données.
    private $conn;
    private $table_name = "product";

    // Constructeur avec connexion à la base de données.
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Méthode pour créer un nouveau produit.
    public function create()
    {
        $query = "INSERT INTO " . $this->table_name .
            " (name, quantity, price, img_url, description) 
                  VALUES (:name, :quantity, :price, :img_url, :description)";

        $stmt = $this->conn->prepare($query);
        // Nettoyage et assignation des paramètres.
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":img_url", $this->img_url);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour lire tous les produits.
    public function read()
    {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Méthode pour lire un produit par son ID.
    public function readOne($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Assignation des valeurs aux propriétés de l'objet.
        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->quantity = $row['quantity'];
        $this->price = $row['price'];
        $this->img_url = $row['img_url'];
        $this->description = $row['description'];
    }

    // Méthode pour mettre à jour un produit existant.
    public function update()
    {
        $query = "UPDATE " . $this->table_name .
            " SET name = :name, quantity = :quantity, price = :price, 
                   img_url = :img_url, description = :description
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        // Nettoyage et assignation des paramètres.
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":quantity", $this->quantity);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":img_url", $this->img_url);
        $stmt->bindParam(":description", $this->description);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Méthode pour supprimer un produit.
    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        // Nettoyage et assignation du paramètre.
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
