<?php
session_start();
require_once '../../config/connexionDB.php';
require_once '../../controller/OrderController.php';

// Verifica si el usuario es un administrador
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$db = connexionDB::getConnection();
$orderController = new OrderController($db);
$orders = $orderController->getAllOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Orders</title>
	<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            background-color: #007BFF;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .action-btn {
            border: none;
            background: none;
            color: #FF0000;
            cursor: pointer;
            font-weight: bold;
        }

        a.back-to-dashboard {
            display: block;
            width: 20%;
            margin: 20px auto;
            background-color: chocolate;
            color: white;
            padding: 10px;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            font-weight: bold;
        }

        a.back-to-dashboard:hover {
            background-color: #D2691E;
        }
    </style>
</head>
<body>
    <h1>Order List</h1>
	<a href="./dashboard.php" class="back-to-dashboard">Return to Dashboard</a>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Reference</th>
                <th>Date</th>
                <th>Total</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['ref']) ?></td>
                    <td><?= htmlspecialchars($order['date']) ?></td>
                    <td>$<?= number_format($order['total'], 2) ?></td>
                    <td><?= htmlspecialchars($order['user_name']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
