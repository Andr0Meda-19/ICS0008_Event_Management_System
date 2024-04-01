<?php
function registerUser($username, $email, $password){

    $filename = "../data/users.csv";
    $handle = fopen($filename, 'w');
    $data = array($username, $email, $password);

    if(fputcsv($handle, $data, ";")){
        return true;
    } else return false;

    fclose($handle);
}


if(isset($_POST['button']) and $_POST['button'] == "Submit") {

    $errors = array();

    if (isset($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address';
    }

    if (isset($_POST['username'])) {
        if ($_POST['username'] === '') {
            $errors[] = 'Username should be filled';
        } else if (!preg_match("/^[a-z0-9_-]{3,15}$/u", $_POST['username'])) {
            $erroes[] = 'Username must be form 3 to 15 symbols and must contain only letters or digits or both';
        }
    }

    if (isset($_POST['password'])) {
        if ($_POST['password'] === '') {
            $errors[] = 'Password should be filled';
        } else if (!preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $_POST['password'])) {
            $errors[] = 'Password must meet the following requirements';
            //    Has minimum 8 characters in length.
            //    At least one uppercase English letter.
            //    At least one lowercase English letter.
            //    At least one digit.
            //    At least one special character.
        }
    }

    if (isset($_POST['repassword'])) {
        if ($_POST['repassword'] === $_POST['password']) {
            $password = $_POST('repassword');
        } else if ($_POST['repassword'] != $_POST['password']) {
            $errors[] = 'Passwords are not equal';
        }
    }

    if (empty($errors)) {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (registerUser($username, $email, $password)) {
            echo "User registered successfully!";
            echo "<meta http-equiv="refresh" content="2;url=/forms/login.html">";
        } else {
            echo "User not registered!";
            echo "<meta http-equiv="refresh" content="2;url=../forms/register.html">";
        }
    }
}


?>
