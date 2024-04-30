<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Task List</title>
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
        <table>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
            <?php
            // Подключение к базе данных
            include 'db_config.php';

            $query = "SELECT * FROM tasks";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>". $row['task_name']. "</td>";
                echo "<td>". $row['task_description']. "</td>";
                echo "<td>". $row['created_at']. "</td>";
                echo "<td> <a href='edit_task.php?id={$row['id']}'>Edit</a>" | "<a href='delete_task.php?id={$row['id']}'>Delete</a></td>";
            }
            ?>
        </table>
</body>
</html>
