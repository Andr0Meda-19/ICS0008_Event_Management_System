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
    <div>
    <?php
        session_start();
        require_once 'db_config.php'; // Импорт файла с подключением к базе данных

        // Добавление новой задачи
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
            $task = $_POST['task'];
            $category = $_POST['category']; // предполагается, что пользователь выбирает категорию из выпадающего списка
            $user_id = $_SESSION['user_id'];

            $sql = "INSERT INTO tasks (user_id, task_description, category) VALUES ('$user_id', '$task', '$category')";

            if ($conn->query($sql) === TRUE) {
                echo "Задача успешно добавлена";
            } else {
                echo "Ошибка: " . $sql . "<br>" . $conn->error;
            }
        }

        // Получение и отображение списка задач пользователя с возможностью сортировки по категориям
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT tasks.*, users.username FROM tasks JOIN users ON tasks.user_id = users.id WHERE tasks.user_id='$user_id'";

        if (isset($_GET['category'])) {
            $category = $_GET['category'];
            $sql .= " AND tasks.category='$category'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<ul>";
            while($row = $result->fetch_assoc()) {
                echo "<li>" . $row["task_description"] . " - Категория: " . $row["category"] . " - Пользователь: " . $row["username"] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "У вас пока нет задач";
        }

        // Форма для добавления новой задачи
        ?>
        <form method="POST" action="">
            <input type="text" name="task" placeholder="Введите задачу" required>
            <select name="category">
                <option value="работа">Работа</option>
                <option value="учеба">Учеба</option>
                <option value="личное">Личное</option>
            </select>
            <button type="submit">Добавить задачу</button>
        </form>
    <?php
    ?>

    </div>
</body>
</html>
