<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title></title>
    </head>
    <body>
        <?php
            date_default_timezone_set("Europe/Paris");
            setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
            require_once 'Calendar.php';
            
            $date=strftime('%d ',time()). ucfirst(strftime('%B', time()));
          
            require_once 'ListClassRooms.php';         
            $i=0;
            $list = new ListClassRooms($i);
            echo('<table>');
            echo('<tr><th colspan=3>'.$date.'</th></tr>');
            echo('<tr><th colspan=3>'. $list->getTimeSlot().'</th></tr>');
            foreach ($list->getFreeRooms() as $value) {
                if ($value->getComputer()==true) {
                    echo('<tr><td>'.$value->getRoom().'</td><td><img src="computer.jpg"></td><td><img src="green.jpg"></td></tr>');
                }
                else {
                    echo('<tr><td>'.$value->getRoom().'</td><td><img src="green.jpg"></td></tr>');
                }
            }
            foreach ($list->getUsedRooms() as $value) {                
                if ($value->getComputer()==true) {
                    echo('<tr><td>'.$value->getRoom().'</td><td><img src="computer.jpg"></td><td><img src="red.jpg"></td></tr>');
                }
                else {
                    echo('<tr><td>'.$value->getRoom().'</td><td><img src="red.jpg"></td></tr>');
                }
            }
            
            echo('<table>');
            echo('<tr><th colspan=3>'.$date.'</th></tr>');
            echo('<tr><th colspan=3>'. $list->getTimeSlot().'</th></tr>');
            //parametre d'entrée de getGroup() : 't' pour trier en fonction des profs, 'g' pour trier en fonction des groupes
            foreach ($list->getGroups('g') as $value) {
                echo('<tr><td>'.$value->getGroup().'</td><td>'.$value->getTeacher().'</td><td>'.$value->getRoom().'</td></tr>');
            }
            echo('</table>');
          
            require_once 'ScheduleRoom.php';
            $scheduleRoom = new ScheduleRoom('S12');
            echo('<table>');
            echo('<tr><th colspan=3>'.$date.'</th></tr>');
            echo('<tr><th colspan=3>'.$scheduleRoom->getRoom().'</th><th><img src="computer.jpg"></th></tr>');
            $last='08:00';
            foreach ($scheduleRoom->getSchedule() as $value) {
                if ($last!=$value->getStart()){
                    echo('<tr><td>'.$last.'</td><td>'.$value->getStart().'</td><td><img src="green.jpg"></td></tr>');
                }
                echo('<tr><td>'.$value->getStart().'</td><td>'.$value->getEnd().'</td><td><img src="red.jpg"></td></tr>');
                $last=$value->getEnd();
            }
            if($last!='21:00') {
                echo('<tr><td>'.$last.'</td><td>21:00</td><td><img src="green.jpg"></td></tr>');
            }
            echo('</table>');

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
                    else if (date('H:i',time()+$i)<'20:00') {
                        $i-=120*60;
                    }
                    else if (date('H:i',time()+$i)>='20:00') {
                        $i-=150*60;
                    }
                    
                }
                return $i;
            }
			
			$j = nextTimeSlot(0);
			$j = nextTimeSlot($j);
			$j = nextTimeSlot($j);
			$j = nextTimeSlot($j);
			$j = nextTimeSlot($j);
			$j = nextTimeSlot($j);
			$k = previousTimeSlot($j);
			$k = previousTimeSlot($k);
			$k = previousTimeSlot($k);
			$k = previousTimeSlot($k);
			$k = previousTimeSlot($k);
			$k = previousTimeSlot($k);
			$k = previousTimeSlot($k);
			echo "0 => $j => $k";
        ?>
    </body>
</html>
