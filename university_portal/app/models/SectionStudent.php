<?php
include __DIR__ . '/../core/Database.php';

class SectionStudent {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getStudentsBySection($section_id) {
        $stmt = $this->conn->prepare("
            SELECT 
                e.id AS enrollment_id,
                s.id AS student_id,
                s.full_name,
                e.enroll_date,
                g.grade
            FROM enrollments e
            JOIN students s ON e.student_id = s.id
            LEFT JOIN grades g ON g.enrollment_id = e.id
            WHERE e.section_id = :section_id
        ");
        $stmt->execute([':section_id' => $section_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addStudentToSection($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO enrollments (student_id, section_id, enroll_date)
            VALUES (:student_id, :section_id, :enroll_date)
        ");
        $stmt->execute([
            ':student_id' => $data['student_id'],
            ':section_id' => $data['section_id'],
            ':enroll_date' => $data['enroll_date'],
        ]);
    }

    public function updateStudentGrade($enrollment_id, $grade) {
        $stmt = $this->conn->prepare("SELECT id FROM grades WHERE enrollment_id = :enrollment_id");
        $stmt->execute([':enrollment_id' => $enrollment_id]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            $stmt = $this->conn->prepare("
                UPDATE grades SET grade = :grade, grade_date = CURDATE() WHERE enrollment_id = :enrollment_id
            ");
            $stmt->execute([
                ':grade' => $grade,
                ':enrollment_id' => $enrollment_id
            ]);
        } else {
            $stmt = $this->conn->prepare("
                INSERT INTO grades (enrollment_id, grade, grade_date)
                VALUES (:enrollment_id, :grade, CURDATE())
            ");
            $stmt->execute([
                ':enrollment_id' => $enrollment_id,
                ':grade' => $grade
            ]);
        }
    }

    public function removeStudentFromSection($enrollment_id) {
        $stmt = $this->conn->prepare("DELETE FROM grades WHERE enrollment_id = :enrollment_id");
        $stmt->execute([':enrollment_id' => $enrollment_id]);

        $stmt = $this->conn->prepare("DELETE FROM enrollments WHERE id = :enrollment_id");
        $stmt->execute([':enrollment_id' => $enrollment_id]);
    }
}
?>
