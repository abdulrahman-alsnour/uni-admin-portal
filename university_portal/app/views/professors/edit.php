<?php
include __DIR__ . '/../../controllers/ProfessorController.php';

$professorController = new ProfessorController();
$departments = $professorController->getAllDepartments();


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$professorId = $_GET['id'];
$professor = $professorController->getProfessorById($professorId);

if (!$professor) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'hire_date' => $_POST['hire_date'],
        'department_id' => $_POST['department_id'],
    ];

    $professorController->updateProfessor($professorId, $data);
    header('Location: index.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Professor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Professor</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($professor['full_name']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($professor['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Hire Date</label>
            <input type="date" name="hire_date" class="form-control" value="<?= htmlspecialchars($professor['hire_date']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Department</label>
            <select name="department_id" class="form-select" required>
                <option value="">Select Department</option>
                    <?php foreach ($departments as $dept): ?>
                    <option value="<?= $dept['id'] ?>"<?= $professor['department_id'] == $dept['id']? 'selected': ''?>>
                     <?= htmlspecialchars($dept['name']) ?></option>
                    <?php endforeach; ?>
            </select> 
                
        </div>
        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
