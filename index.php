<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Add task</title>
</head>
<body>
    <header>
        <nav>
            <img src="./svgs/logo_svg-01.svg" class="logo" alt="logo">
        
            <ul class="navbar">
                <li><a href="index.php">Add Task</a></li>
                <li><a href="tasklist.php">Task List</a></li>
                <li><a href="about.html">About Us</a></li>
            </ul>
            <div class="main">
                <?php
                    session_start();
                    if(isset($_SESSION['user_id'])) {
                        echo '<a href="php/logout.php" class="user"><i class="ri-user-fill"></i>Log Out</a>';
                    } else {
                        echo '<a href="login.php" class="user"><i class="ri-user-fill"></i>Sign In</a>';
                    }
                ?>
                <!-- <a href="login.php" class="user"><i class="ri-user-fill"></i>Sign in</a> -->
                <div class="bx bx-menu" id="menu-icon"></div>
            </div>
        </nav>
    </header>
    <h2>Add Task</h2>
    <div class="add-task-container">
        <form action="./php/add_task.php" id="add_task_form" method="POST">
            <label for="task_name">Task name:</label>
            <input type="text" id="task_name" name="task_name" required>
            <label for="task_description">Description:</label>
            <textarea id="task_description" name="task_description"></textarea>
            <button type="submit" id="submit_task">Add Task</button>
        </form>
    </div>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/navigation.js"></script>
</body>
</html>
