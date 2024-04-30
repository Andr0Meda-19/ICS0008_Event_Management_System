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
                // Redirect user to login page if they are not logged in
                if (!isset($_SESSION['user_id'])) {
                    header("Location: login.php");
                    exit(); // Ensure no further execution if not logged in
                }
                echo '<a href="logout.php">Log out</a>';
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
        // Connect to the database
        include 'db_config.php';
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
            <form action='delete_task.php' method='post' style='display: inline-block;' onsubmit=\"return confirm('Are you sure you want to delete this task?');\">
                <input type='hidden' name='task_id' value='" . htmlspecialchars($row['id']) . "'>
                <button type='submit' style='background:none; border:none; color:blue; text-decoration: underline; cursor:pointer;'>Delete</button>
            </form>
            <a href='edit_task.php?id=" . urlencode($row['id']) . "'>Edit</a>
          </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
