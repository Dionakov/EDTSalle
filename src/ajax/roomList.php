<?php
if(!isset($_POST['time'])) die();

require_once("../ListClassRooms.php");

$time = $_POST['time'];

$list = new ListClassRooms($time);
$result = array(
	"freeRooms" => array(),
	"occupiedRooms" => array()
);
$i = 0;
foreach($list->getFreeRooms() as $room)
	$result["freeRooms"][$i++] = $room->getRoom() . " LIBRE";
$i = 0;
foreach($list->getUsedRooms() as $room)
	$result["occupiedRooms"][$i++] = $room->getRoom() . " OCCUPEE";
	
echo json_encode($result);
?>