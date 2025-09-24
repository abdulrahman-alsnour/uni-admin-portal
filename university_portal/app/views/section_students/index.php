<?php
include __DIR__ . '/../../controllers/SectionStudentController.php';
include __DIR__ . '/../partials/navbar.php';

$section_id = $_GET['section_id'] ?? null;
if (!$section_id) {
    header("Location: ../sections/index.php");
    exit;
}

$controller = new SectionStudentController();
$students = $controller->getStudentsBySection($section_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Section Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Students Enrolled in Section <?= htmlspecialchars($section_id) ?></h2>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Enrollment Date</th>
                <th>Grade</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?= htmlspecialchars($student['student_id']) ?></td>
                <td><?= htmlspecialchars($student['full_name']) ?></td>
                <td><?= htmlspecialchars($student['enroll_date']) ?></td>
                <td><?= htmlspecialchars($student['grade']) ?></td>
                <td>
                    <a href="edit.php?section_id=<?= $section_id ?>&enrollment_id=<?= $student['enrollment_id'] ?>" 
                       class="btn btn-sm btn-warning">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
