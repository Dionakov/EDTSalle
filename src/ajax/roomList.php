<?php
//if(!isset($_POST['time'])) die("Fatal error : time variable missing");

require_once("../ListClassRooms.php");

$time = 7200;

$list = new ListClassRooms($time);
$result = array(
	"timeSlot" => $list->getTimeSlot(),
	"freeRooms" => array(),
	"occupiedRooms" => array()
);
$i = 0;
foreach($list->getFreeRooms() as $room)
	$result["freeRooms"][$i++] = '<a href="room.php?room='.$room->getRoom() . '>'.$room->getRoom() . " : LIBRE</a>";
$i = 0;
foreach($list->getUsedRooms() as $room)
	$result["occupiedRooms"][$i++] = '<a href="room.php?room='.$room->getRoom() . '>'.$room->getRoom() . " : OCCUPEE</a>";
	
echo json_encode($result);
?>