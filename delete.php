<?php
include "db_config.php";

if(isset($_POST['task_name'])) {
    $task_name = $_POST['$task_name'];
    $query = "DELETE FROM tasks WHERE task_name = $task_name";
    mysqli_query($conn, $query);
    header("Location: tasklist.php");
    exit();
}
?>