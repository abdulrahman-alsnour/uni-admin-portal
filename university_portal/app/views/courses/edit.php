<?php
require_once __DIR__ . '/../../controllers/CourseController.php';

$courseController = new CourseController();
$departments = $courseController->getAllDepartments();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$courseId = $_GET['id'];
$course = $courseController->getCourseById($courseId);

if (!$course) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'code' => $_POST['code'],
        'name' => $_POST['name'],
        'credits' => $_POST['credits'],
        'department_id' => $_POST['department_id'],
    ];

    $courseController->updateCourse($courseId, $data);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Course</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Course Code</label>
            <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($course['code']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Course Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($course['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Credits</label>
            <input type="number" name="credits" class="form-control" value="<?= htmlspecialchars($course['credits']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department_id" class="form-select" required>
                <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['id'] ?>" <?= $dept['id'] == $course['department_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
