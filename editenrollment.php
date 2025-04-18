<?php
// Include DB connection
include 'db.php';

// Initialize enrollment array
$enrollment = [];

// Step 1: Get enrollment data from DB using ID from URL
if (isset($_GET['id'])) {
    $original_id = $_GET['id'];

    $query = "SELECT * FROM enrollment WHERE enrollment_id = $original_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $enrollment = mysqli_fetch_assoc($result);
    } else {
        echo "Enrollment not found.";
        exit;
    }
} else {
    echo "No Enrollment ID provided.";
    exit;
}

// Step 2: Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_id = $_POST['enrollment_id'];
    $enrollment_date = $_POST['enrollment_date'];
    $stud_id = $_POST['stud_id'];
    $course_id = $_POST['course_id'];

    $updateQuery = "UPDATE enrollment SET 
        enrollment_id = '$new_id',
        enrollment_date = '$enrollment_date',
        stud_id = '$stud_id',
        course_id = '$course_id'
        WHERE enrollment_id = $original_id"; // <-- removed the extra comma before WHERE

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Enrollment updated successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating enrollment: " . mysqli_error($conn);
    }
}
?>

<!-- Step 3: HTML FORM -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Enrollment</title>
    <link rel="stylesheet" href="editenrollment.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Enrollment</h2>
        <form action="editenrollment.php?id=<?php echo $enrollment['enrollment_id']; ?>" method="post">
            <input type="text" name="enrollment_id" placeholder="Enrollment ID" value="<?php echo $enrollment['enrollment_id']; ?>" required>

            <input type="text" name="enrollment_date" placeholder="Enrollment Date" value="<?php echo $enrollment['enrollment_date']; ?>" required>
            <input type="text" name="stud_id" placeholder="Student ID" value="<?php echo $enrollment['stud_id']; ?>" required>
            <input type="text" name="course_id" placeholder="Course ID" value="<?php echo $enrollment['course_id']; ?>" required>

            <button type="submit">Update Enrollment</button>
        </form>
    </div>
</body>
</html>
