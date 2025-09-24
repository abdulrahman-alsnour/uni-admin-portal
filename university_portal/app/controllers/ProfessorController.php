<?php
include __DIR__ . '/../models/Professor.php';

class ProfessorController {
    private $professorModel;

    public function __construct() {
        $this->professorModel = new Professor();
    }

    public function getAllProfessors() {
        return $this->professorModel->getAllProfessors();
    }

    public function getProfessorById($id) {
        return $this->professorModel->getProfessorById($id);
    }
    public function getAllDepartments()
    {
    return $this->professorModel->getAllDepartments();
    }


    public function addProfessor($data) {
        $this->professorModel->addProfessor($data);
    }

    public function updateProfessor($id, $data) {
        $current = $this->professorModel->getProfessorById($id);
        if ($current['email'] === $data['email']) {
            unset($data['email']); 
        }
        $this->professorModel->updateProfessor($id, $data);
    }

       public function delete($id) {
         $this->professorModel->softDeleteProf($id) ;

}
}
?>
