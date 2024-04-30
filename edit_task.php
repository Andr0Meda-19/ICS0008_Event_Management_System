<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Edit Task</title>
</head>
<body>
    <header>
        <div class="navigation">
            <div class="navigation-content">
                <img src="./svgs/logo_svg-01.svg" alt="logo">
            </div>
        </div>
        <div class="navigation-links">
            <nav>
                <a href="index.html">Home</a>
                <a href="about.html">About</a>
                <?php
                session_start();
                if(isset($_SESSION['user_id'])) {
                    echo '<a href="logout.php">Log out</a>';
                } else {
                    echo '<a href="login.php">Log in</a>';
                }
                ?>
                <a href="tasklist.php">Task List</a>
            </nav>
        </div>
    </header>
    <h2>Edit Task</h2>

    <?php
    include 'db_config.php';

    // Check if task_name is set and fetch the task details
    if(isset($_POST['task_name'])) {
        $task_name = $_POST['task_name'];
        $query = "SELECT * FROM tasks WHERE task_name = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $task_name);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
    }

    ?>
    <form action="edit_task.php" method="POST">
        <label>Task Name</label>
        <input type="text" name="task_name" value="<?php echo htmlspecialchars($row['task_name']); ?>">
        <label>Description</label>
        <textarea name="task_description"><?php echo htmlspecialchars($row['task_description']); ?></textarea>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    // Check if form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];

        // Update the task details in the database
        $query = "UPDATE tasks SET task_description = ? WHERE task_name = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $task_description, $task_name);
        mysqli_stmt_execute($stmt);
        header("Location: tasklist.php");
    }
    ?>
</body>
</html>
