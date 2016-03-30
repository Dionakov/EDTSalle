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
                <link rel="icon" href="agenda.png">
	</head>
	<body>
            <div class="container">
              
		<div class="row">
                <div class="col-md-12 text-center">
		<ul class="nav nav-pills pills-center">
				  <li>
                                      <a href="Rooms.php">Salles Libres</a></li>
					  <li><a href="#">Profs</a>
				  </li>
		</ul>
                </div>
                </div>
                <div class="row">
                <div id="jour" class="col-md-12 text-center"><?=$date?></div>
                </div>
                <div class="row">
                    <?php
                        if ($scheduleRoom->getSchedule()[0]->getComputer()) {
                            $c="<img src=\"computer.jpg\">";
                        }
                        else {
                            $c="";
                        }
                    ?>
                    
                <div id="salle" class="col-md-12 text-center"><?=$_GET['room']?>  <?=$c?></div>
                </div>
             
            </div>

	<div class='grid'>
		<div class="row col-md-12">
			<div id="room">
			<?php
			$last='08:00';
			foreach($scheduleRoom->getSchedule() as $schedule) {
				if($last!=$schedule->getStart()) {
					?><div class="tile tile-lime col-xs-8 col-xs-offset-2"  ><?php
					echo "<h1>".$last." - ".$schedule->getStart()."</h1></div>";
				}
				?><div class="tile tile-red col-xs-8 col-xs-offset-2"  ><?php
				echo "<h1>".$schedule->getStart()." - ".$schedule->getEnd()."</h1><p class=\"group\">".$schedule->getGroup()."</p><p class=\"prof\">".$schedule->getTeacher()."</p></div>";
				$last =$schedule->getEnd();
			}
			if($last != '21:00') {
				echo "<div class=\"tile tile-lime col-xs-8 col-xs-offset-2\"  ><h1>".$last." - 21:00</h1></div>";
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