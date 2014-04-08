<script>
jQuery(document).ready(function($){

    //portfolio - show link

    $('img').hover(

        function () {

            $(this).animate({opacity:'0.5'}, {duration:50});

        },

        function () {

            $(this).animate({opacity:'1'}, {duration:50});

        }

    ); 

});
</script>

<?php

if (isset($_GET['dir'])) {
    if (isset($_GET['foto'])){
    echo '<a href="foto/?dir='.$_GET['dir'].'"><img style="width:100%;" src="'.$_GET['foto'].'"></a>';
   // echo '<img style="width:100%;" src="'.$_GET['foto'].'">';
}
else{
    
    
echo '<center><div class="antraste">'.$_GET['dir'].' puslapis</div></center>';


if (is_dir('./foto/'.$_GET['dir'])){//echo '<pre>'; print_r($_SERVER);
$handle = opendir('./foto/'.$_GET['dir']);
     while (false !== ($entry = readdir($handle))) {
       if ( $entry != "." && $entry != ".." && !is_dir('./foto/'.$_GET['dir'].'/'.$entry)){
           $kurciataspointeris = explode(".", $entry);
              $vardas = reset($kurciataspointeris);
              $vardas = $vardas."_maza";
                    echo '<a href="foto/?dir='.$_GET['dir'].'&foto=./foto/'.$_GET['dir'].'/'.$entry.'">';
        echo '<div id="foto">';
        if (file_exists("resize/".$vardas.".jpg")){
            echo '<img src="vasara/resize/'. $vardas.'.jpg">';
        }
        else {
            mazinimas('foto/'.$_GET['dir'].'/'.$entry, $vardas);
                    
       echo '<img src="./resize/'. $vardas.'.jpg">';
        }
        echo '</div>';
        echo '</a>';
         }
    }
}
else {
    echo "<h1>Pasirinkta neegzistuojanti kategorija";
}




    }
}
else {
    echo "<h1>Nepasirinkta direktorija";
}



function mazinimas($failas, $vardas){
   // echo $failas;
  $extension = end(explode(".", $failas));
  list($width, $height) = getimagesize($failas); 
  $santykis = $width/$height;

  
  //$naujasplotis1 = 40; //$naujasplotis2 = 200; $naujasplotis3 = 60;
  //$naujasaukstis1 = $naujasplotis1/$santykis;

  $naujasaukstis1 = 100;
  $naujasplotis1 = $naujasaukstis1*$santykis; //$naujasplotis2 = 200; $naujasplotis3 = 60;
    //$naujasaukstis2 = $naujasplotis2/$santykis;
      //$naujasaukstis3 = $naujasplotis3/$santykis;
  
//echo     $width." x ".$height."\n";
//echo $santykis."\n";
//echo     $naujasplotis." x ".$naujasaukstis."\n";

 $mazas1 = imagecreatetruecolor($naujasplotis1, $naujasaukstis1); 
 //$mazas2 = imagecreatetruecolor($naujasplotis2, $naujasaukstis2); 
 //$mazas3 = imagecreatetruecolor($naujasplotis3, $naujasaukstis3); 
 $didelis     = imagecreatefromjpeg ($failas); 

 imagecopyresampled($mazas1, $didelis, 0, 0, 0, 0, $naujasplotis1, $naujasaukstis1, $width, $height); 
 //imagecopyresampled($mazas2, $didelis, 0, 0, 0, 0, $naujasplotis2, $naujasaukstis2, $width, $height); 
 //imagecopyresampled($mazas3, $didelis, 0, 0, 0, 0, $naujasplotis3, $naujasaukstis3, $width, $height); 
imagejpeg($mazas1, "resize/".$vardas.".jpg");
//imagejpeg($mazas2, "img/users/".$vardas."_vidutinis.jpg");
//imagejpeg($mazas3, "img/users/".$vardas."_mazas.jpg");

   }
?>
