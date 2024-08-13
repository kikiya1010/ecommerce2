<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Style for the unordered list */
        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        /* Style for list items */
        li {
            margin: 10px 0;
        }

        /* Style for links */
        a {
            display: block;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        button {
            display: block;
            width: 200px;
            height: 50px;
            font-size: 22px;
            padding: 10px;
            font-weight: bold;
            background-color: #007BFF;
            border: none;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #0056b3;
        }

        button:hover{
            background-color: red;
        }
    </style>

</head>

<body>
    <h2>Welcome to the Admin Dashboard</h2>

    <ul>
        <li><a href="../../index.php">Home</a></li>
        <li><a href="add_product.php">Add Product</a></li>
        <li><a href="./user_list.php">User List</a></li>
        <!-- <li><a href="./show_product.php">Product List</a></li> -->
        <li><a href="show_orders.php">Order List</a></li>
        <form action="../../index.php" method="post">
            <input type="hidden" name="logout" value="logout">
            <button type="submit">Log out</button>
        </form>
    </ul>

</body>

</html>
