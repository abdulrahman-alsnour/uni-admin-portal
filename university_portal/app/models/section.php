<?php
include __DIR__ . '/../core/Database.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Section {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getSectionsByCourse($course_id) {
        $stmt = $this->conn->prepare("
            SELECT s.id, s.professor_id, s.semester, s.schedule, c.name AS course_name, p.full_name AS professor_name
            FROM course_sections s
            LEFT JOIN courses c ON s.course_id = c.id
            LEFT JOIN professors p ON s.professor_id = p.id
            WHERE s.course_id = :course_id AND s.deleted_at IS NULL
            ORDER BY s.id ASC
        ");
        $stmt->execute([':course_id' => $course_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSectionById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM course_sections WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addSection($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO course_sections (course_id, professor_id, semester, schedule)
            VALUES (:course_id, :professor_id, :semester, :schedule)
        ");
        $stmt->execute([
            ':course_id' => $data['course_id'],
            ':professor_id' => $data['professor_id'],
            ':semester' => $data['semester'],
            ':schedule' => $data['schedule']
        ]);
    }

    public function updateSection($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $params[':id'] = $id;
        if (!empty($fields)) {
            $sql = "UPDATE course_sections SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
        }
    }

     public function softDeleteSection($section_id) {
        $stmt = $this->conn->prepare("
        UPDATE course_sections
        SET deleted_at = NOW()
        WHERE id = :id
    ");
    $stmt->execute([':id' => $section_id]);
}

    public function getAllProfessors() {
        $stmt = $this->conn->prepare("SELECT id, full_name FROM professors ORDER BY full_name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseName($course_id) {
        $stmt = $this->conn->prepare("SELECT name FROM courses WHERE id = :course_id");
        $stmt->execute([':course_id' => $course_id]);
        return $stmt->fetchColumn();
    }
}
?>
