<?php
include('database.php');

if (!isset($_GET['student_id'])) {
    die('Student ID not provided.');
}

$student_id = $_GET['student_id'];

// Fetch student information
$studentQuery = "SELECT id, CONCAT(first_name, ' ', last_name) AS full_name FROM students WHERE id = '$student_id'";
$studentResult = mysqli_query($conn, $studentQuery);
$student = mysqli_fetch_assoc($studentResult);

if (!$student) {
    die('Student not found.');
}

// Fetch enrolled subjects
$subjectsQuery = "SELECT subjects.subject_code, subjects.subject_description, subjects.subject_units 
                  FROM enrollments 
                  JOIN subjects ON enrollments.subject_id = subjects.id 
                  WHERE enrollments.student_id = '$student_id'";
$subjectsResult = mysqli_query($conn, $subjectsQuery);

if (!$subjectsResult) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Assessment Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-light justify-content-center fs-3 mb-5" style="background-color: #00ff5573;">
    <h1 style="font-family: Arial, Helvetica, sans-serif; font-weight: bold;">Student Assessment Form</h1>
</nav>

    <div class="container">
        <h3>Student Name: <?php echo htmlspecialchars($student['full_name']); ?></h3>
        <h3>Enrolled Subjects:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject Description</th>
                    <th>Subject Units</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($subject = mysqli_fetch_assoc($subjectsResult)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subject['subject_code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['subject_description']); ?></td>
                        <td><?php echo htmlspecialchars($subject['subject_units']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>
