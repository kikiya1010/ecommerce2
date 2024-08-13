<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../../public/css/cursor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            align-items: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;        
        }

        h2 {
            color: #333;
            text-align: center;
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
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #3498db;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
            color: #2a78ad;
        }
    </style>
</head>

<body>
    <h2>Register</h2>
    <form action="../../index.php" method="post">
        <!-- Fields for the 'user' table -->
        <label for="user_name">Username:</label>
        <input type="text" name="user_name" required>
        <?php if (isset($_SESSION['errors']['user_name'])) echo "<p style='color:red'>{$_SESSION['errors']['user_name']}</p>"; ?>
        <br>

        <label for="email">Email:</label>
        <input type="email" name="email" required>
        <?php if (isset($_SESSION['errors']['email'])) echo "<p style='color:red'>{$_SESSION['errors']['email']}</p>"; ?>
        <br>

        <label for="pwd">Password:</label>
        <input type="password" name="pwd" required>
        <?php if (isset($_SESSION['errors']['pwd'])) echo "<p style='color:red'>{$_SESSION['errors']['pwd']}</p>"; ?>
        <br>

        <input type="hidden" name="action" value="register">
        <input type="submit" value="Register">
        <a href="../../index.php">Home</a>

        <?php if (isset($_SESSION['registration_error'])): ?>
            <p style="color:red;"><?php echo $_SESSION['registration_error']; unset($_SESSION['registration_error']); ?></p>
        <?php endif; ?>

    </form>
</body>

</html>