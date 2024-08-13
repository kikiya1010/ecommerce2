<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

require_once './config/connexionDB.php';
require_once './controller/RegisterController.php';
require_once './controller/UserController.php';
require_once './controller/LoginController.php';
require_once './controller/LogoutController.php';


$db = connexionDB::getConnection();

// Inicia los controladores
$registerController = new RegisterController($db);
$userController = new UserController($db);
$loginController = new LoginController($db);
$logoutController = new LogoutController();

// // Llamar metodo
// $userController->listUsers();

// Maneja la acción dependiendo del tipo de solicitud y de los parámetros POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_to_cart'])) {
        // Get product details and add to the cart
        $productId = $_POST['product_id'];
        $productName = $_POST['product_name'];
        $productPrice = $_POST['product_price'];

        // Check if the product is already in the cart
        $productInCart = false;
        foreach ($_SESSION['cart'] as &$cartItem) {
            if ($cartItem['id'] === $productId) {
                $cartItem['quantity'] += 1; // Increment the quantity
                $productInCart = true;
                break;
            }
        }
        unset($cartItem); // Release the explicit reference

        // If the product is not in the cart, add it
        if (!$productInCart) {
            $_SESSION['cart'][] = [
                'id' => $productId,
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => 1,
            ];
        }

        echo '<script>alert("Item has been added to the cart!");</script>';
    } elseif (isset($_POST['action']) && $_POST['action'] === 'register') {
        $userDetails = [
            'user_name' => $_POST['user_name'],
            'email' => $_POST['email'],
            'pwd' => $_POST['pwd'],
            'role_id' => 2,
        ];
    
        $registrationResult = $registerController->register($userDetails);
    
        if ($registrationResult === "Registration successful!") {
            $_SESSION['user_id'] = $userDetails['user_id'];
            $_SESSION['user_email'] = $userDetails['email'];
            $_SESSION['username'] = $userDetails['user_name'];
            $_SESSION['user_role_id'] = $userDetails['role_id'];
    
            header('Location: view/auth/login.php');
            exit;
        } else {
            $_SESSION['registration_error'] = $registrationResult;
            header('Location: view/auth/register.php');
            exit;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'login') {
        $username = $_POST['user_name'];
        $password = $_POST['pwd'];
    
        $result = $loginController->login($username, $password);
    
        if ($result['success']) {
            // Iniciar sesión del usuario
            $_SESSION['user_id'] = $result['user_id'];
            $_SESSION['username'] = $result['username'];
            $_SESSION['role_id'] = $result['role_id'];
    
            // Redirige según el role_id
            if ($result['role_id'] == 1) { // Suponiendo que 1 sea el role_id para administradores
                header('Location: view/admin/dashboard.php');
            } elseif ($result['role_id'] == 2) { // Suponiendo que 2 sea el role_id para clientes
                header('Location: view/auth/profile.php');
            }
            exit;
        } else {
            // Manejo de error de inicio de sesión
            echo '<script>alert("'. $result['message'] .'");</script>';
            // Redirigir al formulario de inicio de sesión o mostrar error
        }
    }
    elseif (isset($_POST['update_profile']) && $_POST['update_profile'] === 'update_profile') {
        // Asegúrate de que el usuario esté logueado
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            $fname = $_POST['fname'];
            $lname = $_POST['lname'];
    
            $result = $userController->updateUser($user_id, $fname, $lname);
    
            if ($result) {
                // Actualización exitosa
                header('Location: view/auth/profile.php?success=1');
                exit;
            } else {
                // Error al actualizar
                header('Location: view/auth/profile.php?error=1');
                exit;
            }
        } else {
            // Usuario no logueado, redirige al login
            header("Location: view/auth/login.php");
            exit;
        }
    } elseif (isset($_POST['logout']) && $_POST['logout'] === 'logout') {
        $logoutController->logout();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'list_users') {
        $userController->listUsers();
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MIAO</title>
    <link rel="stylesheet" href="./public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f8f9fa;
        }

        header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            list-style-type: none;
            padding: 0;
            margin: 0;
            background-color: #343a40;
        }

        nav a {
            text-decoration: none;
            color: white;
            padding: 10px;
        }

        main {
            max-width: 1200px;
            margin: 20px auto;
            padding-bottom: 30px;
        }

        .cat-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        .cat-item img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
            padding-top: 20px;
            border-radius: 20px;
        }

        .cat-item-details {
            padding: 10px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<main>
    <h1>Welcome to the Cat Shop</h1>

    <div class="cat-container">
        <?php
    
        $pdo = new PDO('mysql:host=localhost;dbname=petshop', 'root', '');

        $catImages = glob('public/img/*.jpg');

        foreach ($catImages as $catImage) {
        
            $catName = pathinfo($catImage, PATHINFO_FILENAME);

        
            $stmt = $pdo->prepare("SELECT description FROM product WHERE name = ?");
            $stmt->execute([$catName]);
            $description = $stmt->fetchColumn();

            ?>

            <div class="cat-item">
                <img src="<?= $catImage ?>" alt="<?= $catName ?>">
                <strong><p><?= $catName ?></p></strong>
                <p>Description: <br> <?= $description ?></p>

                <form method="post">
                    <input type="hidden" name="product_id" value="<?= $catName ?>">
                    <input type="hidden" name="product_name" value="<?= $catName ?>">
                    <input type="hidden" name="product_price" value="19.99">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</main>






<?php include 'includes/footer.php'; ?>

</body>
</html>
