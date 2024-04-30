<?php
session_start();

// Уничтожаем все данные сеанса
session_destroy();

// Перенаправляем пользователя обратно на текущую страницу
header("Location: " . $_SERVER['HTTP_REFERER']);
?>
