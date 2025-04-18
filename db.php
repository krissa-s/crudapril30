<?php
$conn = new mysqli("localhost", "root", "", "studentenrollmentsystem");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
