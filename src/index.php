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
				  <li class="active">
                                      <a href="index.php">Salles Libres</a></li>
                                  <li><a href="Teacher.php">Profs</a>
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
		<script type="text/javascript">
			$(document).bind("mobileinit", function () {
				$.mobile.ajaxEnabled = false;
			});
		</script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.mobile-1.4.5.min.js"></script>
		<script type="text/javascript">
			function getRoomList(time, callback) {
				
				$.post("ajax/roomList.php", {time:time}, function(list) { callback(JSON.parse(list)); });
			}
			function nextTimeSlot(time, callback) {
				
				$.post("ajax/nextTimeSlot.php", {time:time}, function(newTime) { callback(newTime); });
			}
			function previousTimeSlot(time, callback) {
				
				$.post("ajax/previousTimeSlot.php", {time:time}, function(newTime) { callback(newTime); });
			}
			
			var currentRoomList = undefined;
			var nextRoomList = undefined;
			var previousRoomList = undefined;
			
			var currentTime = 0;
			var nextTime = undefined;
			var previousTime = undefined;
			
			nextTimeSlot(currentTime, function(newTime) {
				nextTime = newTime;
				getRoomList(newTime, function(list) { 
				
					nextRoomList = list;
				});
			});
			getRoomList(currentTime, function(list) { currentRoomList = list; });
			/*previousTimeSlot(currentTime, function(newTime) {
				previousTime = newTime;
				getRoomList(newTime, function(list) {
					
					previousRoomList = JSON.parse(list);
				});
			});*/
			
			function refreshRooms(direction) {
				
				if(currentTime === 0 && direction === false) return;
				
				if(direction === true) {
					
					previousTime = currentTime;
					currentTime = nextTime;
					nextTime = undefined;
					
					previousRoomList = currentRoomList;
					currentRoomList = nextRoomList;
					nextRoomList = undefined;
					
					nextTimeSlot(currentTime, function(newTime) {
						nextTime = newTime;
						getRoomList(newTime, function(list) { 
						
							nextRoomList = list;
						});
					});
				} else {
					
					nextTime = currentTime;
					currentTime = previousTime;
					previousTime = undefined;
					
					nextRoomList = currentRoomList;
					currentRoomList = previousRoomList;
					previousRoomList = undefined;
					
					previousTimeSlot(currentTime, function(newTime) {
						previousTime = newTime;
						getRoomList(newTime, function(list) {
							
							previousRoomList = list;
						});
					});
				}
				
				$("#rooms").animate({right:direction?"1000px":"-1000px", opacity:0.00}, 300, function() {
						
					$("#rooms").css("right", direction?"-1000px":"1000px");
				
					$("#rooms").html("");

					freeRooms = currentRoomList.freeRooms;
					occupiedRooms = currentRoomList.occupiedRooms;
					for(var i = 0; i < freeRooms.length; i++) {
						
						$("#rooms").append(freeRooms[i]);
					}
					for(var i = 0; i < occupiedRooms.length; i++) {
					
						$("#rooms").append(occupiedRooms[i]);
					}
					
					$("#rooms").animate({right:"0px",opacity:1.00}, "slow");
				});
				
				$("#horaire").animate({opacity:0.00}, 200, function() {
					$("#horaire").html(currentRoomList.timeSlot);
					$("#horaire").animate({opacity:1.00}, 200);
				});
			} 
			
			$(document).ready(function() {
				
				$("#tile_horaire_precedent").click(function() {
					
					var b = $(this);
					b.attr('disabled', 'disabled');
					setTimeout(function() { b.removeAttr('disabled'); }, 2000);
					refreshRooms(false);
				});
				$("#tile_horaire_suivant").click(function() {
				
					var b = $(this);
					b.attr('disabled', 'disabled');
					setTimeout(function() { b.removeAttr('disabled'); }, 2000);
					refreshRooms(true);
				});
				$(document).on("swipeleft", function() {
	
					refreshRooms(true);
				});
				
				$(document).on("swiperight", function() {
	
					refreshRooms(false);
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