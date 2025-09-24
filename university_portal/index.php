<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Portal</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background: #f8f9fa;
        }

        .hero {
            height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .hero .btn-section .btn {
            min-width: 180px;
            padding: 1rem 0;
            font-size: 1.1rem;
            transition: transform 0.2s;
        }

        .hero .btn-section .btn:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <?php require_once __DIR__ . '/app/views/partials/navbar.php'; 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    ?>
    <section class="hero">
        <div class="container">
            <h1>Welcome to University Portal</h1>
            <p class="mb-5 lead">Manage students, professors, courses, and departments efficiently.</p>

            <div class="d-flex flex-wrap justify-content-center gap-3 btn-section">
                <a href="../app/views/students/index.php" class="btn btn-primary btn-lg">Students</a>
                <a href="../app/views/professors/index.php" class="btn btn-success btn-lg">Professors</a>
                <a href="../app/views/departments/index.php" class="btn btn-warning btn-lg">Departments</a>
                <a href="../app/views/courses/index.php" class="btn btn-danger btn-lg">Courses</a>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
