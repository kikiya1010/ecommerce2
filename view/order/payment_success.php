<?php
session_start();

require_once __DIR__ . '/../../config/connexionDB.php';
require_once __DIR__ . '/../../controller/OrderController.php';

$db = connexionDB::getConnection();
$orderController = new OrderController($db);

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$userID = $_SESSION['user_id'];

$totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;

if ($totalPrice == 0) {
    echo "Error: No se encontró el total del precio. Por favor, revise su carrito.";
	header('Location: view_cart.php');
    exit;
}

$orderID = $orderController->createOrder($userID, $totalPrice);

if ($orderID) {
    $_SESSION['cart'] = [];
    header('Location: payment_success_message.php');
    exit;
} else {
    header('Location: view_cart.php');
	exit;
	// echo "Error al crear la orden. Intente nuevamente.";
}
?>