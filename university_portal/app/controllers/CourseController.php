<?php
include __DIR__ . '/../models/Course.php';

class CourseController {
    private $courseModel;

    public function __construct() {
        $this->courseModel = new Course();
    }

    public function getAllCourses() {
        return $this->courseModel->getAllCourses();
    }

    public function getCourseById($id) {
        return $this->courseModel->getCourseById($id);
    }

    public function getAllDepartments() {
        return $this->courseModel->getAllDepartments();
    }

    public function addCourse($data) {
        $this->courseModel->addCourse($data);
    }

    public function updateCourse($id, $data) {
        $this->courseModel->updateCourse($id, $data);
    }

       public function delete($id) {
         $this->courseModel->softDeleteCourse($id) ;

}
}
?>
