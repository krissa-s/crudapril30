<?php
// Include DB connection
include 'db.php';

// Initialize student array
$student = [];

// Step 1: Get student data from DB using ID from URL
if (isset($_GET['id'])) {
    $original_id = $_GET['id'];

    $query = "SELECT * FROM course WHERE course_id = $original_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);
    } else {
        echo "Course not found.";
        exit;
    }
} else {
    echo "No Course ID provided.";
    exit;
}

// Step 2: Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_id = $_POST['course_id'];
    $course_code = $_POST['course_code'];
    $course_desc = $_POST['course_desc'];
    $units = $_POST['units'];

    $updateQuery = "UPDATE course SET 
        course_id = '$new_id',
        course_code = '$course_code',
        course_desc = '$course_desc',
        units  = '$units'
        WHERE course_id = $original_id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Course updated successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating course: " . mysqli_error($conn);
    }
}
?>

<!-- Step 3: HTML FORM -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="editcourse.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Course</h2>
        <form action="editcourse.php?id=<?php echo $course['course_id']; ?>" method="post">
            <input type="text" name="course_id" placeholder="Course ID" value="<?php echo $course['course_id']; ?>" required>

            <input type="text" name="course_code" placeholder="Course Code" value="<?php echo $course['course_code']; ?>" required>
            <input type="text" name="course_desc" placeholder="Course Description" value="<?php echo $course['course_desc']; ?>" required>
            <input type="text" name="units" placeholder="Units" value="<?php echo $course['units']; ?>" required>

            <button type="submit">Update Course</button>
        </form>
    </div>
</body>
</html>
