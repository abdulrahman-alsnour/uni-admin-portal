<?php
include __DIR__ . '/../models/SectionStudent.php';

class SectionStudentController {
    private $model;

    public function __construct() {
        $this->model = new SectionStudent();
    }

    public function getStudentsBySection($section_id) {
        return $this->model->getStudentsBySection($section_id);
    }

    public function addStudentToSection($data) {
        $this->model->addStudentToSection($data);
    }

    public function updateStudentGrade($enrollment_id, $grade) {
        $this->model->updateStudentGrade($enrollment_id, $grade);
    }

    public function removeStudentFromSection($enrollment_id) {
        $this->model->removeStudentFromSection($enrollment_id);
    }
}
?>
