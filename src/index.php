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
            $i=nextTimeSlot($i);
            $list = new ListClassRooms($i);
            echo('<table>');
            echo('<tr><th colspan=3>'.$date.'</th></tr>');
            echo('<tr><th colspan=3>'. $list->getTimeSlot().'</th></tr>');
            foreach ($list->getFreeRooms() as $value) {
                echo('<tr><td>'.$value->getRoom().'</td><td><img src="green.jpg"></td></tr>');
            }
            foreach ($list->getUsedRooms() as $value) {                
                echo('<tr><td>'.$value->getRoom().'</td><td><img src="red.jpg"></td></tr>');
            }
            
            echo('<table>');
            echo('<tr><th colspan=3>'.$date.'</th></tr>');
            echo('<tr><th colspan=3>'. $list->getTimeSlot().'</th></tr>');
            foreach ($list->getGroups() as $value) {
                echo('<tr><td>'.$value->getGroup().'</td><td>'.$value->getRoom().'</td></tr>');
            }
            echo('</table>');
          
            require_once 'ScheduleRoom.php';
            $scheduleRoom = new ScheduleRoom('S01');
            echo('<table>');
            echo('<tr><th colspan=3>'.$date.'</th></tr>');
            echo('<tr><th colspan=3>'.$scheduleRoom->getRoom().'</th></tr>');
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
            
            //Permet d'avancer de reculer d'un créneau lors du swipe ou de l'appuie sur le bouton "Creneau précédent" (pas encore fonctionnel)
            function previousTimeSlot($i) {
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
        ?>
    </body>
</html>
