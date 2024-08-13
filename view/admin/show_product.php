<?php
require_once __DIR__ . '/../../controller/ProductController.php';
require_once __DIR__ . '/../../config/connexionDB.php';

$db = connexionDB::getConnection();
$productController = new ProductController($db);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
	$productController->deleteProduct($_POST['product_id']);
	header("Location: show_product.php");
	exit();
}

$products = $productController->listProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Manage Products</title>
	<link rel="stylesheet" href="../../public/css/cursor.css">
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color: #f4f4f4;
			margin: 0;
			padding: 0;
		}

		h2 {
			background-color: #007BFF;
			color: #fff;
			padding: 10px;
			text-align: center;
		}

		table {
			width: 80%;
			margin: 20px auto;
			border-collapse: collapse;
			background-color: #fff;
		}

		th,
		td {
			padding: 12px;
			text-align: left;
			border-bottom: 1px solid #ddd;
		}

		th {
			background-color: #007BFF;
			color: #fff;
		}

		tr:hover {
			background-color: #f5f5f5;
		}

		.delete-btn {
			color: #FF0000;
			border: none;
			background: none;
			cursor: pointer;
		}

		a {
			background-color: chocolate;
			color: #FFF;
			padding: 20px;
			text-decoration: none;
			text-align: center;
			font-weight: bold;
			display: block;
			margin: 20px auto;
			width: 20%;
			text-align: center;
		}
	</style>
</head>

<body>
	<h2>Product List</h2>
	<a href="./dashboard.php">Return to Dashboard</a>
	<table>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Description</th>
			<th>Action</th>
		</tr>
		<?php foreach ($products as $product) : ?>
			<tr>
				<td><?= htmlspecialchars($product['id']) ?></td>
				<td><?= htmlspecialchars($product['name']) ?></td>
				<td><?= htmlspecialchars($product['price']) ?></td>
				<td><?= htmlspecialchars($product['quantity']) ?></td>
				<td><?= htmlspecialchars($product['description']) ?></td>
				<td>
					<form action="show_product.php" method="POST">
						<input type="hidden" name="product_id" value="<?= $product['id'] ?>">
						<button type="submit" class="delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</body>

</html>