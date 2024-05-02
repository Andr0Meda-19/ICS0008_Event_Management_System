<?php

$conn = require __DIR__ . "/db_config.php";

$sql = sprintf("SELECT * FROM user
                WHERE email = '%s'",
                $conn->real_escape_string($_GET["email"]));
                
$result = $conn->query($sql);

$is_available = $result->num_rows === 0;

header("Content-Type: application/json");

echo json_encode(["available" => $is_available]);

?>