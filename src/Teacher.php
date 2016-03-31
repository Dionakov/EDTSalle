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
            <?php 
            require_once("ListClassRooms.php");

			$time = 0;
            $classRooms = new ListClassRooms($time);
            $lowestTime = $classRooms->getTimeSlot();
			date_default_timezone_set("Europe/Paris");
			setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
			$date=strftime('%d ',time()). ucfirst(strftime('%B', time()));
            ?>
            <div class="container">
				
		<div class="row">
                <div class="col-md-12 text-center">
		<ul class="nav nav-pills pills-center">
				  <li>
                                      <a href="Rooms.php">Salles Libres</a></li>
                                  <li class="active"><a href="Teacher.php">Profs</a>
				  </li>
		</ul>
                </div>
                </div>
                <div class="row">
                        <div class="col-md-12 text-center">
			<div class="btn-group text-center">
  				<button type="button" id="tile_horaire_precedent" class="btn btn-default" >Horaire précedent</button>
  				<button type="button" id="tile_horaire_suivant" class="btn btn-default"  >Horaire suivant</button>
                        </div>
                        </div>        
                </div>
                <div class="row">
                    <div id="jour" class="col-md-12 text-center"><?=$date?></div>
                </div>
                <div class="row">
                    <div id="horaire" class="col-md-12"><?=$classRooms->getTimeSlot()?></div>
                </div>
             
            </div>

	<div class='grid'>
		<div class="row col-md-12">
			<div id="room">
			<?php
                        $sort='t';
                        foreach ($classRooms->getGroups($sort) as $value) {?>
                            <div class="tile tile-blue col-xs-8 col-xs-offset-2"  >
                            <?php 
                                if ($sort==='g') {
                                    echo "<h1>".$value->getGroup()."</h1><p class=\"group\">".$value->getTeacher()."</p><p class=\"roomT\">".$value->getRoom()."</p></div>";
                                }
                                else if ($sort==='t') {
                                    echo "<h1>".$value->getTeacher()."</h1><p class=\"group\">".$value->getGroup()."</p><p class=\"roomT\">".$value->getRoom()."</p></div>";
                                }
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