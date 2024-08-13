<?php

// Définition de la classe LogoutController pour gérer le processus de déconnexion
class LogoutController
{
    // Méthode pour gérer la déconnexion
    public function logout()
    {
        // Nettoyage de la session
        $_SESSION = array(); // Réinitialise le tableau de session, supprimant toutes les données de session
        session_destroy(); // Détruit la session

        // Redirection vers la page de connexion
        header("Location: view/auth/login.php");
        exit; // Assure que le script s'arrête après la redirection pour éviter l'exécution de code supplémentaire
    }
}
