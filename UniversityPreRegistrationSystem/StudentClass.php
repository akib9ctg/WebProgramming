<?php

class StudentClass {
    //put your code here
    var $studentName;
    var $ID;
    var $section;
    var $semester;
    var $registrationStatus;
    var $password;
    var $email;
    var $contactNumber;
    function set_studentName($new_name){
        $this->studentName=$new_name;
    } 
    function set_ID($new_ID){
        $this->ID=$new_ID;
    }
    function set_section($section){
        $this->section=$section;
    }
    function set_semester($semester){
        $this->semester=$semester;
    }
    function set_registrationStatus($status){
        $this->registrationStatus=$status;
    }
    function set_password($password){
        $this->password=$password;
    }
    function set_contactNumber($number){
        $this->contactNumber=$number;
    }
    function set_email($email){
        $this->email=$email;
    }
    function get_studentName(){
        return $this->studentName;
    } 
    function get_ID(){
        return $this->ID;
    }
    function get_section(){
        return $this->section;
    }
    function get_semester(){
        return $this->semester;
    }
    function get_registrationStatus(){
        return $this->registrationStatus;
    }
    function get_number(){
        return $this->contactNumber;
    }
    function get_email(){
        return $this->email;
    }
    
    
    
    
}
