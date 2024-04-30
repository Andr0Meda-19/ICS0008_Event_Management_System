<?php
include "db_config.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$task_name = 'Sample Task'; // Hardcoded for testing

$stmt = mysqli_prepare($conn, "DELETE FROM tasks WHERE task_name = ?");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $task_name);
    $execute = mysqli_stmt_execute($stmt);
    if ($execute) {
        echo "Task deleted successfully.";
    } else {
        echo "Failed to delete task.";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Failed to prepare statement.";
}
?>
