<?php
include __DIR__ . '/../core/Database.php';

class Department {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function getAllDepartments() {
        $stmt = $this->conn->prepare("SELECT * FROM departments WHERE deleted_at  IS NULL ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDepartmentById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM departments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addDepartment($data) {
        $stmt = $this->conn->prepare("INSERT INTO departments (name, dean_name) VALUES (:name, :dean_name)");
        $stmt->execute([
            ':name' => $data['name'],
            ':dean_name' => $data['dean_name']
        ]);
    }

    public function updateDepartment($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $params[':id'] = $id;
        if (!empty($fields)) {
            $sql = "UPDATE departments SET " . implode(', ', $fields) . " WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
        }
    }

      public function softDeleteDepartment($department_id) {
        $stmt = $this->conn->prepare("
        UPDATE departments
        SET deleted_at = NOW()
        WHERE id = :id
    ");
    $stmt->execute([':id' => $department_id]);
}
}
?>

