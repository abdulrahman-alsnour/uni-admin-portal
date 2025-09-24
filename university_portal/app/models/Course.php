<?php
include __DIR__ . '/../core/Database.php';

class Course {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllCourses() {
        $stmt = $this->conn->prepare("
            SELECT c.id, c.code, c.name, c.credits, d.name AS department_name, c.department_id
            FROM courses c
            LEFT JOIN departments d ON c.department_id = d.id
            WHERE c.deleted_at IS NULL
            ORDER BY c.id ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCourse($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO courses (code, name, department_id, credits)
            VALUES (:code, :name, :department_id, :credits)
        ");
        $stmt->execute([
            ':code' => $data['code'],
            ':name' => $data['name'],
            ':department_id' => $data['department_id'],
            ':credits' => $data['credits'],
        ]);
    }

    public function updateCourse($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $params[':id'] = $id;
        if (!empty($fields)) {
            $sql = "UPDATE courses SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
        }
    }

   public function softDeleteCourse($course_id) {
    $stmt = $this->conn->prepare("
        UPDATE courses 
        SET deleted_at = NOW()
        WHERE id = :id
    ");
    $stmt->execute([':id' => $course_id]);
}

    public function getAllDepartments() {
        $stmt = $this->conn->prepare("SELECT * FROM departments");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
