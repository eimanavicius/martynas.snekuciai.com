<?php
   $kokia = "mano";
    $handle = opendir('img/foto/'.$kokia);
    $a=1;
    while (false !== ($entry = readdir($handle))) {
        
        
        if ( $entry != "." && $entry != ".." && !is_dir('foto/'. $kokia.'/'.$entry)){
             $masyvas=explode(".", $entry);
            $extension = end($masyvas);
           $kitas = &$masyvas;
            $vardas = reset($kitas);
 //echo $vardas;
             // $vardas = $vardas."_slaider";
               if (!file_exists("./img/resize/".$vardas."_slaider.jpg")){
                   mazinimas('./img/foto/'.$kokia.'/'.$entry, $vardas."_slaider");
               }
            $paveiksleliai[$vardas]=$extension;
        }
        
        
        
        
    }
    $paveiksleliai = shuffle_assoc($paveiksleliai);
   // shuffle($paveiksleliai);
    //$paveiksleliai[0]=$paveiksleliai[2];
	//print_r($paveiksleliai);
    foreach ($paveiksleliai as $key => $reiksme ){
        if ($a<10){
        
          echo '<div class="slide">
		<a href="http://www.greitas.com/vasara/foto/'. $kokia.'/'.$key.'.'.$reiksme.'" title="'.$key.'_slaider.jpg" ><img src="./resize/'.$key.'_slaider.jpg"   alt="Slide '.$a.'"></a>
                    <div class="caption" >
                    <p>Nuotrauka '.$reiksme.'</p>
                    </div>
            </div>';
     $a=$a+1;
        
       } 
    }

    
function mazinimas($failas, $vardas){
   // echo $failas;
  $extension = end(explode(".", $failas));
  list($width, $height) = getimagesize($failas); 
  $santykis = $width/$height;

  
  $naujasplotis1 = 200; //$naujasplotis2 = 200; $naujasplotis3 = 60;
  $naujasaukstis1 = $naujasplotis1/$santykis;

 // $naujasaukstis1 = 100;
 // $naujasplotis1 = $naujasaukstis1*$santykis; //$naujasplotis2 = 200; $naujasplotis3 = 60;
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
imagejpeg($mazas1, "img/resize/".$vardas.".jpg");
//imagejpeg($mazas2, "img/users/".$vardas."_vidutinis.jpg");
//imagejpeg($mazas3, "img/users/".$vardas."_mazas.jpg");

   }
   
   function shuffle_assoc($list) { 
  if (!is_array($list)) return $list; 

  $keys = array_keys($list); 
  shuffle($keys); 
  $random = array(); 
  foreach ($keys as $key) 
    $random[$key] = $list[$key]; 

  return $random; 
} 
?>
