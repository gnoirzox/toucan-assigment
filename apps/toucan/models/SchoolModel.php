<?php
    namespace Toucan\Model;

    use Slimvc\Core\Model;

    class SchoolModel extends Model {
        /*
         * Get names list of schools
         *
         * @return array|static[]
         */
        public function getSchoolsNames() {
            $sql = 'SELECT name FROM schools';

            $statement = $this->getReadConnection()->query($sql);
            $statement->setFetchMode(\PDO::FETCH_NUM);

            $data = $statement->fetchAll();

            return $data;
        }
    }
