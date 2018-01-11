<?php include("StudentClass.php"); ?>
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author ACER
 */
class Database {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "preRegistration";
    public $conn;

    function __construct() {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    }

    function createTable($sqlCommand) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }

    function getTotalNumberOfRegisteredStudent($CourseCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "SELECT * FROM registrationtable WHERE courseCode= '$CourseCode'";
        $result = $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
        return $result->num_rows;
    }

    function PendingListStudentFromRegistrationTable($Status) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "SELECT * FROM registrationtable WHERE section= '$Status' order by courseCode";
        $result = $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
        return $result;
    }

    function getAllDataFromAdminTable($adminID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "SELECT * FROM admintable WHERE adminID= '$adminID'";
        $result = $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
        return $result;
    }

    function getSectionFromRegistrationTable($CourseCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "SELECT DISTINCT section FROM registrationtable WHERE courseCode= '$CourseCode' AND not section='Pending'";
        $result = $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
        return $result;
    }

    function UpdateSectionToRegistrationTable($StudentID, $CourseCode, $Section) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "UPDATE `registrationtable` SET `section` = '$Section' WHERE courseCode = '$CourseCode' AND studentID='$StudentID'";
        $conn->query($sqlCommand);
    }

    function getTotalNumberOfSemesterWiseStudent($semesterNumber) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "SELECT * FROM student WHERE semester= '$semesterNumber'";
        $result = $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
        return $result->num_rows;
    }

    function addStudentInStudentTable($studentObject) {
        $student = $studentObject;
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "INSERT INTO `student`(`id`, `name`, `section`, `semester`, `registrationStatus`, `password`, `contactNumber`, `email`, `forgetPasswordIdentity`) "
                . "VALUES ('$student->ID','$student->studentName','$student->section','$student->semester','$student->registrationStatus','$student->password','$student->contactNumber','$student->email','')";
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }

    function getNumberOfStudentInSection($Section,$CourseCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM registrationtable WHERE section= '$Section' && courseCode='$CourseCode'";
        $result = $conn->query($query);
        return $result->num_rows;
    }
    function getStudentInSection($Section,$CourseCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT studentID FROM registrationtable WHERE section= '$Section' && courseCode='$CourseCode'";
        $result = $conn->query($query);
        return $result;
    }
    function getAllCoursesFromRegistrationTable(){
         $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT distinct courseCode,CourseName,CourseCredit FROM registrationtable";
        $result = $conn->query($query);
        return $result;
    }
        function addCoursesInCoursesTable($courseCode, $courseTitle, $credit) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "INSERT INTO `coursetable`"
                . "VALUES ('$courseCode','$courseTitle','$credit')";
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }
    function UpdateAllRegistrationStatus(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "update `student` set registrationStatus =false";
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }
    function TruncateRegistrationTable(){
         $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "TRUNCATE TABLE registrationtable";
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo "<br><br>".$conn->connect_error;
        }
    }
    function UpdateSemester(){
         $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "Update student Set semester=semester+1";
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }
    function RemoveCoursesFromTempTable($courseCode, $studentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "DELETE FROM `temptable` WHERE courseCode='$courseCode' AND studentID='$studentID'";

        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }

    function addCoursesInRegistraionTable($courseCode, $courseName, $courseCredit, $studentID, $section) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "INSERT INTO `registrationtable`"
                . "VALUES ('$courseCode.$studentID','$studentID','$courseName','$courseCode','$courseCredit','$section')";
        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }

    function RemoveCoursesFromRegistrationTable($courseCode, $studentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sqlCommand = "DELETE FROM `registrationtable` WHERE courseCode='$courseCode' AND studentID='$studentID'";

        $conn->query($sqlCommand);
        if ($conn->connect_error) {
            echo $conn->connect_error;
        }
    }

    function studentLoginCheck($studentID, $password) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM student WHERE id= '$studentID' && password = '$password'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    function adminLoginCheck($adminID, $adminPassword) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM adminTable WHERE adminID= '$adminID' && adminPassword = '$adminPassword'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    function studentEmailCheck($studentID, $email) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM student WHERE id= '$studentID' && email = '$email'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    function studentHashAndIDCheck($studentID, $hash) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM student WHERE id= '$studentID' && forgetPasswordIdentity = '$hash'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    function adminHashAndIDCheck($adminID, $hash) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM adminTable WHERE adminID= '$adminID' && hashIdentity = '$hash'";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            return true;
        } else {
            return false;
        }
    }

    function courseFromCourseTable($semesterCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT * FROM `coursetable` WHERE RIGHT(CourseCode,3) like \"$semesterCode%\" order by CourseCode";
        $result = $conn->query($sql);
        return $result;
    }

    function StudentCourseFromRegistrationTable($studentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT * FROM `registrationtable` WHERE studentID='$studentID' order by CourseCode";
        $result = $conn->query($sql);
        return $result;
    }

    function allStudentsFromStudentsTable($semesterCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $sql = "SELECT * FROM `student` WHERE semester='$semesterCode' order by section";
        $result = $conn->query($sql);
        return $result;
    }

    function updatePasswordInStudentTable($password, $studentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "update student set password='$password' WHERE id= '$studentID'";
        $conn->query($query);
    }

    function updatePasswordInAdminTable($password, $adminID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "update adminTable set adminPassword='$password' WHERE adminID= '$adminID'";
        $conn->query($query);
    }

    function updateHashStudentTable($hash, $studentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "update student set forgetPasswordIdentity='$hash' WHERE id= '$studentID'";
        $conn->query($query);
    }

    function updateRegistrationStatusInStudentTable($studentID, $update) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "update student set registrationStatus='$update' WHERE id= '$studentID'";
        $conn->query($query);
    }

    function updateHashAdminTable($hash, $adminID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "update adminTable set hashIdentity='$hash' WHERE adminID= '$adminID'";
        $conn->query($query);
    }

    function getNameFromStudentTable($StudentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT name FROM student WHERE id= '$StudentID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["name"];
        }
    }

    function getAdminNameFromAdminTable($adminID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT adminName FROM admintable WHERE adminID= '$adminID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["adminName"];
        }
    }

    function getSectionFromStudentTable($StudentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT section FROM student WHERE id= '$StudentID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["section"];
        }
    }

    function getSemesterFromStudentTable($StudentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT semester FROM student WHERE id= '$StudentID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["semester"];
        }
    }

    function getRegistrationStatusFromStudentTable($StudentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT registrationStatus FROM student WHERE id= '$StudentID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["registrationStatus"];
        }
    }

    function getCourseNameFromCourseTable($courseCode) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT CourseName FROM coursetable WHERE CourseCode= '$courseCode' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["CourseName"];
        }
    }

    function getNameFromAdminTable($adminID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT adminName FROM adminTable WHERE adminID= '$adminID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["adminName"];
        }
    }

    function getEmailFromAdminTable($adminID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT adminEmail FROM adminTable WHERE adminID= '$adminID' ";
        $result = $conn->query($query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            return $row["adminEmail"];
        }
    }

    function getAllInformationFromStudentTable(string $StudentID) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $query = "SELECT * FROM student WHERE id= '$StudentID' ";
        $result = $conn->query($query);
        $student = new StudentClass();
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $student->studentName = $row["name"];
            $student->ID = $row["id"];
            $student->section = $row["section"];
            $student->registrationStatus = $row["registrationStatus"];
            $student->semester = $row["semester"];
            $student->contactNumber = $row["contactNumber"];
            $student->email = $row["email"];
            return $student;
        }
    }

}
