<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Edt salles</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    <link rel="stylesheet" type="text/css" href="dist/css/metro-bootstrap.min.css">
    <link rel="stylesheet" href="styles/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="agenda.png">
</head>

<?php 
require_once("ListClassRooms.php");

$time = 0;

$classRooms = new ListClassRooms($time);
$lowestTime = $classRooms->getTimeSlot();

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>EDT Salles</title>
	</head>
	<body>
            <div class="container">
              
		<div class="row">
                <div class="col-md-12 text-center">
		<ul class="nav nav-pills pills-center">
				  <li class="active">
					  <a href="#">Salles Libres</a></li>
					  <li><a href="#">Profs</a>
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
                <div id="horaire" class="col-md-12"><?=$classRooms->getTimeSlot()?></div>
                </div>
               
            </div>
            <div class="grid">
		
			<div class="row col-md-12">
				<div id="rooms">
					<?php
						foreach ($classRooms->getFreeRooms() as $value) {
							echo('<a href="Room.php?room='.$value->getRoom().'">');
							echo('<div class="tile tile-lime col-md-3 col-xs-12">');
							echo('<h1> '.$value->getRoom(). '</h1>');
							if($value->getComputer()){
                                                            echo('<p><img src="computer.png"></p>');
							}
							echo('</div>');
							echo ('</a>');

						}
						foreach ($classRooms->getUsedRooms() as $value) {
							echo('<a href="Room.php?room='.$value->getRoom().'">');
							echo('<div class="tile tile-red col-md-3 col-xs-12">');
							echo('<h1> '.$value->getRoom(). '</h1>');
                                                        if($value->getComputer()){
                                                            echo('<p><img src="computer.png"></p>');
                                                        }
							echo('</div>');
							echo('</a>');
						}
					?>
				</div>
			</div>
		</div>

		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script type="text/javascript">
		
			function refreshData(direction) {
			
				$.post(direction ? "ajax/previousTimeSlot.php" : "ajax/nextTimeSlot.php", {time:time}, function(data) { 

				time = parseInt(data);
					$.post("ajax/roomList.php", {time:time}, function(data2) { 
						
						data2 = JSON.parse(data2);
						$("#rooms").animate({right:direction?"-1000px":"1000px", opacity:0.00}, 300, function() {
						
							$("#rooms").css("right", direction?"1000px":"-1000px");
						
							$("#rooms").html("");
							freeRooms = data2.freeRooms;
							occupiedRooms = data2.occupiedRooms;
							for(var i = 0; i < freeRooms.length; i++) {
								
								
								$("#rooms").append(freeRooms[i]);
							}
							for(var i = 0; i < occupiedRooms.length; i++) {
							
								$("#rooms").append(occupiedRooms[i]);
							}
							
							$("#rooms").animate({right:"0px",opacity:1.00}, "slow");
						});
						
						$("#horaire").animate({opacity:0.00}, 200, function() {
							$("#horaire").html(data2.timeSlot);
							$("#horaire").animate({opacity:1.00}, 200);
						});
					});
				});
			}
		
			var time = 0;
			$(document).ready(function() {
				
				$("#tile_horaire_precedent").click(function() {
					
					refreshData(true);
				});
				$("body").on("swipeleft", function() {
				
					refreshData(false);
				});
				
				$("body").on("swiperight", function() {
					refreshData(true);
				});
				$("#tile_horaire_suivant").click(function() {
				
					refreshData(false);
				});
			});
		</script>

	<style>
	  .grid .row {
	    background-color: transparent;
	    border: 0;
	    height: 50px;
	    padding-right: 0;
	    
	  }
	  .grid .row .col-md-3
	    {
	        min-height: 150px;
	    }
	  .grid .row .col-md-6
	    {
	        min-height: 300px;
	    }

	</style>
	</body>
</html>