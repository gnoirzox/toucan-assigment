CREATE SCHEMA IF NOT EXISTS toucan DEFAULT CHARACTER SET LATIN1;
USE toucan;
    CREATE TABLE IF NOT EXISTS students (
        studentid BIGINT NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        email VARCHAR(250) NOT NULL,
        PRIMARY KEY(studentid)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS schools (
        schoolid BIGINT NOT NULL AUTO_INCREMENT,
        name VARCHAR(50) NOT NULL,
        PRIMARY KEY(schoolid)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

    CREATE TABLE IF NOT EXISTS student_school_junction (
        student_school_junctionid BIGINT NOT NULL AUTO_INCREMENT,
        studentid BIGINT NOT NULL,
        schoolid BIGINT NOT NULL,
        PRIMARY KEY(student_school_junctionid),
        FOREIGN KEY(studentid) REFERENCES students(studentid),
        FOREIGN KEY(schoolid) REFERENCES schools(schoolid)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;


    INSERT INTO schools(name) VALUE("lincoln");

    INSERT INTO schools(name) VALUE("napier");

    INSERT INTO schools(name) VALUE("brokley");

    INSERT INTO students(name, email) VALUES("emma", "emma@toucan.dev");

    INSERT INTO students(name, email) VALUES("adam", "adam@toucan.dev");

    INSERT INTO students(name, email) VALUES("bernie", "bernie@toucan.dev");

    SET foreign_key_checks = 0;

    INSERT INTO student_school_junction(studentid, schoolid) VALUES(0,1);

    INSERT INTO student_school_junction(studentid, schoolid) VALUES(1,0);

    INSERT INTO student_school_junction(studentid, schoolid) VALUES(2,2);

    SET foreign_key_checks = 1;
