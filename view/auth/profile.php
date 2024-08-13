<?php
// Include the database configuration file
require_once('../../config/connexionDB.php');

// Assuming that user information is stored in a session after login
session_start();

// Redirect to the login page if the user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Initialize the database connection
$db = connexionDB::getConnection();

// Get user information from the database using PDO
$stmt = $db->prepare("SELECT * FROM `user` WHERE `id` = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Disconnect from the database
connexionDB::disconnect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
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
            padding-top: 40px;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        a:last-child {
            padding-bottom: 30px;
        }

        a:hover {
            text-decoration: underline;
        }

        img {
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .error {
            color: red;
        }

        button {
            background: none!important;
            border: none;
            font-size: 20px;
            padding: 0!important;
            font-family: arial, sans-serif;
            color: red;
            /* text-decoration: underline; */
            cursor: pointer;
        }

    </style>

</head>

<body>
    <h2>User Profile</h2>
    <form action="../../index.php" method="post" enctype="multipart/form-data">
        <!-- Display user information and add form fields based on your database structure -->
        <img src="../../public/images/avatar.jpg" alt="Default Profile Picture" width="100">
        <br>
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" readonly>
        <br>
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" readonly>
        <br>
        <label for="fname">First Name:</label>
        <input type="text" name="fname" value="<?php echo $user['fname']; ?>">
        <br>
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" value="<?php echo $user['lname']; ?>">
        <br>
        <input type="hidden" name="update_profile" value="update_profile">
        <input type="submit" value="Save">
    </form>
    <br>
    <form action="../../index.php" method="post">
        <input type="hidden" name="logout" value="logout">
        <button type="submit">Log out</button>
    </form>
    <br>
    <a href="../../index.php">Home</a>
</body>

</html>
