<?php

// Définition de la classe OrderController pour gérer les commandes
class OrderController
{
    private $db; // Variable pour stocker la connexion à la base de données

    // Constructeur de la classe qui initialise la connexion à la base de données
    public function __construct($db)
    {
        $this->db = $db; // Assignation de la connexion à la base de données passée en paramètre
    }

    // Méthode pour créer une commande
    public function createOrder($userID, $totalPrice)
    {
        $ref = uniqid(); // Génération d'un identifiant unique pour la référence de la commande
        $date = date('Y-m-d'); // Obtention de la date actuelle

        // Préparation de la requête SQL pour insérer la commande
        $query = "INSERT INTO user_order (ref, date, total, user_id) VALUES (:ref, :date, :total, :user_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ref', $ref); // Liaison du paramètre ref
        $stmt->bindParam(':date', $date); // Liaison du paramètre date
        $stmt->bindParam(':total', $totalPrice); // Liaison du paramètre total
        $stmt->bindParam(':user_id', $userID); // Liaison du paramètre user_id

        if ($stmt->execute()) { // Exécution de la requête
            return $this->db->lastInsertId(); // Retourne l'ID de la commande insérée
        } else {
            return false; // Retourne false en cas d'échec
        }
    }

    // Méthode pour obtenir toutes les commandes
    public function getAllOrders()
    {
        // Préparation de la requête SQL pour obtenir toutes les commandes
        $sql = "SELECT o.id, o.ref, o.date, o.total, u.user_name FROM user_order o JOIN user u ON o.user_id = u.id ORDER BY o.date DESC";
        $stmt = $this->db->prepare($sql); // Préparation de la requête
        $stmt->execute(); // Exécution de la requête
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les résultats sous forme de tableau associatif
    }
}
