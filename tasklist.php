<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/tasklist-table.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <title>Event List</title>
</head>
<body>
    <header>
        <nav>
            <img src="./svgs/logo_svg-01.svg" class="logo" alt="logo">

            <ul class="navbar">
                <li><a href="index.php">Add Event</a></li>
                <li><a href="tasklist.php">Event List</a></li>
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
    <div class="table-wrapper">
        <table class="fixed-table">
            <thead>
                <tr>
                    <th class="tr1">Event Name</th>
                    <th class="tr2">Description</th>
                    <th class="tr3">Created At</th>
                    <th class="tr4">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connect to the database
                include 'php/db_config.php';
                $user_id = $_SESSION['user_id']; // Get the user's ID from the session
                // Query to fetch tasks for the logged-in user only
                $query = "SELECT * FROM tasks WHERE user_id = $user_id";
                $result = mysqli_query($conn, $query);
                // Display each task in a table row
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td class="tr1">' . htmlspecialchars($row['task_name']) . '</td>';
                    echo '<td class="tr2">' . htmlspecialchars($row['task_description']) . '</td>';
                    echo '<td class="tr3">' . htmlspecialchars($row['created_at']) . '</td>';
                    // Add edit and delete links with task id as a parameter
                    echo '<td class="tr4">
                    <form action="php/delete_task.php" method="post" onsubmit="return confirm(\'Are you sure you want to delete this task?\');">
                    <input type="hidden" name="task_name" value="' . htmlspecialchars($row['task_name']) . '">
                    <button type="submit"><i class="ri-close-large-line"></i></button></form>
                    </td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="scripts/navbar.js"></script>
    <script src="scripts/navigation.js"></script>
</body>
</html>
