<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Dashboard</h1>

    <!-- Students -->
    <div class="table-container">
        <h2>Students <a href="addstudent.php" class="btn">Add Student</a></h2>
        <table>
            <tr><th>Student ID</th><th>First Name</th><th>Middle Initial</th><th>Last Name</th><th>Email Address</th><th>Student Type</th><th>Action</th></tr>
            <?php
            $result = $conn->query("SELECT * FROM student");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['stud_id']}</td>
                        <td>{$row['first_name']}
                        <td>{$row['middle_initial']}
                        <td>{$row['last_name']}</td>
                        <td>{$row['email_add']}</td>
                        <td>{$row['student_type']}</td>
                        <td>
                            <a href='editstudent.php?id={$row['stud_id']}'>Edit</a> |
                            <a href='deletestudent.php?id={$row['stud_id']}' onclick=\"return confirm('Are you sure you want to delete this student?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Courses -->
    <div class="table-container">
        <h2>Courses <a href="addcourse.php" class="btn">Add Course</a></h2>
        <table>
            <tr><th>Course ID</th><th>Course Code</th><th>Course Description</th><th>Units</th><th>Action</th></tr>
            <?php
            $result = $conn->query("SELECT * FROM course");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['course_id']}</td>
                        <td>{$row['course_code']}</td>
                        <td>{$row['course_desc']}</td>
                        <td>{$row['units']}</td>
                        <td>
                            <a href='editcourse.php?id={$row['course_id']}'>Edit</a> |
                            <a href='deletecourse.php?id={$row['course_id']}' onclick=\"return confirm('Are you sure you want to delete this course?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>

    <!-- Enrollments -->
    <div class="table-container">
        <h2>Enrollments <a href="addenrollment.php" class="btn">Add Enrollment</a></h2>
        <table>
            <tr><th>Enrollment ID</th><th>Enrollment Date</th><th>Student ID</th><th>Course ID</th><th>Action</th></tr>
            <?php
            $sql = "SELECT e.enrollment_id, e.enrollment_date, s.stud_id, c.course_code
                    FROM enrollment e
                    JOIN student s ON e.stud_id = s.stud_id
                    JOIN course c ON e.course_id = c.course_id";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['enrollment_id']}</td>
                        <td>{$row['enrollment_date']}</td>
                        <td>{$row['stud_id']}</td>
                        <td>{$row['course_code']}</td>
                        <td>
                            <a href='editenrollment.php?id={$row['enrollment_id']}'>Edit</a> |
                            <a href='deleteenrollment.php?id={$row['enrollment_id']}' onclick=\"return confirm('Are you sure you want to delete this enrollment?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </table>
    </div>
</div>
</body>
</html>
