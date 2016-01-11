<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ScheduleRoom
 *
 * @author Emile Bex
 */
class ScheduleRoom {
    private $_schedule=array();
    private $_room;
    public function __construct($room) {
        $this->_room=$room;
        foreach (Calendar::getRoomSchedule($room) as $event) {
            if(@$event['DTSTART']!=0) {
                $group=preg_split("/(\\\\n)/", @$event['DESCRIPTION']);
                array_push($this->_schedule, new ClassRoom(date('H:i', strtotime(substr(@$event['DTSTART'], 9,6))+3600),date('H:i',strtotime(substr(@$event['DTEND'], 9,6))+3600),substr(@$event['LOCATION'],0,3),$group)); 
            }
        }
        usort($this->_schedule, "ClassRoom::cmpTime");
    }
    public function getRoom() {
        return $this->_room;
    }
    public function getSchedule() {
        return $this->_schedule;
    }  
}