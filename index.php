<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Home Page</title>
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
                <a href="index.php">Add Task</a>
                <a href="tasklist.php">Task List</a>
                <a href="about.html">About</a>
                <?php
                session_start();
                if(isset($_SESSION['user_id'])) {
                    echo '<a href="php/logout.php">Log out</a>';
                } else {
                    echo '<a href="login.php">Log in</a>';
                }
                ?>
            </nav>
        </div>
    </header>
    <div class="add-task-container">
    <h2>Add Task</h2>
    <form action="php/add_task.php" method="POST">
        <label>Task name:</label><br>
        <input type="text" name="task_name" required><br>
        <label>Description:</label><br>
        <textarea name="task_description"></textarea><br>
        <button type="submit">Add Task</button>
    </form>
    </div>
</body>
</html>
