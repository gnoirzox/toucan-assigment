<?php
    namespace Toucan\Controller;
    
    use Slimvc\Core\Controller;
    use Toucan\Model\StudentModel;
    use Toucan\Controller\SchoolController;

    class StudentController extends Controller {
        const EMAIL_REGEXP = "^[a-zA-Z0-9+&*-]+(?:\.[a-zA-Z0-9_+&*-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,7}$";

        /**
         * access to StudentModel
         *
         */
        private function getStudentModelInstance() {
            $studentModel = new StudentModel();

            return $studentModel;
        }

        /**
         * access to SchoolModel
         *
         */
        private function getSchoolControllerInstance() {
            $schoolController = new SchoolController(); 

            return $schoolController;
        }

       /**
        * students action
        *
        */
       public function actionGetStudents() {
           $studentModel = $this->getStudentModelInstance();
           $school_list  = $this->getSchoolControllerInstance()->actionGetSchoolsNames();
           $result       = array();

           try {
                $result = $studentModel->getAllStudents();
           } catch(Exception $exception) {
                $exception->getMessage();
           }

           $data = array(
                'students' => $result,
                'schools'  => $school_list
            );

           $this->getApp()->contentType('text/html');
           $this->render("student/index.phtml", $data);
       }

       /**
        * students/school_name action
        *
        * @param string $school_name 
        */
       public function actionGetStudentsPerSchool($school_name) {
           $studentModel = $this->getStudentModelInstance();
           $school_list  = $this->getSchoolControllerInstance()->actionGetSchoolsNames();
           $result       = array();

           if($school_name && is_string($school_name)) {
                try {
                    $result = $studentModel->getAllStudentsPerSchool($school_name);
                } catch(Exception $exception) {
                    $exception->getMessage();
                }
           }

           $data = array(
               'students'    => $result,
               'schools'     => $school_list,
               'school_name' => $school_name
            );

           $this->getApp()->contentType('text/html');
           $this->render("student/index.phtml", $data);
       }

       /**
        * students/create action
        *
        * @param array $student the student's properties
        */
       public function actionCreateStudent($student = array()) {
           $studentModel  = $this->getStudentModelInstance();
           $school_list   = $this->getSchoolControllerInstance()->actionGetSchoolsNames();

           $app           = $this->getApp();

           $result        = array();
           $error_message = null;

           if($app->request->isPost() && $student && is_array($student)) {
                $email_valid = preg_match(self::EMAIL_REGEXP, $student['email']);

                if       (!isset($student['name'])) {
                    $error_message = "Student's name is required.";

                    $result['email']  = isset($student['email'])  ? $student['email']  : null;
                    $result['school'] = isset($student['school']) ? $student['school'] : null;

                } else if(!isset($student['email']) || !$email_valid) {
                    if(empty($student['email'])) {
                        $error_message = "Student's email is required.";
                    } else {
                        $error_message = "Please submit a valid email address.";
                    }

                    $result['name']   = $student['name'];
                    $result['school'] = isset($student['school']) ? $student['school'] : null;

                } else if(!isset($student['school'])) {
                    $error_message = "Student's school is required.";

                    $result['name']  = $student['name'];
                    $result['email'] = $student['email'];

                } else {
                    try {
                        $result = $studentModel->addStudent($student);
                    } catch(Exception $exception) {
                        $exception->getMessage();
                    }

                    $app->response->redirect('/students/list');
                }
           }

           $data = array(
               'student'       => $result, 
               'schools'       => $school_list,
               'error_message' => $error_message
           );

           $app->contentType('text/html');
           $this->render("student/create.phtml", $data);
       }
    }
