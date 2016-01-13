<?php
require_once 'ClassRoom.php';
require_once 'Calendar.php';
class ListClassRooms {
    private $_usedRooms=array();
    private $_freeRooms=array();
    private $_allRooms = array("S01", "S03", "S10", "S11", "S12", "S13", "S14", "S15", "S16", "S17", "S18 - TP Réseau", "S21", "S22", "S23 - TP réseau", "S24", "S25-Salle de réunion", "S26");
    private $_computerRooms=array("S01", "03", "S13", "S14", "S16", "S17", "S18 - TP Réseau", "S22", "S23 - TP réseau", "S24");
    private $_timeSlot;
    private $_empty;
    public function __construct($i) {
        foreach (Calendar::getDaySchedule() as $event) {
            if(time()+$i>=strtotime(substr(@$event['DTSTART'], 9,6))+3600 && time()+$i<strtotime(substr(@$event['DTEND'], 9,6))+3600) {
                $group=preg_split("/(\\\\n)/", @$event['DESCRIPTION']);
                $locations=preg_split("/(\\\\|\,)/",@$event['LOCATION']);
                foreach($locations as $location){
                     if(isset($location[0]) && strcmp($location[0],"S")==0 && strcmp(substr($location,0,3),"S04")!=0) {
                        array_push($this->_usedRooms, $room=new ClassRoom(date('H:i', strtotime(substr(@$event['DTSTART'], 9,6))+3600),date('H:i',strtotime(substr(@$event['DTEND'], 9,6))+3600),substr($location,0,strlen($location)-1),$group[1]));
                        if($group[2][0]!="(") {
                           $room->setTeacher($group[2]);
                        }
                        if(in_array(substr($location,0,strlen($location)-1), $this->_computerRooms)) {
                            $room->setComputer(true);
                        }
                     }
                }
            }
        }
        
        if(date('H:i',time()+$i)<'08:00' || date('H:i',time()+$i)>='21:00' || date('D', time()+$i)=="Sat" || date('D', time()+$i)=="Sun") {
            $this->_timeSlot="Aucune salle disponible.";
            $this->_empty=true;
        }
        else {
            $this->_empty=false;
            if(date('H:i',time()+$i)>='08:00' && date('H:i',time()+$i)<'10:00') {
                $this->_timeSlot="08:00 - 10:00";
            }
            else if(date('H:i',time()+$i)>='10:00' && date('H:i',time()+$i)<'12:00') {
                $this->_timeSlot="10:00 - 12:00";
            }
            else if(date('D', time()+$i)=="Fri") {
                if(date('H:i',time()+$i)>='12:00' && date('H:i',time()+$i)<'13:30') {
                    $this->_timeSlot="12:00 - 13:30";
                }
                else if(date('H:i',time()+$i)>='13:30' && date('H:i',time()+$i)<'15:30') {
                    $this->_timeSlot="13:30 - 15:30";
                }
                else if(date('H:i',time()+$i)>='15:30' && date('H:i',time()+$i)<'17:30') {
                    $this->_timeSlot="15:30 - 17:30";
                }
                else {
                    $this->_timeSlot="17:30 - 21:00";
                }
            }
            else {
                if(date('H:i',time()+$i)>='12:00' && date('H:i',time()+$i)<'14:00') {
                    $this->_timeSlot="12:00 - 14:00";
                }
                else if(date('H:i',time()+$i)>='14:00' && date('H:i',time()+$i)<'16:00') {
                    $this->_timeSlot="14:00 - 16:00";
                }
                else if(date('H:i',time()+$i)>='16:00' && date('H:i',time()+$i)<'18:00') {
                    $this->_timeSlot="16:00 - 18:00";
                }
                else {
                    $this->_timeSlot="18:00 - 21:00";
                }
            }
        }
        
        foreach ($this->_allRooms as $location) {
            array_push($this->_freeRooms, $room=new ClassRoom(substr($this->_timeSlot,0,5), substr($this->_timeSlot,8,5),$location, null));
            if(in_array($location, $this->_computerRooms)) {
                $room->setComputer(true);
            }
        }
        
        $this->_freeRooms=array_udiff($this->_freeRooms, $this->_usedRooms, "ClassRoom::cmpRoom");
    }
    
    public function getTimeSlot() {
        return $this->_timeSlot;
    }
    
    public function getUsedRooms() {
        usort($this->_usedRooms, "ClassRoom::cmpRoom");
        return $this->_usedRooms;
    }
    
    public function getFreeRooms() {
        if ($this->_empty) {
            return array();
        }
        usort($this->_freeRooms, "ClassRoom::cmpRoom");
        return $this->_freeRooms;
    }
    
    public function getGroups($c) {
        if ($c=='g') {
            usort($this->_usedRooms, "ClassRoom::cmpGroup");
        }
        else if ($c=='t') {
            usort($this->_usedRooms, "ClassRoom::cmpTeacher");
        }
        return $this->_usedRooms;
    }
}
?>