<?php
include __DIR__ . '/../core/Database.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class Student {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllStudents() {
    $stmt = $this->conn->prepare("
        SELECT s.*, m.name AS major
        FROM students s
        LEFT JOIN majors m ON s.major_id = m.id
        WHERE s.deleted_at IS NULL
        ORDER BY s.id
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllMajors() {
        $stmt = $this->conn->prepare("SELECT * FROM majors");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO students (full_name, email, birth_date, gender, major_id, enrollment_year)
            VALUES (:full_name, :email, :birth_date, :gender, :major_id, :enrollment_year)
        ");
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':birth_date' => $data['birth_date'],
            ':gender' => $data['gender'],
            ':major_id' => $data['major_id'],
            ':enrollment_year' => $data['enrollment_year']
        ]);
    }



   
    public function update($id, $data) {
    $fields = [];
    $params = [];

    foreach ($data as $key => $value) {
        $fields[] = "$key = :$key";
        $params[":$key"] = $value;
    }

    $params[':id'] = $id;

    if (!empty($fields)) {
        $sql = "UPDATE students SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
    }
}

   public function softDeleteStudent($student_id) {
    $stmt = $this->conn->prepare("
        UPDATE students 
        SET deleted_at = NOW()
        WHERE id = :id
    ");
    $stmt->execute([':id' => $student_id]);
}

}
