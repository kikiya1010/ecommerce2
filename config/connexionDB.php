<?php
// Définition de la classe connexionDB pour gérer la connexion à la base de données
class connexionDB
{
    // Déclaration des propriétés statiques pour les détails de connexion
    private static $dbHost = "localhost"; // Hôte de la base de données
    private static $dbName = "petshop"; // Nom de la base de données
    private static $dbUsername = "root"; // Nom d'utilisateur pour la base de données
    private static $dbUserPassword = ""; // Mot de passe de l'utilisateur de la base de données

    // Variable pour conserver l'instance de la connexion
    private static $connection = null;

    // Méthode pour obtenir une connexion à la base de données
    public static function getConnection()
    {
        // Vérifie si la connexion existe déjà
        if (null == self::$connection) {
            try {
                // Crée une nouvelle connexion PDO si aucune connexion n'existe
                self::$connection = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
                // Configure l'encodage des caractères en utf-8
                self::$connection->exec("set names utf8");
            } catch (PDOException $exception) {
                // Arrête l'exécution et affiche le message d'erreur si la connexion échoue
                die($exception->getMessage());
            }
        }
        // Retourne l'instance de la connexion
        return self::$connection;
    }

    // Méthode pour déconnecter la base de données
    public static function disconnect()
    {
        // Réinitialise la connexion à null
        self::$connection = null;
    }
}
