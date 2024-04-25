<?php
require_once('db_config.php');

$errors = [];
if(empty($_POST["username"])){
    $errors[] = "Please enter a username";
}

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    $errors[] = "Please enter a valid email address";
}

if(strlen($_POST["password"]) < 8){
    $errors[] = "Password must be at least 8 characters";
}

if(!preg_match("/[A-Z]/", $_POST["password"])){
    $errors[] = "Password must contain at least one uppercase letter";
}

if(!preg_match("/[0-9]/", $_POST["password"])){
    $errors[] = "Password must contain at least one number";
}

if($_POST["password"]!= $_POST["confirmPassword"]){
    $errors[] = "Passwords do not match";
}

if(empty($_POST["checkbox"])){
    $errors[] = "You must agree to the terms and conditions";
}

if(empty($errors)){
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name, email, password_hash)
            VALUES (?, ?, ?)";
        
    $stmt = $conn->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("sss",
                      $_POST["name"],
                      $_POST["email"],
                      $password_hash);
                  
    if ($stmt->execute()) {

        header("Location: signup-success.html");
        exit;
    
    } else {
    
        if ($conn->errno === 1062) {
            die("email already taken");
        } else {
            die($conn->error . " " . $conn->errno);
        }
    }
} else {
    echo print_r($errors, true);
}