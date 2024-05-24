<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // User is not authenticated, redirect to the login page
    header("Location: ../login.php");
    exit();
}

// Connect to the database
require_once 'db_config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$task_name = $_POST['task_name'];
$user_id = $_SESSION['user_id'];
$task_description = $_POST['task_description'];

try {
    // Prepare SQL query
    $sql = "INSERT INTO tasks (user_id, task_name, task_description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("iss", $user_id, $task_name, $task_description);
        if ($stmt->execute()) {
            echo "Task added successfully";
            header("Location: ../tasklist.php");
            exit();
        } else {
            echo "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        throw new Exception("Error preparing query: " . $conn->error);
    }
} catch (mysqli_sql_exception $e) {
    echo "Database error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

mysqli_close($conn);
?>
