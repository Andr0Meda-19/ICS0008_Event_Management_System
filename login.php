<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start(); // Start session to store user login status

require_once('php/db_config.php'); // Include the database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the form was submitted via POST
    $email = $_POST['email']; // Get email from form
    $password = $_POST['password']; // Get password from form

    // Prepare SQL statement to select user data based on email
    $sql = "SELECT id, email, password_hash FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) { // If the statement was prepared successfully
        $stmt->bind_param("s", $email); // Bind email parameter
        $stmt->execute(); // Execute the query
        $stmt->store_result(); // Store the result

        if ($stmt->num_rows == 1) { // If a user with the provided email exists
            $stmt->bind_result($id, $email, $password_hash); // Bind result variables
            $stmt->fetch(); // Fetch the result

            if (password_verify($password, $password_hash)) { // Verify password
                // Password is correct, store user ID in session
                $_SESSION['user_id'] = $id;
                // Redirect user to dashboard or any other authenticated page
                header("Location: index.php");
                exit;
            } else {
                // Password is incorrect, display error message
                $login_error = "Incorrect email or password";
            }
        } else {
            // User with the provided email does not exist, display error message
            $login_error = "Incorrect email or password";
        }
        $stmt->close(); // Close the statement
    } else {
        // If there was an error preparing the query, display error message
        $login_error = "Database error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Sign Up form</title>
    <link rel="stylesheet" href="./styles/signup-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="wrapper">
        <img src="./svgs/logo_svg-01.svg" alt="logo">
        <h1>Login</h1>
        <?php if(isset($login_error)) echo "<p>$login_error</p>"; ?>
        <form action="login.php" method="POST">
            <input type="text" id="email" name="email" placeholder="Email">
            <input type="password" id="password" name="password" placeholder="Password">
            <button>Log in</button>
        </form>
        <div class="member">
            <p>Not a member? <a href="./signup.html">Register Now</a></p>
        </div>
    </div>
</body>
</html>
