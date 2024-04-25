<?php

$host = "anysql.itcollege.ee";
$dbname = "ICS0008_25";
$username = "ICS0008_WT_25";
$password = "8b15d3f168f2";

$conn = new mysqli(hostname: $host, 
                   username: $username, 
                   password: $password, 
                   database: $dbname);

if ($conn->connect_errno) {
    die("Failed to connect to MySQL: " . $conn->connect_error);
}

return $conn;