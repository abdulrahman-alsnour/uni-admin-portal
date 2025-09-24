<?php
include __DIR__ . '/../../controllers/SectionController.php';
include __DIR__ . '/../partials/navbar.php';

if (!isset($_GET['course_id'])) {
    echo "Course not specified.";
    exit;
}

$course_id = $_GET['course_id'];
$sectionController = new SectionController();
$sections = $sectionController->getSectionsByCourse($course_id);
$course_name = $sectionController->getCourseName($course_id);
$professors = $sectionController->getAllProfessors();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_section') {
        $_POST['course_id'] = $course_id;
        $sectionController->addSection($_POST);
        header("Location: index.php?course_id=$course_id");
        exit;
    } 
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $sectionController->delete($_GET['id']);
    header('Location: index.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sections - <?= htmlspecialchars($course_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sections for Course: <?= htmlspecialchars($course_name) ?></h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal">Add New Section</button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Professor</th>
                <th>Semester</th>
                <th>Schedule</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($sections as $section): ?>
            <tr>
                <td><?= $section['id'] ?></td>
                <td><?= htmlspecialchars($section['professor_name'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($section['semester']) ?></td>
                <td><?= htmlspecialchars($section['schedule']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $section['id'] ?>&course_id=<?= $course_id ?>" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                        <input type="hidden" name="action" value="delete_section">
                        <input type="hidden" name="id" value="<?= $section['id'] ?>">
                    <a href="index.php?action=delete&id=<?= $section['id'] ?>" 
                            class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                    </a>                         
                    <a href="../section_students/index.php?section_id=<?= $section['id'] ?>" class="btn btn-sm btn-info">
                        View Students
                    </a>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addSectionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="action" value="add_section">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Section</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Professor</label>
                        <select name="professor_id" class="form-select" required>
                            <option value="">Select Professor</option>
                            <?php foreach ($professors as $prof): ?>
                                <option value="<?= $prof['id'] ?>"><?= htmlspecialchars($prof['full_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="text" name="semester" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Schedule</label>
                        <input type="text" name="schedule" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Section</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
