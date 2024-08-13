Contexte et Objectif
Le projet consiste en une application e-commerce développée en PHP, qui permet aux utilisateurs de parcourir des produits, de les ajouter à un panier, de passer des commandes et de gérer les transactions. Un élément clé du projet est l'implémentation de l'authentification utilisateur, où les utilisateurs peuvent s'inscrire, se connecter, et accéder à leurs commandes passées.

Structure et Organisation
Le code est organisé selon une architecture MVC (Modèle-Vue-Contrôleur), ce qui assure une séparation claire des responsabilités entre la gestion des données, la logique d'application, et l'interface utilisateur. Cette structure modulaire facilite la maintenance du code et le rend plus extensible pour l'ajout de nouvelles fonctionnalités.

Fonctionnalités Clés
Connexion à la Base de Données :

Le projet utilise une classe dédiée, connexionDB, pour gérer la connexion à la base de données. Cette classe implémente le pattern singleton, garantissant une connexion unique à la base de données pour toute la durée d'exécution de l'application. La connexion est établie via PDO, un choix judicieux pour sa sécurité et sa flexibilité.


Authentification des Utilisateurs :

Le code inclut une méthode robuste pour l'authentification des utilisateurs. Lors de la tentative de connexion, l'email de l'utilisateur est comparé avec les enregistrements de la base de données. Si un utilisateur est trouvé, le mot de passe fourni est vérifié contre celui stocké, qui est haché pour assurer la sécurité. Cette méthode protège contre les attaques courantes, telles que les injections SQL et les violations de données sensibles.

Sécurité et Gestion des Erreurs :

Le code met en œuvre des pratiques de sécurité standards, comme l'utilisation de requêtes préparées via PDO pour prévenir les injections SQL. De plus, l'exception est capturée et gérée de manière à arrêter l'exécution en cas de problème de connexion à la base de données, ce qui contribue à la résilience de l'application.


Points Forts:

Séparation des Préoccupations : La classe connexionDB est bien conçue pour encapsuler toute la logique de connexion à la base de données, ce qui améliore la lisibilité et la réutilisabilité du code.

Sécurité : L'utilisation de PDO avec des requêtes préparées et le hachage des mots de passe sont des atouts majeurs pour la sécurité de l'application.

Modularité : Le code est facilement extensible grâce à la structure en MVC, ce qui permet d'ajouter de nouvelles fonctionnalités ou de modifier les existantes sans affecter les autres parties du système.

