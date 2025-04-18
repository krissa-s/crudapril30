<?php
// Include DB connection
include 'db.php';

// Initialize student array
$student = [];

// Step 1: Get student data from DB using ID from URL
if (isset($_GET['id'])) {
    $original_id = $_GET['id'];

    $query = "SELECT * FROM student WHERE stud_id = $original_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $student = mysqli_fetch_assoc($result);
    } else {
        echo "Student not found.";
        exit;
    }
} else {
    echo "No student ID provided.";
    exit;
}

// Step 2: Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_id = $_POST['stud_id'];
    $first_name = $_POST['first_name'];
    $middle_initial = $_POST['middle_initial'];
    $last_name = $_POST['last_name'];
    $email_add = $_POST['email_add'];
    $student_type = $_POST['student_type'];

    $updateQuery = "UPDATE student SET 
        stud_id = '$new_id',
        first_name = '$first_name',
        middle_initial = '$middle_initial',
        last_name = '$last_name',
        email_add = '$email_add',
        student_type = '$student_type'
        WHERE stud_id = $original_id";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>alert('Student updated successfully'); window.location.href='index.php';</script>";
    } else {
        echo "Error updating student: " . mysqli_error($conn);
    }
}
?>

<!-- Step 3: HTML FORM -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="editstudent.css">
</head>
<body>
    <div class="form-container">
        <h2>Edit Student</h2>
        <form action="editstudent.php?id=<?php echo $student['stud_id']; ?>" method="post">
            <input type="text" name="stud_id" placeholder="Student ID" value="<?php echo $student['stud_id']; ?>" required>

            <input type="text" name="first_name" placeholder="First Name" value="<?php echo $student['first_name']; ?>" required>
            <input type="text" name="middle_initial" placeholder="Middle Initial" value="<?php echo $student['middle_initial']; ?>" required>
            <input type="text" name="last_name" placeholder="Last Name" value="<?php echo $student['last_name']; ?>" required>
            <input type="email" name="email_add" placeholder="Email Address" value="<?php echo $student['email_add']; ?>" required>

            <select name="student_type" required>
                <option value="">Select Type</option>
                <option value="Regular" <?php if ($student['student_type'] == 'Regular') echo 'selected'; ?>>Regular</option>
                <option value="Irregular" <?php if ($student['student_type'] == 'Irregular') echo 'selected'; ?>>Irregular</option>
            </select>

            <button type="submit">Update Student</button>
        </form>
    </div>
</body>
</html>
