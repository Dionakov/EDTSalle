<?php
if(!isset($_GET['room'])) die("Fatal Error : Room value missing");
require_once("ScheduleRoom.php");
date_default_timezone_set("Europe/Paris");
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
$time = 0;
$date=strftime('%d ',time()). ucfirst(strftime('%B', time()));
$scheduleRoom = new ScheduleRoom($_GET['room']);

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>EDT Salles</title>
	</head>
	<body>
	
		<button id="jourPrecedent">Jour précédent</button>
		<span id="jour"><?=$_GET['room'].' - '.$date?></span>
		<button id="jourSuivant">Jour suivant</button>
		
			<div id="room"style="position:relative;">
			<?php
			$last='08:00';
			foreach($scheduleRoom->getSchedule() as $schedule) {
				if($last!=$schedule->getStart()) 
					echo "<p>".$last." -> ".$schedule->getStart()." : LIBRE</p>";
				echo "<p>".$schedule->getStart()." -> ".$schedule->getEnd()." : OCCUPEE</p>";
				$last =$schedule->getEnd();
			}
			if($last != '21:00') {
			
				echo "<p>".$last." -> 21:00 : LIBRE</p>";
			}
			?>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
		
			
		</script>
	</body>
</html>