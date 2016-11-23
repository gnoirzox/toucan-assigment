<?php
    namespace Toucan\Model;

    use Slimvc\Core\Model;

    class StudentModel extends Model {
        /**
         * Get Students
         *
         * @return array|static[]
         */
        public function getAllStudents() {
            $sql = 'SELECT students.name, students.email, schools.name AS school FROM students '.
                   'LEFT JOIN student_school_junction ON students.studentid = student_school_junction.studentid '.
                   'LEFT JOIN schools ON student_school_junction.schoolid = schools.schoolid;';

            $statement = $this->getReadConnection()->query($sql);
            $statement->setFetchMode(\PDO::FETCH_ASSOC);

            $data = $statement->fetchAll();
             
            return $data;
        }

        /**
         * Get Students filtered by school
         *
         * @param string $school the school to retrieve the students from
         *
         * @return array|static[]
         */
        public function getAllStudentsPerSchool($school_name) {
            if($school_name && is_string($school_name)) {
                $sql = 'SELECT students.name, students.email, schools.name AS school FROM students ' .
                       'INNER JOIN student_school_junction ON students.studentid = student_school_junction.studentid ' .
                       'INNER JOIN schools ON student_school_junction.schoolid = schools.schoolid ' .
                       'WHERE schools.name = :school_name'; 

                $statement = $this->getWriteConnection()->prepare($sql);
                $statement->bindParam(':school_name', $school_name, \PDO::PARAM_STR);
                $statement->execute();
                $statement->setFetchMode(\PDO::FETCH_ASSOC);

                $data = $statement->fetchAll();

                return $data;
            } else {
                throw new Exception('School parameter is not a string.');

                return null;
            }
        }

        /**
         * Add a new student belonging to a school which is already stored in database
         *
         * @param array $student the fields to store in database
         *
         * @return mixed|static
         */
        public function addStudent($student = array()) {
            if($student && is_array($student)) {
                if(isset($student['name']) && isset($student['email']) && isset($student['school'])) {
                    $sql = 'INSERT INTO students (name, email) VALUES (:name, :email);'.
                           'SET @studentid = LAST_INSERT_ID();'.
                           'SET @schoolid = SELECT schoolid FROM schools WHERE name = :school_name;'.
                           'SET foreign_key_checks = 0;'.
                           'INSERT INTO student_school_junction(studentid, schoolid) VALUES (@studentid, @schoolid)'.
                           'SET foreign_key_checks = 1;'; 

                    $statement = $this->getWriteConnection()->prepare($sql);
                    $statement->bindParam(':name',        $student['name'],   \PDO::PARAM_STR);
                    $statement->bindParam(':email',       $student['email'],  \PDO::PARAM_STR);
                    $statement->bindParam(':school_name', $student['school'], \PDO::PARAM_STR);
                    $statement->execute();

                    $inserted = $statement->fetchColumn();

                    return $inserted;
                } else {
                    throw new Exception('Student parameter(s) not set.');

                    return null;
                }
            } else {
                    throw new Exception('Student parameter(s) not set or is not an array.');

                    return null;
            }
        }
    }
