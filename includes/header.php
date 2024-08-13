<?php
$host = 'localhost';
$dbname = 'petshop';
$user = 'root';
$pass = '';

// Tentative de connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("problème: " . $e->getMessage());
}

// Vérification si l'utilisateur est connecté
$loggedIn = isset($_SESSION['user_id']);
$isAdmin = false;

// Si l'utilisateur est connecté, vérifie si c'est un admin
if ($loggedIn) {
    $userId = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT role_id FROM user WHERE id = ?");
    $stmt->execute([$userId]);
    $roleId = $stmt->fetchColumn();
    if ($roleId == 1) {
        $isAdmin = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre site web</title>
    <link rel="stylesheet" href="../public/css/cursor.css">
    <style>
        /* Style de base pour le corps de la page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f4f4f4;
        }

        /* Style de l'en-tête */
        header {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Style de la navigation */
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 16px;
        }

        nav ul li a:hover {
            color: #ff9900;
        }

        /* Style du logo */
        #logo img {
            max-width: 80px;
            height: auto;
            border-radius: 50px;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <ul style="display: flex; align-items: center;">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="view/auth/register.php">S'inscrire</a></li>
                <?php if ($loggedIn) : ?>
                    <li><a href="view/auth/profile.php">Profil</a></li>
                    <li><a href="view/order/view_cart.php">Panier</a></li>
                    <?php if ($isAdmin) : ?>
                        <li><a href="view/admin/dashboard.php">Tableau de bord</a></li>
                    <?php endif; ?>
                    <li>
                        <form action="index.php" method="post" style="display: flex; flex-direction: column; ">
                            <input type="hidden" name="logout" value="logout">
                            <button type="submit" style="background-color: red; font-weight: bold;">Se déconnecter</button>
                        </form>
                    </li>
                <?php else : ?>
                    <li><a href="view/auth/login.php">Se connecter</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div id="logo">
            <a href="index.php">
                <img src="public/images/logo.png" alt="Logo">
            </a>
        </div>
    </header>
</body>

</html>