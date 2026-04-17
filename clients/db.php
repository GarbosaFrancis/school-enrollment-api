<?php
$conn = new mysqli("localhost", "root", "", "school_app_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>