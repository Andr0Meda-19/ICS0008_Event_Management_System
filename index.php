<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Event Listings</title>
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
            </nav>
        </div>
    </header>
    
    
    <div class="search-container">
        <h1>Upcoming Events</h1>
        <br>
        <label for="date">Date:</label>
        <input type="text" id="date" placeholder="Enter date">

        <label for="location">Location:</label>
        <input type="text" id="location" placeholder="Enter location">

        <label for="category">Category:</label>
        <select id="category">
            <option value="">All</option>
            <option value="music">Music</option>
            <option value="sports">Sports</option>
        </select>

        <button>Search</button>
    </div>
    <div class="add-task-container">
    <h2>Add Task</h2>
    <form action="add_task.php" method="POST">
        <textarea name="task_description" placeholder="Enter task description"></textarea>
        <button type="submit">Add Task</button>
    </form>
    </div>

</body>
</html>
