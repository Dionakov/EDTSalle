<?php
if(!isset($_POST['time'])) die("Fatal error : time variable missing");

require_once("../ListClassRooms.php");

$time = $_POST['time'];

$list = new ListClassRooms($time);
$result = array(
	"timeSlot" => $list->getTimeSlot(),
	"freeRooms" => array(),
	"occupiedRooms" => array()
);
$i = 0;
foreach($list->getFreeRooms() as $room) {
	$result["freeRooms"][$i] = '<a href="room.php?room='.$room->getRoom().'"><div class="tile tile-lime col-md-3 col-xs-12"  >'. '<h1> '.$room->getRoom(). '</h1>';
	if($room->getComputer()) {
		$result["freeRooms"][$i] .= '<p><img src="computer.png"></p>';
	}
	$result["freeRooms"][$i] .= '</div></a>';
	$i++;
}
$i = 0;
foreach($list->getUsedRooms() as $room) {
	$result["occupiedRooms"][$i] = '<a href="room.php?room='.$room->getRoom().'"><div class="tile tile-red col-md-3 col-xs-12"  >'. '<h1> '.$room->getRoom(). '</h1>';
	if($room->getComputer()) {
		$result["occupiedRooms"][$i] .= '<p><img src="computer.png"></p>';
	}
	$result["occupiedRooms"][$i] .= '</div></a>';
	$i++;
}
echo json_encode($result);
?>