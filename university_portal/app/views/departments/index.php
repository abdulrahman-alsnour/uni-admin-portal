<?php
require_once __DIR__ . '/../../controllers/DepartmentControler.php';
require_once __DIR__ . '/../partials/navbar.php';


$departmentController = new DepartmentController();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_department'])) {
    $data = [
        'name' => $_POST['name'],
        'dean_name' => $_POST['dean_name']
    ];
    $departmentController->addDepartment($data);
    header("Location: index.php");
    exit;
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $departmentController->delete($_GET['id']);
    header('Location: index.php'); 
    exit;
}

$departments = $departmentController->getAllDepartments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Departments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Departments</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">
             Add Department
        </button>
    </div>

    <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Dean Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $dept): ?>
                <tr>
                    <td><?= htmlspecialchars($dept['id']) ?></td>
                    <td><?= htmlspecialchars($dept['name']) ?></td>
                    <td><?= htmlspecialchars($dept['dean_name']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= $dept['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?action=delete&id=<?= $dept['id'] ?>" 
                                class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                    Delete
                        </a>                     
                        </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($departments)): ?>
                <tr>
                    <td colspan="4" class="text-center">No departments found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Department</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Dean Name</label>
            <input type="text" name="dean_name" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="add_department" class="btn btn-success">Add</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
