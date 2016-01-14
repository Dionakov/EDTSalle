<?php

class ClassRoom {
    private $_start;
    private $_end;
    private $_room;
    private $_group;
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
        return strcmp($a->_start, $b->_start);
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
}
