<?php
include 'db.php';
$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM student WHERE stud_id=?");
$stmt->bind_param("s", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
?>
