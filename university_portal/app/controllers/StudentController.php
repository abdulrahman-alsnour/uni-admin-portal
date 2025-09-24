<?php
include __DIR__ . '/../models/Student.php';

class StudentController {
    private $studentModel;

    public function __construct() {
        $this->studentModel = new Student();
    }

     public function getAllStudents() {
        return $this->studentModel->getAllStudents();
    }

    
      public function getAllMajors() {
        return $this->studentModel->getAllMajors(); 
    }

    

    public function getStudentById($id) {
    return $this->studentModel->getById($id); 
    }


    
    public function addStudent($data) {
        return $this->studentModel->create($data);
    }

    
    public function update($id, $data) {
        $currentStudent = $this->studentModel->getById($id);

        if ($currentStudent['email'] === $data['email']) {
            unset($data['email']);
        }

        $this->studentModel->update($id, $data);
    }

    


    public function delete($id) {
         $this->studentModel->softDeleteStudent($id) ;

}
}