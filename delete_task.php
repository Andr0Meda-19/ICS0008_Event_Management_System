<?php
include "db_config.php";

// Check if the task_name is posted
if(isset($_POST['task_name'])) {
    $task_name = $_POST['task_name']; // Corrected variable access

    // Prepare a statement to prevent SQL injection
    $stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE task_name = ?");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $task_name); // Bind the task_name parameter as string
        mysqli_stmt_execute($stmt); // Execute the prepared statement
        mysqli_stmt_close($stmt); // Close the statement
    }

    // Redirect to task list page
    header("Location: tasklist.php");
    exit();
}
?>
