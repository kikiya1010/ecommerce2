<?php

// Définition de la classe LoginController pour gérer le processus de connexion
class LoginController
{
	private $db; // Variable pour stocker la connexion à la base de données

	// Constructeur de la classe qui initialise la connexion à la base de données
	public function __construct($db)
	{
		$this->db = $db; // Assignation de la connexion à la base de données passée en paramètre
	}

	// Méthode pour gérer le processus de connexion
	public function login($username, $password)
	{
		// Préparation de la requête SQL pour trouver l'utilisateur par son nom d'utilisateur
		$query = "SELECT id, user_name, pwd, role_id FROM user WHERE user_name = :username";

		try {
			$stmt = $this->db->prepare($query); // Préparation de la requête
			$stmt->bindParam(':username', $username); // Liaison du paramètre username
			$stmt->execute(); // Exécution de la requête

			if ($stmt->rowCount() == 1) { // Vérification s'il y a exactement un utilisateur correspondant
				$user = $stmt->fetch(PDO::FETCH_ASSOC); // Récupération de l'utilisateur

				if (password_verify($password, $user['pwd'])) { // Vérification du mot de passe
					// Les informations d'identification sont correctes
					return [
						'success' => true,
						'user_id' => $user['id'],
						'username' => $user['user_name'],
						'role_id' => $user['role_id']
					];
				} else {
					// Le mot de passe est incorrect
					return [
						'success' => false,
						'message' => 'La mot de passe est incorrect.'
					];
				}
			} else {
				// Aucun utilisateur trouvé avec ce nom d'utilisateur
				return [
					'success' => false,
					'message' => "L'utilisateur n'existe pas."
				];
			}
		} catch (PDOException $e) {
			// Gestion des erreurs de connexion à la base de données
			return [
				'success' => false,
				'message' => 'Erreur lors de l’accès à la base de données.'
			];
		}
	}
}
