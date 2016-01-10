<?php 
require_once("Calendar.php");
require_once("ListClassRooms.php");
require_once("ScheduleRoom.php");

date_default_timezone_set("Europe/Paris");
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
$date=strftime('%d ',time()). ucfirst(strftime('%B', time()));

$schedule = new ScheduleRoom("S16");
$time = 0;

$classRooms = new ListClassRooms($time);
//Permet d'avancer d'un créneau lors du swipe ou de l'appuie sur le bouton "Creneau suivant"
function nextTimeSlot($i) {
	if(date('D', time()+$i)=="Fri" && (date('H:i',time()+$i)>='11:30' && date('H:i',time()+$i)<'12:00')) {
		$i+=90*60;
	}
	else if(date('D', time()+$i)=="Fri" && (date('H:i',time()+$i)>='15:30' && date('H:i',time()+$i)<'16:00')) {
		$i+=150*60;
	}
	else if (date('H:i',time()+$i)<'18:00') {
		$i+=120*60;
	}
	return $i;
}

//Permet de reculer d'un créneau lors du swipe ou de l'appuie sur le bouton "Creneau précédent" (pas encore fonctionnel)
function previousTimeSlot($i) {
	if ($i!=0) {
		if(date('D', time()+$i)=="Fri" && (date('H:i',time()+$i)>='13:00' && date('H:i',time()+$i)<'13:30')) {
			$i-=90*60;
		}
		else if(date('D', time()+$i)=="Fri" && (date('H:i',time()+$i)>='18:00' && date('H:i',time()+$i)<'18:30')) {
			$i-=150*60;
		}
		else if (date('H:i',time()+$i)<'18:00') {
			$i-=120*60;
		}
	}
	return $i;
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>EDT Salles</title>
	</head>
	<body>
	
		<button id="horairePrecedent">Horaire précédent</button>
		<?=$classRooms->getTimeSlot()?>
		<button id="horaireSuivant">Horaire suivant</button>
		
		<?php
		foreach($classRooms->getFreeRooms() as $room) {
			echo "<p>".$room->getRoom()." : LIBRE";
		}
		foreach($classRooms->getUsedRooms() as $room) {
			echo "<p>".$room->getRoom()." : OCCUPEE";
		}
		?>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
			$("#horairePrecedent").click(function() {
				
				$.post("ajax/roomList.php"), {
					
					time:<?=
				}
			});
		</script>
	</body>
</html>