<?php
require_once __DIR__ . '/../../controllers/StudentController.php';
require_once __DIR__ . '/../partials/navbar.php'; 

$studentController = new StudentController();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$studentId = $_GET['id'];
$student = $studentController->getStudentById($studentId); 

if (!$student) {
    header('Location: index.php');
    exit;
}

$majors = $studentController->getAllMajors();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'full_name' => $_POST['full_name'],
        'email' => $_POST['email'],
        'birth_date' => $_POST['birth_date'],
        'gender' => $_POST['gender'],
        'major_id' => $_POST['major_id'],
        'enrollment_year' => $_POST['enrollment_year']
    ];

    $studentController->update($studentId, $data);
    header('Location: index.php'); 
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student - University Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Edit Student</h2>
    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control" value="<?= htmlspecialchars($student['full_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="birth_date" class="form-label">Birth Date</label>
                        <input type="date" id="birth_date" name="birth_date" class="form-control" value="<?= htmlspecialchars($student['birth_date']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label">Gender</label>
                        <select id="gender" name="gender" class="form-select" required>
                            <option value="Male" <?= $student['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                            <option value="Female" <?= $student['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                            <option value="Other" <?= $student['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="major_id" class="form-label">Major</label>
                        <select id="major_id" name="major_id" class="form-select" required>
                            <?php foreach ($majors as $major): ?>
                                <option value="<?= $major['id'] ?>" <?= $student['major_id'] == $major['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($major['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="enrollment_year" class="form-label">Enrollment Year</label>
                        <input type="number" id="enrollment_year" name="enrollment_year" class="form-control" min="2000" max="<?= date('Y') ?>" value="<?= htmlspecialchars($student['enrollment_year']) ?>" required>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
