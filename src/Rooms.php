<?php 
require_once("ListClassRooms.php");

$time = 0;

$classRooms = new ListClassRooms($time);

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8"/>
		<title>EDT Salles</title>
	</head>
	<body>
	
		<button id="horairePrecedent">Horaire précédent</button>
		<span id="timeSlot"><?=$classRooms->getTimeSlot()?></span>
		<button id="horaireSuivant">Horaire suivant</button>
		
			<div id="rooms"style="position:relative;">
			<?php
			foreach($classRooms->getFreeRooms() as $room) {
				echo "<p><a href=\"room.php?room=".$room->getRoom()."\">".$room->getRoom()." : LIBRE</a></p>";
			}
			foreach($classRooms->getUsedRooms() as $room) {
				echo "<p><a href=\"room.php?room=".$room->getRoom()."\">".$room->getRoom()." : OCCUPEE</a></p>";
			}
			?>
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
								
								//alert(freeRooms[i]);
								$("#rooms").append("<p>"+freeRooms[i]+"</p>");
							}
							for(var i = 0; i < occupiedRooms.length; i++) {
							
								$("#rooms").append("<p>"+occupiedRooms[i]+"</p>");
							}
							
							$("#rooms").animate({right:"0px",opacity:1.00}, "slow");
						});
						
						$("#timeSlot").animate({opacity:0.00}, 200, function() {
							$("#timeSlot").html(data2.timeSlot);
							$("#timeSlot").animate({opacity:1.00}, 200);
						});
					});
				});
			}
		
			var time = 0;
			$(document).ready(function() {
				
				$("#horairePrecedent").click(function() {
					
					refreshData(true);
				});
				$("body").on("swipeleft", function() {
				
					refreshData(false);
				});
				
				$("body").on("swiperight", function() {
					refreshData(true);
				});
				$("#horaireSuivant").click(function() {
				
					refreshData(false);
				});
			});
		</script>
	</body>
</html>