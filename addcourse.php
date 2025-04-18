<?php
// Include the database connection file
include('db.php');

// Initialize message variable
$message = '';

// Check if the form is submitted
if (isset($_POST['add'])) {
    // Get the values from the form
    $course_id = $_POST['course_id'];  // Added student ID input
    $course_code = $_POST['course_code'];
    $course_desc = $_POST['course_desc']; // Fix the variable name to match the column
    $units = $_POST['units'];
    

    // Insert the student data into the database
    $query = "INSERT INTO course (course_id, course_code, course_desc, units) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $course_id, $course_code, $course_desc, $units); 

    if ($stmt->execute()) {
        // Success message
        $message = "Course added successfully!";
        // Redirect to the dashboard after a delay to see the message
        header("refresh:3;url=index.php"); // Redirect after 3 seconds
    } else {
        // Error message
        $message = "Error: " . $stmt->error;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <link rel="stylesheet" href="addcourse.css">
</head>
<body>
    <div class="form-container">
        <h2>Add Course</h2>

        <!-- Display message (success or error) -->
        <?php if ($message != ''): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="addcourse.php" method="post">
            <!-- Include student_id in the form -->
            <input type="text" name="course_id" placeholder="Course ID" required>
            <input type="text" name="course_code" placeholder="Course Code" required>
            <input type="text" name="course_desc" placeholder="Course Description" required>
            <input type="text" name="units" placeholder="Units" required>
            <button type="submit" name="add">Save Course</button>
        </form>
    </div>
</body>
</html>
