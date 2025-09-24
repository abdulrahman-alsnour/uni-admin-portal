<?php
include __DIR__ . '/../core/Database.php';

class Professor {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

   public function getAllProfessors()
{
    $stmt = $this->conn->prepare("
        SELECT p.id, p.full_name, p.email, p.hire_date, d.name AS department_name
        FROM professors p
        LEFT JOIN departments d ON p.department_id = d.id
        WHERE p.deleted_at IS NULL
        ORDER BY p.id ASC
    ");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function getProfessorById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM professors WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProfessor($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO professors (full_name, email, hire_date, department_id)
            VALUES (:full_name, :email, :hire_date, :department_id)
        ");
        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':hire_date' => $data['hire_date'],
            ':department_id' => $data['department_id']
        ]);
    }
    public function getAllDepartments()
    {
    $stmt = $this->conn->prepare("SELECT * FROM departments");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateProfessor($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        $params[':id'] = $id;
        if (!empty($fields)) {
        $sql = "UPDATE professors SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        }
    }

     public function softDeleteProf($professor_id) {
        $stmt = $this->conn->prepare("
        UPDATE professors 
        SET deleted_at = NOW()
        WHERE id = :id
    ");
        $stmt->execute([':id' => $professor_id]);

     }
}
?>
