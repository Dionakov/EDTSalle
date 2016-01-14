<?php

if(!isset($_POST['time'])) die("Fatal Error : time variable missing.");

date_default_timezone_set("Europe/Paris");
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

if(date('D', time()+$_POST['time'])=="Fri" && (date('H:i',time()+$_POST['time'])>='11:30' && date('H:i',time()+$_POST['time'])<'12:00')) {
	$_POST['time']+=90*60;
}
else if(date('D', time()+$_POST['time'])=="Fri" && (date('H:i',time()+$_POST['time'])>='15:30' && date('H:i',time()+$_POST['time'])<'16:00')) {
	$_POST['time']+=150*60;
}
else if (date('H:i',time()+$_POST['time'])<'18:00') {
	$_POST['time']+=120*60;
}
echo $_POST['time'];

?>