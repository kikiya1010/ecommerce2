<?php

// Définition de la classe ProductController pour gérer les produits
class ProductController
{
    private $db; // Variable pour stocker la connexion à la base de données

    // Constructeur de la classe qui initialise la connexion à la base de données
    public function __construct($db)
    {
        $this->db = $db;
    }

    // Méthode pour ajouter un produit à la base de données
    public function addProduct($name, $quantity, $price, $description, $image)
    {
        $targetDir = "../../public/img/"; // Dossier cible pour les images
        $imageName = basename($image['name']); // Nom de l'image
        $targetFile = $targetDir . $imageName; // Chemin complet du fichier image
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION)); // Extension du fichier image
        $checkImage = getimagesize($image['tmp_name']); // Vérifie si le fichier est une image

        if ($checkImage !== false) { // Vérifie si le fichier est une image
            if ($imageFileType != "jpg") {
                return "Seuls les fichiers JPG sont autorisés."; // Restreindre le type de fichier
            }

            // Créer un nom de fichier unique pour éviter l'écrasement des fichiers
            $temp = explode(".", $imageName);
            $newfilename = round(microtime(true)) . '.' . end($temp);
            $targetFile = $targetDir . $newfilename;

            if (move_uploaded_file($image['tmp_name'], $targetFile)) { // Déplace l'image uploadée
                $imgPath = "public/img/" . $newfilename; // Chemin de l'image pour la base de données
                $insertQuery = "INSERT INTO product (name, quantity, price, img_url, description) VALUES (?, ?, ?, ?, ?)";

                // Préparation de la requête SQL avec PDO
                $stmt = $this->db->prepare($insertQuery);
                // Liaison des paramètres
                $stmt->bindParam(1, $name);
                $stmt->bindParam(2, $quantity);
                $stmt->bindParam(3, $price);
                $stmt->bindParam(4, $imgPath);
                $stmt->bindParam(5, $description);

                if ($stmt->execute()) { // Exécute la requête
                    return true; // Retourne vrai si le produit est ajouté avec succès
                } else {
                    return "Erreur lors de l'ajout du produit : " . $stmt->errorInfo()[2]; // Gestion des erreurs
                }
            } else {
                return "Erreur lors du téléchargement de l'image."; // Erreur de téléchargement
            }
        } else {
            return "Le fichier n'est pas une image."; // Fichier non-image
        }
    }

    // Méthode pour lister tous les produits
    public function listProducts()
    {
        $stmt = $this->db->prepare("SELECT id, name, price, quantity, description FROM product");
        $stmt->execute(); // Exécute la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les produits sous forme de tableau associatif
    }

    // Méthode pour supprimer un produit
    public function deleteProduct($productId)
    {
        $stmt = $this->db->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bindParam(1, $productId, PDO::PARAM_INT); // Liaison du paramètre
        $stmt->execute(); // Exécute la suppression
    }

    // Méthode pour lister les produits de la catégorie 'Cat'
    public function listCatProducts()
    {
        $stmt = $this->db->prepare("SELECT id, name, price, img_url FROM product WHERE category = 'Cat'");
        $stmt->execute(); // Exécute la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les produits sous forme de tableau associatif
    }

    // Méthode pour obtenir un produit par son ID
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT id, name, quantity, price, img_url, description FROM product WHERE id = ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT); // Liaison du paramètre
        $stmt->execute(); // Exécute la requête
        return $stmt->fetch(); // Retourne le produit
    }
}
