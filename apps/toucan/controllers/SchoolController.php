<?php
    namespace Toucan\Controller;

    use Slimvc\Core\Controller;
    use Toucan\Model\SchoolModel;

    class SchoolController {

        /**
         * access to SchoolModel
         *
         */
        private function getSchoolModelInstance() {
            $schoolModel = new SchoolModel(); 

            return $schoolModel;
        }

        /**
         * Get schools' names list
         *
         */
        public function actionGetSchoolsNames() {
            $schoolModel = $this->getSchoolModelInstance();
            $result = array();

            try {
                $result = $schoolModel->getSchoolsNames();
            } catch(Exception $exception) {
                $exception->getMessage();
            }

            return $result;
        }
    }
