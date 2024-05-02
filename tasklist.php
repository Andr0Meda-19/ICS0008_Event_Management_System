<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Task List</title>
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
                    // Redirect user to login page if they are not logged in
                    if (!isset($_SESSION['user_id'])) {
                        header("Location: login.php");
                        exit(); // Ensure no further execution if not logged in
                    }
                    echo '<a href="php/logout.php" class="user"><i class="ri-user-fill"></i>Log Out</a>';
                ?>
                <!-- <a href="login.php" class="user"><i class="ri-user-fill"></i>Sign in</a> -->
                <div class="bx bx-menu" id="menu-icon"></div>
            </div>

        </nav>
    </header>
    <table>
        <tr>
            <th>Task Name</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php
        // Connect to the database
        include 'php/db_config.php';
        $user_id = $_SESSION['user_id']; // Get the user's ID from the session

        // Query to fetch tasks for the logged-in user only
        $query = "SELECT * FROM tasks WHERE user_id = $user_id";
        $result = mysqli_query($conn, $query);

        // Display each task in a table row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['task_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['task_description']) . "</td>";
            echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
            // Add edit and delete links with task id as a parameter
                echo "<td>
            <form action='php/delete_task.php' method='post' style='display: inline-block;' onsubmit=\"return confirm('Are you sure you want to delete this task?');\"><input type='hidden' name='task_name' value='" . htmlspecialchars($row['task_name']) . "'><button type='submit' style='background:none; border:none; color:red; text-decoration: underline; cursor:pointer;'>Delete</button></form>
          </td>";
            echo "</tr>";
        }
        ?>
    </table>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/navigation.js"></script>
</body>
</html>
