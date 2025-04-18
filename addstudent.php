<?php
// Include the database connection file
include('db.php');

// Initialize message variable
$message = '';

// Check if the form is submitted
if (isset($_POST['add'])) {
    // Get the values from the form
    $stud_id = $_POST['stud_id'];  // Added student ID input
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_name']; // Fix the variable name to match the column
    $last_name = $_POST['last_name'];
    $email_add = $_POST['email_add'];
    $student_type = $_POST['student_type'];

    // Insert the student data into the database
    $query = "INSERT INTO student (stud_id, first_name, middle_initial, last_name, email_add, student_type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isssss', $stud_id, $first_name, $middle_initial, $last_name, $email_add, $student_type);  // Adjusted for student_id

    if ($stmt->execute()) {
        // Success message
        $message = "Student added successfully!";
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
    <title>Add Student</title>
    <link rel="stylesheet" href="addstudent.css">
</head>
<body>
    <div class="form-container">
        <h2>Add Student</h2>

        <!-- Display message (success or error) -->
        <?php if ($message != ''): ?>
            <div class="message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="addstudent.php" method="post">
            <!-- Include student_id in the form -->
            <input type="text" name="stud_id" placeholder="Student ID" required>
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="middle_name" placeholder="Middle Initial" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email_add" placeholder="Email Address" required>
            <select name="student_type" required>
                <option value="">Select Type</option>
                <option value="regular">Regular</option>
                <option value="irregular">Irregular</option>
            </select>
            <button type="submit" name="add">Save Student</button>
        </form>
    </div>
</body>
</html>
