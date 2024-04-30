<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Пользователь не авторизован, перенаправляем его на страницу входа
    header("Location: ./login.php");
    exit();
}

// Подключение к базе данных
require_once 'db_config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$task_name = $_POST['task_name'];
$user_id = $_SESSION['user_id'];
$task_description = $_POST['task_description'];

// Защита от SQL-инъекций (можно улучшить, в зависимости от используемой библиотеки)
$task_description = mysqli_real_escape_string($conn, $task_description);

$sql = "INSERT INTO tasks (user_id, task_name, task_description) VALUES ('$user_id', '$task_name', '$task_description')";

if (mysqli_query($conn, $sql)) {
    echo "Task added successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
