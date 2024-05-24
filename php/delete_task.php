<?php
include "db_config.php";  // Includes your database connection settings

// Check if the form's submit button is clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_name'])) {
    $task_name = $_POST['task_name'];

    // Prepare the DELETE statement
    $sql = "DELETE FROM tasks WHERE task_name = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters and execute query
        $stmt->bind_param("s", $task_name);
        if ($stmt->execute()) {
            echo "Task deleted successfully.";
            header("Location: ../tasklist.php");
            exit();
        } else {
            echo "Failed to delete task. Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Failed to prepare statement. Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect user back if the page is accessed without posting form
    header("Location: ../tasklist.php");
    exit();
}
?>
