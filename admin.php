<?php
session_start(); // Start the session to track the logged-in user

// Database connection
$connection = new mysqli("localhost", "root", "", "photography_website");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch username and password entered by the user
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to fetch admin details by username
    $query = "SELECT * FROM admin WHERE username = '$username'";  // Use username to identify admin
    $result = $connection->query($query);

    // Check if the username exists in the database
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password (for now using plain-text, not recommended for production)
        if ($password == $row['password']) { // Direct password check for plain text password
            // Successful login, store session data
            $_SESSION['admin'] = true;
            $_SESSION['username'] = $row['username'];  // Store username in session

            // Redirect to the admin dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Incorrect password
            $error_message = "Incorrect password!";
        }
    } else {
        // Username not found
        $error_message = "Username not found!";
    }

    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Malcolm Lismore Photography</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        td {
            padding: 10px;
        }
        .error-message {
            color: red;
            text-align: center;
        }
        .login-container input[type="text"], .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #005f73;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0a9396;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Admin Login</h1>

        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>

        <form method="POST">
            <table align="center">
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" id="username" name="username" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" id="password" name="password" required></td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <button type="submit">Login</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

</body>
</html>

