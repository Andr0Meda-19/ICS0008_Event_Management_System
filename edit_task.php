<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <a href="#">Task List</a>
            </nav>
        </div>
    </header>
    <h2>Edit Task</h2>

    <?php
    include 'db_config.php';

    if(isset($_POST['task_name'])) {
        $task_name = $_POST['task_name'];
        $query = 'SELECT * FROM tasks WHERE task_name = $task_name';
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
    }

    ?>
    <form action="edit_task.php?id=<?php echo $task_name; ?>" method="POST">
        <label>Task Name</label>
        <input type="text" name="task_name" value="<?php echo $row['task_name'];?>">
        <label>Description</label>
        <textare name="task_description"><?php echo $row['task_description'];?></textarea>
        <input type="submit" name="submit" value="Submit">
    </form>

    <?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $task_name = $_POST['task_name'];
        $task_description = $_POST['task_description'];

        $query = "UPDATE tasks SET task_name = '$task_name', task_description = '$task_description' WHERE task_name = '$task_name'";
        mysqli_query($conn, $query);
        header("Location: tasklist.php");
    }
    ?>
</body>
</html>