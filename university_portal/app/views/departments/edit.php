<?php
require_once __DIR__ . '/../../controllers/DepartmentControler.php';

$departmentController = new DepartmentController();

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$deptId = $_GET['id'];
$department = $departmentController->getDepartmentById($deptId);

if (!$department) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'name' => $_POST['name'],
        'dean_name' => $_POST['dean_name']
    ];
    $departmentController->updateDepartment($deptId, $data);
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Department</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Department</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($department['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Dean Name</label>
            <input type="text" name="dean_name" class="form-control" value="<?= htmlspecialchars($department['dean_name']) ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
