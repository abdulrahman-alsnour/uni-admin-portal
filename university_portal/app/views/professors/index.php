<?php
include __DIR__ . '/../../controllers/ProfessorController.php';
include __DIR__ . '/../partials/navbar.php';

$professorController = new ProfessorController();
$professors = $professorController->getAllProfessors();
$departments = $professorController->getAllDepartments();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_professor') {
    $professorController->addProfessor($_POST);
    header('Location: index.php'); 
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $professorController->delete($_GET['id']);
    header('Location: index.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professors - University Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Professors</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProfessorModal">
            Add New Professor
        </button>
    </div>

    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Hire Date</th>
                <th>Department</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($professors as $professor): ?>
            <tr>
                <td><?= htmlspecialchars($professor['id']) ?></td>
                <td><?= htmlspecialchars($professor['full_name'] ?? '') ?></td>
                <td><?= htmlspecialchars($professor['email'] ?? '') ?></td>
                <td><?= htmlspecialchars($professor['hire_date'] ?? '') ?></td>
                <td><?= htmlspecialchars($professor['department_name'] ?? 'N/A') ?></td>
                <td>
                    <a href="edit.php?id=<?= $professor['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="index.php?action=delete&id=<?= $professor['id'] ?>" 
                            class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                            Delete
                    </a>                 
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="addProfessorModal" tabindex="-1" aria-labelledby="addProfessorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="addProfessorForm">
                <input type="hidden" name="action" value="add_professor">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProfessorModalLabel">Add New Professor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hire Date</label>
                        <input type="date" name="hire_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                            <select name="department_id" class="form-select" required>
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Professor</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
</script>
</body>
</html>
