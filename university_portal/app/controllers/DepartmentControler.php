<?php
include __DIR__ . '/../models/Department.php';

class DepartmentController {
    private $departmentModel;

    public function __construct() {
        $this->departmentModel = new Department();
    }

    public function getAllDepartments() {
        return $this->departmentModel->getAllDepartments();
    }

    public function getDepartmentById($id) {
        return $this->departmentModel->getDepartmentById($id);
    }

    public function addDepartment($data) {
        $this->departmentModel->addDepartment($data);
    }

    public function updateDepartment($id, $data) {
        $this->departmentModel->updateDepartment($id, $data);
    }

      public function delete($id) {
         $this->departmentModel->softDeleteDepartment($id) ;

}
}
?>
