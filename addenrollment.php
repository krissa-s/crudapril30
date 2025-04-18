<?php
// Include the database connection file
include('db.php');

// Initialize message variable
$message = '';

// Check if the form is submitted
if (isset($_POST['add'])) {
    // Get the values from the form
    $enrollment_id = $_POST['enrollment_id'];  // Added student ID input
    $enrollment_date = $_POST['enrollment_date'];
    $stud_id = $_POST['stud_id']; // Fix the variable name to match the column
    $course_id = $_POST['course_id'];

    // Insert the student data into the database
    $query = "INSERT INTO enrollment (enrollment_id, enrollment_date, stud_id, course_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $enrollment_id, $enrollment_date, $stud_id, $course_id);  // Adjusted for student_id

    if ($stmt->execute()) {
        // Success message
        $message = "Enrollment added successfully!";
        // Redirect to the dashboard after a delay to see the message
        header("refresh:3;url=index.php"); // Redirect after  seconds
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
    <title>Add Enrollment</title>
    <link rel="stylesheet" href="addenrollment.css">
</head>
<body>
    <div class="form-container">
        <h2>Add Enrollment</h2>

        <!-- Display message (success or error) -->
        <?php if ($message != ''): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="addenrollment.php" method="post">
            <!-- Include student_id in the form -->
            <input type="text" name="enrollment_id" placeholder="Enrollment ID" required>
            <input type="text" name="enrollment_date" placeholder="Enrollment Date" required>
            <input type="text" name="stud_id" placeholder="Student ID" required>
            <input type="text" name="course_id" placeholder="Course ID" required>
            <button type="submit" name="add">Save Enrollment</button>
        </form>
    </div>
</body>
</html>
