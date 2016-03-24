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
		<link rel="stylesheet" type="text/css" href="dist/css/metro-bootstrap.min.css">
		<link rel="stylesheet" href="styles/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<p>
		<ul class="nav nav-pills">
				  <li class="active">
					  <a href="rooms.php">Salles Libres</a></li>
					  <li><a href="#">Profs</a></li>
				  </li>
		</ul>
	</p>
        <center><span id="jour"><?=$date?></span></center>
	<center><span id="salle"><?=$_GET['room']?></span></center>
	<div class='grid'>
		<div class="row col-md-12">
			<div id="room"style="position:relative;">
			<?php
			$last='08:00';
			foreach($scheduleRoom->getSchedule() as $schedule) {
				if($last!=$schedule->getStart()) {
					?><div class="tile tile-lime col-xs-6 col-xs-offset-3"  ><?php
					echo "<h1>".$last." - ".$schedule->getStart()."</h1></div>";
				}
				?><div class="tile tile-red col-xs-6 col-xs-offset-3"  ><?php
				echo "<h1>".$schedule->getStart()." - ".$schedule->getEnd()."</h1></div>";
				$last =$schedule->getEnd();
			}
			if($last != '21:00') {
				echo "<div class=\"tile tile-lime col-xs-6 col-xs-offset-3\"  ><h1>".$last." - 21:00</h1></div>";
			}
			?>
			</div>
		</div>
	</div>
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		
	</script>
	</body>


</html>