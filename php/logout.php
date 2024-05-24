<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect the user back to the current page
header("Location: " . $_SERVER['HTTP_REFERER']);
?>
