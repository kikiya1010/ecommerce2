<?php

session_start();

require_once __DIR__ . '/../../controller/ProductController.php';
require_once __DIR__ . '/../../config/connexionDB.php';

$db = connexionDB::getConnection();

$controller = new ProductController($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = $controller->addProduct($_POST['name'], $_POST['quantity'], $_POST['price'], $_POST['description'], $_FILES['image']);

    if ($result === true) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo $result;
    }
} else {
    // echo "Access not allowed.";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        /* Style for links */
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
</body>

</html>

<h2>Add Product</h2>
<form action="add_product.php" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" required><br>

    <label for="quantity">Quantity:</label>
    <input type="number" name="quantity" required><br>

    <label for="price">Price:</label>
    <input type="text" name="price" required><br>

    <label for="image">Product Image (JPG only):</label>
    <input type="file" name="image" accept=".jpg" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>

    <input type="submit" value="Add Product">

    <a href="./dashboard.php">Dashboard</a>
</form>
