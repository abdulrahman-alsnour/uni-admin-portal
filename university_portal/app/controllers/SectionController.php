<?php
include __DIR__ . '/../models/section.php';

class SectionController {
    private $sectionModel;

    public function __construct() {
        $this->sectionModel = new Section();
    }

    public function getSectionsByCourse($course_id) {
        return $this->sectionModel->getSectionsByCourse($course_id);
    }

    public function getSectionById($id) {
        return $this->sectionModel->getSectionById($id);
    }

    public function addSection($data) {
        $this->sectionModel->addSection($data);
    }

    public function updateSection($id, $data) {
        $this->sectionModel->updateSection($id, $data);
    }

        public function delete($id) {
         $this->sectionModel->softDeleteSection($id) ;

    }

    public function getAllProfessors() {
        return $this->sectionModel->getAllProfessors();
    }

    public function getCourseName($course_id) {
        return $this->sectionModel->getCourseName($course_id);
    }
}
?>
