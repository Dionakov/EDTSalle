<?php

if(!isset($_POST['time'])) die("Fatal Error : time variable missing.");

date_default_timezone_set("Europe/Paris");
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

if ($_POST['time']!=0) {
	if(date('D', time()+$_POST['time'])=="Fri" && (date('H:i',time()+$_POST['time'])>='13:00' && date('H:i',time()+$_POST['time'])<'13:30')) {
		$_POST['time']-=90*60;
	}
	else if(date('D', time()+$_POST['time'])=="Fri" && (date('H:i',time()+$_POST['time'])>='18:00' && date('H:i',time()+$_POST['time'])<'18:30')) {
		$_POST['time']-=150*60;
	}
	else if (date('H:i',time()+$_POST['time'])<'20:00') {
		$_POST['time']-=120*60;
	}
	else if (date('H:i',time()+$_POST['time'])>='20:00') {
		$_POST['time']-=150*60;
	}
	
}
echo $_POST['time'];