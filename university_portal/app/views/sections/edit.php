<?php
include __DIR__ . '/../../controllers/SectionController.php';

if (!isset($_GET['id'], $_GET['course_id'])) {
    echo "Section not specified.";
    exit;
}

$id = $_GET['id'];
$course_id = $_GET['course_id'];

$sectionController = new SectionController();
$section = $sectionController->getSectionById($id);
$professors = $sectionController->getAllProfessors();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sectionController->updateSection($id, $_POST);
    header("Location: index.php?course_id=$course_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Section</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Section</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Professor</label>
            <select name="professor_id" class="form-select" required>
                <?php foreach ($professors as $prof): ?>
                    <option value="<?= $prof['id'] ?>" <?= $prof['id'] == $section['professor_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($prof['full_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Semester</label>
            <input type="text" name="semester" class="form-control" value="<?= htmlspecialchars($section['semester']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Schedule</label>
            <input type="text" name="schedule" class="form-control" value="<?= htmlspecialchars($section['schedule']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Section</button>
        <a href="index.php?course_id=<?= $course_id ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
