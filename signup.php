<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('./php/db_config.php'); // Include the database configuration file

$errors = []; // Initialize an array to store validation errors

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Check if the form was submitted via POST
    // Validation checks for username, email, password, etc.
    if(empty($_POST["username"])){
        $errors[] = "- Please enter a username";
    }

    if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
        $errors[] = "- Please enter a valid email address";
    }

    if(strlen($_POST["password"]) < 8){
        $errors[] = "- Password must be at least 8 characters";
    }

    if(!preg_match("/[A-Z]/", $_POST["password"])){
        $errors[] = "- Password must contain at least one uppercase letter";
    }

    if(!preg_match("/[0-9]/", $_POST["password"])){
        $errors[] = "- Password must contain at least one number";
    }

    if($_POST["password"] != $_POST["confirmPassword"]){
        $errors[] = "- Passwords do not match";
    }

    if(empty($_POST["checkbox"])){
        $errors[] = "- You must agree to the terms and conditions";
    }

    if(empty($errors)) { // If there are no validation errors
        $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password

        // Prepare SQL statement to insert user data into the database
        $sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        try { // Begin try-catch block for error handling
            if ($stmt) { // If the statement was prepared successfully
                // Bind parameters and execute the query
                $stmt->bind_param("sss", $_POST["username"], $_POST["email"], $password_hash);
                if ($stmt->execute()) { // If the query was executed successfully
                    header("Location: login.php"); // Redirect to signup success page
                    exit;
                } else {
                    // If there was an error executing the query, display error message
                    die("Error executing query: " . $stmt->error);
                }
                $stmt->close(); // Close the statement
            } else {
                // If there was an error preparing the query, throw an exception
                throw new Exception("Error preparing query: " . $conn->error);
            }
        } catch (mysqli_sql_exception $e) { // Catch specific MySQLi exceptions
            if ($e->getCode() === 1062) { // If the error code indicates a duplicate entry
                $errors[] = "- This email is already registered. Please use another email.";
            } else {
                echo "Database error: " . $e->getMessage(); // Display general database error
            }
        } catch (Exception $e) { // Catch general exceptions
            echo "Error: " . $e->getMessage(); // Display general error
        }
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
    <script src="scripts/signup-validation.js" defer></script>
</head>
<body>
    <div class="wrapper">

        <img src="./svgs/logo_svg-01.svg" class="logo" alt="logo">

        <h1>Sign Up</h1>

        <form action="signup.php" method="post" class="form">

            <div class="signup-form">
                <input type="email" id="email" name="email" placeholder="Email">
                <input type="text" id="username" name="username" placeholder="Username">
                <input type="password" id="password" name="password" placeholder="Password">
                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-Enter Password">
            </div>
        
            <div class="terms">
                <input type="checkbox" id="checkbox" name="checkbox">
                <label for="checkbox">I agree to these <a href="terms.html" target="_blank">Terms &amp; Conditions</a></label>
            </div>

            <button class="submit" name="button" style="margin: 25px">Sign Up</button>

            <div>
            <?php
            if (isset($_POST['button'])) {
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if(!empty($errors)) { // If there are validation errors, display them
                        foreach ($errors as $error) {
                            echo $error . "<br>";
                        }
                    }   
                }
            }
            ?>
            </div>
            
        </form>

        <div class="member">
            <p>Already a member? <a href="login.php">Login Here</a></p>
        </div>

    </div>
    <script src="scripts/navigation.js"></script>
</body>
</html>
