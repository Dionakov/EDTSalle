<!DOCTYPE html>
<html lang="en">
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
  <?php
            date_default_timezone_set("Europe/Paris");
            setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
            require_once 'Calendar.php';
            require_once 'ListClassRooms.php'; 

            $date=strftime('%d ',time()). ucfirst(strftime('%B', time()));
          
                    
            $i=0;
            $i=nextTimeSlot($i);

            // affichage salles
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
            foreach ($list->getGroups('t') as $value) {
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
            
            //Permet de reculer d'un créneau lors du swipe ou de l'appuie sur le bouton "Creneau précédent" (pas encore fonctionnel)
            function previousTimeSlot($i) {
                if ($i!=0) {
                    if(date('D', time()+$i)=="Fri" && (date('H:i',time()+$i)>='13:00' && date('H:i',time()+$i)<'13:30')) {
                        $i-=90*60;
                    }
                    else if(date('D', time()+$i)=="Fri" && (date('H:i',time()+$i)>='18:00' && date('H:i',time()+$i)<'18:30')) {
                        $i-=150*60;
                    }
                    else if (date('H:i',time()+$i)<'18:00') {
                        $i-=120*60;
                    }
                }
                return $i;
            }
        ?>


	<style>

	</style>
  </head>  
  <body >


<div class='grid'>
       <div class="row col-md-12">

          <div class="tile tile-clouds col-md-4 col-xs-12"  >
            <a href="" >
              <h1>Emploi du temps</h1>
            </a>
          </div>

          <div class="tile tile-emerald col-md-4 col-xs-12">
            <a href="prof.php">
              <h1>Espace prof</h1>
            </a>
          </div>     

          <div class="tile tile-turquoise col-md-4 col-xs-12 "  >
            <a href="">
              <h1>Espace etudiant</h1>
            </a>
          </div>
      </div>
</div>

<hr class="tile-red" style="" />
  <div class="grid">
     <div class="row col-md-12">
          <div>
             <?php
            foreach ($list->getFreeRooms() as $value) {
              echo(' <div class="tile tile-lime col-md-3 col-xs-12"  >');
              echo('<h1> '.$value->getRoom(). '</h1>');
                if($value->getComputer()){
                  echo('<p><img src="computer.png"></p>');
                }
              echo('</div>');

            }
            foreach ($list->getUsedRooms() as $value) {
              echo(' <div class="tile tile-red col-md-3 col-xs-12"  >');
              echo('<p> '.$value->getRoom(). '</p>');
                if($value->getComputer()){
                  echo('<p><img src="computer.png"></p>');
                }
                echo('</div>');
            }
              ?>
          </div>

        
    

    

  </body>

  <!-- Le javascript
    ================================================== -->
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/vendor/bootstrap.min.js"></script>
    <script type="text/javascript" src="scripts/metro-docs.js"></script>
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36060270-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
  
  $('#collapse-sidebar').click(function()
  {
  
  $('.navbar-side').toggleClass('navbar-side-closed');
  $('#wrapper').toggleClass('wrapper-full');
  
  
  });

</script>
</html>
