<?php
include "db_config.php";  // Includes your database connection settings

// Check if the form's submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_name'])) {
    // Clean the data received from the form to avoid SQL Injection
    $task_name = mysqli_real_escape_string($conn, $_POST['task_name']);

    // Prepare the DELETE statement
    $stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE task_name = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $task_name);
        $execute = mysqli_stmt_execute($stmt);
        if ($execute) {
            echo "Task deleted successfully.";
        } else {
            echo "Failed to delete task. Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare statement. Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Redirect user back if the page is accessed without posting form
    header("Location: ../tasklist.php");
    exit();
}
?>
