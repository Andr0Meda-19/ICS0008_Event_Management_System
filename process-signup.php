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
    $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $_POST["username"], $_POST["email"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0){
        $errors[] = "Username or email already exists";
    }

    mysqli_stmt_close($stmt);
    mysqli_free_result($result);
}

if(empty($errors)){
    $passwordhash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $_POST["username"], $_POST["email"], $passwordhash);
    if (mysqli_stmt_execute($stmt)) {
        die ("You have successfully registered. You may now log in.");
    } else {
        mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}