<?php

class ClassRoom {
    private $_start;
    private $_end;
    private $_room;
    private $_group;
    private $_teacher;
    public function __construct($start, $end, $room, $group) {
        $this->_start = $start;
        $this->_end = $end;
        $this->_room = $room;
        $this->_group =$group;
    }
    
    static function cmpRoom($a, $b) {
        return strcmp($a->_room, $b->_room);
    }
    
    static function cmpTime($a, $b) {
        return strcmp($a->_start, $b->_start);
    }
    
    static function cmpGroup($a, $b) {
        return strcmp($a->_group, $b->_group);
    }
    
    static function cmpTeacher($a, $b) {
        return strcmp($a->_teacher, $b->_teacher);
    }
    
    public function getStart() {
        return $this->_start;
    }

    public function getEnd() {
        return $this->_end;
    }

    public function getRoom() {
        return $this->_room;
    }
    public function getGroup() {
        return $this->_group;
    }
    public function getTeacher() {
        return $this->_teacher;
    }

    public function setTeacher($teacher) {
        $this->_teacher = $teacher;
    }
}
