<?php
include  __DIR__ . '/../../controllers/SectionStudentController.php';
include __DIR__ . '/../partials/navbar.php';

$sectionId = $_GET['section_id'] ?? null;
if (!$sectionId) {
    die('Section ID is required');
}

$sectionStudentController = new SectionStudentController();
$students = $sectionStudentController->getStudentsBySection($sectionId);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_student') {
        $data = [
            'student_id' => $_POST['student_id'],
            'section_id' => $sectionId,
            'enroll_date' => $_POST['enroll_date']
        ];
        $sectionStudentController->addStudentToSection($data);
        header("Location: index.php?section_id=$sectionId");
        exit;
    } elseif ($_POST['action'] === 'update_grade') {
        $sectionStudentController->updateStudentGrade($_POST['enrollment_id'], $_POST['grade']);
        header("Location: index?section_id=$sectionId");
        exit;
    } elseif ($_POST['action'] === 'remove_student') {
        $sectionStudentController->removeStudentFromSection($_POST['enrollment_id']);
        header("Location: index.php?section_id=$sectionId");
        exit;
    }
}
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
    <h2>Students in Section #<?= htmlspecialchars($sectionId) ?></h2>

    <table class="table table-striped table-hover mt-4">
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
                <td>
                    <form method="POST" class="d-flex gap-2">
                        <input type="hidden" name="action" value="update_grade">
                        <input type="hidden" name="enrollment_id" value="<?= $student['enrollment_id'] ?>">
                        <input type="number" step="0.01" name="grade" class="form-control" value="<?= $student['grade'] ?? '' ?>">
                        <button class="btn btn-sm btn-success">Save</button>
                    </form>
                </td>
                <td>
                    <form method="POST" onsubmit="return confirm('Are you sure?');">
                        <input type="hidden" name="action" value="remove_student">
                        <input type="hidden" name="enrollment_id" value="<?= $student['enrollment_id'] ?>">
                        <button class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h4 class="mt-5">Add Student to Section</h4>
    <form method="POST" class="row g-3">
        <input type="hidden" name="action" value="add_student">
        <div class="col-md-4">
            <label class="form-label">Student ID</label>
            <input type="number" name="student_id" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Enroll Date</label>
            <input type="date" name="enroll_date" class="form-control" required>
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary">Add Student</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
